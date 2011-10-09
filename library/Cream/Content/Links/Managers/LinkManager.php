<?php

class Cream_Links_Managers_LinkManager
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Links_Managers_LinkManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Returns the friendly URL of the item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return string
	 */
	public function getItemUrl(Cream_Content_Item $item)
	{
		
	}
}