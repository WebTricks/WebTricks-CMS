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
 * Context menu class to generate and ExtJS context menu control.
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Framework_ContextMenu extends Cream_ApplicationComponent implements Cream_Web_UI_ExtControlInterface
{
	const REPOSITORY_PATH_DEFAULT_CONTEXT_MENU = '';
	
	/**
	 * Ext control object
	 * 
	 * @var Cream_Web_UI_ExtControls_Menu_Menu
	 */
	protected $_extControl;
	
	/**
	 * Content item of the context menu.
	 *  
	 * @var Cream_Content_Item
	 */
	protected $_item;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Framework_ContextMenu
	 */
	public static function instance(Cream_Content_Item $item)
	{
		return Cream::instance(__CLASS__, $item);
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function __init(Cream_Content_Item $item)
	{
		$this->_item = $item;
	}
	
	/**
	 * Returns the Ext JS control
	 * 
	 * @see library/Cream/Web/UI/ExtControls/Cream_Web_UI_ExtControl_Interface::getExtControl()
	 * @return Cream_Web_UI_ExtControls_Menu_Menu
	 */
	public function getExtControl()
	{
		if (!$this->_extControl) {
			$this->_extControl = $this->build();
		}
		
		return $this->_extControl;
	}
	
	/**
	 * Builds the context menu
	 * 
	 * @return Cream_Web_UI_ExtControls_Menu_Menu
	 */
	protected function build()
	{
		$itemId = Cream_Guid::parseGuid($this->_item->getTemplate()->getContextMenuItemId());
		$control = Cream_Web_UI_ExtControls_Menu_Menu::instance();
		
		if ($itemId) {
			$item = $this->_item->getRepository()->getItem($itemId);
			$control->setItems($this->buildChildren($item));
		}			
		
		return $control;
	}
	
	/**
	 * Builds a single menu item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Web_UI_ExtControls_Menu_Item;
	 */
	protected function buildMenuItem(Cream_Content_Item $item)
	{
		$menuItem = Cream_Web_UI_ExtControls_Menu_Item::instance();
		$menuItem->setText($item->getDisplayName());
		$menuItem->setIconCls($item->icon);
		$menuItem->setHandler($item->handler);

		if ($item->hasChildren()) {
			$menuItem->setMenu($this->buildChildren($item));
		}
		
		return $menuItem;
	}
	
	/**
	 * Builds the menu item of the children of the current item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return array
	 */
	protected function buildChildren(Cream_Content_Item $item)
	{
		$children = array();
			
		foreach($item->getChildren() as $childItem) {  
			$children[] = $this->buildMenuItem($childItem);
		}
		
		return $children;
	}
}