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
 * This class encapsulates the user interface of an Ext.grid.GridPanel. Methods
 * of this class may be used to access user interface elements to enable 
 * special display effects. Do not change the DOM structure of the user 
 * interface.
 * 
 * This class does not provide ways to manipulate the underlying data. The data 
 * model of a Grid is held in an Ext.data.Store.
 *  
 * @package		Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_GridView extends Cream_Web_UI_ExtControls_Util_Observable 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_GridView
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
		$this->setControl('Ext.grid.GridView');
	}

	/**
	 * Defaults to false. Specify true to have the column widths 
	 * re-proportioned when the grid is initially rendered. The initially 
	 * configured width of each column will be adjusted to fit the grid width
	 * and prevent horizontal scrolling. If columns are later resized 
	 * (manually or programmatically), the other columns in the grid will not 
	 * be resized to fit the grid width. See forceFit also.
	 *
	 * @param boolean $autoFill
	 */
	public function setAutoFill($autoFill)
	{
		$this->setAttribute('autoFill', $autoFill);
	}
	
	/**
	 * Default text to display in the grid body when no rows are available 
	 * (defaults to '').
	 *
	 * @param string $cellSelector
	 */
	public function setCellSelector($cellSelector)
	{
		$this->setAttribute('cellSelector', $cellSelector);
	}	
	
	/**
	 * The number of levels to search for cells in event delegation (defaults 
	 * to 4)
	 *
	 * @param integer $cellSelectorDepth
	 */
	public function setCellSelectorDepth($cellSelectorDepth)
	{
		$this->setAttribute('cellSelectorDepth', $cellSelectorDepth);
	}		
	
	/**
	 * The text displayed in the 'Columns' menu item (defaults to 'Columns')
	 *
	 * @param string $columnsText
	 */
	public function setColumnsText($columnsText)
	{
		$this->setAttribute('columnsText', $columnsText);
	}
	
	/**
	 * True to defer emptyText being applied until the store's first load 
	 * (defaults to true).
	 *
	 * @param boolean $deferEmptyText
	 */
	public function setDeferEmptyText($deferEmptyText)
	{
		$this->setAttribute('deferEmptyText', $deferEmptyText);
	}	
	
	/**
	 * Default text (html tags are accepted) to display in the grid body when 
	 * no rows are available (defaults to ''). 
	 *
	 * @param string $emptyText
	 */
	public function setEmptyText($emptyText)
	{
		$this->setAttribute('emptyText', $emptyText);
	}		
	
	/**
	 * True to add a second TR element per row that can be used to provide a 
	 * row body that spans beneath the data row. Use the getRowClass method's 
	 * rowParams config to customize the row body.
	 *
	 * @param boolean $enableRowBody
	 */
	public function setEnableRowBody($enableRowBody)
	{
		$this->setAttribute('enableRowBody', $enableRowBody);
	}		

	/**
	 * True to auto expand/contract the size of the columns to fit the grid 
	 * width and prevent horizontal scrolling.
	 *
	 * @param boolean $forceFit
	 */
	public function setForceFit($forceFit)
	{
		$this->setAttribute('forceFit', $forceFit);
	}
	
	/**
	 * True to disable the grid column headers (defaults to false). Use the 
	 * ColumnModel menuDisabled config to disable the menu for individual 
	 * columns. 
	 *
	 * @param boolean $headersDisabled
	 */
	public function setHeadersDisabled($headersDisabled)
	{
		$this->setAttribute('headersDisabled', $headersDisabled);
	}	
	
	/**
	 * The selector used to find row bodies internally (defaults to 
	 * 'div.x-grid3-row')
	 *
	 * @param string $rowBodySelector
	 */
	public function setRowBodySelector($rowBodySelector)
	{
		$this->setAttribute('rowBodySelector', $rowBodySelector);
	}	
	
	/**
	 * The number of levels to search for row bodies in event delegation 
	 * (defaults to 10)
	 *
	 * @param integer $rowBodySelectorDepth
	 */
	public function setRowBodySelectorDepth($rowBodySelectorDepth)
	{
		$this->setAttribute('rowBodySelectorDepth', $rowBodySelectorDepth);
	}		
	
	/**
	 * The selector used to find rows internally (defaults to 'div.x-grid3-row')
	 *
	 * @param string $rowSelector
	 */
	public function setRowSelector($rowSelector)
	{
		$this->setAttribute('rowSelector', $rowSelector);
	}	
	
	/**
	 * The number of levels to search for rows in event delegation (defaults to 
	 * 10)
	 *
	 * @param integer $rowSelectorDepth
	 */
	public function setRowSelectorDepth($rowSelectorDepth)
	{
		$this->setAttribute('rowSelectorDepth', $rowSelectorDepth);
	}

	/**
	 * The amount of space to reserve for the vertical scrollbar (defaults to 
	 * undefined). If an explicit value isn't specified, this will be 
	 * automatically calculated.
	 *
	 * @param integer $scrollOffset
	 */
	public function setScrollOffset($scrollOffset)
	{
		$this->setAttribute('scrollOffset', $scrollOffset);
	}		
	
	/**
	 * The CSS class applied to a selected row (defaults to 
	 * 'x-grid3-row-selected').
	 * 
	 * Note that this only controls the row, and will not do anything for the 
	 * text inside it. 
	 *
	 * @param string $selectedRowClass
	 */
	public function setSelectedRowClass($selectedRowClass)
	{
		$this->setAttribute('selectedRowClass', $selectedRowClass);
	}		
	
	/**
	 * The text displayed in the 'Sort Ascending' menu item (defaults to 'Sort
	 * Ascending')
	 *
	 * @param string $sortAscText
	 */
	public function setAscText($sortAscText)
	{
		$this->setAttribute('sortAscText', $sortAscText);
	}	

	/**
	 * The CSS classes applied to a header when it is sorted. (defaults to 
	 * ['sort-asc', 'sort-desc'])
	 *
	 * @param array $sortClasses
	 */
	public function setSortClasses($sortClasses)
	{
		$this->setAttribute('sortClasses', $sortClasses);
	}

	/**
	 * The text displayed in the 'Sort Descending' menu item (defaults to 'Sort 
	 * Descending')
	 *
	 * @param string $sortDescText
	 */
	public function setDescText($sortDescText)
	{
		$this->setAttribute('sortDescText', $sortDescText);
	}	
}