<?php

class Cream_Security_Accounts_Role extends Cream_Security_Accounts_Account
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @param string $name
	 * @return Cream_Security_Accounts_Role
	 */
	public static function instance($name)
	{
		return Cream::instance(__CLASS__, $name);	
	}
	
	public function __init($name)
	{
		$this->_name = $name;
		$this->_accountType = Cream_Security_Accounts_AccountType::ROLE;
	}
		
	/**
	 * Check to see if the given account is a member of this role.
	 *  
	 * @param Cream_Security_Accounts_Account $account
	 * @return boolean
	 */
	public function isMember(Cream_Security_Accounts_Account $account)
	{
		if ($this->getName() == $account->getName()) {
			return true;
		}
		
		return Cream_Security_MembershipProvider::isUserInRole($account, $this);
	}
}