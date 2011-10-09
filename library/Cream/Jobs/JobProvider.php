<?php
/**
 * WebTricks - PHP Framework
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
 * The job provider class. 
 *
 * @package		Cream_Jobs
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Jobs_JobProvider
{
	/**
	 * holding the job manager object.
	 * 
	 * @var Cream_Jobs_JobManager
	 */
	protected static $_manager;
	
	/**
	 * Processes the job queue, generates the job schedule and cleans
	 * up the job schedule.
	 *  
	 * @return void
	 */
	public static function dispatch()
	{
		self::_getManager()->dispatch();
	}
	
	public static function tryLock($job, $newStatus)
	{
		return self::_getManager()->tryLock($job, $newStatus);
	}
	
	public static function save(Cream_Jobs_Job $job)
	{
		return self::_getManager()->save($job);
	}
	
	/**
	 * Returns the job manager
	 * 
	 * @return Cream_Jobs_JobManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Jobs_JobManager::instance();
		}		
		
		return self::$_manager;
	}
}