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
 * An implementation of Ext.data.DataProxy that processes data requests within 
 * the same domain of the originating page.
 * 
 * Note: this class cannot be used to retrieve data from a domain other than 
 * the domain from which the running page was served. For cross-domain 
 * requests, use a ScriptTagProxy.
 * 
 * Be aware that to enable the browser to parse an XML document, the server 
 * must set the Content-Type header in the HTTP response to "text/xml".
 * 
 * @package		Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_HttpProxy extends Cream_Web_UI_ExtControls_Data_DataProxy 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_HttpProxy
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
		$this->setControl('Ext.data.HttpProxy');
	}
}