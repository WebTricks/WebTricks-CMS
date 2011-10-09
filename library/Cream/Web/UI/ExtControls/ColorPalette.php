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
 * Simple color palette class for choosing colors. The palette can be rendered to any container.
 *
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_ColorPalette extends Cream_Web_UI_ExtControls_Component 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_ColorPalette
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
		$this->setControl('Ext.ColorPallete');
		$this->setXtype('colorpalette');
	}
	
	/**
	 * If set to true then reselecting a color that is already selected fires the selection event.
	 *
	 * @param string $itemCls
	 */
	public function setItemCls($itemCls) 
	{
		$this->setAttribute('itemCls', $itemCls);
	}

	/**
	 * The CSS class to apply to the containing element (defaults to "x-color-palette")
	 *
	 * @param string $value
	 */
	public function setValue($value) 
	{
		$this->setAttribute('value', $value);
	}

	/**
	 * The initial color to highlight (should be a valid 6-digit color hex code
	 * without the # symbol). Note that the hex codes are case-sensitive.
	 *
	 * @param boolean $allowReselect
	 */
	public function setAllowReselect($allowReselect) 
	{
		$this->setAttribute('allowReselect', $allowReselect);
	}
	
	/**
	 * The DOM event that will cause a color to be selected. This can be any 
	 * valid event name (dblclick, contextmenu). Defaults to 'click'.
	 *
	 * @param string $clickEvent
	 */
	public function setClickEvent($clickEvent) 
	{
		$this->setAttribute('clickEvent', $clickEvent);
	}		
	
	/**
	 * Optional. A function that will handle the select event of this palette. 
	 * The handler is passed the following parameters:
	 * - palette : ColorPalette
	 *   The Ext.ColorPalette.
	 * - color : String
	 *   The 6-digit color hex code (without the # symbol).
	 * 
	 * @param function $handler
	 */
	public function setHandler($handler) 
	{
		$this->setAttribute('handler', $handler);
	}			
	
	/**
	 * The scope (this reference) in which the handler function will be called. 
	 * Defaults to this ColorPalette instance.
	 * 
	 * @param object $scope
	 */
	public function setScope($scope) 
	{
		$this->setAttribute('scope', $scope);		
	}
}