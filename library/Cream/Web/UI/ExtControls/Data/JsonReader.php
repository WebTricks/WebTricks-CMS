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
 * Data reader class to create an Array of Ext.data.Record objects from a JSON 
 * packet based on mappings in a provided Ext.data.Record constructor.
 * 
 * @package 	Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_JsonReader extends Cream_Web_UI_ExtControls_Data_DataReader 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_JsonReader
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
		$this->setControl('Ext.data.JsonReader');
	}

	/**
	 * Name of the property from which to retrieve the total number of records 
	 * in the dataset. This is only needed if the whole dataset is not passed 
	 * in one go, but is being paged from the remote server. Defaults to total.
	 *
	 * @param string $totalProperty
	 */
	public function setTotalProperty($totalProperty)
	{
		$this->setAttribute('totalProperty', $totalProperty);
	}

	/**
	 * Name of the property from which to retrieve the success attribute. 
	 * Defaults to success. See Ext.data.DataProxy.exception for additional 
	 * information.
	 *
	 * @param string $successProperty
	 */
	public function setSuccessProperty($successProperty)
	{
		$this->setAttribute('successProperty', $successProperty);
	}

	/**
	 * Required. The name of the property which contains the Array of row 
	 * objects. Defaults to undefined. An exception will be thrown if the root
	 * property is undefined. The data packet value for this property should 
	 * be an empty array to clear the data or show no data.
	 *
	 * @param string $root
	 */
	public function setRoot($root)
	{
		$this->setAttribute('root', $root);
	}

	/**
	 * Name of the property within a row object that contains a record 
	 * identifier value. Defaults to id.
	 *
	 * @param string $idProperty
	 */
	public function setIdProperty($idProperty)
	{
		$this->setAttribute('idProperty', $idProperty);
	}
}