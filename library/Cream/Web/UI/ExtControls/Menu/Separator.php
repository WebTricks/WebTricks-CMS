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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Adds a separator bar to a menu, used to divide logical groups of menu items. 
 * Generally you will add one of these by using "-" in you call to add() or in 
 * your items config rather than creating one directly.
 * 
 * @package 	Cream_Web_UI_ExtControls_Menu
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Menu_Separator extends Cream_Web_UI_ExtControls_Menu_BaseItem
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Menu_Separator
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
		$this->setControl('Ext.menu.Separator');		
	}
		
	/**
	 * False to continue showing the menu after a date is selected, defaults 
	 * to true.
	 * 
	 * @param boolean $hideOnClick
	 */
	public function setHideOnClick($hideOnClick)
	{
		$this->setAttribute('hideOnClick', $hideOnClick);
	}	
	
	/**
	 * The default CSS class to use for separators (defaults to "x-menu-sep")
	 * 
	 * @param string $itemCls
	 */
	public function setItemCls($itemCls)
	{
		$this->setAttribute('itemCls', $itemCls);
	}		
}