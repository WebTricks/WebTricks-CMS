<?php

class WebTricks_Shell_Web_UI_ExtControls_Form_GroupedComboBox extends Cream_Web_UI_ExtControls_Form_ComboBox
{
	public function __init()
	{
		$this->setControl('Ext.form.GroupComboBox');
	}
	
	public function setGroupField($groupField)
	{
		$this->setAttribute('groupField', $groupField);
	}
}