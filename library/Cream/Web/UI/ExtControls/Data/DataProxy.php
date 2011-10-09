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
 * Abstract base class for implementations which provide retrieval of 
 * unformatted data objects. This class is intended to be extended and should
 * not be created directly.
 * 
 * @package		Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_DataProxy extends Cream_Web_UI_ExtControls_Util_Observable 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_DataProxy
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
		$this->setControl('Ext.data.DataProxy');		
	}	
	
	/**
	 * Specific urls to call on CRUD action methods "read", "create", "update"
	 * and "destroy".
	 *
	 * @param object $api
	 */
	public function setApi($api)
	{
		$this->setAttribute('api', $api);
	}	
	
	/**
	 * Abstract method that should be implemented in all subclasses. 
	 * 
	 * Note: Should only be used by custom-proxy developers. (e.g.: 
	 * HttpProxy.doRequest, DirectProxy.doRequest).
	 *
	 * @param function $doRequest
	 */
	public function setDoRequest($doRequest)
	{
		$this->setAttribute('doRequest', $doRequest);
	}	

	/**
	 * Abstract method that should be implemented in all subclasses. 
	 * 
	 * Note: Should only be used by custom-proxy developers. Callback for read
	 * action.
	 *
	 * @param function $onRead
	 */
	public function setOnRead($onRead)
	{
		$this->setAttribute('onRead', $onRead);
	}	

	/**
	 * Abstract method that should be implemented in all subclasses. 
	 * 
	 * Note: Should only be used by custom-proxy developers. Callback for 
	 * create, update and destroy actions.
	 *
	 * @param function $onWrite
	 */
	public function setOnWrite($onWrite)
	{
		$this->setAttribute('onWrite', $onWrite);
	}	

	/**
	 * Defaults to false. Set to true to operate in a RESTful manner.
	 * 
	 * Note: this parameter will automatically be set to true if the 
	 * Ext.data.Store it is plugged into is set to restful: true. If the Store
	 * is RESTful, there is no need to set this option on the proxy.
	 *
	 * @param boolean $restful
	 */
	public function setRestful($restful)
	{
		$this->setAttribute('restful', $restful);
	}		
}