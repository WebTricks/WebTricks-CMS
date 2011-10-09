<?php

class Cream_Content_Managers_LinkProvider
{
	/**
	 * Holds the manager object
	 * 
	 * @var Cream_Content_Managers_LinkManager
	 */
	protected static $_manager;	
	
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Content_Managers_LinkManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Content_Managers_ItemManager::instance();
		}		
		
		return self::$_manager;
	}
}