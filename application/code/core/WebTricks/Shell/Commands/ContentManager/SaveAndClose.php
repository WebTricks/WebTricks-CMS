<?php

class WebTricks_Shell_Commands_ContentManager_SaveAndClose extends WebTricks_Shell_Commands_Command
{	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if ($this->_getApplication()->getRequest()->get('editmode') !== 'webedit') {
			return WebTricks_Shell_Commands_CommandState::HIDDEN;
		}
	}
}