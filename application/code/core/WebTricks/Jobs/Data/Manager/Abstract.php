<?php
/**
 * WebTricks
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in
 * the future. If you wish to customize WebTricks for your needs please go to 
 * http://www.webtricksframework.com for more information.
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Base class for jobs data managers.
 *
 * @package		WebTricks_Jobs
 * @author		WebTicks Core Team <core@webtricksframework.com>
 */
abstract class WebTricks_Jobs_Data_Manager_Abstract extends Cream_ApplicationComponent
{
	/**
	 * Builds a site object and returns it.
	 * 
	 * @param object jobInfo
	 * @param WebTricks_Jobs_Job
	 */
	protected function _buildJob($jobInfo)
	{
		$job = WebTricks_Jobs_Job::instance();	
		$job->setId((string) $jobInfo->job_id);
		$job->setJob((string) $jobInfo->job);
		$job->setStatus((string) $jobInfo->status);
		$job->setMessages((string) $jobInfo->messages);
		$job->setProgress((string) $jobInfo->progress);
		$job->setCreated((string) $jobInfo->created);
		$job->setScheduled((string) $jobInfo->scheduled);
		$job->setExecuted((string) $jobInfo->executed);
		$job->setFinished((string) $jobInfo->finished);
				
		return $job;
	}
	
	abstract public function getPendingJobs();
	
	abstract public function getExpiredJobs();
	
	abstract public function tryLock();
	
	abstract public function saveJob();
}