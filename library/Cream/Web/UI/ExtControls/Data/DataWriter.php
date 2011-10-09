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
 * Ext.data.DataWriter facilitates create, update, and destroy actions between 
 * an Ext.data.Store and a server-side framework. A Writer enabled Store will 
 * automatically manage the Ajax requests to perform CRUD actions on a Store.
 * 
 * Ext.data.DataWriter is an abstract base class which is intended to be 
 * extended and should not be created directly. 
 * 
 * @package		Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_DataWriter extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_DataWriter
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
		$this->setControl('Ext.data.DataWriter');		
	}	
		
	/**
	 * False by default. Set true to have the DataWriter always write HTTP 
	 * params as a list, even when acting upon a single record.
	 *
	 * @param boolean $listful
	 */
	public function setListful($listful)
	{
		$this->setAttribute('listful', $listful);
	}		
	
	/**
	 * false by default. Set true to have DataWriter return ALL fields of a 
	 * modified record -- not just those that changed. false to have DataWriter
	 * only request modified fields from a record.
	 *
	 * @param boolean $writeAllFields
	 */
	public function setWriteAllFields($writeAllFields)
	{
		$this->setAttribute('writeAllFields', $writeAllFields);
	}		
}