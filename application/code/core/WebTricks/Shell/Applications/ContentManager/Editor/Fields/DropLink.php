<?php

class WebTricks_Shell_Applications_ContentManager_Editor_Fields_DropLink extends WebTricks_Shell_Applications_ContentManager_Editor_Fields_Abstract
{
	protected function _getExtControl()
	{
		$control = Cream_Web_UI_ExtControls_Form_ComboBox::instance();
		$control->setStore($this->_getStore());
		$control->setDisplayField('name');
		$control->setValueField('value');
		$control->setMode('local');
		$control->setTriggerAction('all');
		$control->setValue($this->_getFieldValue());
				
		return $control;
	}

	protected function _getStore()
	{
		$data = array();
		$item = $this->_item->getRepository()->getItemByPath($this->_field->getSource());
		
		if ($item) {
			foreach($item->getChildren() as $child) {
				$data[] = array('value' => (string) $child->getItemId(), 'name' => (string) $child->getName());
			} 
		}
		
		$store = Cream_Web_UI_ExtControls_Data_JsonStore::instance();
		$store->setData($data);
		$store->associate('fields', array('name', 'value'));
		
		return $store;
	}
}