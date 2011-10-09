<?php


class Cream_Security_Managers_DomainProvider
{
	/**
	 * Domain manager
	 *  
	 * @var Cream_Security_Domains_DomainManager
	 */
	protected static $_manager;
	
	/**
	 * Add a domain
	 * 
	 * @param string $name
	 */
	public static function addDomain($name)
	{
		self::_getManager()->addDomain($name);
	}
	
	/**
	 * Deletes a domain
	 * 
	 * @param string $name
	 */
	public static function deleteDomain($name)
	{
		self::_getManager()->deleteDomain($name);	
	}
	
	/**
	 * Returns the default domain
	 * 
	 * @return Cream_Security_Domains_Domain
	 */
	public static function getDefaultDomain()
	{
		return self::_getManager()->getDefaultDomain();	
	}
	
	/**
	 * Returns the domain of the specified name.
	 * 
	 * @param string $name
	 * @return Cream_Security_Domains_Domain
	 */
	public static function getDomain($name)
	{
		return self::_getManager()->getDomain($name);
	}

	/**
	 * Returns an array with all domains.
	 * 
	 * @return array
	 */
	public static function getDomains()
	{
		return self::_getManager()->getDomains();
	}
		
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Security_Managers_DomainManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Security_Managers_DomainManager::instance();
		}		
		
		return self::$_manager;
	}
}