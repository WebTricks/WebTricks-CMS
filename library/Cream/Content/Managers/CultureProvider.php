<?php

class Cream_Content_Managers_CultureProvider
{
	/**
	 * Holds the manager object.
	 * 
	 * @var Cream_Content_Managers_CultureManager
	 */
	protected static $_manager;
	
	
	public static function getCultures(Cream_Content_Repository $repository)
	{
		return self::_getManager()->getCultures($repository);
	}
	
	/**
	 * Returns theculture manager
	 * 
	 * @return Cream_Content_Managers_CultureManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Content_Managers_CultureManager::instance();
		}		
		
		return self::$_manager;
	}
}