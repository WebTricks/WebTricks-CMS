<?php

class WebTricks_Shell_Web_UI_ExtControls_Desktop_Module extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Web_UI_ExtControls_Desktop_Module
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
		
	public function setId($id)
	{
		$this->setAttribute('id', $id);
	}
	
	public function setType($type)
	{
		$this->setAttribute('type', $type);
	}
	
	public function setClassName($className)
	{
		$this->setAttribute('className', $className);
	}
	
	public function setLauncher($launcher)
	{
		$this->setAttribute('launcher', $launcher);
	}
	
	public function setLauncherPaths($launcherPaths)
	{
		$this->setAttribute('launcherPaths', $launcherPaths);
	}
}