<?php

class WebTricks_Shell_Commands_ContentManager_Back extends WebTricks_Shell_Commands_Command
{	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		$session = WebTricks_Shell_Session::singleton();
		$itemUri = $session->getHistory()->back();
		
		$sender = $context->getMessage()->getSender();
		WebTricks_Shell_Commands_CommandProvider::sendMessage($sender, 'item:load(itemId='. $itemUri->getItemId() .', culture='. $itemUri->getCulture() .', version='. $itemUri->getVersion() .', disableHistory=1)');
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		$session = WebTricks_Shell_Session::singleton();
		
		if (!$session->getHistory()->canGoBack()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		return parent::queryState($context);
	}
}