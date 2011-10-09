<?php

class Cream_Content_Serialization_SyncField extends Cream_ApplicationComponent
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Content_Serialization_SyncField
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function setFieldId($fieldId)
	{
		$this->_setData('fieldId', $fieldId);
	}
	
	public function getFieldId()
	{
		return $this->_getData('fieldId');
	}
	
	public function setFieldKey($fieldKey)
	{
		$this->_setData('fieldKey', $fieldKey);
	}
	
	public function getFieldKey()
	{
		return $this->_getData('fieldKey');
	}
	
	public function setFieldName($fieldName)
	{
		$this->_setData('fieldName', $fieldName);
	}
	
	public function getFieldName()
	{
		return $this->_getData('fieldName');
	}
	
	public function setFieldValue($fieldValue)
	{
		$this->_setData('fieldValue', $fieldValue);
	}
	
	public function getFieldValue()
	{
		return $this->_getData('fieldValue');
	}
}