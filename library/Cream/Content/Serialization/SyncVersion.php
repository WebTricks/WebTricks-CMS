<?php

class Cream_Content_Serialization_SyncVersion extends Cream_ApplicationComponent
{
	/**
	 * Array holding the version fields
	 * 
	 * @var array
	 */
	protected $_fields = array();
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Content_Serialization_SyncVersion
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function setCulture($culture)
	{
		$this->_setData('culture', $culture);
	}
	
	public function getCulture()
	{
		return $this->_getData('culture');
	}	
	
	public function setRevision($revision)
	{
		$this->_setData('revision', $revision);
	}
	
	public function getRevision()
	{
		return $this->_getData('revision');
	}		
	
	public function setVersion($version)
	{
		$this->_setData('version', $version);
	}
	
	public function getVersion()
	{
		return $this->_getData('version');
	}		
	
	public function addField(Cream_Content_Serialization_SyncField $field)
	{
		$this->_fields[] = $field;
	}
	
	public function removeField()
	{
		
	}
	
	public function getFields()
	{
		return $this->_fields;
	}
}