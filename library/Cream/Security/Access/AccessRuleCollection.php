<?php

class Cream_Security_Access_AccessRuleCollection extends Cream_Collection_Iterator
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @param array $data
	 * @return Cream_Security_Access_AccessRuleCollection
	 */
	public static function instance($data = null) 
	{
		return Cream::instance(__CLASS__, $data);		
	}
	
	/**
	 * Retrieves the matching rule in the access rule collection. If
	 * no match is found returns null.
	 * 
	 * @param Cream_Security_Accounts_Account $account
	 * @param string $accessRight
	 * @return Cream_Security_Access_AccessRule
	 */
	public function getMatchingRule(Cream_Security_Accounts_Account $account, $accessRight)
	{
		foreach($this->_data as $accessRule) {
			if ($accessRule->isMatch($account, $accessRight)) {
				return $accessRule;
			}
		}
	}
	
	/**
	 * Returns a collection of accounts which are specified in access
	 * rule collection.
	 * 
	 * @return Cream_Security_Accounts_AccountCollection
	 */
	public function getAccounts()
	{
		$accounts = Cream_Security_Accounts_AccountCollection::instance();
		
		foreach($this->_data as $accessRule) {
			$add = true;
			foreach($accounts as $account) {
				if ($account->getName() == $accessRule->getAccount()->getName()) {
					$add = false;
				}	
			}
			
			if ($add) {
				$accounts->add($accessRule->getAccount());
			}
		}
		
		return $accounts;
	}
}