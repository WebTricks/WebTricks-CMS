<?php

class Cream_Security_AuthenticationProvider
{
	/**
	 * Array holding the manager objects
	 * 
	 * @var array
	 */
	protected static $_manager;		
	
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Security_AuthenticationManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Security_AuthenticationManager::instance();
		}		
		
		return self::$_manager;
	}

	public static function login($user, $password)
	{
		return self::_getManager()->login($user, $password);
	}
	
	/**
	 * Logs the current user out.
	 *
	 * @return void
	 */
	public static function logout()
	{
		return self::_getManager()->logout();
	}
	
	public static function setActiveUser($username)
	{
		self::_getManager()->setActiveUser($username);
	}
	
	
}