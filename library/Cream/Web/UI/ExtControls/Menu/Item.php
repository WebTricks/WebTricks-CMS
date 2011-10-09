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
 * A base class for all menu items that require menu-related functionality 
 * (like sub-menus) and are not static display items. Item extends the base 
 * functionality of Ext.menu.BaseItem by adding menu-specific activation and 
 * click handling.
 * 
 * @package 	Cream_Web_UI_ExtControls_Menu
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Menu_Item extends Cream_Web_UI_ExtControls_Menu_BaseItem
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Web_UI_ExtControls_Menu_Item
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
		$this->setControl('Ext.menu.Item');		
	}
	
	/**
	 * The href attribute to use for the underlying anchor link (defaults to 
	 * '#').
	 * 
	 * @param string $href
	 */
	public function setHref($href)
	{
		$this->setAttribute('href', $href);
	}
	
	/**
	 * The target attribute to use for the underlying anchor link (defaults to 
	 * '').
	 * 
	 * @param string $hrefTarget
	 */
	public function setHrefTarget($hrefTarget)
	{
		$this->setAttribute('hrefTarget', $hrefTarget);
	}	
	
	/**
	 * The path to an icon to display in this item (defaults to 
	 * Ext.BLANK_IMAGE_URL). If icon is specified iconCls should not be.
	 * 
	 * @param string $icon
	 */
	public function setIcon($icon)
	{
		$this->setAttribute('icon', $icon);
	}		
	
	/**
	 * A CSS class that specifies a background image that will be used as the 
	 * icon for this item (defaults to ''). If iconCls is specified icon 
	 * should not be.
	 * 
	 * @param string $iconCls
	 */
	public function setIconCls($iconCls)
	{
		$this->setAttribute('iconCls', $iconCls);
	}		
	
	/**
	 * The default CSS class to use for menu items (defaults to 'x-menu-item')
	 * 
	 * @param string $itemCls
	 */
	public function setItemCls($itemCls)
	{
		$this->setAttribute('itemCls', $itemCls);
	}		
	
	/**
	 * An instance of Cream_Web_UI_ExtControls_Menu_Menu which acts as the submenu 
	 * when this item is activated.
	 * 
	 * @param Cream_Web_UI_ExtControls_Menu_Menu $menu
	 */
	public function setMenu(Cream_Web_UI_ExtControls_Menu_Menu $menu)
	{
		$this->setAttribute('menu', $menu);
	}		

	/**
	 * Length of time in milliseconds to wait before showing this item 
	 * (defaults to 200)
	 * 
	 * @param integer $showDelay
	 */
	public function setShowDelay($showDelay)
	{
		$this->setAttribute('showDelay', $showDelay);
	}		
	
	/**
	 * The text to display in this item (defaults to '').
	 * 
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->setAttribute('text', $text);
	}	
}