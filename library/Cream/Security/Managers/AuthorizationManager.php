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

class Cream_Security_Managers_AuthorizationManager
{
	protected $_dataManager;
	
	protected $_innerCache = array();
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Security_Access_AuthorizationManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * 
	 * @param Cream_Security_Accounts_Account $account
	 * @param Cream_Security_SecurableInterface $item
	 * @param string $accessRight
	 * @return Cream_Security_Access_AccessResult
	 */
	public function getAccess(Cream_Security_Accounts_Account $account, Cream_Security_SecurableInterface $item, $accessRight)
	{
		return $this->_getItemAccess($account, $item, $accessRight);
	}
	
	/**
	 * Returns all the access rules of the given item.
	 * 
	 * @param Cream_Security_SecurableInterface $item
	 * @return Cream_Security_Access_AccessRuleCollection
	 */
	public function getAccessRules(Cream_Security_SecurableInterface $item)
	{
		$accessRules = $this->_getAccessRulesFromCache($item);
		
		if ($accessRules === null) {

			$accessRules = $item->getAccess()->getAccessRules();
			
			$this->_addAccessRulesToCache($item, $accessRules);
		}

		return $accessRules;
	}
	
	/**
	 * Generates a unique id for cache storage.
	 * 
	 * @param Cream_Security_SecurableInterface $item
	 * @return string
	 */
	protected function _getAccessRulesCacheKey(Cream_Security_SecurableInterface $item)
	{
		return $item->getUniqueId();
	}
	
	/**
	 * Check to see if the access rules are stored in the inner cache.
	 * Returns the access rules collection if found, otherwise null.
	 * 
	 * @param Cream_Security_SecurableInterface $item
	 * @return Cream_Security_Access_AccessRuleCollection
	 */
	protected function _getAccessRulesFromCache(Cream_Security_SecurableInterface $item)
	{
		$cacheKey = $this->_getAccessRulesCacheKey($item);
		
		if (isset($this->_innerCache[$cacheKey])) {
			return $this->_innerCache[$cacheKey];
		} else {
			return null;
		}
	}
	
	/**
	 * Adds the access rules to the inner cache.
	 * 
	 * @param Cream_Security_SecurableInterface $item
	 * @param Cream_Security_Access_AccessRuleCollection $accessRules
	 */
	protected function _addAccessRulesToCache(Cream_Security_SecurableInterface $item, Cream_Security_Access_AccessRuleCollection $accessRules)
	{
		$cacheKey = $this->_getAccessRulesCacheKey($item);
		$this->_innerCache[$cacheKey] = $accessRules;
	}
		
	protected function _getDataManager()
	{
		if (!$this->_dataManager) {
			
		}	
		
		return $this->_dataManager;
	}
	
	protected function _getItemAccess(Cream_Security_Accounts_Account $account, Cream_Content_Item $item, $accessRight)
	{
		$accessRules = Cream_Security_Managers_AuthorizationProvider::getAccessRules($item);		
		$accessRule = $accessRules->getMatchingRule($account, $accessRight);

		if ($accessRule) {
			return $accessRule;
		}

		$parent = Cream_Content_Managers_ItemProvider::getParent($item, true);
		
		if ($parent) {
			return $this->_getItemAccess($account, $parent, $accessRight);
		}
		
		return Cream_Security_Access_AccessResult::instance(Cream_Security_Access_AccessPermission::notSet);
	}
}