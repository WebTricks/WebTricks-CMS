<?php

class Cream_Security_AuthenticationManager extends Cream_ApplicationComponent
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Security_AuthenticationManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function login(Cream_Security_Accounts_User $user, $password)
	{
		$user->setAuthenticated(true);
		return true;
	}
	
	public function logout(Cream_Security_Accounts_User $user)
	{
		$user->setAuthenticated(false);
		return true;
		
	}
	
	public function setActiveUser($username)
	{
		
	}
}