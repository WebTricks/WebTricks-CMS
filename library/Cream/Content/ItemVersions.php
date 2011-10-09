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
 * Provides methods for working with versions of a content item. 
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemVersions
{
	/**
	 * The content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $item;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemVersions
	 */
	public static function instance(Cream_Content_Item $item)
	{
		return Cream::instance(__CLASS__, $item);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public function __init(Cream_Content_Item $item)
	{
		$this->item = $item;
	}	
	
	/**
	 * Adds a new version to the source item. Returns the Cream_Content_Item
	 * object of the new version.
	 * 
	 * @return Cream_Content_Item
	 */
	public function addVersion()
	{
		return Cream_Content_Managers_ItemProvider::addVersion($this->item);
	}
	
	/**
	 * Get the versions the have coma after the current version
	 * 
	 * @return Cream_Content_ItemCollection
	 */
	public function getLaterVersions()
	{
		$items = Cream_Content_ItemCollection::instance();
		$versions = $this->getVersions();
		
		foreach($versions as $version) {
			if ($version->getNumber() > $this->item->getVersion()->getNumber()) {
				$item = $this->getVersion($version); 
				$items->add($item);
			}
		}
		
		return $items;	
	}
	
	/**
	 * Gets the latest version of the current item.
	 * 
	 * @return Cream_Content_Item
	 */
	public function getLatestVersion()
	{
		return $this->getVersion(Cream_Content_Version::getLatest());
	}
	
	/**
	 * Gets the versions that have come before the current version
	 * 
	 * @return Cream_Content_ItemCollection
	 */
	public function getOlderVersions()
	{
		$items = Cream_Content_ItemCollection::instance();
		$versions = $this->getVersions();
		
		foreach($versions as $version) {
			if ($version->getNumber() < $this->item->getVersion()->getNumber()) {
				$item = $this->getVersion($version); 
				$items->add($item);
			}
		}
		
		return $items;
	}
	
	/**
	 * Gets a list of version numbers
	 * 
	 * @return unknown_type
	 */
	public function getVersionNumbers()
	{
		$list = array();
		$versions = Cream_Content_Managers_ItemProvider::getVersions($this->item);
				
		return $list;
	}
	
	/**
	 * Gets the versions of the content item.
	 * 
	 * @param boolean $allCultures
	 * @return Cream_Content_ItemCollection
	 */
	public function getVersions($allCultures = false)
	{
		$items = Cream_Content_ItemCollection::instance();
		
		if ($allCultures) {
			$cultures = $this->item->getCultures();
		} else {
			$cultures = array($this->item->getCulture());
		}
		
		foreach($cultures as $culture) {
			$versions = $this->getVersionNumbers($culture);
			
			foreach($versions as $version) {
				$item = Cream_Content_Managers_ItemProvider::getItem($this->item->getItemId(), $culture, $version);
				$items->add($item);
			}
		}
		
		return $items;
	}
	
	/**
	 * Determines whether item is the latest version in item 
	 * culture. True if item is the latest version in item 
	 * culture otherwise, false. 
	 * 
	 * @return boolean
	 */
	public function isLatestVersion()
	{
		$latestVersion = $this->getLatestVersion();
		if ($latestVersion->getVersion()->getNumber() == $this->item->getVersion()->getNumber()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Removes all the versions of an item
	 * 
	 * @param boolean $allCultures
	 * @return unknown_type
	 */
	public function removeAll($allCultures = false)
	{
		foreach($this->getVersions($allCultures) as $item) {
			$item->getVersions()->removeVersion();
		}
	}
	
	/**
	 * Removes this version of the item
	 * 
	 * @return void
	 */
	public function removeVersion()
	{
		Cream_Content_Managers_ItemProvider::removeVersion($this->item);
	}
	
	/**
	 * Gets the Cream_Content_Item object with the specified version. 
	 * 
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_Item
	 */
	public function getVersion(Cream_Content_Version $version)
	{
		return Cream_Content_Managers_ItemProvider::getItem($this->item->getItemId(), $this->item->getCulture(), $version);
	}
}