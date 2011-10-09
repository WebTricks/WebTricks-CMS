<?php

class Cream_Security_Domains_Domain
{
	/**
	 * Name of the anonymouse user
	 * 
	 * @var string
	 */
    protected $_anonymousUsername = 'anonymous';
    
    protected $_everyoneRolename = 'everyone';
	
	protected $_name;
	
	protected $_description;	
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param string $name
	 * @return Cream_Security_Domains_Domain
	 */
	public static function instance($name, $description = '')
	{
		return Cream::instance(__CLASS__, $name, $description);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param string $name
	 */
	public function __init($name, $description = '') 
	{
		$this->_name = $name;
		$this->_description = $description;	
	}
	
	/**
	 * Returns the anonymous user for this domain
	 * 
	 * @return Cream_Security_Accounts_User
	 */
	public function getAnonymousUser()
	{
		$username = $this->getName() .'\\'. $this->_anonymousUsername;
		//return Cream_Security_MembershipProvider::getUser($this->_anonymousUsername, $this);
		return Cream_Security_Accounts_User::instance($username);
	}
	
	public function getEveryoneRole()
	{
		
	}
	
	/**
	 * Returns the name of the domain
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
	 * Returns the domain description.
	 * 
	 * @return string
	 */
	public function getDescription()
	{
		return $this->_description;	
	}
}