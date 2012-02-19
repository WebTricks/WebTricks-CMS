<?php

class WebTricks_Shell_Web_UI_ExtControls_Form_ComboTree extends Cream_Web_UI_ExtControls_Form_ComboBox
{
	/**
	 * Create a new instance of this class
	 *
	 * @return WebTricks_Shell_Web_UI_ExtControls_Form_ComboTree
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
		$this->setControl('WebTricks.Shell.Controls.Form.ComboTree');
		$this->setAttribute('xtype', 'combotree');
	}	

	/**
	 * Sets the node id.
	 * 
	 * @param string $nodeId
	 */	
	public function setNodeId($nodeId)
	{
		$this->setAttribute('nodeId', $nodeId);		
	}
}