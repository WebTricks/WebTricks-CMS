<?php

class WebTricks_Shell_Commands_Shell_RoleManager extends WebTricks_Shell_Commands_Command
{
	const APPLICATION_PATH = 'WebTricks/content/Applications/Security/Role Manager';
		
	/**
	 * Execute delete command.
	 * 
	 * @see WebTricks_Shell_Commands_Command::execute()
	 */
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		$item = $this->getApplication()->getContext()->getRepository()->getItemByPath(self::APPLICATION_PATH);
		
		if ($item) {
			WebTricks_Shell_Client_Response::runApplication($item);
		} else {
			WebTricks_Shell_Client_Response::alert("The requested applicaton can't be found.");
		}
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		$item = $this->getApplication()->getContext()->getRepository()->getItemByPath(self::APPLICATION_PATH);
		
		if (!$item) {
			return WebTricks_Shell_Commands_CommandState::HIDDEN;	
		}
		
		return parent::queryState($context);
	}
}