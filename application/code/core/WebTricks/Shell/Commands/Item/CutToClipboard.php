<?php

class WebTricks_Shell_Commands_Item_CutToClipboard extends WebTricks_Shell_Commands_Command
{
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) == 1) {
			$session = WebTricks_Shell_Session::singleton();
			$session->setClipboard('cut:'. $context->getItem()->getItemId());
		}
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) == 1) {
			return parent::queryState($context);
		}
		
		return WebTricks_Shell_Commands_CommandState::DISABLED;
	}
}