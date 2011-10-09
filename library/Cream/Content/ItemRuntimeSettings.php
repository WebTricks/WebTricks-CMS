<?php

class Cream_Content_ItemRuntimeSettings
{
	/**
	 * The content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $_item;
	
	/**
	 * True if all data needs to be save, otherwise false.
	 * 
	 * @var boolean
	 */
	protected $_saveAll;
	
	/**
	 * Create an instance of this class
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemEditing
	 */
	public static function instance(Cream_Content_Item $item)
	{
		return Cream::instance(__CLASS__, $item);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public function __init(Cream_Content_Item $item)
	{
		$this->_item = $item;
	}

	public function setSaveAll($saveAll)
	{
		$this->_saveAll = $saveAll;
	}
	
	public function getSaveAll()
	{
		return $this->_saveAll;
	}
}