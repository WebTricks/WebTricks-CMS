<?php

class WebTricks_Shell_Commands_Item_SetSubitemsSorting extends WebTricks_Shell_Commands_Command
{	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		$sorting = WebTricks_Shell_Framework_Sorting::instance();
		
		if ($context->hasItems()) {
			foreach($context->getItems() as $item) {
				$sorting->moveUp($item);
				WebTricks_Shell_Client_Response::refresh((string) $item->getParent()->getItemId());
			}
		}				
	} 
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{		
		if (!$context->hasItems()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		$item = $context->getItem();
		
		if ($item->getAppearance()->isReadOnly()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if (!$item->getAccess()->canWrite()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if ($item->getLocking()->isLocked() && !$item->getLocking()->hasLock()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		return parent::queryState($context);
	}
}