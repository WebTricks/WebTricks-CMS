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
 * A custom selection model that renders a column of checkboxes that can be 
 * toggled to select or deselect rows.
 * 
 * @package		Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_CheckboxSelectionModel extends Cream_Web_UI_ExtControls_Grid_RowSelectionModel 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_CheckboxSelectionModel
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
		$this->setControl('Ext.grid.CheckboxSelectionModel');
	}
	
	/**
	 * true if rows can only be selected by clicking on the checkbox column 
	 * (defaults to false).
	 * 
	 * @param boolean $checkOnly
	 */
	public function setCheckOnly($checkOnly)
	{
		$this->setAttribute('checkOnly', $checkOnly);		
	}

	/**
	 * Any valid text or HTML fragment to display in the header cell for the 
	 * checkbox column.
	 *
	 * @param string $header
	 */
	public function setHeader($header)
	{
		$this->setAttribute('header', $header);
	}

	/**
	 * The default width in pixels of the checkbox column (defaults to 20).
	 *
	 * @param number $width
	 */
	public function setWidth($width)
	{
		$this->setAttribute('width', $width);
	}

	/**
	 * True if the checkbox column is sortable (defaults to false).
	 *
	 * @param boolean $sortable
	 */
	public function setSortable($sortable)
	{
		$this->setAttribute('sortable', $sortable);
	}
}