<?php

class WebTricks_Shell_Applications_ContentManager_Editor_Fields_GroupedDropList extends WebTricks_Shell_Applications_ContentManager_Editor_Fields_Abstract
{
	protected function _getExtControl()
	{
		$control = WebTricks_Shell_Web_UI_ExtControls_Form_GroupedComboBox::instance();	
		$control->setStore($this->_getStore());
		$control->setDisplayField('name');
		$control->setValueField('value');
		$control->setGroupField('group');
		$control->setMode('local');
		$control->setTriggerAction('all');
		
		return $control;
	}

	protected function _getStore()
	{
		$data = array();
		$item = $this->_item->getRepository()->getItemByPath($this->_field->getSource());
		
		if ($item) {
			foreach($item->getChildren() as $child) {
				foreach($child->getChildren() as $childChild)
				$data[] = array('value' => (string) $childChild->getItemId(), 'name' => (string) $childChild->getName(), 'group' => (string) $child->getName());
			} 
		}
		
		$store = Cream_Web_UI_ExtControls_Data_JsonStore::instance();
		$store->setData($data);
		$store->associate('fields', array('name', 'value', 'group'));
		
		return $store;
	}
}