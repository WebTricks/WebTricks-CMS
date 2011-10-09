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
 * This class provides a container DD instance that allows dragging of multiple 
 * child source nodes.
 * 
 * @package		Cream_Web_UI_ExtControls_DD
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_DD_DragZone extends Cream_Web_UI_ExtControls_DD_DragSource
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_DD_DragZone
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
		$this->setControl('Ext.dd.DragZone');
	}

	/**
	 * True to register this container with the Scrollmanager for auto 
	 * scrolling during drag operations.
	 *
	 * @param boolean $containerScroll
	 */
	public function setContainerScroll($containerScroll)
	{
		$this->setAttribute('containerScroll', $containerScroll);
	}	
	
	/**
	 * The color to use when visually highlighting the drag source in the 
	 * afterRepair method after a failed drop (defaults to "c3daf9" - light 
	 * blue)
	 *
	 * @param string $hlColor
	 */
	public function setHlColor($hlColor)
	{
		$this->setAttribute('hlColor', $hlColor);
	}		
}