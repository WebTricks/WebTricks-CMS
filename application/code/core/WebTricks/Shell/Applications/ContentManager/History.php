<?php

class WebTricks_Shell_Applications_ContentManager_History 
{
	/**
	 * Pointer to the current history item.
	 * 
	 * @var unknown_type
	 */
	protected $_current = -1;
	
	/**
	 * Array holding the history.
	 * 
	 * @var array
	 */
	protected $_history = array();
	
	/**
	 * Create new instance of this class.
	 * 
	 * @return WebTricks_Shell_Applications_ContentManager_History
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Check to see if you can go back in the history. Returns true
	 * when possible, otherwise false.
	 * 
	 * @return boolean
	 */
	public function canGoBack()
	{
		if ($this->_current > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Check to see if you can go forward in the history. Returns true
	 * when possible, otherwise false.
	 *
	 * @return boolean
	 */
	public function canGoForward()
	{
		if (count($this->_history) && $this->_current < (count($this->_history) - 1)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Adds an item the the history.
	 * 
	 * @param unknown_type $item
	 */
	public function add(Cream_Content_ItemUri $item)
	{
		if (count($this->_history) && $item == $this->_history[$this->_current]) {
			return;
		}
		
		while($this->_current < (count($this->_history) - 1)) {
			array_pop($this->_history);
		}
		
		$this->_history[] = $item;
		$this->_current++;
		
		if (count($this->_history) > 99) {
			array_shift($this->_history);
			$this->_current--;
		}
	}
	
	/**
	 * Goes back in the history. Returns the histoyr
	 * 
	 * @return Cream_Content_ItemUri
	 */
	public function back()
	{
		if ($this->_current > 0) {
			$this->_current--;
			return $this->current();
		} 
	}
	
	/**
	 * Clears the history list
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->_history = array();
		$this->_current = -1;
	}
	
	/**
	 * Returns the current history item.
	 * 
	 * @return Cream_Content_ItemUri
	 */
	public function current()
	{
		return $this->_history[$this->_current];
	}
	
	/**
	 * Goes forward in the history list. Returns the new history
	 * item.
	 * 
	 * @return Cream_Content_ItemUri
	 */
	public function forward()
	{
		if ($this->_current <= count($this->_history)) {
			$this->_current++;
			return $this->current();
		}
	}
}