<?php

abstract class WebTricks_Shell_Applications_ContentManager_Abstract extends WebTricks_Shell_Applications_Abstract
{
	/**
	 * Culture
	 * 
	 * @var Cream_Globalization_Culture
	 */
	protected $_culture;
	
	/**
	 * Item id guid.
	 * 
	 * @var Cream_Guid
	 */
	protected $_itemId;
	
	protected $_controller;
	
	/**
	 * Initialize function
	 * 
	 */
	public function __init($controller = null)
	{
		$this->_itemId = Cream_Guid::parseGuid($this->getApplication()->getRequest()->getParam('itemId'));
		$this->_culture = Cream_Globalization_Culture::instance($this->getApplication()->getRequest()->getParam('culture'));
		
		if ($controller) {
			$this->_controller = $controller;
		}
	}
		
	public function getItemId()
	{
		return $this->_itemId;
	}
	
	public function getLanguage()
	{
		return $this->_culture;		
	}
	
	/**
	 * 
	 * 
	 * @return Cream_Content_Item
	 */
	public function getItem()
	{
		return $this->_item;
	}
	
	public function setItem(Cream_Content_Item $item)
	{
		$this->_item = $item;
	}
	
	/**
	 * 
	 * 
	 * @return Cream_Content_Repository
	 */
	public function getRepository()
	{
		return $this->getApplication()->getContext()->getContentRepository();
	}
	
	protected function _getToolbar()
	{
		$item = $this->getApplicationItem()->getChildren()->getByName('Ribbon');
		
		if ($item) {
			$context = WebTricks_Shell_Commands_CommandContext::instance();
			
			$ribbon = WebTricks_Shell_Toolbar_Ribbon::instance();
			$ribbon->setCommandContext($context);
			return $ribbon->getExtControl($item);
		}
	}	
}