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
 * Represents the locking state of an item. Locking ensures that only
 * one user can edit an item at the same time. 
 * 
 * @package		Cream_Content
 * @author 		Danny Verkade
 */
class Cream_Content_ItemLocking extends Cream_ApplicationComponent
{
	/**
	 * The content item for this state object
	 * 
	 * @var Cream_Content_Item
	 */
	protected $item;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemLocking
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
		$this->item = $item;		
	}
	
	/**
	 * Check to determine if the user can lock the item. True if the
	 * item can be locked, otherwise false.
	 * 
	 * @return boolean
	 */
	public function canLock()
	{
		if (!$this->isLocked && $this->item->getAccess()->canWrite()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Check to see if the current user can unlock the item. True if
	 * the item can be unlocked, otherwise false.
	 * 
	 * @return boolean
	 */
	public function canUnlock()
	{
		if ($this->hasLock()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Returns the name of the owner who has currently locked this
	 * item. If the item is not locked, return an empty string.
	 * 
	 * @return string
	 */
	public function getOwner()
	{
		$lockField = $this->getLockField();
		
		if ($lockField) {
			return $lockField->getOwner();			
		}		
	}
	
	
	/**
	 * Determines whether the current user has a lock on the item. 
	 * True if the current user has a lock on the item, otherwise 
	 * false.
	 * 
	 * @return boolean
	 */
	public function hasLock()
	{
		$lockField = $this->getLockField();
		
		if ($lockField && $lockField->getOwner() == $this->_getApplication()->getUser()->getAdministratorProfile()->getUserId()) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Check of the item is already locked. Returns true if the item
	 * is locked, otherwise false.
	 * 
	 * @return boolean
	 */
	public function isLocked()
	{
		$lockField = $this->getLockField();
		
		if ($lockField && $lockField->getOwner()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Check if another user has a lock on the item. Returns true if
	 * another user has locked the item, otherwise false.
	 * 
	 * @return boolean
	 */
	public function isLockedByOther()
	{
		if ($this->isLocked() && !$this->hasLock()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Locks the item. Returns true if the user has acquired a lock on
	 * the item, otherwise false.
	 * 
	 * @return boolean
	 */
	public function lock()
	{
		if ($this->hasLock()) {
			return true;
		}
		
		if ($this->canLock()) {
			$lockField = $this->getLockField();
			
			if ($lockField) {
				return $lockField->acquireLock();
			}
		}
		
		return false;
	}
	
	/**
	 * Unlocks the item. Returns true if unlocking the item was
	 * successfull, otherwise false.
	 * 
	 * @return boolean
	 */
	public function unlock()
	{
		if ($this->canUnlock()) {
			$lockField = $this->getLockField();
			if ($lockField) {
				return $lockField->releaseLock();
			}
		}
		
		return false;
	}
	
	/**
	 * Returns the lock field of the item. Returns the field if the
	 * lockfield is present, otherwise null.
	 * 
	 * @return Cream_Content_Fields_LockField
	 */
	protected function getLockField()
	{
		return $this->item->getFields()->getField(Cream_Application_FieldIds::lock);
	}
}