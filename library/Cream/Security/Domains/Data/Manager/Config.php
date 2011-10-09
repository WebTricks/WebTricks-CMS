<?php

class Cream_Security_Domains_Data_Manager_Config extends Cream_Security_Domains_Data_Manager_Abstract
{
	/**
	 * Array holding domain objects.
	 *  
	 * @var array
	 */
	protected $_domains;
	
	/**
	 * Path to the root folder in the repository to look for domain
	 * items.
	 *  
	 * @var string
	 */
	protected $_path;
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Config_Xml_Element $config
	 */
	public function __init(Cream_Config_Xml_Element $config)
	{	
		$this->_path = (string) $config->path;
	}
	
	/**
	 * Adds a domain
	 * 
	 * @param string $name
	 */	
	public function addDomain($name)
	{
		throw new Cream_Exceptions_NotImplementedExcpetion('Repository manager does not support adding domains.');
	}
	
	/**
	 * Deletes a domain
	 * 
	 * @param string $name
	 */	
	public function deleteDomain($name)
	{
		throw new Cream_Exceptions_NotImplementedExcpetion('Repository manager does not support deleting domains.');
	}
	
	/**
	 * Returns an array of all domains. Array key is the name of the
	 * domain, array value is the domain object.
	 * 
	 * @return array 
	 */	
	public function getDomains()
	{		
		if (!$this->_domains) {
			$node = $this->getApplication()->getConfig()->getNode($this->_path);
			
			foreach ($node->children() as $child) {
				$domain = $this->_buildDomain($child);
				$this->_domains[$domain->getName()] = $domain;
			}			
		}
		
		return $this->_domains;
	}
		
	/**
	 * Builds a domain object from a content item.
	 * 
	 * @param Cream_Config_Xml_Element $config
	 * @return Cream_Security_Domains_Domain
	 */
	protected function _buildDomain(Cream_Config_Xml_Element $config) 
	{
		$name = (string) $config->name;
		$description = (string) $config->description;
		$domain = Cream_Security_Domains_Domain::instance($name, $description);
		return $domain;
	}
}