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
 * Supporting Class for Ext.list.ListView
 *
 * @package 	Cream_Web_UI_ExtControls_List
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_List_ColumnResizer extends Cream_Web_UI_ExtControls_Util_Observable
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_List_ColumnResizer
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
		
	/**
	 * Initialize function, set the Ext JS control
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.list.ColumnResizer');
	}
	
	/**
	 * The minimum percentage to allot for any column (defaults to .05)
	 * 
	 * @param integer $minPct
	 */
	public function setMinPct($minPct)
	{
		$this->setAttribute('minPct', $minPct);		
	}
}