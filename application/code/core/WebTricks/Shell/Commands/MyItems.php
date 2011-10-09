<?php

class WebTricks_Shell_Commands_MyItems extends WebTricks_Shell_Commands_Command
{	
	/**
	 * Execute delete command.
	 * 
	 * @see WebTricks_Shell_Commands_Command::execute()
	 */
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		WebTricks_Shell_Client_Response::showModalDialog('WebTricks.Shell.Applications.WebEdit.Dialogs.LockedItems', array());
	}
}