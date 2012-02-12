<?php

class WebTricks_Shell_Applications_Workbox extends WebTricks_Shell_Applications_Abstract
{
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
		$itemId = $this->_getApplication()->getRepository('core')->getDataManager()->resolvePath('WebTricks/content/Applications/Content Editor/Ribbons/Ribbons/Default');
		$item = $this->_getApplication()->getRepository('core')->getItem($itemId);

		$context = WebTricks_Shell_Commands_CommandContext::instance();
		
		$ribbon = WebTricks_Shell_Toolbar_Ribbon::instance();
		$ribbon->setCommandContext($context);
		return $ribbon->getExtControl($item);
	}	
}