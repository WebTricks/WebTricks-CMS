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
 * An extended Ext.Element object that supports a shadow and shim, constrain to
 * viewport and automatic maintaining of shadow/shim positions.
 * 
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Layer extends Cream_Web_UI_ExtControls_Element 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Layer
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
		$this->setControl('Ext.Layer');
	}
		
	/**
	 * False to disable the iframe shim in browsers which need one (defaults to
	 * true)
	 *
	 * @param boolean $shim
	 */
	public function setShim($shim) 
	{
		$this->setAttribute('shim', $shim);
	}

	/**
	 * True to create a shadow element with default class "x-layer-shadow", or
	 *
	 * @param string/boolean $shadow
	 */
	public function setShadow($shadow) 
	{
		$this->setAttribute('shadow', $shadow);
	}

	/**
	 * DomHelper object config to create element with (defaults to {tag: "div",
	 * cls: "x-layer"}).
	 *
	 * @param object $dh
	 */
	public function setDh($dh) 
	{
		$this->setAttribute('dh', $dh);
	}

	/**
	 * False to disable constrain to viewport (defaults to true)
	 *
	 * @param boolean $constrain
	 */
	public function setConstrain($constrain) 
	{
		$this->setAttribute('constrain', $constrain);
	}

	/**
	 * CSS class to add to the element
	 *
	 * @param string $cls
	 */
	public function setCls($cls) 
	{
		$this->setAttribute('cls', $cls);
	}
	
	/**
	 * Defaults to use css offsets to hide the Layer. Specify true to use css 
	 * style 'display:none;' to hide the Layer.
	 *
	 * @param boolean $useDisplay
	 */
	public function setUseDisplay($useDisplay) 
	{
		$this->setAttribute('useDisplay', $useDisplay);
	}	

	/**
	 * Starting z-index (defaults to 11000)
	 *
	 * @param number $zindex
	 */
	public function setZindex($zindex) 
	{
		$this->setAttribute('zindex', $zindex);
	}

	/**
	 * Number of pixels to offset the shadow (defaults to 3)
	 *
	 * @param number $shadowOffset
	 */
	public function setShadowOffset($shadowOffset) 
	{
		$this->setAttribute('shadowOffset', $shadowOffset);
	}
}