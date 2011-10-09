<?php

class WebTricks_Shell_Web_UI_ExtControls_Tree_Column extends Cream_Web_UI_ExtControls_List_Column
{
	/**
	 * Create a new instance of this class.
	 *
	 * @return WebTricks_Shell_Web_UI_ExtControls_Tree_TreeGridPanel
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function.
	 * 
	 */
	public function __init()
	{
		$this->setControl('Ext.tree.Column');
	}
}