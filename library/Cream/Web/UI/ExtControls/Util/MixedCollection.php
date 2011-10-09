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
 * A wrapper class which can be applied to any element. Fires a "click" event 
 * while the mouse is pressed. The interval between firings may be specified 
 * in the config but defaults to 20 milliseconds. Optionally, a CSS class may 
 * be applied to the element during the time it is pressed.
 * 
 * @package 	Cream_Web_UI_ExtControls_Util
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Util_MixedCollection extends Cream_Web_UI_ExtControls_Util_Observable
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Util_MixedCollection
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
		$this->setControl('Ext.util.MixedCollection');
	}	
	
	/**
	 * Specify true if the addAll function should add function references to 
	 * the collection. Defaults to false.
	 * 	 
	 * @param boolean $allowFunctions
	 */
	public function setAllowFunctions($allowFunctions)
	{
		$this->setAttribute('allowFunctions', $allowFunctions);		
	}
}