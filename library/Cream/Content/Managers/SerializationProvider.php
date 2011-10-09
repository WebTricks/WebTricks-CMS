<?php 
/**
 * WebTricks
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in
 * the future. If you wish to customize WebTricks for your needs please go to 
 * http://www.webtricksframework.com for more information.
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * The serialization manager
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Managers_SerializationProvider
{
	/**
	 * Serilization manager
	 *  
	 * @var Cream_Content_Managers_SerializationManager
	 */
	protected static $_manager = null;

	public static function dumpTree(Cream_Content_Item $item, $path)
	{
		return self::_getManager()->dumpTree($item, $path);
	}
	
	public static function dumpItem(Cream_Content_Item $item, $path)
	{
		return self::_getManager()->dumpItem($item, $path);
	}
	
	public static function loadTree($path)
	{
		return self::_getManager()->loadTree($path);
	}
	
	public static function loadItem($path)
	{
		return self::_getManager()->loadItem($path);
	}

	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Content_Managers_SerializationManager
	 */
	protected static function _getManager()
	{
		if (!self::$_manager) {
			self::$_manager = Cream_Content_Managers_SerializationManager::instance();
		}		
		
		return self::$_manager;
	}		
}