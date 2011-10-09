<?php

class Cream_Security_Accounts_UserProfile
{
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Security_Accounts_UserProfile
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
}