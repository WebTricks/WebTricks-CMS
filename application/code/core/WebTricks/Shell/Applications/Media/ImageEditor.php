<?php

class WebTricks_Shell_Applications_Media_ImageEditor extends WebTricks_Shell_Applications_Abstract
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

		$ribbon = WebTricks_Shell_Toolbar_Ribbon::instance();
		return $ribbon->getExtControl($item);
	}
}