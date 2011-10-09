<?php
/**
 * WebTricks
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
 * Content manager folder editor
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_ContentManager_Folder extends WebTricks_Shell_Applications_ContentManager_Abstract
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Applications_ContentManager_Folder
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Gets the context menu
	 * 
	 * @return Cream_Web_UI_ExtControls_Menu_Menu
	 */
	public function getContextMenu()
	{
		$contextMenu = WebTricks_Shell_Framework_ContextMenu::instance($this->getItem());
		$control = $contextMenu->getExtControl();
		$control->addItem(Cream_Web_UI_ExtControls_Menu_Separator::instance());
		
		$item = Cream_Web_UI_ExtControls_Menu_Item::instance();
		/* $item->setText(Cream_Globalization_Translate::text('Refresh')); */
		$item->setText('Refresh');
		$item->setIconCls('icon-refresh');
		
		$control->addItem($item);
		
		return $control;
	}
	
	public function getItems()
	{
		return $this->getItem()->getChildren();
	}
	
	public function getConfig()
	{
		return array();
	}
}