<?php

class WebTricks_Shell_Commands_Rename extends WebTricks_Shell_Commands_Command
{	
	/**
	 * Execute delete command.
	 * 
	 * @see WebTricks_Shell_Commands_Command::execute()
	 */
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		if ($context->hasResult()) {
			if ($context->getResult() == 'ok' && count($context->getItems()) == 1 && $context->getItem()->getAccess()->canWrite()) {
				$context->getItem()->getEditing()->startEdit();
				$context->getItem()->setName($context->getValue());
				$context->getItem()->getEditing()->endEdit();
			}
		} else {
			WebTricks_Shell_Client_Response::prompt('Enter a new name for the item:');
		}
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) != 1) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		$item = $context->getItem(); 
		
		if ($item->getAppearance()->isReadOnly()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if (!$item->getAccess()->canRename()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if ($item->getLocking()->isLockedByOther()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;			
		}
		
		return parent::queryState($context);
	}
}