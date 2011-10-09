<?php

class WebTricks_Shell_Web_UI_ExtControls_Form_GroupedLookup extends WebTricks_Shell_Web_UI_ExtControls_Form_GroupedValueLookup
{
	public function render() 
	{
		$this->setStore($this->_getStore());
		$this->setDisplayField('name');
		$this->setValueField('value');
		$this->setMode('local');
		$this->setTriggerAction('all');
		
		return parent::render();
	}	
}