<?php

class WebTricks_Shell_Web_UI_ExtControls_ContentManager_Fields_FieldContainer extends Cream_Web_UI_ExtControls_Panel
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Web_UI_ExtControls_ContentManager_Fields_FieldContainer
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
		$this->setControl('WebTricks.Shell.Applications.ContentManager.Fields.FieldContainer');
		$this->setBodyBorder(false);
		$this->setBorder(false);
		$this->setCls('x-fieldcontainer');
		$this->setPadding(5);
	}
}