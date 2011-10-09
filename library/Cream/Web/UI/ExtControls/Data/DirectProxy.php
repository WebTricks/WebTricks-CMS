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
 * DirectProxy
 * 
 * @package		Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_DirectProxy extends Cream_Web_UI_ExtControls_Data_DataProxy
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_DirectProxy
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
		$this->setControl('Ext.data.DirectProxy');		
	}	
	
	/**
	 * Function to call when executing a request. directFn is a simple 
	 * alternative to defining the api configuration-parameter for Store's 
	 * which will not implement a full CRUD api.
	 *
	 * @param function $directFn
	 */
	public function setDirectFn($directFn)
	{
		$this->setAttribute('directFn', $directFn);
	}	
	
	/**
	 * Defaults to undefined. A list of params to be executed server side. 
	 * Specify the params in the order in which they must be executed on the 
	 * server-side as either (1) an Array of String values, or (2) a String of 
	 * params delimited by either whitespace, comma, or pipe. 
	 *
	 * @param array|string $paramOrder
	 */
	public function setParamOrder($paramOrder)
	{
		$this->setAttribute('paramOrder', $paramOrder);
	}

	/**
	 * Send parameters as a collection of named arguments (defaults to true). 
	 * Providing a paramOrder nullifies this configuration.
	 *
	 * @param boolean $paramsAsHash
	 */
	public function setParamsAsHash($paramsAsHash)
	{
		$this->setAttribute('paramsAsHash', $paramsAsHash);
	}	
}
