<?php

class WebTricks_Shell_Applications_ContentManager_Manager extends WebTricks_Shell_Applications_ContentManager_Abstract
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

	public function getConfig()
	{
		return array(
			'id' => (string) $this->getApplicationItem()->getItemId(),
			'toolbar' => $this->_getToolbar(),
			'windowConfig' => $this->_getWindowConfig()
		);
	}
	
	protected function _getToolbar()
	{
		$itemId = $this->getApplication()->getRepository('core')->getDataManager()->resolvePath('WebTricks/content/Applications/Content Editor/Ribbons/Ribbons/Default');
		$item = $this->getApplication()->getRepository('core')->getItem($itemId);

		$context = WebTricks_Shell_Commands_CommandContext::instance();
		
		$ribbon = WebTricks_Shell_Toolbar_Ribbon::instance();
		$ribbon->setCommandContext($context);
		return $ribbon->getExtControl($item);
	}
}