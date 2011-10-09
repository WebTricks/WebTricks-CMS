<?php

interface WebTricks_Shell_Commands_MessageHandlerInterface 
{
	/**
	 * Handles the message
	 * 
	 * @param WebTricks_Shell_Commands_CommandContext $context
	 */
	public function handleMessage(WebTricks_Shell_Commands_CommandContext $context);	
}