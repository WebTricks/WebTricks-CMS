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
 * This class represents the primary interface of a component based 
 * grid control.
 *
 * Note: Although this class inherits many configuration options from 
 * base classes, some of them (such as autoScroll, layout, items, etc) 
 * won't function as they do with the base Panel class.
 * 
 * @package Cream_Web_UI_ExtControls_Grid
 * @author Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_GridPanel extends Cream_Web_UI_ExtControls_Panel 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_GridPanel
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
		$this->setControl('Ext.grid.GridPanel');
		$this->setAttribute('xtype', 'grid');
	}

	/**
	 * The Ext.data.Store the grid should use as its data source (required).
	 *
	 * @param ext.data.store $store
	 */
	public function setStore($store)
	{
		$this->setAttribute('store', $store);
	}

	/**
	 * The Ext.grid.ColumnModel to use when rendering the grid (required).
	 *
	 * @param Cream_Web_UI_ExtControls_Grid_ColumnModel $colModel
	 */
	public function setColModel(Cream_Web_UI_ExtControls_Grid_ColumnModel $colModel)
	{
		$this->setAttribute('colModel', $colModel);
	}
	
	/**
	 * True to add css for column separation lines. Default is false.
	 *
	 * @param boolean $columnLines
	 */
	public function setColumnLines($columnLines)
	{
		$this->setAttribute('columnLines', $columnLines);
	}	

	/**
	 * Any subclass of Ext.grid.AbstractSelectionModel that will provide the 
	 * selection model for the grid (defaults to Ext.grid.RowSelectionModel if 
	 * not specified).
	 *
	 * @param object $selModel
	 */
	public function setSelModel($selModel)
	{
		$this->setAttribute('selModel', $selModel);
	}
	
	/**
	 * An array of columns to auto create a ColumnModel
	 *
	 * @param array $columns
	 */
	public function setColumns($columns)
	{
		$this->setAttribute('columns', $columns);
	}

	/**
	 * Sets the maximum height of the grid - ignored if autoHeight is not on.
	 *
	 * @param number $maxHeight
	 */
	public function setMaxHeight($maxHeight)
	{
		$this->setAttribute('maxHeight', $maxHeight);
	}
	
	/**
	 * The DD group this GridPanel belongs to. Defaults to 'GridDD' if not 
	 * specified.
	 *
	 * @param string $ddGroup
	 */
	public function setDdGroup($ddGroup)
	{
		$this->setAttribute('ddGroup', $ddGroup);
	}

	/**
	 * Configures the text in the drag proxy. Defaults to: {0} selected row{1}
	 * {0} is replaced with the number of selected rows.
	 *
	 * @param string $ddText
	 */
	public function setDdText($ddText)
	{
		$this->setAttribute('ddText', $ddText);
	}	

	/**
	 * True to disable selections in the grid (defaults to false). - ignored 
	 * a SelectionModel is specified
	 *
	 * @param boolean $disableSelection
	 */
	public function setDisableSelection($disableSelection)
	{
		$this->setAttribute('disableSelection', $disableSelection);
	}

	/**
	 * False to turn off column reordering via drag drop (defaults to true).
	 *
	 * @param boolean $enableColumnMove
	 */
	public function setEnableColumnMove($enableColumnMove)
	{
		$this->setAttribute('enableColumnMove', $enableColumnMove);
	}

	/**
	 * False to turn off column resizing for the whole grid (defaults to true).
	 *
	 * @param boolean $enableColumnResize
	 */
	public function setEnableColumnResize($enableColumnResize)
	{
		$this->setAttribute('enableColumnResize', $enableColumnResize);
	}

	/**
	 * A config object that will be applied to the grid's UI view. Any of the 
	 * config options available for Ext.grid.GridView can be specified here. 
	 * This option is ignored if view is specified.
	 *
	 * @param object $viewConfig
	 */
	public function setViewConfig($viewConfig)
	{
		$this->setAttribute('viewConfig', $viewConfig);
	}

	/**
	 * The minimum width a column can be resized to. Defaults to 25.
	 *
	 * @param integer $minColumnWidth
	 */
	public function setMinColumnWidth($minColumnWidth)
	{
		$this->setAttribute('minColumnWidth', $minColumnWidth);
	}

	/**
	 * True to highlight rows when the mouse is over. Default is true.
	 *
	 * @param boolean $trackMouseOver
	 */
	public function setTrackMouseOver($trackMouseOver)
	{
		$this->setAttribute('trackMouseOver', $trackMouseOver);
	}

	/**
	 * True to enable drag and drop of rows.
	 *
	 * @param boolean $enableDragDrop
	 */
	public function setEnableDragDrop($enableDragDrop)
	{
		$this->setAttribute('enableDragDrop', $enableDragDrop);
	}

	/**
	 * True to enable hiding of columns with the header context menu.
	 *
	 * @param boolean $enableColumnHide
	 */
	public function setEnableColumnHide($enableColumnHide)
	{
		$this->setAttribute('enableColumnHide', $enableColumnHide);
	}

	/**
	 * True to enable the drop down button for menu in the headers.
	 *
	 * @param boolean $enableHdMenu
	 */
	public function setEnableHdMenu($enableHdMenu)
	{
		$this->setAttribute('enableHdMenu', $enableHdMenu);
	}

	/**
	 * True to stripe the rows. Default is false.
	 *
	 * @param boolean $stripeRows
	 */
	public function setStripeRows($stripeRows)
	{
		$this->setAttribute('stripeRows', $stripeRows);
	}

	/**
	 * The id of a column in this grid that should expand to fill unused space. 
	 * This value specified here can not be 0.
	 * 
	 * Note: If the Grid's view is configured with forceFit=true the 
	 * autoExpandColumn is ignored. See Ext.grid.Column.width for additional 
	 * details.
	 * 
	 * @param string $autoExpandColumn
	 */
	public function setAutoExpandColumn($autoExpandColumn)
	{
		$this->setAttribute('autoExpandColumn', $autoExpandColumn);
	}

	/**
	 * The minimum width the autoExpandColumn can have (if enabled). Defaults 
	 * to 50.
	 *
	 * @param integer $autoExpandMin
	 */
	public function setAutoExpandMin($autoExpandMin)
	{
		$this->setAttribute('autoExpandMin', $autoExpandMin);
	}
	
	/**
	 * An array of events that, when fired, should be bubbled to any parent 
	 * container. See Ext.util.Observable.enableBubble. Defaults to [].
	 *
	 * @param array $bubbleEvents
	 */
	public function setBubbleEvents($bubbleEvents)
	{
		$this->setAttribute('bubbleEvents', $bubbleEvents);
	}	

	/**
	 * The maximum width the autoExpandColumn can have (if enabled). Defaults 
	 * to 1000.
	 *
	 * @param integer $autoExpandMax
	 */
	public function setAutoExpandMax($autoExpandMax)
	{
		$this->setAttribute('autoExpandMax', $autoExpandMax);
	}

	/**
	 * The Ext.grid.GridView used by the grid. This can be set before a call 
	 * to render().
	 *
	 * @param object $view
	 */
	public function setView($view)
	{
		$this->setAttribute('view', $view);
	}

	/**
	 * An Ext.LoadMask config or true to mask the grid while loading (defaults 
	 * to false).
	 *
	 * @param object $loadMask
	 */
	public function setLoadMask($loadMask)
	{
		$this->setAttribute('loadMask', $loadMask);
	}

	/**
	 * True to hide the grid's header. Defaults to false.
	 *
	 * @param boolean $hideHeaders
	 */
	public function setHideHeaders($hideHeaders)
	{
		$this->setAttribute('hideHeaders', $hideHeaders);
	}
}