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
 * Represents a content repository
 * 
 * @package 	Cream_Content
 * @author 		Danny Verkade
 */
class Cream_Content_Repository
{
	/**
	 * Name of the repository
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * Read only
	 * 
	 * @var boolean
	 */
	protected $readOnly;
	
	/**
	 * The data manager for this repository
	 * 
	 * @var Cream_Content_Data_Manager_Abstract
	 */
	protected $dataManager;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param string $name
	 * @param array $config
	 * @return Cream_Content_Repository
	 */
	public static function instance($name, $config)
	{
		return Cream::instance(__CLASS__, $name, $config);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param string $name
	 * @param array $config
	 * @return void
	 */
	public function __init($name, Cream_Config_Xml_Element $config)
	{
		$this->name = $name;
		$this->setReadOnly($config->is('read_only'));
		$this->setDataManager(Cream_Content_Data_Manager::factory($this, $config));
	}
	
	/**
	 * Returns a collection of cultures in the repository.
	 * 
	 * @return Cream_Globalization_CultureCollection
	 */
	public function getCultures()
	{
		return Cream_Content_Managers_CultureProvider::getCultures($this);
	}
	
	/**
	 * Retrieves an item
	 * 
	 * @param Cream_Guid $itemId
 	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_Item
	 */
	public function getItem(Cream_Guid $itemId, $culture = null, $version = null)
	{
		return Cream_Content_Managers_ItemProvider::getItem($this, $itemId, $culture, $version);
	}
	
	/**
	 * Returns the content item by the given path. If no item is found
	 * returns null.
	 * 
	 * @param string $path
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_Item
	 */
	public function getItemByPath($path, $culture = null, $version = null)
	{
		$itemId = $this->getItemIdByPath($path);
				
		if ($itemId) {
			return $this->getItem($itemId, $culture, $version);
		}
	}
	
	/**
	 * Returns the item id of a path.
	 * 
	 * @param string $path
	 * @return Cream_Guid
	 */
	public function getItemIdByPath($path)
	{
		return $this->getDataManager()->resolvePath($path);
	}
	
	/**
	 * Returns true if the content repository is read only, otherwise
	 * returns false.
	 * 
	 * @return boolean
	 */
	public function isReadOnly()
	{
		return $this->readOnly;
	}
	
	/**
	 * Sets if this repository is read only.
	 * 
	 * @param boolean $readOnly
	 */
	public function setReadOnly($readOnly)
	{
		$this->readOnly = $readOnly;
	}
	
	/**
	 * Returns the name of the repository
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Returns the data provider.
	 *
	 * @return Cream_Content_Data_Manager_Abstract
	 */
	public function getDataManager()
	{
		return $this->dataManager;
	}
	
	/**
	 * Sets the data provider
	 * 
	 * @param Cream_Content_Data_Manager_Abstract $dataManager
	 */
	public function setDataManager(Cream_Content_Data_Manager_Abstract $dataManager)
	{
		$this->dataManager = $dataManager;
	}
}