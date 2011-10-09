<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in
 * the future. If you wish to customize WebTricks for your needs please go to 
 * http://www.webtricksframework.com for more information.
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Tree drop zone
 * 
 * @package		Cream_Web_UI_ExtControls_Tree
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Tree_TreeDropZone extends Cream_Web_UI_ExtControls_DD_DropZone
{	
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Tree_TreeDropZone
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
		$this->setControl('Ext.tree.TreeDragZone');
	}		
	
	/**
	 * Allow inserting a dragged node between an expanded parent node and its 
	 * first child that will become a sibling of the parent when dropped 
	 * (defaults to false)
	 *
	 * @param boolean $allowParentInsert
	 */
	public function setAllowParentInsert($allowParentInsert)
	{
		$this->setAttribute('allowParentInsert', $allowParentInsert);
	}

	/**
	 * True if drops on the tree container (outside of a specific tree node) 
	 * are allowed (defaults to false).
	 *
	 * @param string $allowContainerDrop
	 */
	public function setAllowContainerDrop($allowContainerDrop)
	{
		$this->setAttribute('allowContainerDrop', $allowContainerDrop);
	}

	/**
	 * True if the tree should only allow append drops (use for trees which are 
	 * sorted, defaults to false)
	 *
	 * @param string $appendOnly
	 */
	public function setAppendOnly($appendOnly)
	{
		$this->setAttribute('appendOnly', $appendOnly);
	}

	/**
	 * A named drag drop group to which this object belongs. If a group is 
	 * specified, then this object will only interact with other drag drop 
	 * objects in the same group (defaults to 'TreeDD').
	 *
	 * @param string $ddGroup
	 */
	public function setDdGroup($ddGroup)
	{
		$this->setAttribute('ddGroup', $ddGroup);
	}

	/**
	 * The delay in milliseconds to wait before expanding a target tree node 
	 * while dragging a droppable node over the target (defaults to 1000)
	 *
	 * @param string $expandDelay
	 */
	public function setExpandDelay($expandDelay)
	{
		$this->setAttribute('expandDelay', $expandDelay);
	}
}