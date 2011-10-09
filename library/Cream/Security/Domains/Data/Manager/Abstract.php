<?php

abstract class Cream_Security_Domains_Data_Manager_Abstract extends Cream_ApplicationComponent
{
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Config_Xml_Element $config
	 * @return Cream_Security_Domains_Data_Manager_Abstract
	 */
	public static function instance(Cream_Config_Xml_Element $config)
	{
		return Cream::instance(__CLASS__, $config);
	}
	
	/**
	 * Adds a domain
	 * 
	 * @param string $name
	 */
	abstract function addDomain($name);
	
	/**
	 * Deletes a domain
	 * 
	 * @param string $name
	 */
	abstract function deleteDomain($name);
	
	/**
	 * Returns an array of all domains. Array key is the name of the
	 * domain, array value is the domain object.
	 * 
	 * @return array 
	 */
	abstract function getDomains();
}