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
 * DataWriter extension for writing an array or single Ext.data.Record 
 * object(s) in preparation for executing a remote CRUD action.
 * 
 * @package 	Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_JsonWriter extends Cream_Web_UI_ExtControls_Data_DataWriter
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_JsonWriter
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
		$this->setControl('Ext.data.JsonWriter');
	}

	/**
	 * true to encode the hashed data. Defaults to true. When using 
	 * Ext.data.DirectProxy, set this to false since Ext.Direct.JsonProvider 
	 * will perform its own json-encoding. In addition, if you're using 
	 * Ext.data.HttpProxy, setting to false will cause HttpProxy to transmit 
	 * data using the jsonData configuration-params of Ext.Ajax.request instead
	 * of params. When using a Ext.data.Store.restful Store, some serverside 
	 * frameworks are tuned to expect data through the jsonData mechanism. In 
	 * those cases, one will want to set encode: false, as in let the 
	 * lower-level connection object (eg: Ext.Ajax) do the encoding.
	 *
	 * @param boolean $encode
	 */
	public function setEncode($encode)
	{
		$this->setAttribute('encode', $encode);
	}
	
	/**
	 * False to send only the id to the server on delete, true to encode it in 
	 * an object literal. Defaults to false.
	 *
	 * @param boolean $encodeDelete
	 */
	public function setEncodeDelete($encodeDelete)
	{
		$this->setAttribute('encodeDelete', $encodeDelete);
	}	
}