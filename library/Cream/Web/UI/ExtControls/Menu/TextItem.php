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
 * Adds a static text string to a menu, usually used as either a heading or 
 * group separator.
 * 
 * @package 	Cream_Web_UI_ExtControls_Menu
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Menu_TextItem extends Cream_Web_UI_ExtControls_Menu_BaseItem
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Menu_TextItem
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
		$this->setControl('Ext.menu.TextItem');		
	}
	
	/**
	 * True to hide the containing menu after this item is clicked 
	 * (defaults to false)
	 * 
	 * @param boolean $hideOnClick
	 */
	public function setHideOnClick($hideOnClick)
	{
		$this->setAttribute('hideOnClick', $hideOnClick);
	}	
	
	/**
	 * The default CSS class to use for text items (defaults to "x-menu-text")
	 * 
	 * @param string $itemCls
	 */
	public function setItemCls($itemCls)
	{
		$this->setAttribute('itemCls', $itemCls);
	}	
	
	/**
	 * The text to display for this item (defaults to '')
	 * 
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->setAttribute('text', $text);
	}		
}