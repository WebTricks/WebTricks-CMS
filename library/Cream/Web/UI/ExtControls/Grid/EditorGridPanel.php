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
 * This class extends the GridPanel Class to provide cell editing on selected 
 * columns. The editable columns are specified by providing an editor in the 
 * column configuration.
 * 
 * Editability of columns may be controlled programatically by inserting an 
 * implementation of isCellEditable into the ColumnModel.
 * 
 * Editing is performed on the value of the field specified by the column's 
 * dataIndex in the backing Store (so if you are using a renderer in order to 
 * display transformed data, this must be accounted for).
 * 
 * If a value-to-description mapping is used to render a column, then a 
 * ComboBox which uses the same value-to-description mapping would be an 
 * appropriate editor.
 * 
 * If there is a more complex mismatch between the visible data in the grid, 
 * and the editable data in the Store, then code to transform the data both 
 * before and after editing can be injected using the beforeedit and afteredit 
 * events.
 * 
 * @package 	Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_EditorGridPanel extends Cream_Web_UI_ExtControls_Grid_GridPanel 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_EditorGridPanel
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
		$this->setControl('Ext.grid.EditorGridPanel');
		$this->setAttribute('xtype', 'editorgrid');
	}	
	
	/**
	 * The number of clicks on a cell required to display the cell's editor 
	 * (defaults to 2). Setting this option to 'auto' means that mousedown on 
	 * the selected cell starts editing that cell.
	 *
	 * @param number $clicksToEdit
	 */
	public function setClicksToEdit($clicksToEdit)
	{
		$this->setAttribute('clicksToEdit', $clicksToEdit);
	}

	/**
	 * True to automatically HTML encode and decode values pre and post edit
	 * (defaults to false)
	 *
	 * @param boolean $autoEncode
	 */
	public function setAutoEncode($autoEncode)
	{
		$this->setAttribute('autoEncode', $autoEncode);
	}
	
	/**
	 * True to force validation even if the value is unmodified (defaults to 
	 * false)
	 *
	 * @param boolean $forceValidation
	 */
	public function setForceValidation($forceValidation)
	{
		$this->setAttribute('forceValidation', $forceValidation);
	}

	/**
	 * Any subclass of AbstractSelectionModel that will provide the selection 
	 * model for the grid (defaults to Ext.grid.CellSelectionModel if not 
	 * specified).
	 *
	 * @param Cream_Web_UI_ExtControls_Grid_AbstractSelectionModel $selModel
	 */
	public function setSelModel(Cream_Web_UI_ExtControls_Grid_AbstractSelectionModel $selModel)
	{
		$this->setAttribute('selModel', $selModel);
	}	
}