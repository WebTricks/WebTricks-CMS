<?php

class WebTricks_Shell_Commands_ContentManager_Up extends WebTricks_Shell_Commands_Command
{	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) == 1) {
			$item = $context->getItem();
			
			$sender = $context->getMessage()->getSender();
			WebTricks_Shell_Commands_CommandProvider::sendMessage($sender, 'item:load(itemId='. $item->getParent()->getItemId() .', culture='. $item->getCulture() .', version='. Cream_Content_Version::getLatest() .')');		
		}
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) != 1) {
			return WebTricks_Shell_Commands_CommandState::HIDDEN;
		}
		
		$item = $context->getItem();
		
		if ((string) $item->getItemId() == Cream_Application_ItemIds::rootId) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		return parent::queryState($context);
	}
}