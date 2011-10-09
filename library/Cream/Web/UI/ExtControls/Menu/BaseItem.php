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
 * The base class for all items that render into menus. BaseItem provides 
 * default rendering, activated state management and base configuration 
 * options shared by all menu components.
 * 
 * @package 	Cream_Web_UI_ExtControls_Menu
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Menu_BaseItem extends Cream_Web_UI_ExtControls_Component
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Web_UI_ExtControls_Menu_BaseItem
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
		$this->setControl('Ext.menu.BaseItem');		
	}

	/**
	 * The CSS class to use when the item becomes activated (defaults to 
	 * "x-menu-item-active")
	 * 
	 * @param string $activeClass
	 */
	public function setActiveClass($activeClass)
	{
		$this->setAttribute('activeClass', $activeClass);
	}
	
	/**
	 * True if this item can be visually activated (defaults to false)
	 * 
	 * @param boolean $canActivate
	 */
	public function setCanActivate($canActivate)
	{
		$this->setAttribute('canActivate', $canActivate);
	}	
	
	/**
	 * Length of time in milliseconds to wait before hiding after a click 
	 * (defaults to 100)
	 * 
	 * @param integer $clickHideDelay
	 */
	public function setClickHideDelay($clickHideDelay)
	{
		$this->setAttribute('clickHideDelay', $clickHideDelay);
	}		
	
	/**
	 * A function that will handle the click event of this menu item 
	 * (optional). The handler is passed the following parameters:
	 * b : Item
	 * This menu Item.
	 * e : EventObject
	 * The click event.
	 * 
	 * @param integer $handler
	 */
	public function setHandler($handler)
	{
		$this->setAttribute('handler', $handler);
	}	
	
	/**
	 * True to hide the containing menu after this item is clicked (defaults 
	 * to true)
	 * 
	 * @param boolean $hideOnClick
	 */
	public function setHideOnClick($hideOnClick)
	{
		$this->setAttribute('hideOnClick', $hideOnClick);
	}		
	
	/**
	 * The scope (this reference) in which the handler function will be called.
	 * 
	 * @param object $scope
	 */
	public function setScope($scope)
	{
		$this->setAttribute('scope', $scope);
	}	
}