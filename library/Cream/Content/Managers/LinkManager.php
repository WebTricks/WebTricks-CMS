<?php

class Cream_Content_Managers_LinkManager extends Cream_ApplicationComponent
{
	/**
	 * Data manager
	 * 
	 * @var Cream_Content_Links_Data_Manager_Abstract
	 */
	protected $_dataManager;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Links_Managers_LinkManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Returns the data manager. The manager to use is defined in the 
	 * config section /global/content/links
	 * 
	 * @return Cream_Content_Links_Data_Manager_Abstract
	 */
	protected function _getDataManager()
	{
		if (!$this->_dataManager) {
    		$config = $this->getConfig()->getNode('global/content/links');
    		$this->_dataManager = Cream_Content_Links_Data_Manager::factory($config);
		}
		
		return $this->_dataManager;
	}
}