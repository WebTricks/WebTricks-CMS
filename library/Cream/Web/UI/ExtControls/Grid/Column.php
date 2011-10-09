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
 * This class encapsulates column configuration data to be used in
 * the initialization of a ColumnModel.
 *
 * While subclasses are provided to render data in different ways,
 * this class renders a passed data field unchanged and is usually
 * used for textual columns.
 *
 * @package		Cream_Web_UI_ExtControls_Grid
 * @author		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_Column extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_Column
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
		$this->setControl('Ext.grid.Column');
		$this->setXtype('gridcolumn');		
	}

	/**
	 * Set the CSS text-align property of the column. Defaults to
	 * undefined.
	 *
	 * @param string $align
	 */
	public function setAlign($align)
	{
		$this->setAttribute('align', $align);
	}

	/**
	 * An inline style definition string which is applied to all table
	 * cells in the column (excluding headers). Defaults to undefined.
	 *
	 * @param string $css
	 */
	public function setCss($css)
	{
		$this->setAttribute('css', $css);
	}

	/**
	 * The name of the field in the grid's Ext.data.Store's Ext.data.Record
	 * definition from which to draw the column's value. If not
	 * specified, the column's index is used as an index into the
	 * Record's data Array.
	 *
	 * @param string $dataIndex
	 */
	public function setDataIndex($dataIndex)
	{
		$this->setAttribute('dataIndex', $dataIndex);
	}
	
	/**
	 * (optional) The Ext.Form.Field to use when editing values in this column if
	 *
	 * @param Cream_Web_UI_ExtControls_Form_Field $editor
		*/
	public function setEditor(Cream_Web_UI_ExtControls_Form_Field $editor)
	{
		$this->setAttribute('editor', $editor);
	}
	
	/**
	 * Optional. If the grid is being rendered by an Ext.grid.GroupingView, this 
	 * option may be used to specify the text to display when there is an empty 
	 * group value. Defaults to the Ext.grid.GroupingView.emptyGroupText.
	 *
	 * @param string $emptyGroupText
	 */
	public function setEmptyGroupText($emptyGroupText)
	{
		$this->setAttribute('emptyGroupText', $emptyGroupText);
	}	

	/**
	 * Defaults to true, enabling the configured editor. Set to false
	 * to initially disable editing on this column. The initial
	 * configuration may be dynamically altered using
	 * Ext.grid.ColumnModel.setEditable().
	 *
	 * @param boolean $editable
	 */
	public function setEditable($editable)
	{
		$this->setAttribute('editable', $editable);
	}

	/**
	 * true if the column width cannot be changed. Defaults to false.
	 *
	 * @param boolean $fixed
	 */
	public function setFixed($fixed)
	{
		$this->setAttribute('fixed', $fixed);
	}

	/**
	 * true if the column width cannot be changed. Defaults to false.
	 *
	 * @param string $groupName
	 */
	public function setGroupName($groupName)
	{
		$this->setAttribute('groupName', $groupName);
	}

	/**
	 * If the grid is being rendered by an Ext.grid.GroupingView, this
	 * option may be used to specify the function used to format the
	 * grouping field value for display in the group header. If a
	 * groupRenderer is not specified, the configured renderer will be
	 * called; if a renderer is also not specified the new value of
	 * the group field will be used.
	 *
	 * The called function (either the groupRenderer or renderer) will
	 * be passed the following parameters:
	 *
	 * v : Object
	 * The new value of the group field.
	 *
	 * unused : undefined
	 * Unused parameter.
	 *
	 * r : Ext.data.Record
	 * The Record providing the data for the row which caused group change.
	 *
	 * rowIndex : Number
	 * The row index of the Record which caused group change.
	 *
	 * colIndex : Number
	 * The column index of the group field.
	 *
	 * ds : Ext.data.Store
	 * The Store which is providing the data Model.
	 *
	 * @param string $groupRenderer
	 */
	public function setGroupRenderer($groupRenderer)
	{
		$this->setAttribute('groupRenderer', $groupRenderer);
	}

	/**
	 * If the grid is being rendered by an Ext.grid.GroupingView, this
	 * option may be used to disable the header menu item to group by
	 * the column selected. Defaults to true, which enables the header
	 * menu group option. Set to false to disable (but still show) the
	 * group option in the header menu for the column. See also groupName.
	 *
	 * @param string $groupable
	 */
	public function setGroupable($groupable)
	{
		$this->setAttribute('groupable', $groupable);
	}

	/**
	 * The header text to be used as innerHTML (html tags are accepted)
	 * to display in the Grid view.
	 *
	 * @param string $header
	 */
	public function setHeader($header)
	{
		$this->setAttribute('header', $header);
	}

	/**
	 * true to hide the column. Defaults to false.
	 *
	 * @param boolean $hidden
	 */
	public function setHidden($hidden)
	{
		$this->setAttribute('hidden', $hidden);
	}

	/**
	 * Specify as false to prevent the user from hiding this column
	 * (defaults to true). To disallow column hiding globally for
	 * all columns in the grid, use
	 * Ext.grid.GridPanel.enableColumnHide instead.
	 *
	 * @param string $hideable
	 */
	public function setHideable($hideable)
	{
		$this->setAttribute('hideable', $hideable);
	}

	/**
	 * A name which identifies this column (defaults to the column's
	 * initial ordinal position.) The id is used to create a CSS
	 * class name which is applied to all table cells (including
	 * headers) in that column (in this context the id does not need
	 * to be unique). The class name takes the form of
	 *
	 * x-grid3-td-id
	 *
	 * Header cells will also receive this class name, but will also
	 * have the class
	 *
	 * x-grid3-hd
	 *
	 * So, to target header cells, use CSS selectors such as:
	 *
	 * .x-grid3-hd.x-grid3-td-id
	 *
	 * The Ext.grid.GridPanel.autoExpandColumn grid config option
	 * references the column via this unique identifier.
	 *
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->setAttribute('id', $id);
	}

	/**
	 * true to disable the column menu. Defaults to false.
	 *
	 * @param boolean $menuDisabled
	 */
	public function setMenuDisabled($menuDisabled)
	{
		$this->setAttribute('menuDisabled', $menuDisabled);
	}

	/**
	 * For an alternative to specifying a renderer see xtype
	 *
	 * @param string $renderer
	 */
	public function setRenderer($renderer)
	{
		$this->setAttribute('renderer', $renderer);
	}

	/**
	 * false to disable column resizing. Defaults to true.
	 *
	 * @param boolean $resizable
	 */
	public function setResizable($resizable)
	{
		$this->setAttribute('resizable', $resizable);
	}

	/**
	 * The scope (this reference) in which to execute the renderer.
	 * Defaults to the Column configuration object.
	 *
	 * @param string $scope
	 */
	public function setScope($scope)
	{
		$this->setAttribute('scope', $scope);
	}

	/**
	 * true if sorting is to be allowed on this column. Defaults to
	 * the value of the defaultSortable property. Whether
	 * local/remote sorting is used is specified in
	 * Ext.data.Store.remoteSort.
	 *
	 * @param boolean $sortable
	 */
	public function setSortable($sortable)
	{
		$this->setAttribute('sortable', $sortable);
	}

	/**
	 * A text string to use as the column header's tooltip. If
	 * Quicktips are enabled, this value will be used as the text of
	 * the quick tip, otherwise it will be set as the header's HTML
	 * title attribute. Defaults to ''.
	 *
	 * @param string $tooltip
	 */
	public function setTooltip($tooltip)
	{
		$this->setAttribute('tooltip', $tooltip);
	}

	/**
	 * The initial width in pixels of the column.
	 *
	 * @param integer $width
	 */
	public function setWidth($width)
	{
		$this->setAttribute('width', $width);
	}
}