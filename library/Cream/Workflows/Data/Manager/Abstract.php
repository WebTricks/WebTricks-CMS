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
 * The data manager class, for creating the correct data manager.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
abstract class Cream_Workflows_Data_Manager_Abstract extends Cream_ApplicationComponent
{
	/**
	 * Retrieves the workflow history entries of an item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return array
	 */
	abstract function getHistory(Cream_Content_Item $item);
	
	/**
	 * Clears the workflow history entries of an item.
	 *  
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	abstract function clearHistory(Cream_Content_Item $item);

	/**
	 * Adds a workflow history entry.
	 * 
	 * @param Cream_Content_Item $item
	 * @param Cream_Guid $oldStateId
	 * @param Cream_Guid $newStateId
	 * @param string $message
	 * @return void
	 */
	abstract function addHistory(Cream_Content_Item $item, Cream_Guid $oldStateId, Cream_Guid $newStateId, $message);
}