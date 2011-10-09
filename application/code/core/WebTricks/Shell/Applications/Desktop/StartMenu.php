<?php

class WebTricks_Shell_Applications_Desktop_StartMenu extends Cream_ApplicationComponent
{
	const START_MENU_DIVIDER = 'aac615ee-2b3a-469c-8713-318a117c281a';
	
	const START_MENU_ACTION = 'd5e26c65-a6dc-46bf-bd69-0a4490d920e1';
	
	const START_MENU_FOLDER = '26c6c2bb-9cfc-40f6-bd45-b8ad9db11c8b';
	
	const APPLICATION_SHORTCUT = '3499e1e1-86bf-4f1a-89de-307f75a1a221';
	
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function getExtControl(Cream_Content_Item $item)
	{		
		return array(
			'items' => $this->_getMenuItems($item->getChildren()->getByName('left'), $item->getChildren()->getByName('programs'), true),
			'toolItems' => $this->_getMenuItems($item->getChildren()->getByName('right')),
			'footerConfig' => $this->_getFooter($item->getChildren()->getByName('bottom'))
		);
	}
	
	protected function _getMenu(Cream_Content_Item $item, $bottomMenuItem = null, $large = false) 
	{
		$menu = Cream_Web_UI_ExtControls_Menu_Menu::instance();
		$menu->setItems($this->_getMenuItems($item, $bottomMenuItem));
		
		return $menu;
	}
	
	protected function _getMenuItems(Cream_Content_Item $menu, $bottomMenuItem = null, $large = false)
	{
		$menuItems = array();
		
		foreach($menu->getChildren() as $item) {
			$menuItem = $this->_getMenuItem($item, $large);
			if ($menuItem) {
				$menuItems[] = $menuItem;
			}
		}
		
		if ($bottomMenuItem) {
			$menuItems[] = Cream_Web_UI_ExtControls_Menu_Separator::instance();
			$menuItems[] = $this->_getMenuItem($bottomMenuItem, $large);
		}
		
		return $menuItems;
	}
	
	protected function _getMenuItem(Cream_Content_Item $item, $large)
	{
		switch ($item->getTemplateId()) {
			case self::START_MENU_ACTION:
				return $this->_getStartMenuAction($item, $large);
				break;
			case self::START_MENU_DIVIDER:
				return $this->_getStartMenuDivider($item);
				break;
			case self::START_MENU_FOLDER:
				return $this->_getStartMenuFolder($item, $large);
				break;
			case self::APPLICATION_SHORTCUT:
				return $this->_getApplicationShortcut($item, $large);
		}
	}
	
	protected function _getApplicationShortcut(Cream_Content_Item $item, $large)
	{
		$menuItem = Cream_Web_UI_ExtControls_Menu_Item::instance();
		if ($large) {
			$menuItem->setIconCls('icon-large-'. $item->getAppearance()->getIcon());
			$menuItem->setItemCls('x-menu-item-large');
		} else {
			$menuItem->setIconCls('icon-'. $item->getAppearance()->getIcon());
		}
		$menuItem->setHandler(Cream_Expression::instance('function() { application.desktop.launchWindow(\''. $item->get('Application') .'\'); }'));
		$menuItem->setText($item->getName());
		
		return $menuItem;
	}

	protected function _getStartMenuAction(Cream_Content_Item $item, $large)
	{
		$menuItem = Cream_Web_UI_ExtControls_Menu_Item::instance();
		if ($large) {
			$menuItem->setIconCls('icon-large-'. $item->getAppearance()->getIcon());
			$menuItem->setItemCls('x-menu-item-large');
		} else {
			$menuItem->setIconCls('icon-'. $item->getAppearance()->getIcon());
		}
		$menuItem->setText($item->getName());
		
		return $menuItem;
	}
	
	protected function _getStartMenuDivider(Cream_Content_Item $item)
	{
		$menuItem = Cream_Web_UI_ExtControls_Menu_Separator::instance();		
		return $menuItem;
	}

	protected function _getStartMenuFolder(Cream_Content_Item $item, $large)
	{
		$menuItem = Cream_Web_UI_ExtControls_Menu_Item::instance();
		if ($large) {
			$menuItem->setItemCls('x-menu-item-large');
			if ($item->getAppearance()->getIcon()) {
				$menuItem->setIconCls('icon-large-'. $item->getAppearance()->getIcon());
			} else {
				$menuItem->setIconCls('icon-large-folder');
			}
		} else {
			if ($item->getAppearance()->getIcon()) {
				$menuItem->setIconCls('icon-'. $item->getAppearance()->getIcon());
			} else {
				$menuItem->setIconCls('icon-folder');
			}
		}
		$menuItem->setText($item->getName());
		$menuItem->setMenu($this->_getMenu($item));
		
		return $menuItem;
	}	
	
	protected function _getFooter(Cream_Content_Item $item)
	{
		$buttons = array();
		$toolbar = Cream_Web_UI_ExtControls_Toolbar::instance(); 
		
		foreach ($item->getChildren() as $button) {
			$buttons[] = $this->_getButton($button);
		}
		
		$toolbar->setItems($buttons);
		
		return $toolbar;
	}
	
	protected function _getButton(Cream_Content_Item $item)
	{
		$button = Cream_Web_UI_ExtControls_Button::instance();
		$button->setText((string) $item->get('Header'));
		$button->setIconCls('icon-'. $item->getAppearance()->getIcon());
		
		return $button;
	}
}