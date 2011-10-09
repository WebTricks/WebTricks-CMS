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
 * A menu containing an Ext.DatePicker Component.
 * 
 * @package 	Cream_Web_UI_ExtControls_Menu
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Menu_DateMenu extends Cream_Web_UI_ExtControls_Menu_Menu
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Menu_DateMenu
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
		$this->setControl('Ext.menu.DateMenu');		
	}
	
	/**
	 * Optional. A function that will handle the select event of this menu. The 
	 * handler is passed the following parameters:
	 * picker : DatePicker
	 * The Ext.DatePicker.
	 * date : Date
	 * The selected date.
	 * 
	 * @param string $handler
	 */
	public function setHandler($handler)
	{
		$this->setAttribute('handler', $handler);
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
	 * An id to assign to the underlying date picker. Defaults to null.
	 * 
	 * @param string $pickerId
	 */
	public function setPickerId($pickerId)
	{
		$this->setAttribute('pickerId', $pickerId);
	}
	
	/**
	 * The scope (this reference) in which the handler function will be called. 
	 * Defaults to this DateMenu instance.
	 * 
	 * @param object $scope
	 */
	public function setScope($scope)
	{
		$this->setAttribute('scope', $scope);		
	}	
}