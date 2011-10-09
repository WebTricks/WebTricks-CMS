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
 * A grouping container for Ext.form.Checkbox controls. Sample usage:
 * 
 * <code>
 * var myCheckboxGroup = new Ext.form.CheckboxGroup({
 * 	id:'myGroup',
 * 	xtype: 'checkboxgroup',
 * 	fieldLabel: 'Single Column',
 * 	itemCls: 'x-check-group-alt',
 * 	// Put all controls in a single column with width 100%
 * 	columns: 1,
 * 	items: [
 * 		{boxLabel: 'Item 1', name: 'cb-col-1'},
 *		{boxLabel: 'Item 2', name: 'cb-col-2', checked: true},
 *		{boxLabel: 'Item 3', name: 'cb-col-3'}
 *	]
 *});
 *</code>
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_CheckboxGroup extends Cream_Web_UI_ExtControls_Form_Field  
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_CheckboxGroup
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
		$this->setControl('Ext.form.CheckboxGroup');
		$this->setAttribute('xtype', 'checkboxgroup');
	}
	
	/**
	 * True to allow every item in the group to be blank (defaults to
	 * true). If allowBlank = false and no items are selected at 
	 * validation time.
	 *
	 * @param boolean $allowBlank
	 */
	public function setAllowBlank($allowBlank)
	{
		$this->setAttribute('allowBlank', $allowBlank);
	}

	/**
	 * Error text to display if the allowBlank validation fails 
	 * (defaults to 'You must select one item in this group')
	 *
	 * @param string $blankText
	 */
	public function setBlankText($blankText)
	{
		$this->setAttribute('blankText', $blankText);
	}
	
	/**
	 * Specifies the number of columns to use when displaying grouped
	 * checkbox/radio controls using automatic layout. This config 
	 * can take several types of values:
	 *  
	 * 'auto' :
	 * The controls will be rendered one per column on one row and the
	 * width of each column will be evenly distributed based on the 
	 * width of the overall field container. This is the default.
	 * 
	 * Number :
	 * If you specific a number (e.g., 3) that number of columns will 
	 * be created and the contained controls will be automatically 
	 * distributed based on the value of vertical.
	 * 
	 * Array : Object
	 * You can also specify an array of column widths, mixing integer 
	 * (fixed width) and float (percentage width) values as needed 
	 * (e.g., [100, .25, .75]). Any integer values will be rendered 
	 * first, then any float values will be calculated as a percentage 
	 * of the remaining space. Float values do not have to add up to 1 
	 * (100%) although if you want the controls to take up the entire 
	 * field container you should do so.
	 * 
	 * @param $columns string|number|array
	 * @return void
	 */
	public function setColumns($columns)
	{
		$this->setAttribute('columns', $columns);		
	}
	
	/**
	 * An Array of Checkboxes or Checkbox config objects to arrange in 
	 * the group.
	 * 
	 * @param $items array
	 * @return void
	 */
	public function setItems($items)
	{
		$this->setAttribute('items', $items);	
	}
	
	/**
	 * True to distribute contained controls across columns, completely
	 * filling each column top to bottom before starting on the next 
	 * column. The number of controls in each column will be 
	 * automatically calculated to keep columns as even as possible. The 
	 * default value is false, so that controls will be added to columns 
	 * one at a time, completely filling each row left to right before 
	 * starting on the next row.
	 * 
	 * @param $verical boolean
	 * @return void
	 */
	public function setVertical($vertical)
	{
		$this->setAttribute('vertical', $vertical);	
	}
}