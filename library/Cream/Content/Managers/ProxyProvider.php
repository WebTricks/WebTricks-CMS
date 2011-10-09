<?php

class Cream_Content_Managers_ProxyProvider
{
	/**
	 * Holds the manager object
	 * 
	 * @var Cream_Content_Managers_ProxyManager
	 */
	protected static $_manager;	
	
	public function isProxy(Cream_Content_Item $item)
	{
		return self::_getManager()->isProxy($item);
	}
	
	public function isVirtual(Cream_Content_Item $item)
	{
		return self::_getManager()->isVirtual($item);
	}
	
	public function getRealItem(Cream_Content_Item $item)
	{
		return self::_getManager()->getRealItem($item);
	}
	
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Content_Managers_ProxyManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Content_Managers_ItemManager::instance();
		}		
		
		return self::$_manager;
	}	
}