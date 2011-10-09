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
 * An implementation of Ext.data.DataProxy that reads a data object from a URL
 * which may be in a domain other than the originating domain of the running 
 * page.
 * 
 * Note that if you are retrieving data from a page that is in a domain that is 
 * NOT the same as the originating domain of the running page, you must use 
 * this class, rather than HttpProxy.
 * 
 * @package 	Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_ScriptTagProxy extends Cream_Web_UI_ExtControls_Data_DataProxy 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_ScriptTagProxy
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function
	 * 
	 * @return void
	 */
	public function __init()
	{
		$this->setControl('Ext.data.ScriptTagProxy');
	}
	
	/**
	 * The URL from which to request the data object.
	 *
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->setAttribute('url', $url);
	}

	/**
	 * (Optional) The number of milliseconds to wait for a response. Defaults 
	 * to 30 seconds.
	 *
	 * @param number $timeout
	 */
	public function setTimeout($timeout)
	{
		$this->setAttribute('timeout', $timeout);
	}

	/**
	 * The name of the parameter to pass to the server which tells the server 
	 * the name of the callback function set up by the load call to process 
	 * the returned data object. Defaults to "callback".
	 * 
	 * The server-side processing must read this parameter value, and generate 
	 * javascript output which calls this named function passing the data 
	 * object as its only parameter.
	 * 
	 * @param string $callbackParam
	 */
	public function setCallbackParam($callbackParam)
	{
		$this->setAttribute('callbackParam', $callbackParam);
	}

	/**
	 * (Optional) Defaults to true. Disable cacheing by adding a unique 
	 * parameter
	 *
	 * @param boolean $nocache
	 */
	public function setNocache($nocache)
	{
		$this->setAttribute('nocache', $nocache);
	}
}