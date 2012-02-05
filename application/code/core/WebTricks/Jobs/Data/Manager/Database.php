<?php

class WebTricks_Jobs_Data_Manager_Database extends WebTricks_Jobs_Data_Manager_Abstract
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
		return $this->_getApplication()->getConnection($this->_readConnection);
	}

	/**
	 * Returns the write connection
	 *
	 * @return Cream_Data_Connection
	 */	
	protected function _getWriteConnection()
	{
		return $this->_getApplication()->getConnection($this->_writeConnection);
	}

	/**
	 * 
	 */
	public function getPendingJobs()
	{		
		$jobCollection = WebTricks_Jobs_JobCollection::instance();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from('jobs_schedule');
		$select->where('status = ?', WebTricks_Jobs_JobStatus::PENDING);

		$result = $this->_getReadConnection()->query($select);
		
		foreach($result->getRows() as $row) {
			$jobCollection->add($this->_buildJob($row));
		}
		
		return $jobCollection;
	}
	
	/**
	 * 
	 */
	public function getExpiredJobs()
	{
		$jobCollection = WebTricks_Jobs_JobCollection::instance();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from('jobs_schedule');		
		$select->where('status IN ?', array(
				WebTricks_Jobs_JobStatus::SUCCESS,
				WebTricks_Jobs_JobStatus::MISSED,
				WebTricks_Jobs_JobStatus::ERROR));
		
		$result = $this->_getReadConnection()->query($select);
		
		foreach($result->getRows() as $row) {
			$jobCollection->add($this->_buildJob($row));
		}
		
		return $jobCollection;		
	}
	
	public function tryLock()
	{
		
	}
	
	public function saveJob()
	{
		
	}
	
	public function deleteJob()
	{
		
	}
}