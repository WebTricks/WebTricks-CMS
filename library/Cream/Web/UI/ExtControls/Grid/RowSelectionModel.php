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
 * The default SelectionModel used by Ext.grid.GridPanel. It supports multiple 
 * selections and keyboard selection/navigation. The objects stored as 
 * selections and returned by getSelected, and getSelections are the Records 
 * which provide the data for the selected rows.
 * 
 * @package 	Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_RowSelectionModel extends Cream_Web_UI_ExtControls_Grid_AbstractSelectionModel
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_RowSelectionModel
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
		$this->setControl('Ext.grid.RowSelectionModel');
	}		
	
	/**
	 * false to turn off moving the editor to the next row down when the enter 
	 * key is pressed or the next row up when shift + enter keys are pressed.
	 *
	 * @param boolean $moveEditorOnEnter
	 */
	public function setMoveEditorOnEnter($moveEditorOnEnter)
	{
		$this->setAttribute('moveEditorOnEnter', $moveEditorOnEnter);
	}	
	
	/**
	 * True to allow selection of only one row at a time (defaults to false 
	 * allowing multiple selections)
	 *
	 * @param boolean $singleSelect
	 */
	public function setSingleSelect($singleSelect)
	{
		$this->setAttribute('singleSelect', $singleSelect);
	}
}