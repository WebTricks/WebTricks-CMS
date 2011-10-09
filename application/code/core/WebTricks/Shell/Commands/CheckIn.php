<?php

class WebTricks_Shell_Commands_Checkin extends WebTricks_Shell_Commands_Command
{	
	/**
	 * Execute delete command.
	 * 
	 * @see WebTricks_Shell_Commands_Command::execute()
	 */
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) == 1) {
			$item = $context->getItem();
			
			if ($item->getLocking()->hasLock()) {
				$item->getEditing()->startEdit();
				$item->getLocking()->unlock();
				$item->getEditing()->endEdit();
			}
		}
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) != 1) {
			return WebTricks_Shell_Commands_CommandState::HIDDEN;
		}

		$item = $context->getItem();
		
		if ($item->getAppearance()->getReadOnly()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if (!$item->getAccess()->canWrite()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;			
		}
		
		if (!$item->getLocking()->hasLock()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;			
		}
		
		return parent::queryState($context);
	}
}