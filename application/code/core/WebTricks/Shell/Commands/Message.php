<?php

class WebTricks_Shell_Commands_Message extends Cream_Component
{
	/**
	 * Message
	 * 
	 * @var string
	 */
	protected $_message;
	
	/**
	 * Sender object
	 * 
	 * @var object
	 */
	protected $_sender;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param object $sender
	 * @param string $message
	 * @return WebTricks_Shell_Commands_Message
	 */
	public static function instance($sender, $message)
	{
		return Cream::instance(__CLASS__, $sender, $message);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param object $sender
	 * @param string $message
	 */
	public function __init($sender, $message)
	{
		$this->_sender = $sender;
		$this->_message = $message;
	}
	
	/**
	 * Returns the sender object instance.
	 * 
	 * @return 
	 */
	public function getSender()
	{
		return $this->_sender;
	}
	
	/**
	 * Returns the message.
	 * 
	 * @return string
	 */
	public function getMessage()
	{
		return $this->_message;
	}
}