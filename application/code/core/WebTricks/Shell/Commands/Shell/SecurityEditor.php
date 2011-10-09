<?php

class WebTricks_Shell_Commands_Shell_SecurityEditor extends WebTricks_Shell_Commands_Command
{
	const APPLICATION_PATH = 'WebTricks/content/Applications/Security/Security Editor';
		
	/**
	 * Execute the domain manager command. Starts the domain manager
	 * application when the user has sufficient rights to do so.
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
	
	/**
	 * Queries the state of the command. Hides the button when the
	 * user has no rights to the application.
	 * 
	 * @see WebTricks_Shell_Commands_Command::queryState()
	 */
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		$item = $this->getApplication()->getContext()->getRepository()->getItemByPath(self::APPLICATION_PATH);
		
		if (!$item) {
			return WebTricks_Shell_Commands_CommandState::HIDDEN;	
		}
		
		return parent::queryState($context);
	}
}