<?php

class WebTricks_Shell_Web_UI_ExtControls_Form_PasswordField extends Cream_Web_UI_ExtControls_Form_TextField
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_DateTimeField
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function
	 *
	 */	
	public function __init()
	{
		$this->setInputType('password');
		parent::__init();
	}
}