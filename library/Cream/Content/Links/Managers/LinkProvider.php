<?php

class Cream_Links_Managers_LinkProvider
{
	/**
	 * holding the manager objects
	 * 
	 * @var Cream_Content_Managers_ItemManager
	 */
	protected static $_manager;	
	
	/**
	 * Returns the friendly URL of the item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return string
	 */
	public static function getItemUrl(Cream_Content_Item $item)
	{
		return self::_getManager()->getItemUrl($item);
	}
	
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Content_Managers_ItemManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Content_Managers_ItemManager::instance();
		}		
		
		return self::$_manager;
	}
}