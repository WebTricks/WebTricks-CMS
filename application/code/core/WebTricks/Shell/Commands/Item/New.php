<?php

class WebTricks_Shell_Commands_Item_New extends WebTricks_Shell_Commands_Command
{
	public function getClick(WebTricks_Shell_Commands_CommandContext $context, $click)
	{
		return '';
	}
	
	public function getSubmenuItems(WebTricks_Shell_Commands_CommandContext $context)
	{
		
	}
	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		
	} 
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (!count($context->getItems)) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
				
		if (!$context->getItem()->getAccess()->canCreate()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		return parent::queryState();
	}
}