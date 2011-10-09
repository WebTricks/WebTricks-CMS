<?php

class WebTricks_Shell_Client_Response
{
	protected static $_commands = array();
	
	protected static function _add($commandName, $value, $name = null)
	{
		$command = WebTricks_Shell_Client_Command::instance();
		$command->setCommand($commandName);
		$command->setValue($value);
		if ($name) {
			$command->setName($name);
		}
		
		self::$_commands[] = $command;
	}
	
	public static function alert($text)
	{
		self::_add('alert', Cream_Globalization_Translate::text($text));
	}
	
	public static function confirm($text)
	{
		self::_add('confirm', Cream_Globalization_Translate::text($text));
	}
	
	public static function prompt($text)
	{
		self::_add('prompt', Cream_Globalization_Translate::text($text));
	}
	
	public static function setParameter($name, $value)
	{
		self::_add('setParameter', $value, $name);			
	}

	public static function setControl($name, $value)
	{
		self::_add('setControl', $value, $name);			
	}
	
	public static function runApplication(Cream_Content_Item $item)
	{
		self::_add('runApplication', (string) $item->getItemId());
	}
	
	public static function showModalDialog($name, $value)
	{
		self::_add('showModalDialog', $value, $name);
	}
	
	public static function refresh($value)
	{
		self::_add('refresh', $value);
	}
	
	
	public static function clear()
	{
		self::$_commands = array();
	}
	
	public static function toJson()
	{
		return array('commands' => self::$_commands);
	}
}