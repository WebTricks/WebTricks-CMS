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
 * A Column definition class which renders boolean data fields. See the xtype
 * config option of Ext.list.Column for more details.
 *
 * @package 	Cream_Web_UI_ExtControls_List
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_List_Column extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_List_Column
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
		$this->setControl('Ext.list.Column');
	}
	
	/**
	 * Set the CSS text-align property of the column. Defaults to 'left'.
	 * 
	 * @param string $align
	 */
	public function setAlign($align)
	{
		$this->setAttribute('align', $align);		
	}
	
	/**
	 * Optional. This option can be used to add a CSS class to the cell of each
	 * row for this column.
	 * 
	 * @param string $cls
	 */
	public function setCls($cls)
	{
		$this->setAttribute('cls', $cls);		
	}

	/**
	 * Required. The name of the field in the ListViews's Ext.data.Store's 
	 * Ext.data.Record definition from which to draw the column's value.
	 * 
	 * @param string $dataIndex
	 */
	public function setDataIndex($dataIndex)
	{
		$this->setAttribute('dataIndex', $dataIndex);		
	}

	/**
	 * Optional. The header text to be used as innerHTML (html tags are 
	 * accepted) to display in the ListView. Note: to have a clickable header
	 * with no text displayed use ' '.
	 * 
	 * @param string $header
	 */
	public function setHeader($header)
	{
		$this->setAttribute('header', $header);		
	}

	/**
	 * Optional. Specify a string to pass as the configuration string for 
	 * Ext.XTemplate. By default an Ext.XTemplate will be implicitly created 
	 * using the dataIndex.
	 * 
	 * @param string $tpl
	 */
	public function setTpl($tpl)
	{
		$this->setAttribute('tpl', $tpl);		
	}

	/**
	 * Optional. Percentage of the container width this column should be 
	 * allocated. Columns that have no width specified will be allocated with 
	 * an equal percentage to fill 100% of the container width. To easily take 
	 * advantage of the full container width, leave the width of at least one 
	 * column undefined. Note that if you do not want to take up the full width 
	 * of the container, the width of every column needs to be explicitly 
	 * defined.
	 * 
	 * @param integer $width
	 */
	public function setWidth($width)
	{
		$this->setAttribute('width', $width);		
	}	
}