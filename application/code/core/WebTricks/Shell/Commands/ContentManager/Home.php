<?php

class WebTricks_Shell_Commands_ContentManager_Home extends WebTricks_Shell_Commands_Command
{	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		$item = $this->_getHomeItem();
		
		if ($item) {
			$sender = $context->getMessage()->getSender();
			WebTricks_Shell_Commands_CommandProvider::sendMessage($sender, 'item:load(itemId='. $item->getItemId() .', culture='. $item->getCulture() .', version='. $item->getVersion() .')');
		}
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (!$this->_getHomeItem()) {
			return WebTricks_Shell_Commands_CommandState::HIDDEN;
		}
		
		return parent::queryState($context);
	}
	
	protected function _getHomeItem()
	{
		
	}
}