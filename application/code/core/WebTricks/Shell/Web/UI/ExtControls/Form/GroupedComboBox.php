<?php

class WebTricks_Shell_Web_UI_ExtControls_Form_GroupedComboBox extends Cream_Web_UI_ExtControls_Form_ComboBox
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return WebTricks_Shell_Web_UI_ExtControls_Form_GroupedComboBox
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function
	 * 
	 * @return void
	 */
	public function __init()
	{
		$this->setControl('WebTricks.Shell.Controls.Form.GroupedComboBox');
	}
	
	/**
	 * Set the field name to group the items by.
	 * 
	 * @return void
	 */
	public function setGroupField($groupField)
	{
		$this->setAttribute('groupField', $groupField);
	}	
}