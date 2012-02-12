<?php

class Cream_Security_Managers_DomainManager extends Cream_ApplicationComponent
{
	/**
	 * Path to domain data manager configuration
	 * 
	 * @var string 
	 */
	const CONFIG_PATH_DOMAIN_DATA_MANAGER = 'global/security/managers/domains';

	/**
	 * Path to the default domain
	 * 
	 * @var string 
	 */
	const CONFIG_PATH_DEFAULT_DOMAIN = 'global/security/authentication/default_domain';
	
	/**
	 * Domain data manager
	 * 
	 * @var Cream_Security_Domains_Data_Manager_Abstract
	 */
	protected $_dataManager;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Security_Domains_DomainManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Get the domains data manager
	 * 
	 * @throws Cream_Exception_ConfigurationException
	 * @return Cream_Security_Domains_Data_Manager_Abstract
	 */
	protected function _getDataManager()
	{
		if (!$this->_dataManager) {
			$path = self::CONFIG_PATH_DOMAIN_DATA_MANAGER;
			$config = $this->_getApplication()->getConfig()->getNode($path);

			if ($config) {
				$this->_dataManager = Cream_Security_Domains_Data_Manager::factory($config);
			} else {
				throw new Cream_Exceptions_ConfigurationException('Config "'. $path .'" not set.');
			}
		}
		return $this->_dataManager;
	}
	
	/**
	 * Adds a domain name. Returns true when the domain is 
	 * succesfully added, otherwise false. 
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function addDomain($name)
	{
		return $this->_getDataManager()->addDomain($name);
	}
	
	/**
	 * Deletes a domain name. Returns true when the domain is 
	 * succesfully deleted, otherwise returns false.
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function deleteDomain($name)
	{
		return $this->_getDataManager()->deleteDomain($name);
	}
	
	/**
	 * Returns the domain object from the name given. 
	 * 
	 * @param string $name
	 * @return Cream_Security_Domains_Domain
	 */
	public function getDomain($name)
	{
		foreach ($this->getDomains() as $key => $domain) {
			if ($name == $name) {
				return $domain;
			}
		}
	}
	
	/**
	 * Returns the default domain.
	 * 
	 * @return Cream_Security_Domains_Domain
	 */
	public function getDefaultDomain()
	{
		$config = $this->_getApplication()->getConfig()->getNode(self::CONFIG_PATH_DEFAULT_DOMAIN);
		$this->getDomain((string) $config);
	}
	
	/**
	 * Returns an array holding the domains. The array key is the
	 * name of the name, the value is de domain object.
	 *
	 * @return array
	 */
	public function getDomains()
	{
		return $this->_getDataManager()->getDomains();
	}
}