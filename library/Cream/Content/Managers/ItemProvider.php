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
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * The content item provider
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Managers_ItemProvider 
{
	/**
	 * holding the manager objects
	 * 
	 * @var Cream_Content_Managers_ItemManager
	 */
	protected static $_manager;	
	
	/**
	 * Ads a version to the item. Returns the new version of the item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Item
	 */
	public static function addVersion($item)
	{
		return self::_getManager()->addVersion($item);
	}
	
	public static function copyItem($source, $destination)
	{
		
	}

	/**
	 * Creates an item under the given item.
	 * 
	 * @param Cream_Guid $templateId
	 * @param Cream_Content_Item $parentItem
	 * @return Cream_Content_Item
	 */	
	public static function createItem(Cream_Guid $templateId, Cream_Content_Item $parentItem)
	{
		return self::_getManager()->createItem($templateId, $parentItem);
	}
	
	/**
	 * Deletes an item from the repository
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public static function deleteItem(Cream_Content_Item $item)
	{
		self::_getManager()->deleteItem($item);
	}
	
	/**
	 * Gets the collection of child items 
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemCollection
	 */
	public static function getChildren(Cream_Content_Item $item)
	{
		return self::_getManager()->getChildren($item);
	}
	
	/**
	 * Returns an array containing all cultures for the given item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return array
	 */
	public static function getItemCultures(Cream_Content_Item $item) 
	{
		return self::_getManager()->getItemCultures($item);		
	}
	
	/**
	 * Get a content item
	 * 
	 * @param Cream_Content_Repository $re
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_Item
	 */
	public static function getItem(Cream_Content_Repository $repository, Cream_Guid $itemId, $culture = null, $version = null)
	{
		return self::_getManager()->getItem($repository, $itemId, $culture, $version);
	}
	
	/**
	 * Returns the item data
	 *  
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 */
	public static function getItemData(Cream_Content_Repository $repository, Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version)
	{
		return self::_getManager()->getItemData($repository, $itemId, $culture, $version);
	}

	/**
	 * Get a content item by it's path
	 * 
	 * @param string $path
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_Item
	 */
	public static function getItemByPath($path, $culture = null, $version = null)
	{
		return self::_getManager()->getItemByPath($path, $culture, $version);		
	}
	
	/**
	 * Returns the parent item of the given item
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Item
	 */
	public static function getParent(Cream_Content_Item $item, $disableSecurity = false)
	{
		return self::_getManager()->getParent($item, $disableSecurity);
	}
	
	/**
	 * Returns the content item of the root node
	 * 
	 * @return Cream_Content_Item
	 */
	public static function getRootItem()
	{
		return self::_getManager()->getRootItem();
	}
	
	public static function getVersions($item)
	{
		
	}
	
	/**
	 * Check to see if there are any children under the given item.
	 * Returns true if there are, otherwise false.
	 * 
	 * @param Cream_Content_Item $item
	 * @return boolean
	 */
	public static function hasChildren(Cream_Content_Item $item)
	{
		return self::_getManager()->hasChildren($item);		
	}
	
	/**
	 * Moves a content item. The destination item will become the new
	 * parent of the item. Returns true if the item was moves, 
	 * othwerwise false.
	 * 
	 * @param Cream_Content_Item $item
	 * @param Cream_Content_Item $destination
	 * @return boolean
	 */
	public static function moveItem(Cream_Content_Item $item, Cream_Content_Item $destination)
	{
		return self::_getManager()->moveItem($item, $destination);
	}
	
	/**
	 * Saves an item
	 * 
	 * @param Cream_Content_Item $item
	 * @return boolean
	 */
	public static function saveItem(Cream_Content_Item $item)
	{
		return self::_getManager()->saveItem($item);
	}
	
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Content_Managers_ItemManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Content_Managers_ItemManager::instance();
		}		
		
		return self::$_manager;
	}
}