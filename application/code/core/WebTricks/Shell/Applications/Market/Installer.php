<?php

class WebTricks_Shell_Applications_Market_Installer extends WebTricks_Shell_Applications_Abstract
{
	public function getConfig()
	{
		return array(
			'id' => (string) $this->getApplicationItem()->getItemId(),
			'windowConfig' => $this->_getWindowConfig()
		);
	}	
}