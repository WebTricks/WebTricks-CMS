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
 * The class encapsulates a connection to the page's originating domain, 
 * allowing requests to be made either to a configured URL, or to a URL 
 * specified at request time.
 * 
 * Requests made by this class are asynchronous, and will return immediately. 
 * No data from the server will be available to the statement immediately 
 * following the request call. To process returned data, use a success 
 * callback in the request options object, or an event listener.
 *  
 * @package		Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_Connection extends Cream_Web_UI_ExtControls_Util_Observable
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_Connection
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
		$this->setControl('Ext.data.Connection');		
	}	
	
	/**
	 * Whether this request should abort any pending requests. (defaults to 
	 * false)
	 *
	 * @param boolean $autoAbort
	 */
	public function setAutoAbort($autoAbort)
	{
		$this->setAttribute('autoAbort', $autoAbort);
	}	
	
	/**
	 * An object containing request headers which are added to each request 
	 * made by this object. (defaults to undefined)
	 *
	 * @param object $defaultHeaders
	 */
	public function setDefaultHeaders($defaultHeaders)
	{
		$this->setAttribute('defaultHeaders', $defaultHeaders);
	}		
	
	/**
	 * True to add a unique cache-buster param to GET requests. (defaults to 
	 * true)
	 *
	 * @param boolean $disableCaching
	 */
	public function setDisableCaching($disableCaching)
	{
		$this->setAttribute('disableCaching', $disableCaching);
	}		
	
	/**
	 * Change the parameter which is sent went disabling caching through a 
	 * cache buster. Defaults to '_dc'
	 *
	 * @param string $disableCachingParam
	 */
	public function setDisableCachingParam($disableCachingParam)
	{
		$this->setAttribute('disableCachingParam', $disableCachingParam);
	}		

	/**
	 * An object containing properties which are used as extra parameters to 
	 * each request made by this object. (defaults to undefined)
	 *
	 * @param object $extraParams
	 */
	public function setExtraParams($extraParams)
	{
		$this->setAttribute('extraParams', $extraParams);
	}	

	/**
	 * The default HTTP method to be used for requests. (defaults to undefined; 
	 * if not set, but request params are present, POST will be used; otherwise, 
	 * GET will be used.)
	 *
	 * @param string $method
	 */
	public function setMethod($method)
	{
		$this->setAttribute('method', $method);
	}	
	
	/**
	 * The timeout in milliseconds to be used for requests. (defaults to 30000)
	 *
	 * @param integer $timeout
	 */
	public function setTimeout($timeout)
	{
		$this->setAttribute('timeout', $timeout);
	}	

	/**
	 * The default URL to be used for requests to the server. Defaults to 
	 * undefined.
	 * 
	 * The url config may be a function which returns the URL to use for the 
	 * Ajax request. The scope (this reference) of the function is the scope 
	 * option passed to the request method.
	 *
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->setAttribute('url', $url);
	}		
}