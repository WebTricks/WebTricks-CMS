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

class Cream_Jobs_Job
{
	/**
	 * Create a new instance of this class.
	 *
	 * @return Cream_Jobs_Job
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function save()
	{
		Cream_Jobs_JobProvider::save($this);	
	}
	
	public function tryLock()
	{
		
	}
	
	public function getScheduleId()
	{
		
	}
	
	public function getJobCode()
	{
		
	}
	
	public function getStatus()
	{
		
	}
	
	public function getMessages()
	{
		
	}
	
	public function getProgress()
	{
		
	}
	
	public function getCreated()
	{
		
	}
	
	public function getScheduled()
	{
		
	}
	
	public function getExecuted()
	{
		
	}
	
	public function getFinished()
	{
		
	}
}