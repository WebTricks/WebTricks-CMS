<?php
/**
 * WebTricks - PHP Framework
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
 * Data reader class to create an Array of Ext.data.Record objects from an 
 * Array. Each element of that Array represents a row of data fields. The 
 * fields are pulled into a Record object using as a subscript, the mapping 
 * property of the field definition if it exists, or the field's ordinal 
 * position in the definition.
 * 
 * @package 	Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_ArrayReader extends Cream_Web_UI_ExtControls_Data_JsonReader 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_ArrayReader
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function
	 * 
	 */
	public function __init()
	{
		$this->setControl('Ext.data.ArrayReader');		
	}

	/**
	 * The subscript within row Array that provides an ID for the Record.
	 *
	 * @param integer $idIndex
	 */
	public function setIdIndex($idIndex)
	{
		$this->setAttribute('idIndex', $idIndex);
	}
}