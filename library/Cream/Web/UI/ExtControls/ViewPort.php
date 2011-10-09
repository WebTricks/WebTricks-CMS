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
 * A specialized container representing the viewable application area 
 * (the browser viewport).
 *
 * The Viewport renders itself to the document body, and automatically 
 * sizes itself to the size of the browser viewport and manages window 
 * resizing. There may only be one Viewport created in a page. Inner 
 * are available by virtue of the fact that all Panels added to the 
 * Viewport, either through its items, or through the items, or the 
 * add method of any of its child Panels may themselves have a layout.
 *
 * The Viewport does not provide scrolling, so child Panels within 
 * the Viewport should provide for scrolling if needed using the 
 * autoScroll config.
 *
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Viewport extends Cream_Web_UI_ExtControls_Container 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Viewport
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
		$this->setControl('Ext.Viewport');
	}
}