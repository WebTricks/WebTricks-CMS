<?php

class WebTricks_Shell_Commands_CommandProvider
{
	/**
	 * holding the manager objects
	 * 
	 * @var WebTricks_Shell_Commands_CommandManager
	 */
	protected static $_manager;
			
	public static function queryState($name, $item)
	{
		return self::_getManager()->queryState($name, $item);
	}
	
	public static function getCommand($name)
	{
		return self::_getManager()->getCommand($name);	
	}
	
	public static function getDispatchCommand($sender, $name)
	{
		return self::_getManager()->getDispatchCommand($sender, $name);	
	}
	
	public static function sendMessage($sender, $name, $argumentsFromReqeust = false)
	{
		self::_getManager()->sendMessage($sender, $name, $argumentsFromReqeust);
	}
	
	/**
	 * Returns the item manager
	 * 
	 * @return WebTricks_Shell_Commands_CommandManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = WebTricks_Shell_Commands_CommandManager::instance();
		}		
		
		return self::$_manager;
	}
}