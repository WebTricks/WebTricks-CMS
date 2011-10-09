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
 * Manages the content item
 * 
 * @package Cream_Content_Managers
 * @author Danny Verkade
 */
class Cream_Content_Managers_ItemManager extends Cream_ApplicationComponent
{
	/**
	 * Inner cache of items already loaded.
	 * 
	 * @var array
	 */
	protected $_innerCache = array();

	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Content_Manager_ItemManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Ads a new version to the item. Returns the new version of the 
	 * item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Item
	 */
	public function addVersion($item)
	{
		$realItem = $this->_mapToRealItem($item);
		$newItem = $this->repository->getDataManager()->addVersion($realItem);
		
		if ($newItem === null) {
			return null;
		}
		
		return $this->_mapToVirtualItem($newItem, $item);
	}
	
	public function copyItem($item, $destination)
	{
		
	}
	
	/**
	 * Creates an item under the given parent item
	 * 
	 * @param Cream_Guid $templateId
	 * @param Cream_Content_Item $parentItem
	 * @return Cream_Content_Item
	 */
	public function createItem(Cream_Guid $templateId, Cream_Content_Item $parentItem) 
	{
		$itemId = Cream_Guid::generateGuid();
		$version = Cream_Content_Version::getFirst();
		$culture = $parentItem->getCulture();
		
		$itemDefinition = Cream_Content_ItemDefinition::instance($itemId, $templateId, $parentItem->getParentId(), '<<NEW ITEM>>');
		$itemFields = $this->_getItemFields($itemId, $culture, $version);
		$itemData = Cream_Content_ItemData::instance($itemDefinition, $culture, $version, $itemFields);
		$item = Cream_Content_Item::instance($itemId, $itemData);
		
		// Add the new item to the parent
		$parentItem->getChildren()->add($item);
		
		// Always set to cache the item, so changes will be cached automatically
		$this->_addItemToCache($itemId, $culture, $version, $item);		
		
		return $item;
	}
	
	/**
	 * Deletes an item, returns true if the item is deleted, otherwise
	 * returns false.
	 * 
	 * @param Cream_Content_Item $item
	 * @return boolean
	 */
	public function deleteItem(Cream_Content_Item $item)
	{
		$this->_deleteItemFromCache($item->getRepository(), $item->getItemId(), $item->getCulture(), $item->getVersion());	
		$this->repository->getDataManager()->deleteItem($item);
	}
	
	/**
	 * Returns an array containing all cultures for the given item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Globalization_CultureCollection
	 */
	public function getItemCultures(Cream_Content_Item $item)
	{
		return $item->getRepository()->getDataManager()->getItemCultures($item->getItemId());
	}
	
	/**
	 * Returns a content item
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_Item
	 */
	public function getItem(Cream_Content_Repository $repository, Cream_Guid $itemId, $culture = null, $version = null, $disableSecurity = false) 
	{	
		$cacheItem = false;
				
		if (!$culture) {
			$culture = $this->getApplication()->getContext()->getCulture();
		}		
				
		if (!$version) {
			//$version = $repository->getDataManager()->getLatestVersion($itemId, $culture);
			$version = Cream_Content_Version::getFirst();
		}
				
		$item = $this->_getItemFromCache($repository, $itemId, $culture, $version);
	
		if ($item === null) {
			$cacheItem = true;
			$itemData = $this->getItemData($repository, $itemId, $culture, $version);

			if ($itemData === null) {
				return null;
			}			
			
			$item = Cream_Content_Item::instance($itemId, $itemData, $repository);
		}
		
		$this->_addItemToCache($repository, $itemId, $culture, $version, $item, $cacheItem);
		
		if ($disableSecurity || $item->getAccess()->canRead()) {
			return $item;
		} else {
			return null;
		}
	}
	
	/**
	 * Gets a content item by its path
	 * 
	 * @param string $path
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_Item
	 */
	public function getItemByPath($path, $culture = null, $version = null)
	{	
		$itemId = $this->repository->getDataManager()->resolvePath($path);
		
		if ($itemId) {
			return $this->getItem($itemId, $culture, $version);
		} else {
			return null;
		}
	}

	/**
	 * Returns the item data
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Version $version
	 * @return Cream_Content_ItemData
	 */
	public function getItemData(Cream_Content_Repository $repository, Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version)
	{
		$itemDefinition = $this->_getItemDefinition($repository, $itemId);
		
		if (!$itemDefinition) {
			return null;
		}
		
		$itemFields = $this->_getItemFields($repository, $itemId, $culture, $version);
		$itemData = Cream_Content_ItemData::instance($itemDefinition, $culture, $version, $itemFields);
		
		return $itemData;
	}
	
	/**
	 * Returns the item definition
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @return Cream_Content_ItemDefinition
	 */
	protected function _getItemDefinition(Cream_Content_Repository $repository, Cream_Guid $itemId)
	{
		$itemDefinition = $this->_getItemDefinitionFromCache($repository, $itemId);
		
		if (!$itemDefinition) {
			$itemDefinition = $repository->getDataManager()->loadItemDefinition($itemId);
			
			if ($itemDefinition) {
				$this->_addItemDefinitionToCache($repository, $itemId, $itemDefinition);
			}
		} 
		
		return $itemDefinition;
	}
	
	/**
	 * Returns the item fields
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 */
	protected function _getItemFields(Cream_Content_Repository $repository, Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version)
	{
		return $repository->getDataManager()->loadItemFields($itemId, $culture, $version);
	}
	
	/**
	 * Returns the unique cache key to cache this item by.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return string
	 */
	protected function _getItemCacheKey(Cream_Content_Repository $repository, Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version) 
	{
		return $repository->getName() .'.item.'. $itemId .'.'. $culture .'.'. $version;	
	}

	/**
	 * Returns the unique cache key to cache this item by.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return string
	 */
	protected function _getItemDefinitionCacheKey(Cream_Content_Repository $repository, Cream_Guid $itemId) 
	{
		return $repository->getName() .'.itemdefinition.'. $itemId;	
	}
	
	/**
	 * Returns a content item from the cache. It will first hit the
	 * inner cache and then tries to get it from the applications
	 * cache.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_Item
	 */
	protected function _getItemFromCache(Cream_Content_Repository $repository, Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version)
	{
		$key = $this->_getItemCacheKey($repository, $itemId, $culture, $version);

		if (isset($this->_innerCache[$key])) {
			return $this->_innerCache[$key];
		} else {
			$cache = $this->getApplication()->getCache()->load($key);
			
			if ($cache === false) {
				return null;
			} else {
				return $cache;
			}
		}
	}

	/**
	 * Returns a item definition from the inner cache.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @return Cream_Content_ItemDefinition
	 */
	protected function _getItemDefinitionFromCache(Cream_Content_Repository $repository, Cream_Guid $itemId)
	{
		$key = $this->_getItemDefinitionCacheKey($repository, $itemId);

		if (isset($this->_innerCache[$key])) {
			return $this->_innerCache[$key];
		} else {
			return null;
		}
	}
	
	
	/**
	 * Deletes a cached item from the cache. It will delete it from
	 * the inner cache and from the application cache.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return void
	 */
	protected function _deleteItemFromCache(Cream_Content_Repository $repository, Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version)
	{
		$key = $this->_getItemCacheKey($repository, $itemId, $culture, $version);

		if (isset($this->_innerCache[$key])) {
			unset($this->_innerCache[$key]);
		}
		
		$this->getApplication()->getCache()->remove($key);
	}
	
	/**
	 * Deletes a cached child ids from the cache. It will delete it 
	 * from the inner cache and from the application cache.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return void
	 */
	protected function _deleteChildIdsFromCache(Cream_Content_Repository $repository, Cream_Guid $itemId)
	{
		$key = $this->_getChildIdsCacheKey($repository, $itemId);

		if (isset($this->_innerCache[$key])) {
			unset($this->_innerCache[$key]);
		}
		
		$this->getApplication()->getCache()->remove($key);
	}	
	
	/**
	 * Caches a content item in the inner cache and the application
	 * cache. 
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	protected function _addItemToCache(Cream_Content_Repository $repository, Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version, Cream_Content_Item $item, $external = false)
	{
		$key = $this->_getItemCacheKey($repository, $itemId, $culture, $version);
		$this->_innerCache[$key] = $item;
		
		if ($external) {
			$this->getApplication()->getCache()->save($item, $key);
		}
	}
	
	/**
	 * Caches an item definition to the inner cache
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @return void
	 */
	protected function _addItemDefinitionToCache(Cream_Content_Repository $repository, Cream_Guid $itemId, Cream_Content_ItemDefinition $itemDefinition)
	{
		$key = $this->_getItemDefinitionCacheKey($repository, $itemId);
		$this->_innerCache[$key] = $itemDefinition;
	}	
	
	protected function _mapToRealItem($item)
	{
		if (!Cream_Content_Managers_ProxyProvider::isVirtual($item)) {
			return $item;
		} else {
			return Cream_Content_Managers_ProxyProvider::getRealItem($item);
		}
	}
	
	protected function _mapToVirtualItem($item)
	{
		if (!Cream_Content_Managers_ProxyProvider::isProxy($item)) {
			return $item;
		} else {
			return Cream_Content_Managers_ProxyProvider::getRealItem($item);
		}		
	}
		
	/**
	 * Returns the parent item of the given item
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Item
	 */	
	public function getParent(Cream_Content_Item $item, $disableSecurity = false)
	{
		return $this->getItem($item->getRepository(), $item->getParentId(), $item->getCulture(), Cream_Content_Version::getLatest(), $disableSecurity);
	}
	
	/**
	 * Returns the content item of the root node
	 * 
	 * @return Cream_Content_Item
	 */
	public function getRootItem()
	{
		$this->getItem(Cream_Application_ItemIds::rootId);
	}
	
	public function getVersions()
	{
		
	}
	
	/**
	 * Check to see if there are any children under the given item.
	 * Returns true if there are, otherwise false.
	 * 
	 * @param Cream_Content_Item $item
	 * @return boolean
	 */
	public function hasChildren(Cream_Content_Item $item)
	{
		if (count($this->_getChildIds($item))) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Loads the item ids of the child items. Returns an array with the
	 * item ids.sssssssss 
	 * 
	 * @param Cream_Content_Item $item
	 * @return array
	 */
	protected function _getChildIds(Cream_Content_Item $item)
	{
		$cacheChildIds = false;
		$childIds = $this->_getChildIdsFromCache($item->getRepository(), $item->getItemId());
		
		if ($childIds === null) {
			$cacheChildIds = true;
			$childIds = $item->getRepository()->getDataManager()->loadChildIds($item->getItemId());
		}
		
		$this->_addChildIdsToCache($item->getRepository(), $item->getItemId(), $childIds, $cacheChildIds);
		
		return $childIds;
	}
	
	/**
	 * Retrieves the child ids from the cache. Returns an array when
	 * items are found, otherwise null. 
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param array|null
	 */
	protected function _getChildIdsFromCache(Cream_Content_Repository $repository, Cream_Guid $itemId)
	{
		$key = $this->_getChildIdsCacheKey($repository, $itemId);

		if (isset($this->_innerCache[$key])) {
			return $this->_innerCache[$key];
		} else {
			$cache = $this->getApplication()->getCache()->load($key);
			
			if ($cache === false) {
				return null;
			} else {
				return $cache;
			}
		}
	}
	
	/**
	 * Saves the child ids to the cache.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @param array $childIds
	 * @return void
	 */
	protected function _addChildIdsToCache(Cream_Content_Repository $repository, Cream_Guid $itemId, $childIds, $external)
	{
		$key = $this->_getChildIdsCacheKey($repository, $itemId);
		$this->_innerCache[$key] = $childIds;
		
		if ($external) {
			$this->getApplication()->getCache()->save($childIds, $key);
		}
	}
	
	/**
	 * Generated the unique cache key to store the child ids.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Guid $itemId
	 * @return string
	 */
	protected function _getChildIdsCacheKey(Cream_Content_Repository $repository, Cream_Guid $itemId) 
	{
		return $repository->getName() .'.childids.'. $itemId;	
	}
	
	/**
	 * Returns a collection of child item which are under the given
	 * item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemCollection
	 */
	public function getChildren(Cream_Content_Item $item)
	{
		$collection = Cream_Content_ItemCollection::instance();
		
		foreach($this->_getChildIds($item) as $itemId) {
			$item = $this->getItem($item->getRepository(), $itemId, $item->getCulture());		
			if ($item) {
				$collection->add($item);
			}			
		}
		
		$collection->sort(Cream_Content_ItemCollection::defaultComparer);
		
		return $collection;
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
	public function moveItem(Cream_Content_Item $item, Cream_Content_Item $destination)
	{	
		$source = $item->getParent();
		$this->_deleteItemFromCache($item->getRepository(), $item->getItemId(), $item->getCulture(), $item->getVersion());
		$this->_deleteItemFromCache($destination->getRepository(), $destination->getItemId(), $destination->getCulture(), $destination->getVersion());
		$this->_deleteChildIdsFromCache($source->getRepository(), $source->getItemId());
		$this->_deleteChildIdsFromCache($destination->getRepository(), $destination->getItemId());
		
		return $item->getRepository()->getDataManager()->moveItem($item->getItemId(), $destination->getItemId());
	}
	
	/**
	 * Saves an item
	 * 
	 * @param Cream_Content_Item $item
	 * @return boolean
	 */	
	public function saveItem(Cream_Content_Item $item)
	{
		if (!$item->isModified()) {
			return false;
		} else {
			$item->getRepository()->getDataManager()->saveItem($item);
			$item->reload();
			$this->_deleteItemFromCache($item->getRepository(), $item->getItemId(), $item->getCulture(), $item->getVersion(), $item);
			return true;
		}
	}
}