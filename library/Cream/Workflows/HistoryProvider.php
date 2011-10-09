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
 * The provider to access the workflow history.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Workflows_HistoryProvider
{
	/**
	 * Holds the manager object.
	 * 
	 * @var Cream_Workflows_HistoryManager
	 */
	protected static $_manager;
	
	/**
	 * Adds an entry to the workflow history.
	 * 
	 * @param Cream_Content_Item $item
	 * @param Cream_Guid $oldStateId
	 * @param Cream_Guid $newStateId
	 * @param string $message
	 * @return void
	 */	
	public static function addHistory(Cream_Content_Item $item, Cream_Guid $oldStateId, Cream_Guid $newStateId, $message)
	{
		return self::_getManager()->getCultures($repository);
	}
	
	/**
	 * Clears the workflow history of an item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public static function clearHistory(Cream_Content_Item $item)
	{
		return self::_getManager()->clearHistory($item);		
	}
	
	/**
	 * Returns an array holding history event for the item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return array
	 */
	public static function getHistory(Cream_Content_Item $item)
	{
		return self::_getManager()->getHistory($item);
	}
	
	/**
	 * Returns the workflow history manager
	 * 
	 * @return Cream_Workflows_HistoryManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Workflows_HistoryManager::instance();
		}		
		
		return self::$_manager;
	}	
}