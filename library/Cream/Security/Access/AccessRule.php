<?php

class Cream_Security_Access_AccessRule 
{
	/**
	 * The name of the access right.
	 * 
	 * @var string
	 */
	protected $_accessRight;
	
	/**
	 * The account of the access rule.
	 * 
	 * @var Cream_Security_Accounts_Account
	 */
	protected $_account;
	
	/**
	 * The permission of the access rule. 
	 * 
	 * @var boolean
	 */
	protected $_permission;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Security_Accounts_Account $account
	 * @param string $accessRight
	 * @param string $permission
	 * @return Cream_Security_Access_AccessRule
	 */
	public static function instance(Cream_Security_Accounts_Account $account, $accessRight, $permission)
	{
		return Cream::instance(__CLASS__, $account, $accessRight, $permission);
	}
	
	/**
	 * Initialize function.
	 * 
	 * @param Cream_Security_Accounts_Account $account
	 * @param unknown_type $accessRight
	 */
	public function __init(Cream_Security_Accounts_Account $account, $accessRight, $permission)
	{
		$this->_account = $account;
		$this->_accessRight = $accessRight;		
		$this->_permission = $permission;
	}
	
	/**
	 * Determines if the given account and access right matched the 
	 * access rule. Returns true if it matches, otherwise false.
	 *  
	 * @param Cream_Security_Accounts_Account $account
	 * @param string $accessRight
	 * @return boolean
	 */
	public function isMatch(Cream_Security_Accounts_Account $account, $accessRight)
	{
		if ($accessRight != $this->_accessRight) {
			return false;
		}
		
		if ($this->getAccount()->getAccountType() == Cream_Security_Accounts_AccountType::ROLE) {
			return $this->getAccount()->isMember($account);
		} else {
			if ($this->getAccount()->getName() == $account->getName()) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	/**
	 * Returns the account for this access rule.
	 * 
	 * @return Cream_Security_Accounts_Account
	 */
	public function getAccount()
	{
		return $this->_account;
	}
	
	/**
	 * Returns the access right.
	 * 
	 * @return string
	 */
	public function getAccessRight()
	{
		return $this->_accessRight;
	}
	
	/**
	 * Returns the permission of the access rule.
	 * 
	 * @return boolean
	 */
	public function getPermission()
	{
		return $this->_permission;
	}
}