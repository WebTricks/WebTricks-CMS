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
 * A simple class that provides the basic implementation needed to make any 
 * element draggable.
 * 
 * @package		Cream_Web_UI_ExtControls_DD
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_DD_DragSource extends Cream_Web_UI_ExtControls_DD_DDProxy
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_DD_DragSource
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
		$this->setControl('Ext.dd.DragSource');
	}

	/**
	 * A named drag drop group to which this object belongs. If a group is 
	 * specified, then this object will only interact with other drag drop 
	 * objects in the same group (defaults to undefined).
	 *
	 * @param string $ddGroup
	 */
	public function setDdGroup($ddGroup)
	{
		$this->setAttribute('ddGroup', $ddGroup);
	}	
	
	/**
	 * The CSS class returned to the drag source when drop is allowed (defaults 
	 * to "x-dd-drop-ok").
	 *
	 * @param string $dropAllowed
	 */
	public function setDropAllowed($dropAllowed)
	{
		$this->setAttribute('dropAllowed', $dropAllowed);
	}	

	/**
	 * The CSS class returned to the drag source when drop is not allowed 
	 * (defaults to "x-dd-drop-nodrop").
	 *
	 * @param string $dropNotAllowed
	 */
	public function setDropNotAllowed($dropNotAllowed)
	{
		$this->setAttribute('dropNotAllowed', $dropNotAllowed);
	}		
}