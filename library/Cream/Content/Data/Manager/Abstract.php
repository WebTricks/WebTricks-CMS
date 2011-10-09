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
 * Abstract class defining all methods a data manager should include.
 *
 * @package		Cream_Content_Data_Manager
 * @author		Danny Verkade
 */
abstract class Cream_Content_Data_Manager_Abstract extends Cream_ApplicationComponent
{
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	protected $repository;
		
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Config_Xml_Element $config
	 * @return Cream_Content_Data_Manager_Abstract
	 */
	public static function instance(Cream_Content_Repository $repository, Cream_Config_Xml_Element $config)
	{
		return Cream::instance(__CLASS__, $repository, $config);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Config_Xml_Element $config
	 */
	public function __init(Cream_Content_Repository $repository, Cream_Config_Xml_Element $config)
	{
		$this->repository = $repository;
	}

	/**
	 * Deletes an item
	 * 
	 * @param Cream_Guid $itemId
	 * @return void
	 */
	abstract public function deleteItem(Cream_Guid $itemId);
		
	/**
	 * Checks if a given item exists, returns true if it is, otherwise
	 * returns false.
	 * 
	 * @param Cream_Guid $itemId
	 * @return boolean
	 */
	abstract public function itemExists(Cream_Guid $itemId);
	
	/**
	 * Gets a list of all versions that have been defined in the 
	 * entire database. 
	 * 
	 * @return array
	 */
	abstract public function getVersions();
	
	/**
	 * Returns the cultures in the repository.
	 * 
	 * @return Cream_Globalization_CultureCollection
	 */
	abstract public function getCultures();
	
	/**
	 * Returns an item collection containing all cultures for the
	 * specified item.
	 * 
	 * @param Cream_Guid $itemId
	 * @return Cream_Globalization_CultureCollection
	 */
	abstract public function getItemCultures(Cream_Guid $itemId);
	
	/**
	 * Gets all items that are in a specific workflow state. 
	 * 
	 * @param Cream_Guid $stateId
	 * @return Cream_Content_ItemCollection
	 */
	abstract public function getItemsInWorkflowState(Cream_Guid $stateId);
	
	/**
	 * Adds an version to the item. Returns the version number of the
	 * new version.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_Version $version
	 * @param Cream_Globalization_Culture $culture
	 * @return integer
	 */
	abstract public function addVersion(Cream_Guid $itemId, Cream_Content_Version $version, Cream_Globalization_Culture $culture);
	
	/**
	 * Gets the latest version number for a specific culture. 
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @return integer
	 */
	abstract public function getLatestVersion(Cream_Guid $itemId, Cream_Globalization_Culture $culture);
	
	/**
	 * Loads the childs ids of the specified item ID into an array.
	 * Returns an empty array if there are no child items present.
	 * 
	 * @param Cream_Guid $itemId
	 * @return array
	 */
	abstract public function loadChildIds(Cream_Guid $itemId);
	
	/**
	 * Loads the item definition, throws an exception when the given
	 * item ID is not found.
	 * 
	 * @param Cream_Guid $itemId
	 * @return Cream_Content_ItemDefinition
	 * @throws Cream_Content_Data_Provider_Exception when the item ID
	 * is not found
	 */
	abstract public function loadItemDefinition(Cream_Guid $itemId);

	/**
	 * Loads all the field data
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_ItemFieldData
	 */
	abstract public function loadItemFields(Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version);	
	
	/**
	 * Saves an item
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	abstract public function saveItem(Cream_Content_Item $item);
	
	/**
	 * Moves an item, returns true of the item is moved, otherwise
	 * false.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Guid $destinationId
	 * @return boolean
	 */
	abstract public function moveItem(Cream_Guid $itemId, Cream_Guid $destinationId);
	
	/**
	 * Removes a version from an item. 
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_Version $version
	 * @return void
	 */
	abstract public function removeVersion(Cream_Guid $itemId, Cream_Content_Version $version);
	
	/**
	 * Removes a culture of the specified item.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @return void
	 */
	abstract public function removeCulture(Cream_Guid $itemId, Cream_Globalization_Culture $culture);
	
	/**
	 * Resolves a path to a item GUID. Returns the guid when an item found,
	 * otherwise returns null.
	 * 
	 * @param string $path
	 * @return Cream_Guid
	 */
	abstract public function resolvePath($path);
}