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
 * Small helper class to create an Ext.data.Store configured with an 
 * Ext.data.DirectProxy and Ext.data.JsonReader to make interacting with an 
 * Ext.Direct Server-side Provider easier. To create a different proxy/reader 
 * combination create a basic Ext.data.Store configured as needed.
 * 
 * @package		Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_DirectStore extends Cream_Web_UI_ExtControls_Data_Store
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_DirectStore
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
		$this->setControl('Ext.data.DirectStore');		
	}	
}