<?php

class Cream_Content_ItemEditing
{
	/**
	 * The content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $_item;
	
	/**
	 * True if editing is enabled, otherwise false.
	 * 
	 * @var boolean
	 */
	protected $_isEditing = false;
	
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
	
	/**
	 * Start to edit the item
	 *  
	 * @throws UnauthorizedAccessException
	 */
	public function startEdit()
	{
    	if ($this->_item->getRepository()->isReadOnly()) {
        	throw new Cream_Exceptions_UnauthorizedAccessException("The current database is read only (" + this.m_item.Database.Name + ")");
    	}
    
    	if (!$this->_item->getAccess()->canWrite()) {
        	throw new Cream_Exceptions_UnauthorizedAccessException("The current user does not have write access to this item. User: ". ", Item: ". $this->_item->getName() ." (". $this->_item->getItemId() .")");
    	}
    	
    	$this->_isEditing = true;
	}
	
	/**
	 * Check if currently editing the item.
	 * 
	 * @throws EditingNotAllowedException
	 */
	public function assertEditing()
	{
    	if (!$this->_isEditing) {
        	throw new Cream_Exceptions_EditingNotAllowedException($this->_item);
    	}
	}
	
	/**
	 * Cancels the edit and reverts all changes.
	 * 
	 */
	public function cancelEdit()
	{
		$this->_item->rejectChanges();
		$this->_isEditing = false;
	}
	
	/**
	 * Ends the editing and saves the item.
	 * 
	 */
	public function endEdit()
	{
		$this->acceptChanges();
		$this->_isEditing = false;
	}
	
	/**
	 * Save the changes to the item.
	 * 
	 */
	public function acceptChanges()
	{
		Cream_Content_Managers_ItemProvider::saveItem($this->_item);
	}
}