<?php

class WebTricks_Shell_Commands_Delete extends WebTricks_Shell_Commands_Command
{	
	/**
	 * Execute delete command.
	 * 
	 * @see WebTricks_Shell_Commands_Command::execute()
	 */
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		if ($context->hasResult()) {
			if ($context->getResult() == "yes" && $context->getItems()) {
				foreach($context->getItems() as $item) {
					$item->delete();
				}
			}
		} else {
			WebTricks_Shell_Client_Response::confirm('Do you really want to delete this item?');
		}
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if ($context->getItems()) {
			foreach($context->getItems() as $item) {
				/* @var $item Cream_Content_Item */
				if (!$item->getAccess()->canDelete()) {
					return WebTricks_Shell_Commands_CommandState::DISABLED;
				}
				
				if ($item->getAppearance()->getReadOnly()) {
					return WebTricks_Shell_Commands_CommandState::DISABLED;
				}
				
				if ($item->getLocking()->isLocked && !$item->getLocking()->hasLock()) {
					return WebTricks_Shell_Commands_CommandState::DISABLED;				
				}
			}
		} else {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}	
		
		return parent::queryState($context);
	}
}