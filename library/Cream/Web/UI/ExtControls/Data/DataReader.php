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
 * Abstract base class for reading structured data from a data source and 
 * converting it into an object containing Ext.data.Record objects and metadata
 * for use by an Ext.data.Store. This class is intended to be extended and 
 * should not be created directly. For existing implementations, see 
 * Ext.data.ArrayReader, Ext.data.JsonReader and Ext.data.XmlReader.
 * 
 * @package		Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_DataReader extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_DataReader
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
		$this->setControl('Ext.data.DataReader');		
	}	
		
	/**
	 * Array of Field definition objects 
	 *
	 * @param array $fields
	 */
	public function setFields($fields)
	{
		$this->setAttribute('fields', $fields);
	}
	
	/**
	 * Optional name of a property within a server-response that represents a 
	 * user-feedback message.
	 *
	 * @param string $messageProperty
	 */
	public function setMessageProperty($messageProperty)
	{
		$this->setAttribute('messageProperty', $messageProperty);
	}
}	