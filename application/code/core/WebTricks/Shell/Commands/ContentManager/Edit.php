<?php

class WebTricks_Shell_Commands_ContentManager_Edit extends WebTricks_Shell_Commands_Command
{	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) != 1) {
			
			$item = $context->getItem();
			
			if ($this->_canCheckIn($item)) {
				$message = 'item:checkin';
			} else {
				$message = 'item:checkout';
			}
			
			$sender = $context->getMessage()->getSender();
			WebTricks_Shell_Commands_CommandProvider::sendMessage($sender, $message);
		}		
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) != 1) {
			return WebTricks_Shell_Commands_CommandState::HIDDEN;
		}
		
		$item = $context->getItem();
		
		if (!$item->getAccess()->canWrite()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if ($this->_canCheckIn($item)) {
			return WebTricks_Shell_Commands_CommandState::DOWN;
		}
		
		if ($this->_canEdit($item)) {
			return WebTricks_Shell_Commands_CommandState::ENABLED;
		}

		return WebTricks_Shell_Commands_CommandState::DISABLED;
	}
	
	protected function _canCheckIn(Cream_Content_Item $item)
	{
		if (!$item->getAppearance()->getReadOnly() && $item->getLocking()->hasLock()) {
			return true;
		} else {
			return false;
		}
	}
	
	protected function _canEdit(Cream_Content_Item $item)
	{
		if ($item->getLocking()->canLock()) {
			return true;
		} else {
			return false; 
		}
	}
}