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
 * Ext.list.ListView is a fast and light-weight implentation of a Grid like 
 * view with the following characteristics:
 * - resizable columns
 * - selectable
 * - column widths are initially proportioned by percentage based on the 
 *   container width and number of columns
 * - uses templates to render the data in any required format
 * - no horizontal scrolling
 * - no editing
 *
 * @package 	Cream_Web_UI_ExtControls_List
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_List_ListView extends Cream_Web_UI_ExtControls_DataView
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_List_ListView
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
		$this->setControl('Ext.list.ListView');
	}
	
	/**
	 * Specify true or specify a configuration object for 
	 * Ext.list.ListView.ColumnResizer to enable the columns to be resizable
	 * (defaults to true).
	 * 
	 * @param boolean|Cream_Web_UI_ExtControls_List_ColumnResizer $columnResize
	 */
	public function setColumnResize($columnResize)
	{
		$this->setAttribute('columnResize', $columnResize);		
	}	
	
	/**
	 * Specify true or specify a configuration object for 
	 * Ext.list.ListView.Sorter to enable the columns to be sortable (defaults
	 * to true).
	 * 
	 * @param boolean|Cream_Web_UI_ExtControls_List_Sorter $columnSort
	 */
	public function setColumnSort($columnSort)
	{
		$this->setAttribute('columnSort', $columnSort);		
	}

	/**
	 * An array of column configuration objects.
	 * 
	 * @param array $columns
	 */
	public function setColumns($columns)
	{
		$this->setAttribute('columns', $columns);		
	}		
	
	/**
	 * True to hide the header row (defaults to false so the header row will be
	 * shown).
	 * 
	 * @param boolean $hideHeaders
	 */
	public function setHideHeaders($hideHeaders)
	{
		$this->setAttribute('hideHeaders', $hideHeaders);		
	}		
	
	/**
	 * The template to be used for the header row. See tpl for more details.
	 * 
	 * @param string|array $internalTpl
	 */
	public function setInternalTpl($internalTpl)
	{
		$this->setAttribute('internalTpl', $internalTpl);		
	}		

	/**
	 * Defaults to 'dl' to work with the preconfigured tpl. This setting 
	 * specifies the CSS selector (e.g. div.some-class or span:first-child) 
	 * that will be used to determine what nodes the ListView will be working 
	 * with.
	 * 
	 * @param string $internalTpl
	 */
	public function setItemSelector($itemSelector)
	{
		$this->setAttribute('itemSelector', $itemSelector);		
	}		
	
	/**
	 * By default will defer accounting for the configured scrollOffset for 10 
	 * milliseconds. Specify true to account for the configured scrollOffset 
	 * immediately.
	 * 
	 * @param boolean $reserveScrollOffset
	 */
	public function setReserveScrollOffset($reserveScrollOffset)
	{
		$this->setAttribute('reserveScrollOffset', $reserveScrollOffset);		
	}		
	
	/**
	 * The amount of space to reserve for the scrollbar (defaults to 
	 * undefined). If an explicit value isn't specified, this will be 
	 * automatically calculated.
	 * 
	 * @param integer $scrollOffset
	 */
	public function setScrollOffset($scrollOffset)
	{
		$this->setAttribute('scrollOffset', $scrollOffset);		
	}					
}