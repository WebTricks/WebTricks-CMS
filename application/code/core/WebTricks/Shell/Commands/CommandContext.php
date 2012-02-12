<?php

class WebTricks_Shell_Commands_CommandContext extends Cream_Object
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return WebTricks_Shell_Commands_CommandContext
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function getItems()
	{
		return $this->_getData('items');
	}
	
	/**
	 * Returns the context item
	 * 
	 * @return Cream_Content_Item
	 */
	public function getItem()
	{
		if ($this->hasItems()) {
			$items = $this->getItems();
			return $items[0];
		}
	}
	
	public function addItem(Cream_Content_Item $item)
	{
		$items = array();
		if ($this->hasItems()) {
			$items = $this->getItems();
		}
		$items[] = $item;
		$this->_setData('items', $items);
	}
	
	public function clearItems()
	{
		return $this->_unsetData('items');
	}
	
	public function hasItems()
	{
		return $this->_hasData('items');
	}
	
	public function getResult()
	{
		return $this->_getData('result');
	}
	
	public function hasResult()
	{
		return $this->_hasData('result');
	}
	
	public function setResult($result)
	{
		$this->_setData('result', $result);
	}
	
	public function getValue()
	{
		return $this->_getData('value');
	}
	
	public function hasValue()
	{
		return $this->_hasData('value');
	}
	
	public function setValue($value)
	{
		$this->_setData('value', $value);
	}
	
	/**
	 * Returns the context message
	 * 
	 * @return WebTricks_Shell_Commands_Message
	 */
	public function getMessage()
	{
		return $this->_getData('message');
	}
	
	public function setMessage(WebTricks_Shell_Commands_Message $message)
	{
		$this->_setData('message', $message);
	}
	
}