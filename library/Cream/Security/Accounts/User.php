<?php


class Cream_Security_Accounts_User extends Cream_Security_Accounts_Account
{	
	protected $_isAuthenticated = false;
			
	protected $_profile;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Security_Accounts_User
	 */
	public static function instance($name)
	{
		return Cream::instance(__CLASS__, $name);
	}
	
	public function __init($name)
	{
		$this->_name = $name;
		$this->_accountType = Cream_Security_Accounts_AccountType::USER;
	}
	
	public function delete()
	{
		
	}
	
	public function getProfile()
	{
		return $this->_profile;
	}
	
	public function getRoles()
	{
		
	}
	
	public function isAuthenticated()
	{
		return $this->_isAuthenticated;
	}
	
	public function setAuthenticated($authenticated)
	{
		$this->_isAuthenticated = $authenticated;
	}
	
	public function isInRole(Cream_Security_Accounts_Role $role)
	{
		foreach ($this->getRoles() as $role) {
			$role->isMemberOf($this);
		}
	}
	
	protected function _isInRole()
	{
		
	}
	
	public function changePassword($newPassword)
	{
		Cream_Security_MembershipProvider::changePassword($this->getLocalName(), $this->getDomain()->getName(), $newPassword);
	}
}