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
 * Database manager. Manages the jobs from the database. 
 *
 * @package		Cream_Jobs
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Jobs_Data_Manager_Database extends Cream_Jobs_Data_Manager_Abstract
{
	/**
	 * Name of the read connection to use
	 * 
	 * @var string
	 */
	protected $_readConnection;
	
	/**
	 * Name of the write connection to use
	 * 
	 * @var string
	 */
	protected $_writeConnection;
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Config_Xml_Element $config
	 */
	public function __init(Cream_Config_Xml_Element $config)
	{
		$this->_readConnection = (string) $config->connection->read;
		$this->_writeConnection = (string) $config->connection->write;
	}

	/**
	 * Returns the read connection
	 *
	 * @return Cream_Data_Connection
	 */
	protected function _getReadConnection()
	{
		return $this->getApplication()->getConnection($this->_readConnection);
	}

	/**
	 * Returns the write connection
	 *
	 * @return Cream_Data_Connection
	 */	
	protected function _getWriteConnection()
	{
		return $this->getApplication()->getConnection($this->_writeConnection);
	}	
	
	public function getJobHistory()
	{
		$collection = Cream_Jobs_JobCollection::instance();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from('jobs_schedule');
		$select->where('status IN (?)', array(
			Cream_Jobs_JobStatus::SUCCESS,
			Cream_Jobs_JobStatus::MISSED,
			Cream_Jobs_JobStatus::ERROR
		));
		
		$result = $this->_getReadConnection()->query($select);
		
		foreach($result->getRows() as $row) {
			$collection->add($job);	
		}
		
		return $collection;		
	}
	
	public function getPendingJobs()
	{
		$collection = Cream_Jobs_JobCollection::instance();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from('jobs_schedule');
		$select->where('status = ?', Cream_Jobs_JobStatus::STATUS_PENDING);
		
		$result = $this->_getReadConnection()->query($select);
		
		foreach($result->getRows() as $row) {
			$collection->add($job);	
		}
		
		return $collection;
	}
	
	/**
	 * Tries to lock the specified job
	 * Enter description here ...
	 * @param unknown_type $jobId
	 * @param unknown_type $currentStatus
	 * @param unknown_type $newStatus
	 */
	public function tryLock($jobId, $currentStatus, $newStatus)
	{
		$update = Cream_Data_Statement_Update::instance();
		$update->from('jobs_schedule');
		$update->set('status', $newStatus);
		$update->where('job_id = ?', $jobId);
		$update->where('status = ?', $currentStatus);
		
		$result = $this->_getWriteConnection()->query($update);
		
		if ($result->getAffectedRows()) {
			return true;
		} else {
			return false;
		}
	}
	
	public function saveJob()
	{
		
	}
}