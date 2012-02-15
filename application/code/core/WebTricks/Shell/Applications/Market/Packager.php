<?php

class WebTricks_Shell_Applications_Market_Packager extends WebTricks_Shell_Applications_Abstract
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
		$item = $this->getApplicationItem()->getChildren()->getByName('ribbon');

		$context = WebTricks_Shell_Commands_CommandContext::instance();
		
		$ribbon = WebTricks_Shell_Toolbar_Ribbon::instance();
		$ribbon->setCommandContext($context);
		return $ribbon->getExtControl($item);
	}	
}