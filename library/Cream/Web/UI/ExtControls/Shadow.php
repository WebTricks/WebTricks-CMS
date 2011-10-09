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
 * Simple class that can provide a shadow effect for any element. Note that the 
 * element MUST be absolutely positioned, and the shadow does not provide any 
 * shimming. This should be used only in simple cases -- for more advanced 
 * functionality that can also provide the same shadow effect, see the Ext.Layer 
 * class.
 * 
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Shadow extends Cream_Web_UI_ExtControl 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Shadow
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
		$this->setControl('Ext.Shadow');
	}
		
	/**
	 * 
	 *
	 * @param string $mode
	 */
	public function setMode($mode) 
	{
		$this->setAttribute('mode', $mode);
	}

	/**
	 * 
	 *
	 * @param string $offset
	 */
	public function setOffset($offset) 
	{
		$this->setAttribute('offset', $offset);
	}
}