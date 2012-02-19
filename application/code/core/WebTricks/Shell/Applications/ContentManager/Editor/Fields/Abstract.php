<?php

abstract class WebTricks_Shell_Applications_ContentManager_Editor_Fields_Abstract
{
	protected $_field;
	
	protected $_item;
	
	public function __init(Cream_Content_Template_Field $field, Cream_Content_Item $item)
	{
		$this->_field = $field;		
		$this->_item = $item;
	}
	
	public function getExtControl()
	{		
		$control = $this->_getExtControl();
		$control->setName('editor_'. $this->_field->getId());
		$control->setWidth('500');
				
		//$control->setAutoWidth(true);
		
		return $control;
	}
	
	abstract protected function _getExtControl();
	
	protected function _getFieldValue()
	{
		$contentField = $this->_item->getFields()->getField($this->_field->getName());
		if ($contentField) {
			return $contentField->getValue();			
		}		
	}
}
