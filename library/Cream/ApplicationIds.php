<?php

class Cream_ApplicationIds
{
	protected static $_cache;
	
	protected static function _getGuid($string)
	{
		if (!isset(self::$_cache[$string])) {
			self::$_cache[$string] = Cream_Guid::parseGuid($string);
		}
		
		return self::$_cache[$string];
	}
}