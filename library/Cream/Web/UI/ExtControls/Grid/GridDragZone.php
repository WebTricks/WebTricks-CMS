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
 * A customized implementation of a DragZone which provides default 
 * implementations of two of the template methods of DragZone to enable 
 * dragging of the selected rows of a GridPanel.
 * 
 * A cooperating DropZone must be created who's template method implementations
 * of onNodeEnter, onNodeOver, onNodeOut and onNodeDrop are able to process the 
 * data which is provided.
 *
 * @package 	Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_GridDragZone extends Cream_Web_UI_ExtControls_DD_DragZone
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_BooleanColumn
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
		$this->setControl('Ext.grid.GridDragZone');
	}
}