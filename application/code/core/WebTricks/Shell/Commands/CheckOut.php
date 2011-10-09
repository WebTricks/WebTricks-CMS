<?php

class WebTricks_Shell_Commands_Checkout extends WebTricks_Shell_Commands_Command
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
			
			if (!$item->getLocking()->isLocked()) {
				throw new Cream_Exceptions_TodoException();
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
		
		if ($item->getLocking()->hasLock()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;			
		}
		
		return parent::queryState($context);
	}
}