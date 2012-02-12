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
 * @copyright Copyright (c) 2007-2012 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Factory for HTTP client classes
 *
 * @category    Cream
 * @package     Cream_IO
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */ 
class Cream_IO_Http_Client
{
	/**
	 * Factory for HTTP client
	 * 
	 * @param string/false $frontend  'curl'/'socket' or false for auto-detect
	 * @return Cream_IO_Http_Client_Interface
	 */
	public static function factory($frontend = false) 
	{
		if(false === $frontend) {
            $frontend = self::detectFrontend();            			
		}
		
		if(false === $frontend) { 
			throw new Exception("Cannot find frontend automatically, set it manually");
		}
		
		$class = __CLASS__."_".str_replace(' ', DIRECTORY_SEPARATOR, ucwords(str_replace('_', ' ', $frontend)));
		$obj = Cream::instance(__CLASS__);
		return $obj;
	}
	
	/**
	 * Detects frontend type.
	 * Priority is given to CURL
	 * 
	 * @return string/bool
	 */
	protected static function detectFrontend()
	{
	   if(function_exists("curl_init")) {
	   	   return "curl";	   	
	   }
	   if(function_exists("fsockopen")) {
	   	   return "socket";
	   }
	   return false;	   
	}
}