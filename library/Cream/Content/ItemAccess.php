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
 * Determines the access to an item
 * 
 * @package		Cream_Content
 * @author 		Danny Verkade
 */
class Cream_Content_ItemAccess extends Cream_ApplicationComponent
{
	/**
	 * Holds the item access rules
	 *
	 * @var Cream_Security_Access_AccessRuleCollection
	 */	
	protected $_accessRules;
	
	/**
	 * The content item for this state object
	 * 
	 * @var Cream_Content_Item
	 */
	protected $_item;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemAppearance
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
	 * Determines if the user can administer the item.
	 * 
	 * @return boolean
	 */
	public function canAdmin()
	{
		return $this->_isAllowed($this, Cream_Security_Access_AccessRight::itemAdmin);
	}
		
	public function canAdd()
	{
		if (!$this->canCreate()) {
			return false;
		}
	}
	
	/**
	 * Determines if the user can copy this item.
	 * 
	 * @param Cream_Content_Item $destination
	 * @return boolean
	 */	
	public function canCopyTo(Cream_Content_Item $destination)
	{
		return $destination->getAccess()->canCreate();
	}
	
	/**
	 * Determines if the user can create this item.
	 * 
	 * @return boolean
	 */	
	public function canCreate()
	{
		return $this->_isAllowed($this->_item, Cream_Security_Access_AccessRight::itemCreate);
	}
	
	/**
	 * Determines if the user can delete this item.
	 * 
	 * @return boolean
	 */	
	public function canDelete()
	{
		return $this->_isAllowed($this->_item, Cream_Security_Access_AccessRight::itemDelete);	
	}
	
	/**
	 * Determines if the user can duplicate this item.
	 * 
	 * @return boolean
	 */	
	public function canDuplicate()
	{
		if ($this->_item->getParent()) {
			return $this->_item->getParent()->getAccess()->canCreate();
		} else {
			return false;
		}
	}
	
	/**
	 * Determines if the user can move this item.
	 * 
	 * @param Cream_Content_Item $destination
	 * @return boolean
	 */	
	public function canMoveTo(Cream_Content_Item $destination)
	{
		if ($this->canDelete() && $destination->getAccess()->canCreate()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Determines if the user can read this item.
	 * 
	 * @return boolean
	 */
	public function canRead()
	{
		return $this->_isAllowed($this->_item, Cream_Security_Access_AccessRight::itemRead);			
	}
	
	public function canReadLanguage()
	{
		
	}
	
	/**
	 * Determines if the user can rename this item.
	 * 
	 * @return boolean
	 */
	public function canRename()
	{
		return $this->_isAllowed($this->_item, Cream_Security_Access_AccessRight::itemRename);			
	}
	
	/**
	 * Determines if the user can write this item.
	 * 
	 * @return boolean
	 */
	public function canWrite()
	{
		return $this->_isAllowed($this->_item, Cream_Security_Access_AccessRight::itemWrite);
	}
	
	public function canWriteLanguage()
	{
		
	}
	
	/**
	 * Returns the access rules of the item.
	 * 
	 * @return Cream_Security_Access_AccessRuleCollection
	 */
	public function getAccessRules()
	{
		if (!$this->_accessRules) {
			$securityField = $this->_getSecurityField();
			$this->_accessRules = Cream_Security_Access_AccessRuleSerializer::singleton()->unserializeAccessRules($securityField->getValue());
		}
		
		return $this->_accessRules;
	}
	
	/**
	 * Sets the access rules of the item. To set the access rules the
	 * item must editable, else an exception is thrown.
	 * 
	 * @param Cream_Security_Access_AccessRuleCollection $accessRules
	 * @return void
	 */
	public function setAccessRules(Cream_Security_Access_AccessRuleCollection $accessRules)
	{
		$this->_item->getEditing()->assertEditing();
		$rules = Cream_Security_Access_AccessRuleSerializer::singleton()->serializeAccessRules($accessRules);
		
		$securityField = $this->_getSecurityField();
		$securityField->setValue($rules);
	}
	
	/**
	 * Returns the lock field of the item. Returns the field if the
	 * lockfield is present, otherwise null.
	 * 
	 * @return Cream_Content_Fields_Field
	 */
	protected function _getSecurityField()
	{
		return $this->_item->getFields()->getField(Cream_Application_FieldIds::getSecurity());
	}	
	
	/**
	 * Determines whether the specified access right is granted for
	 * the current user
	 * 
	 * @param Cream_Content_Item $item
	 * @param string $accessRight
	 */
	protected function _isAllowed(Cream_Content_Item $item, $accessRight)
	{
		return Cream_Security_Managers_AuthorizationProvider::isAllowed($this->getApplication()->getContext()->getUser(), $item, $accessRight);
	}
}