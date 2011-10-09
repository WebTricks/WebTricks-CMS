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

/**
 * The manager to access the workflow history.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Workflows_HistoryManager extends Cream_ApplicationComponent
{
	/**
	 * Data manager
	 * 
	 * @var Cream_Workflows_Data_Manager_Abstract
	 */
	protected $_dataManager;

	/**
	 * Creates a new instance of this class.
	 * 
	 * @return Cream_Workflows_HistoryManager
	 */
	public function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Adds an entry to the workflow history.
	 * 
	 * @param Cream_Content_Item $item
	 * @param Cream_Guid $oldStateId
	 * @param Cream_Guid $newStateId
	 * @param string $message
	 * @return void
	 */		
	public function addHistory(Cream_Content_Item $item, Cream_Guid $oldStateId, Cream_Guid $newStateId, $message)
	{
		return $this->_getDataManager()->addHistory($item, $oldStateId, $newStateId, $message);
	}
	
	/**
	 * Returns an array holding history event for the item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return array
	 */
	public function getHistory(Cream_Content_Item $item)
	{
		return $this->_getDataManager()->getHistory($item);
	}
	
	/**
	 * Clears the workflow history of an item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */	
	public function clearHistory(Cream_Content_Item $item)
	{
		return $this->_getDataManager()->clearHistory($item);
	}
	
	/**
	 * Returns the workflow history data manager.
	 * 
	 * @return Cream_Workflows_Data_Manager_Abstract
	 */
	protected function _getDataManager()
	{
		if (!$this->_dataManager) {
    		$config = $this->getConfig()->getNode('global/workflows/history');
    		$this->_dataManager = Cream_Workflows_Data_Manager::factory($config);
		}
		
		return $this->_dataManager;
	}
}