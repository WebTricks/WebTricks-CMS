<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */


class WebTricks_Jobs_JobManager extends Cream_ApplicationComponent
{
    const CACHE_KEY_LAST_SCHEDULE_GENERATE_AT   = 'jobs_last_schedule_generate_at';
    const CACHE_KEY_LAST_HISTORY_CLEANUP_AT     = 'jobs_last_history_cleanup_at';

    const XML_PATH_SCHEDULE_GENERATE_EVERY  = 'system/jobs/schedule_generate_every';
    const XML_PATH_SCHEDULE_AHEAD_FOR       = 'system/jobs/schedule_ahead_for';
    const XML_PATH_SCHEDULE_LIFETIME        = 'system/jobs/schedule_lifetime';
    const XML_PATH_HISTORY_CLEANUP_EVERY    = 'system/jobs/history_cleanup_every';
    const XML_PATH_HISTORY_SUCCESS          = 'system/jobs/history_success_lifetime';
    const XML_PATH_HISTORY_FAILURE          = 'system/jobs/history_failure_lifetime';

    const REGEX_RUN_MODEL = '#^([a-z0-9_]+/[a-z0-9_]+)::([a-z0-9_]+)$#i';

    /**
     * Holds the data manager.
     * 
     * @var WebTricks_Jobs_Data_Manager_Abstract
     */
    protected $_dataManager;
    
    protected $_pendingSchedules;
    
    protected $_expiredJobs;

    /**
     * Create a new instance of this class.
     * 
     * @return Cream_Jobs_JobManager
     */
    public static function instance()
    {
    	return Cream::instance(__CLASS__);
    }
    
    /**
     * Process cron queue
     * Geterate tasks schedule
     * Cleanup tasks schedule
     *
     */
    public function dispatch()
    {
        $jobs = $this->_getPendingJobs();
        $jobLifetime = $this->_getApplication()->getConfig()->getNode(self::XML_PATH_SCHEDULE_LIFETIME) * 60;
        $now = time();
        $jobsRoot = $this->_getApplication()->getConfig()->getNode('jobs');

        foreach ($jobs as $job) {
            $jobConfig = $jobsRoot->{$job->getJobCode()};
            if (!$jobConfig || !$jobConfig->run) { 
                continue;
            }

            $runConfig = $jobConfig->run;
            $time = strtotime($job->getScheduledAt());
            if ($time > $now) {
                continue;
            }
            
            try {
                $errorStatus = WebTricks_Jobs_JobStatus::ERROR;
                $errorMessage = 'Unknown error.';

                if ($time < $now - $jobLifetime) {
                    $errorStatus = WebTricks_Jobs_JobStatus::MISSED;
                    throw new Cream_Exceptions_Exception('Too late for the schedule.');
                }

                if ($runConfig->model) {
                    if (!preg_match(self::REGEX_RUN_MODEL, (string)$runConfig->model, $run)) {
                        throw new Cream_Exceptions_Exception('Invalid model/method definition, expecting "model/class::method".');
                    }
                    if (!($model = Cream::instance($run[1])) || !method_exists($model, $run[2])) {
                        throw new Cream_Exceptions_Exception('Invalid callback: '. $run[1] .'::'. $run[2] .' does not exist');
                    }
                    
                    $callback = array($model, $run[2]);
                    $arguments = array($job);
                }
                if (empty($callback)) {
                    throw new Cream_Exceptions_Exception('No callbacks found');
                }

                if (!$job->tryLockJob()) {
                    // another cron started this job intermittently, so skip it
                    continue;
                }

                $job->setStatus(WebTricks_Jobs_JobStatus::RUNNING);
                $job->setExecutedAt(strftime('%Y-%m-%d %H:%M:%S', time()));
                $job->save();

                call_user_func_array($callback, $arguments);

                $job->setStatus(WebTricks_Jobs_JobStatus::SUCCESS);
				$job->setFinishedAt(strftime('%Y-%m-%d %H:%M:%S', time()));

            } catch (Exception $e) {
                $job->setStatus($errorStatus);
				$job->setMessages($e->__toString());
            }
            
            $job->save();
        }

        $this->generate();
        $this->cleanup();
    }
    
    protected function _getPendingJobs()
    {
    	if (!$this->_pendingJobs) {
    		$this->_pendingJobs = $this->_getDataManager()->getPendingJobs();
    	}
    	
    	return $this->_pendingJobs;
    }    

    protected function _getExpiredJobs()
    {
    	if (!$this->_expiredJobs) {
    		$this->_expiredJobs = $this->_getDataManager()->getExpiredJobs();
    	}
    
    	return $this->_expiredJobs;
    }
    
    
    protected function _getHistoryLifetimes()
    {
		return array(
            WebTricks_Jobs_JobStatus::SUCCESS => $this->_getApplication()->getNode(self::XML_PATH_HISTORY_SUCCESS)*60,
            WebTricks_Jobs_JobStatus::MISSED => $this->_getApplication()->getNode(self::XML_PATH_HISTORY_FAILURE)*60,
            WebTricks_Jobs_JobStatus::ERROR => $this->_getApplication()->getNode(self::XML_PATH_HISTORY_FAILURE)*60,
        );    	
    }

    /**
     * Generate cron schedule
     *
     * @return Cream_Observer
     */
    public function generate()
    {
        $lastRun = $this->_getApplication()->getCache()->load(self::CACHE_KEY_LAST_SCHEDULE_GENERATE_AT);
        if ($lastRun > time() - $this->_getApplication()->getConfig()->getNode(self::XML_PATH_SCHEDULE_GENERATE_EVERY)*60) {
            return $this;
        }

        $schedules = $this->_getPendingJobs();
        $exists = array();
        foreach ($schedules as $schedule) {
            $exists[$schedule->getJobCode().'/'.$schedule->getScheduledAt()] = 1;
        }

        /**
         * generate global crontab jobs
         */
        $config = $this->_getApplication()->getConfig()->getNode('crontab/jobs');
        if ($config instanceof Cream_Config_Xml_Element) {
            $this->_generateJobs($config->children(), $exists);
        }

        /**
         * generate configurable crontab jobs
         */
        $config = $this->_getApplication()->getConfig()->getNode('default/crontab/jobs');
        if ($config instanceof Cream_Config_Xml_Element) {
            $this->_generateJobs($config->children(), $exists);
        }

        /**
         * save time schedules generation was ran with no expiration
         */
        $this->_getApplication()->getCache()->save(time(), self::CACHE_KEY_LAST_SCHEDULE_GENERATE_AT, array('crontab'), null);
    }

    /**
     * Generate jobs for config information
     *
     * @param   $jobs
     * @param   array $exists
     * @return  Cream_Observer
     */
    protected function _generateJobs($jobs, $exists)
    {
        $scheduleAheadFor = $this->_getApplication()->getConfig()->getNode(self::XML_PATH_SCHEDULE_AHEAD_FOR)*60;
        $schedule = WebTricks_Jobs_Job::instance();

        foreach ($jobs as $jobCode => $jobConfig) {
            $cronExpr = null;
            if ($jobConfig->schedule->config_path) {
                $cronExpr = $this->_getApplication()->getConfig()->getNode((string)$jobConfig->schedule->config_path);
            }
            if (empty($cronExpr) && $jobConfig->schedule->cron_expr) {
                $cronExpr = (string)$jobConfig->schedule->cron_expr;
            }
            if (!$cronExpr) {
                continue;
            }

            $now = time();
            $timeAhead = $now + $scheduleAheadFor;
            $schedule->setJobCode($jobCode)
                ->setCronExpr($cronExpr)
                ->setStatus(WebTricks_Jobs_JobStatus::PENDING);

            for ($time = $now; $time < $timeAhead; $time += 60) {
                $ts = strftime('%Y-%m-%d %H:%M:00', $time);
                if (!empty($exists[$jobCode.'/'.$ts])) {
                    // already scheduled
                    continue;
                }
                if (!$schedule->trySchedule($time)) {
                    // time does not match cron expression
                    continue;
                }
                $schedule->unsScheduleId()->save();
            }
        }
        return $this;
    }

    public function cleanup()
    {
        $lastCleanup = $this->_getApplication()->getCache()->load(self::CACHE_KEY_LAST_HISTORY_CLEANUP_AT);
        if ($lastCleanup > time() - ($this->_getApplication()->getConfig()->getNode(self::XML_PATH_HISTORY_CLEANUP_EVERY) * 60)) {
            return $this;
        }

        $history = $this->_getExpiredJobs();
        $historyLifetimes = $this->_getHistoryLifetimes();
        
        $now = time();
        foreach ($history as $job) {
        	
        	print_r($job);
        	print '<hr>';
        	
            if (strtotime($job->getExecuted()) < $now - $historyLifetimes[$job->getStatus()]) {
                $job->delete();
            }
        }

        // save time history cleanup was ran with no expiration
        $this->_getApplication()->getCache()->save(time(), self::CACHE_KEY_LAST_HISTORY_CLEANUP_AT, array('crontab'));
    }	
    
    /**
     * 
     * Enter description here ...
     * @param $job
     * @param $newStatus
     */
	public function tryLock(Cream_Jobs_Job $job, $newStatus)
	{
		return $this->_getDataManager()->tryLock($job->getJobId(), $job->getStatus(), $newStatus);
	}
	
	public function save(WebTricks_Jobs_Job $job)
	{
		$this->_getDataManager()->save($job);
	}
	
	/**
	 * Returns the data manager
	 * 
	 * @return Cream_Jobs_Data_Manager_Abstract
	 */
	protected function _getDataManager()
	{
		if (!$this->_dataManager) {
			$config = $this->_getApplication()->getConfig()->getNode('global/security/data');
			$this->_dataManager = WebTricks_Jobs_Data_Manager::factory($config);
		}
	
		return $this->_dataManager;
	}	
}