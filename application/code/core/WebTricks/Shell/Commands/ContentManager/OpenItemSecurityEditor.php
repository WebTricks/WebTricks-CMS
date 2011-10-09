<?php

class WebTricks_Shell_Commands_ContentManager_OpenItemSecurityEditor extends WebTricks_Shell_Commands_Command
{	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		WebTricks_Shell_Client_Response::showModalDialog('WebTricks.Shell.Applications.Security.SecurityDetails', array());
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) != 1) {
			return WebTricks_Shell_Commands_CommandState::HIDDEN;
		}
				
		return parent::queryState($context);
	}
}