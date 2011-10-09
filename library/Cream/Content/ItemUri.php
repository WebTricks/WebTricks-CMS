<?php

/**
 * Unique identified to the item. 
 *
 */
class Cream_Content_ItemUri extends Cream_Component
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemUri
	 */
	public static function instance(Cream_Content_Item $item)
	{
		return Cream::instance(__CLASS__, $item);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Item $item
	 */
	public function __init(Cream_Content_Item $item)
	{
		$this->_setData('repositoryName', $item->getRepository()->getName());
		$this->_setData('itemId', (string) $item->getItemId());
		$this->_setData('culture', (string) $item->getCulture());
		$this->_setData('version', (string) $item->getVersion());
	}
	
	/**
	 * Returns the repository name.
	 * 
	 * @return string
	 */
	public function getRepositoryName()
	{
		return $this->_getData('repositoryName');
	}
	
	/**
	 * Returns the item id as a string.
	 * 
	 * @return string
	 */
	public function getItemId()
	{
		return $this->_getData('itemId');
	}
	
	/**
	 * Returns the culture.
	 * 
	 * @return string
	 */
	public function getCulture()
	{
		return $this->_getData('culture');
	}
	
	/**
	 * Returns the version number.
	 * 
	 * @return string
	 */
	public function getVersion()
	{	
		return $this->_getData('version');
	}
}