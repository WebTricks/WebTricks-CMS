<?php

class WebTricks_Shell_Commands_ContentManager_Save extends WebTricks_Shell_Commands_Command
{
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		if ($context->getMessage()) {
			$sender = $context->getMessage()->getSender();
			WebTricks_Shell_Commands_CommandProvider::sendMessage($sender, 'item:save', true);
		}
	}
}