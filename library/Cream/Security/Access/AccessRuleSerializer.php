<?php

class Cream_Security_Access_AccessRuleSerializer
{
	/**
	 * Returns the singleton of this class
	 * 
	 * @return Cream_Security_Access_AccessRuleSerializer
	 */
	public static function singleton()
	{
		return Cream::singleton(__CLASS__);
	}
		
	public function serializeAccessRules(Cream_Security_Access_AccessRuleCollection $accessRules)
	{
		$rules = array();
		
		foreach($accessRules as $accessRule) {
			$rules[] = $this->serializeAccessRule($accessRule);
		}
		
		return serialize($rules);
	}
	
	public function unserializeAccessRules($value)
	{
		$accessRules = Cream_Security_Access_AccessRuleCollection::instance();
		$array = unserialize($value);
		if (is_array($array)) {
			foreach($array as $rule) {
				$accessRule = $this->unserializeAccessRule($rule);
				if ($accessRule) {
					$accessRules->add($accessRule);
				}
			}
		}
		
		return $accessRules;	
	}
	
	public function serializeAccessRule(Cream_Security_Access_AccessRule $accessRule)
	{		
		return array('account' => array(
				'type' => $accessRule->getAccount()->getAccountType(),
				'name' => $accessRule->getAccount()->getName()
			),
			'accessRight' => $accessRule->getAccessRight(),
			'permission' => $accessRule->getPermission()
		);
	}
	
	public function unserializeAccessRule($rule)
	{
		switch ($rule['account']['type']) {
			case Cream_Security_Accounts_AccountType::USER:
				$account = Cream_Security_Accounts_User::instance($rule['account']['name']);
				break;
			case Cream_Security_Accounts_AccountType::ROLE:
				$account = Cream_Security_Accounts_Role::instance($rule['account']['name']);
				break;
			default:
				throw new Cream_Exceptions_Exception('Account type not found: '. $rule['account']['type']);
				break;
		}
				
		return Cream_Security_Access_AccessRule::instance($account, $rule['accessRight'], $rule['permission']);
	}
}