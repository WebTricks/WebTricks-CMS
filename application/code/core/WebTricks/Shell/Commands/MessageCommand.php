<?php

class WebTricks_Shell_Commands_MessageCommand extends WebTricks_Shell_Commands_Command
{
	/**
	 * Message object
	 * 
	 * @var WebTricks_Shell_Commands_Message
	 */
	protected $_message;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param WebTricks_Shell_Commands_Message $message
	 * @return WebTricks_Shell_Commands_MessageCommand
	 */
	public static function instance(WebTricks_Shell_Commands_Message $message)
	{
		return Cream::instance(__CLASS__, $message);
	}
	
	/**
	 * Initialize function
	 *  
	 * @param WebTricks_Shell_Commands_Message $message
	 */
	public function __init(WebTricks_Shell_Commands_Message $message) 
	{
		$this->_message = $message;
	}
	
	/**
	 * Returns the command message.
	 * 
	 * @return WebTricks_Shell_Commands_Message
	 */
	public function getMessage()
	{
		return $this->_message;
	}
	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		$sender = $this->_message->getSender();
		if ($sender instanceof WebTricks_Shell_Commands_MessageHandlerInterface) {
			$sender->handleMessage($context);
		}
	}	
}