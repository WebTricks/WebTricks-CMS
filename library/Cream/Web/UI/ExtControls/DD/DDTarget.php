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
 * A DragDrop implementation that does not move, but can be a drop target. You
 * would get the same result by simply omitting implementation for the event 
 * callbacks, but this way we reduce the processing cost of the event listener 
 * and the callbacks.
 * 
 * @package		Cream_Web_UI_ExtControls_DD
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_DD_DDTarget extends Cream_Web_UI_ExtControls_DD_DragDrop
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_DD_DDTarget
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
		$this->setControl('Ext.dd.DDTarget');
	}
}