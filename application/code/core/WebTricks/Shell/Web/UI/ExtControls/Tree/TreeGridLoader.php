<?php

class WebTricks_Shell_Web_UI_ExtControls_TreeGridLoader extends Cream_Web_UI_ExtControls_Tree_TreeLoader
{
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
		$this->setControl('Ext.ux.tree.TreeGridLoader');
	}	
}