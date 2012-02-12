<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Controller handeling the content manager tree.
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_ContentManager_TreeController extends WebTricks_Shell_Controller_Action
{	
	protected $_typeIds;
	
	protected $_rootId;
	
	public function childrenAction()
	{
		$children = array();
		$this->_rootId = $this->getRequest()->getParam('rootId');
		//$this->_typeIds = $this->getRequest()->getParam('typeIds');
		$itemId = Cream_Guid::parseGuid($this->getRequest()->getParam('node'));
		
		if ($itemId) {
			$item = $this->_getApplication()->getContext()->getContentRepository()->getItem($itemId);
		} else {
			return;
		}
		
		foreach($item->getChildren() as $childItem) {
			if (!$this->_typeIds || !count($this->_typeIds) || in_array($childItem->getTemplateId(), $this->_typeIds)) {
				if ($childItem->hasChildren()) {
					$leaf = false;
				} else {
					$leaf = true;
				}
				
				array_push($children, array(
					'id' => $childItem->getItemId()->toString(),
					'text' => $childItem->getItemData()->getItemDefinition()->getName(),
					'iconCls' => 'icon-'. $childItem->getAppearance()->getIcon(),
					'leaf' => $leaf
				));
			}
		}
		
		$this->getResponse()->setBody(Cream_Json::encode($children));
	}
	
	public function contextMenuAction()
	{
		$items = array();
		
		$item = Cream_Web_UI_ExtControls_Menu_Item::instance();
		$item->setText('New');
		
		$items[] = $item;
		
		$item = Cream_Web_UI_ExtControls_Menu_Item::instance();
		$item->setText('New');
		
		$items[] = $item;
		
		
		$menu = Cream_Web_UI_ExtControls_Menu_Menu::instance();
		$menu->setItems($items);
		
		//$menu = array('items' => $items);
		
		$this->getResponse()->setBody(Cream_Json::encode($menu));
	}
	
	protected function _hasChildren()
	{
		
	}
}