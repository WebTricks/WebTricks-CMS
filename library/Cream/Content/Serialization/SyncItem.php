<?php

class Cream_Content_Serialization_SyncItem extends Cream_ApplicationComponent
{
	protected $_sharedFields = array();
	
	protected $_versions = array();
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Content_Serialization_SyncItem
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function setBranchId($branchId)
	{
		$this->_setData('branchId', $branchId);
	}
	
	public function getBranchId()
	{
		return $this->_getData('branchId');
	}	
	
	public function setRepositoryName($repositoryName)
	{
		$this->_setData('repositoryName', $repositoryName);
	}
	
	public function getRepositoryName()
	{
		return $this->_getData('repositoryName');
	}

	public function setId($id)
	{
		$this->_setData('id', $id);
	}
	
	public function getId()
	{
		return $this->_getData('id');
	}

	public function setItemPath($itemPath)
	{
		$this->_setData('itemPath', $itemPath);
	}
	
	public function getItemPath()
	{
		return $this->_getData('itemPath');
	}	
	
	public function setName($name)
	{
		$this->_setData('name', $name);
	}
	
	public function getName()
	{
		return $this->_getData('name');
	}	
	
	public function setParentId($parentId)
	{
		$this->_setData('parentId', $parentId);
	}
	
	public function getParentId()
	{
		return $this->_getData('parentId');
	}	
	
	public function setTemplateId($templateId)
	{
		$this->_setData('templateId', $templateId);
	}
	
	public function getTemplateId()
	{
		return $this->_getData('templateId');
	}	

	/**
	 * Adds a sync field to the shared fields of the sync item.
	 *  
	 * @param Cream_Content_Serialization_SyncField $sharedField
	 */
	public function addSharedField(Cream_Content_Serialization_SyncField $sharedField)
	{
		$this->_sharedFields[] = $sharedField;
	}
	
	public function removeSharedField()
	{
		
	}
	
	public function getSharedFields()
	{
		return $this->_sharedFields;
	}
	
	/**
	 * Add a sync version to the sync item.
	 * 
	 * @param Cream_Content_Serialization_SyncVersion $version
	 */
	public function addVersion(Cream_Content_Serialization_SyncVersion $version)
	{
		$this->_versions[] = $version;
	}
	
	public function removeVersion($language, $version)
	{
		
	}
	
	public function removeVersions($language)
	{
		
	}
	
	public function getVersions()
	{
		return $this->_versions;
	}
}