<?php

class Cream_Security_Domains_Data_Manager_Repository extends Cream_Security_Domains_Data_Manager_Abstract
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
	 * Repository object
	 * 
	 * @var Cream_Content_Repository
	 */
	protected $_repository;
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Config_Xml_Element $config
	 */
	public function __init(Cream_Config_Xml_Element $config)
	{	
		$repositoryName = (string) $config->repository;
		$repository = Cream_Content_Managers_RepositoryProvider::getRepository($repositoryName);
		
		$this->_repository = $repository;
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
			$itemId = $this->_repository->getDataManager()->resolvePath($this->_path);
			$item = $this->_repository->getItem($itemId);
			$this->_addDomains($item);			
		}
		
		return $this->_domains;
	}
	
	/**
	 * Sets the domain items based on the content tree.
	 * 
	 * @param Cream_Content_Item $item
	 */
	protected function _addDomains(Cream_Content_Item $item)
	{
		if ($item->getTemplateId() == Cream_Application_TemplateIds::getDomainId()) {
			$domain = $this->_buildDomain($item);
			$this->_domains[$domain->getName()] = $domain;
		}
		
		foreach ($item->getChildren() as $childItem) {
			$this->_addDomains($childItem);
		}
	}
	
	/**
	 * Builds a domain object from a content item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Security_Domains_Domain
	 */
	protected function _buildDomain(Cream_Content_Item $item) 
	{
		$name = $item->getName();
		$domain = Cream_Security_Domains_Domain::instance($name);
		
		return $domain;
	}
}