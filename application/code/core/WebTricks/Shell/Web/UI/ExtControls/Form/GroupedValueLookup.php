<?php

class WebTricks_Shell_Web_UI_ExtControls_Form_GroupedValueLookup extends Cream_Web_UI_ExtControls_Form_ComboBox
{
	protected $_source = '';
	
	public function setSource($source)
	{
		$this->_source = $source;
	}
	
	public function render() 
	{
		$this->setStore($this->_getStore());
		$this->setDisplayField('name');
		$this->setValueField('name');
		$this->setGroupField('group');
		$this->setMode('local');
		$this->setTriggerAction('all');
		
		return parent::render();
	}
	
	protected function _getStore()
	{
		$data = array();
		$item = $this->_getApplication()->getContext()->getContentRepository()->getItemByPath($this->_source);
		
		if ($item) {
			foreach($item->getChildren() as $group) {
				$data[] = array('group' => (string) $group->getName(), 'value' => '', 'name' => '');
				foreach($group->getChildren() as $child) {
					$data[] = array('group' => '', 'value' => (string) $child->getItemId(), 'name' => (string) $child->getName());
				}
			} 
		}
		
		$store = Cream_Web_UI_ExtControls_Data_JsonStore::instance();
		$store->setData($data);
		$store->associate('fields', array('group', 'name', 'value'));
		
		return $store;
	}
}