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
 * Object representing item data. 
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemData 
{
	/**
	 * The object holding the item definition
	 * 
	 * @var Cream_Content_ItemDefinition
	 */
	protected $itemDefinition;
	
	/**
	 * Object holding the culture information
	 * 
	 * @var Cream_Globalization_Culture
	 */
	protected $culture;
	
	/**
	 * Object holding the version information
	 * 
	 * @var Cream_Content_Version
	 */
	protected $version;
	
	/**
	 * Object holding the field list
	 * 
	 * @var Cream_Content_FieldList
	 */
	protected $fieldList;
	
	/**
	 * Cerate a new instance of this class
	 * 
	 * @param Cream_Content_ItemDefinition $itemDefinition
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @param Cream_Content_ItemFieldData $fieldList
	 * @return Cream_Content_ItemData
	 */
	public static function instance(Cream_Content_ItemDefinition $itemDefinition, Cream_Globalization_Culture $culture, Cream_Content_Version $version, Cream_Content_ItemFieldData $fieldList) 
	{
		return Cream::instance(__CLASS__, $itemDefinition, $culture, $version, $fieldList);
	}	
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_ItemDefinition $itemDefinition
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @param Cream_Content_ItemFieldData $fieldList
	 * @return void
	 */
	public function __init(Cream_Content_ItemDefinition $itemDefinition, Cream_Globalization_Culture $culture, Cream_Content_Version $version, Cream_Content_ItemFieldData $fieldList)
	{
		$this->itemDefinition = $itemDefinition;
		$this->culture = $culture;
		$this->version = $version;
		$this->fieldList = $fieldList;
	}
	
	/**
	 * Returns the item definition
	 * 
	 * @return Cream_Content_ItemDefinition
	 */
	public function getItemDefinition()
	{
		return $this->itemDefinition;
	}
	
	/**
	 * Returns the culture
	 * 
	 * @return Cream_Globalization_Culture
	 */
	public function getCulture()
	{
		return $this->culture;
	}
	
	/**
	 * Returns the version
	 * 
	 * @return Cream_Content_Version
	 */
	public function getVersion()
	{
		return $this->version;
	}
	
	/**
	 * Returns the field list
	 * 
	 * @return Cream_Content_ItemFieldData
	 */
	public function getFieldList()
	{
		return $this->fieldList;
	}
}