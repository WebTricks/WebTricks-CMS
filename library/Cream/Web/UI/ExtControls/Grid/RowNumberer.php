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
 * This is a utility class that can be passed into a Ext.grid.ColumnModel as a 
 * column config that provides an automatic row numbering column. 
 * 
 * @package		Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_RowNumberer extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_RowNumberer
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
		$this->setControl('Ext.grid.RowNumberer');
	}	
	
	/**
	 * Any valid text or HTML fragment to display in the header cell for the row
	 *
	 * @param string $header
	 */
	public function setHeader($header)
	{
		$this->setAttribute('header', $header);
	}

	/**
	 * The default width in pixels of the row number column (defaults to 23).
	 *
	 * @param number $width
	 */
	public function setWidth($width)
	{
		$this->setAttribute('width', $width);
	}
} 