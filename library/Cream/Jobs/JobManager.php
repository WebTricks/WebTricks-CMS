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


class Cream_Jobs_JobManager extends Cream_ApplicationComponent
{
    const CACHE_KEY_LAST_SCHEDULE_GENERATE_AT   = 'cron_last_schedule_generate_at';
    const CACHE_KEY_LAST_HISTORY_CLEANUP_AT     = 'cron_last_history_cleanup_at';

    const XML_PATH_SCHEDULE_GENERATE_EVERY  = 'system/cron/schedule_generate_every';
    const XML_PATH_SCHEDULE_AHEAD_FOR       = 'system/cron/schedule_ahead_for';
    const XML_PATH_SCHEDULE_LIFETIME        = 'system/cron/schedule_lifetime';
    const XML_PATH_HISTORY_CLEANUP_EVERY    = 'system/cron/history_cleanup_every';
    const XML_PATH_HISTORY_SUCCESS          = 'system/cron/history_success_lifetime';
    const XML_PATH_HISTORY_FAILURE          = 'system/cron/history_failure_lifetime';

    const REGEX_RUN_MODEL = '#^([a-z0-9_]+/[a-z0-9_]+)::([a-z0-9_]+)$#i';

    protected $_pendingSchedules;

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
        $schedules = $this->getPendingSchedules();
        $scheduleLifetime = $this->getApplication()->getConfig()->getNode(self::XML_PATH_SCHEDULE_LIFETIME) * 60;
        $now = time();
        $jobsRoot = $this->getApplication()->getConfig()->getNode('crontab/jobs');

        foreach ($schedules->getIterator() as $schedule) {
            $jobConfig = $jobsRoot->{$schedule->getJobCode()};
            if (!$jobConfig || !$jobConfig->run) { 
                continue;
            }

            $runConfig = $jobConfig->run;
            $time = strtotime($schedule->getScheduledAt());
            if ($time > $now) {
                continue;
            }
            try {
                $errorStatus = Cream_Jobs_JobStatus::STATUS_ERROR;
                $errorMessage = 'Unknown error.';

                if ($time < $now - $scheduleLifetime) {
                    $errorStatus = Cream_Jobs_JobStatus::STATUS_MISSED;
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
                    $arguments = array($schedule);
                }
                if (empty($callback)) {
                    throw new Cream_Exceptions_Exception('No callbacks found');
                }

                if (!$schedule->tryLockJob()) {
                    // another cron started this job intermittently, so skip it
                    continue;
                }
                /**
                    though running status is set in tryLockJob we must set it here because the object
                    was loaded with a pending status and will set it back to pending if we don't set it here
                 */
                $schedule
                    ->setStatus(Cream_Jobs_JobStatus::STATUS_RUNNING)
                    ->setExecutedAt(strftime('%Y-%m-%d %H:%M:%S', time()))
                    ->save();

                call_user_func_array($callback, $arguments);

                $schedule
                    ->setStatus(Cream_Jobs_JobStatus::STATUS_SUCCESS)
                    ->setFinishedAt(strftime('%Y-%m-%d %H:%M:%S', time()));

            } catch (Exception $e) {
                $schedule->setStatus($errorStatus)
                    ->setMessages($e->__toString());
            }
            $schedule->save();
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
    
    protected function _getHistoryLifetimes()
    {
		return array(
            Cream_Jobs_JobStatus::SUCCESS => $this->getApplication()->getNode(self::XML_PATH_HISTORY_SUCCESS)*60,
            Cream_Jobs_JobStatus::MISSED => $this->getApplication()->getNode(self::XML_PATH_HISTORY_FAILURE)*60,
            Cream_Jobs_JobStatus::ERROR => $this->getApplication()->getNode(self::XML_PATH_HISTORY_FAILURE)*60,
        );    	
    }

    /**
     * Generate cron schedule
     *
     * @return Cream_Observer
     */
    public function generate()
    {
        /**
         * check if schedule generation is needed
         */
        $lastRun = $this->getApplication()->getCache()->load(self::CACHE_KEY_LAST_SCHEDULE_GENERATE_AT);
        if ($lastRun > time() - $this->getApplication()->getConfig(self::XML_PATH_SCHEDULE_GENERATE_EVERY)*60) {
            return $this;
        }

        $schedules = $this->_getPendingSchedules();
        $exists = array();
        foreach ($schedules->getIterator() as $schedule) {
            $exists[$schedule->getJobCode().'/'.$schedule->getScheduledAt()] = 1;
        }

        /**
         * generate global crontab jobs
         */
        $config = $this->getApplication()->getConfig()->getNode('crontab/jobs');
        if ($config instanceof Cream_Config_Xml_Element) {
            $this->_generateJobs($config->children(), $exists);
        }

        /**
         * generate configurable crontab jobs
         */
        $config = $this->getApplication()->getConfig()->getNode('default/crontab/jobs');
        if ($config instanceof Cream_Config_Xml_Element) {
            $this->_generateJobs($config->children(), $exists);
        }

        /**
         * save time schedules generation was ran with no expiration
         */
        $this->getApplication()->getCache()->save(time(), self::CACHE_KEY_LAST_SCHEDULE_GENERATE_AT, array('crontab'), null);
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
        $scheduleAheadFor = $this->getApplication()->getConfig()->getNode(self::XML_PATH_SCHEDULE_AHEAD_FOR)*60;
        $schedule = Cream_Jobs_Job::instance();

        foreach ($jobs as $jobCode => $jobConfig) {
            $cronExpr = null;
            if ($jobConfig->schedule->config_path) {
                $cronExpr = $this->getApplication()->getConfig()->getNode((string)$jobConfig->schedule->config_path);
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
                ->setStatus(Cream_Jobs_JobStatus::PENDING);

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
        $lastCleanup = $this->getApplication()->getCache()->load(self::CACHE_KEY_LAST_HISTORY_CLEANUP_AT);
        if ($lastCleanup > time() - ($this->getApplication()->getConfig()->getNode(self::XML_PATH_HISTORY_CLEANUP_EVERY) * 60)) {
            return $this;
        }

        $history = $this->_getDataManager()->getJobsHistory();
        $historyLifetimes = $this->_getHistoryLifetimes();

        $now = time();
        foreach ($history as $job) {
            if (strtotime($job->getExecutedAt()) < $now-$historyLifetimes[$job->getStatus()]) {
                $job->delete();
            }
        }

        // save time history cleanup was ran with no expiration
        $this->getApplication()->getCache()->save(time(), self::CACHE_KEY_LAST_HISTORY_CLEANUP_AT, array('crontab'));
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
    
	protected function _getDataManager()
	{
		if (!$this->_dataManager) {
			$config = $this->getApplication()->getConfig()->getNode('global/jobs/data');
			$this->_dataManager = Cream_Jobs_Data_Manager::factory($config);
		}
		
		return $this->_dataManager;
	}    	
}