<?php

class WebTricks_Shell_Web_UI_ExtControls_Tree_TreeGridPanel extends Cream_Web_UI_ExtControls_Tree_TreePanel
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
		$this->setControl('Ext.ux.tree.TreeGrid');
	}

	/**
	 * Sets if the columns of the tree grid can be resized. Default to
	 * true.
	 * 
	 * @param boolean $columnResize
	 */
	public function setColumnResize($columnResize)
	{
		$this->setAttribute('columnResize', $columnResize);
	}
	
	/**
	 * Sets if the columns can be sorted, default is true.
	 * 
	 * @param boolean $enableSort
	 */
	public function setEnableSort($enableSort)
	{
		$this->setAttribute('enableSort', $enableSort);
	}

	/**
	 * Sets the tree grid columns.
	 * 
	 * @param array $columns
	 */
	public function setColumns($columns)
	{
		$this->setAttribute('columns', $columns);
	}
}