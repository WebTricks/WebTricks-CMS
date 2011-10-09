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
 * Adds a menu item that contains a checkbox by default, but can also be part
 * of a radio group.
 * 
 * @package 	Cream_Web_UI_ExtControls_Menu
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Menu_CheckItem extends Cream_Web_UI_ExtControls_Menu_Item
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Web_UI_ExtControls_Menu_CheckItem
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
		$this->setControl('Ext.menu.CheckItem');		
	}
	
	/**
	 * True to initialize this checkbox as checked (defaults to false). Note 
	 * that if this checkbox is part of a radio group (group = true) only the 
	 * last item in the group that is initialized with checked = true will be 
	 * rendered as checked.
	 * 
	 * @param boolean $checked
	 */
	public function setChecked($checked)
	{
		$this->setAttribute('checked', $checked);
	}
	
	/**
	 * All check items with the same group name will automatically be grouped 
	 * into a single-select radio button group (defaults to '')
	 * 
	 * @param string $group
	 */
	public function setGroup($group)
	{
		$this->setAttribute('group', $group);
	}
	
	/**
	 * The default CSS class to use for radio group check items (defaults to 
	 * "x-menu-group-item")
	 * 
	 * @param string $groupClass
	 */
	public function setGroupClass($groupClass)
	{
		$this->setAttribute('groupClass', $groupClass);
	}	
	
	/**
	 * The default CSS class to use for check items (defaults to 
	 * "x-menu-item x-menu-check-item")
	 * 
	 * @param string $itemCls
	 */
	public function setItemCls($itemCls)
	{
		$this->setAttribute('itemCls', $itemCls);
	}		
}