<?php

abstract class Cream_Security_Accounts_Account
{
	protected $_name;
	
	protected $_accountType;
	
	protected $_domain;
	
	public function getDescription()
	{
		
	}
	
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * Returns the domain.
	 * 
	 * @return Cream_Security_Domains_Domain
	 */
	public function getDomain()
	{
		if (!$this->_domain) {
			list($domain, $name) = explode('\\', $this->getName());
			
			if ($domain) {
				$this->_domain = Cream_Security_Managers_DomainProvider::getDomain($domain);
			}
		}	
		
		return $this->_domain;
	}

	/**
	 * Returns the local name of the account name.
	 * 
	 * @return string
	 */
	public function getLocalName()
	{
		list($domain, $name) = explode('\\', $this->getName());
		
		return $name;
	}
	
	/**
	 * Returns the type of account.
	 * 
	 * @return integer
	 */
	public function getAccountType()
	{
		if (!$this->_accountType) {
			$this->_accountType = Cream_Security_Accounts_AccountType::UNKNOWN;
		}
		
		return $this->_accountType;
	}
	
	public function getIcon()
	{
		$icon = '';
		
		switch($this->getAccountType()) {
			case Cream_Security_Accounts_AccountType::USER;
				$icon = 'user1';
				break;
			case Cream_Security_Accounts_AccountType::ROLE;
				$icon = 'id-card';
				break;
		}	
		
		return $icon;
	}
}