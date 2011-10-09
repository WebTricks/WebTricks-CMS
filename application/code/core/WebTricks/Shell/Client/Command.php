<?php

class WebTricks_Shell_Client_Command extends Cream_ApplicationComponent
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return WebTricks_Shell_Client_Command
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function setCommand($command)
	{
		$this->_setData('command', $command);
	}
	
	public function setValue($value)
	{
		$this->_setData('value', $value);
	}
	
	public function setName($name)
	{
		$this->_setData('name', $name);
	}
	
	public function toJson()
	{
		return Cream_Json::encode($this->_getData());
	}
}