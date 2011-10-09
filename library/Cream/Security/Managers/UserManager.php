<?php

class Cream_Security_Managers_UserManager extends Cream_ApplicationComponent
{
	protected $_dataManager;
	
	/**
	 * Create an instance of this class.
	 * 
	 * @return Cream_Security_MembershipManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
		
	public function getAllUsers($search = '', $domain, $start = 0, $size = 50, $order = 'email', $orderDirection = 'asc')
	{
		return $this->_getDataManager()->getAllUsers($search, $domain, $start, $size, $order, $orderDirection);
	}
	
	
	protected function _getDataManager()
	{
		if (!$this->_dataManager) {
			$config = $this->getApplication()->getConfig()->getNode('global/security/data');
			$this->_dataManager = Cream_Security_Data_Manager::factory($config);
		}
		
		return $this->_dataManager;
	}	
}