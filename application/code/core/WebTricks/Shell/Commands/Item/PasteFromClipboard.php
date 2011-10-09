<?php

class WebTricks_Shell_Commands_Item_PasteFromClipboard extends WebTricks_Shell_Commands_Command
{
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		if (count($context->getItems()) == 1) {
			
			$session = WebTricks_Shell_Session::singleton();
			$clipboard = $session->getClipboard();
			
			list($action, $itemId) = explode(':', $clipboard);
			$itemId = Cream_Guid::parseGuid($itemId);
			
			if ($action != 'copy' && $action != 'cut') {
				return;
			}
			
			if (!$itemId) {
				return;
			}
			
			$item = $context->getItem()->getRepository()->getItem($itemId);
			
			switch ($action) {
				case 'cut':
					$item->moveTo($context->getItem());					
					break;
				case 'copy':
					$item->copyTo($context->getItem());
					break;
					
			}
			
			WebTricks_Shell_Client_Response::refresh(array((string) $item->getParent()->getItemId(), (string) $context->getItem()->getItemId()));
		}
	}
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		$session = WebTricks_Shell_Session::singleton();
		
		if (count($context->getItems()) == 1 && $session->getClipboard()) {
			return WebTricks_Shell_Commands_CommandState::ENABLED;
		}
		
		return WebTricks_Shell_Commands_CommandState::DISABLED;
	}
}