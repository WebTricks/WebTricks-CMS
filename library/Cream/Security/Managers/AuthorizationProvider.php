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

class Cream_Security_Managers_AuthorizationProvider 
{
	/**
	 * Array holding the manager object
	 * 
	 * @var array
	 */
	protected static $_manager;	
	
	/**
	 * Check of the user is allowed for the given access right. 
	 *  
	 * @param Cream_Security_Accounts_Account $user
	 * @param Cream_Security_SecurableInterface $resource
	 * @param string $permission
	 * @return boolean
	 */
	public static function isAllowed(Cream_Security_Accounts_Account $user, Cream_Security_SecurableInterface $resource, $accessRight)
	{
		$accessResult = self::_getManager()->getAccess($user, $resource, $accessRight);
		
		if ($accessResult->getPermission() == Cream_Security_Access_AccessPermission::allow) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $user
	 * @param unknown_type $resource
	 * @param unknown_type $permission
	 */
	public static function isDenied($user, $resource, $permission)
	{
		$accessResult = self::_getManager()->getAccess($user, $resource, $permission);
		
		if ($accessResult->getPermission() == Cream_Security_Access_AccessPermission::deny) {
			return true;
		} else {
			return false;
		}		
	}
	
	/**
	 * Returns the access rule collection of the given item.
	 *  
	 * @param unknown_type $resource
	 * @return Cream_Security_Access_AccessRuleCollection
	 */
	public static function getAccessRules(Cream_Security_SecurableInterface $resource)
	{
		return self::_getManager()->getAccessRules($resource);		
	}
	
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Security_Managers_AuthorizationManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Security_Managers_AuthorizationManager::instance();
		}		
		
		return self::$_manager;
	}
}