<?php

class Cream_Security_Managers_UserProvider
{
	/**
	 * Array holding the manager objects
	 * 
	 * @var array
	 */
	protected static $_manager;		
		
	public static function getAllUsers($search = '', $domain = '', $start = 0, $size = 50, $order = 'email', $orderDirection = 'asc')
	{	
		return self::_getManager()->getAllUsers($search, $domain, $start, $size, $order, $orderDirection);
	}

	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Security_Managers_UserManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Security_Managers_UserManager::instance();
		}		
		
		return self::$_manager;
	}	
	
}