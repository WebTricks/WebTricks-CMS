<?php

class Cream_Security_MembershipProvider
{
	/**
	 * Array holding the manager objects
	 * 
	 * @var array
	 */
	protected static $_manager;		
	
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Security_MembershipManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Security_MembershipManager::instance();
		}		
		
		return self::$_manager;
	}
	
	public static function changePassword($email, $domain, $newPassword)
	{
		return self::_getManager()->changePassword($email, $domain, $newPassword);
	}
	
	public static function createUser()
	{
		
	}
	
	public static function deleteUser($username)
	{
		self::_getManager()->deleteUser($username);
	}
	
	public static function getUser($username, $domain = null)
	{
		return self::_getManager()->getUser($username, $domain);
	}
	
	/**
	 * Returns a user by the given emailaddress and domain.
	 * 
	 * @param string $email
	 * @param string $domain
	 * @return Cream_Security_Accounts_User
	 */
	public static function getUserByEmail($email, $domain)
	{
		return self::_getManager()->getUserByEmail($email, $domain);
	}
	
	public static function getUsernameByEmail($email)
	{
		return self::_getManager()->getUsernameByEmail($email);
	}
	
	public static function updateUser(Cream_Security_Accounts_User $user)
	{
		self::_getManager()->updateUser($user);
	}
	
	/**
	 * Determines if the given user is in the given role. Returns true
	 * if the user is in the role, otherwise false.
	 * 
	 * @param Cream_Security_Accounts_User $user
	 * @param Cream_Security_Accounts_Role $role
	 * @return boolean
	 */
	public static function isUserInRole(Cream_Security_Accounts_User $user, Cream_Security_Accounts_Role $role)
	{
		return self::_getManager()->isUserInRole($user, $role);
	}
	
	/**
	 * Retrieves all the users in the given role.
	 *  
	 * @param Cream_Security_Accounts_Role $role
	 * @return Cream_Security_Accounts_AccountCollection
	 */
	public static function getUsersInRole(Cream_Security_Accounts_Role $role)
	{
		return self::_getManager()->getUsersInRole($role);
	}
}