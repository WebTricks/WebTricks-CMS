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
 * A custom wrapper for the Ext.grid.PropertyGrid's Ext.data.Store. This class 
 * handles the mapping between the custom data source objects supported by the 
 * grid and the Ext.grid.PropertyRecord format required for compatibility with 
 * the underlying store. Generally this class should not need to be used 
 * directly -- the grid's data should be accessed from the underlying store via 
 * the store property.
 * 
 * @package 	Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_PropertyStore extends Cream_Web_UI_ExtControls_Util_Observable 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_PropertyRecord
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
		$this->setControl('Ext.grid.PropertyStore');
	}
}