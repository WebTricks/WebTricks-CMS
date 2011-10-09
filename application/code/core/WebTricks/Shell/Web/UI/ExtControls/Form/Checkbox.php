<?php

class WebTricks_Shell_Web_UI_ExtControls_Form_Checkbox extends Cream_Web_UI_ExtControls_Form_Checkbox
{
	/**
	 * Create a new instance of this class
	 *
	 * @return WebTricks_Shell_Web_UI_ExtControls_Form_CheckboxField
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

	public function setValue($value)
	{
		$this->setChecked($value);
	}
}