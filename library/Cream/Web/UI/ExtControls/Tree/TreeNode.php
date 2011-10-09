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
 * A node of the tree.
 * 
 * @package 	Cream_Web_UI_ExtControls_Tree
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Tree_TreeNode extends Cream_Web_UI_ExtControls_Data_Node 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Tree_TreeNode
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * The text for this node
	 *
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->setAttribute('text', $text);
	}

	/**
	 * true to start the node expanded
	 *
	 * @param boolean $expanded
	 */
	public function setExpanded($expanded)
	{
		$this->setAttribute('expanded', $expanded);
	}
	
	/**
	 * True to render hidden. (Defaults to false).
	 *
	 * @param boolean $hidden
	 */
	public function setHidden($hidden)
	{
		$this->setAttribute('hidden', $hidden);
	}	

	/**
	 * False to make this node undraggable if #draggable = true (defaults to true)
	 *
	 * @param boolean $allowDrag
	 */
	public function setAllowDrag($allowDrag)
	{
		$this->setAttribute('allowDrag', $allowDrag);
	}

	/**
	 * False if this node cannot have child nodes dropped on it (defaults to true)
	 *
	 * @param boolean $allowDrop
	 */
	public function setAllowDrop($allowDrop)
	{
		$this->setAttribute('allowDrop', $allowDrop);
	}

	/**
	 * true to start the node disabled
	 *
	 * @param boolean $disabled
	 */
	public function setDisabled($disabled)
	{
		$this->setAttribute('disabled', $disabled);
	}

	/**
	 * The path to an icon for the node. The preferred way to do this
	 *
	 * @param string $icon
	 */
	public function setIcon($icon)
	{
		$this->setAttribute('icon', $icon);
	}

	/**
	 * A css class to be added to the node
	 *
	 * @param string $cls
	 */
	public function setCls($cls)
	{
		$this->setAttribute('cls', $cls);
	}

	/**
	 * A css class to be added to the nodes icon element for applying css background images
	 *
	 * @param string $iconCls
	 */
	public function setIconCls($iconCls)
	{
		$this->setAttribute('iconCls', $iconCls);
	}

	/**
	 * URL of the link used for the node (defaults to #)
	 *
	 * @param string $href
	 */
	public function setHref($href)
	{
		$this->setAttribute('href', $href);
	}

	/**
	 * target frame for the link
	 *
	 * @param string $hrefTarget
	 */
	public function setHrefTarget($hrefTarget)
	{
		$this->setAttribute('hrefTarget', $hrefTarget);
	}

	/**
	 * An Ext QuickTip for the node
	 *
	 * @param string $qtip
	 */
	public function setQtip($qtip)
	{
		$this->setAttribute('qtip', $qtip);
	}

	/**
	 * If set to true, the node will always show a plus/minus icon, even when empty
	 *
	 * @param boolean $expandable
	 */
	public function setExpandable($expandable)
	{
		$this->setAttribute('expandable', $expandable);
	}

	/**
	 * An Ext QuickTip config for the node (used instead of qtip)
	 *
	 * @param string $qtipCfg
	 */
	public function setQtipCfg($qtipCfg)
	{
		$this->setAttribute('qtipCfg', $qtipCfg);
	}

	/**
	 * True for single click expand on this node
	 *
	 * @param boolean $singleClickExpand
	 */
	public function setSingleClickExpand($singleClickExpand)
	{
		$this->setAttribute('singleClickExpand', $singleClickExpand);
	}

	/**
	 * A UI <b>class</b> to use for this node (defaults to Ext.tree.TreeNodeUI)
	 *
	 * @param function $uiProvider
	 */
	public function setUiProvider($uiProvider)
	{
		$this->setAttribute('uiProvider', $uiProvider);
	}

	/**
	 * True to render a checked checkbox for this node, false to render an unchecked checkbox
	 *
	 * @param boolean $checked
	 */
	public function setChecked($checked)
	{
		$this->setAttribute('checked', $checked);
	}

	/**
	 * True to make this node draggable (defaults to false)
	 *
	 * @param boolean $draggable
	 */
	public function setDraggable($draggable)
	{
		$this->setAttribute('draggable', $draggable);
	}
	
	/**
	 * False to not allow this node to be edited by an Ext.tree.TreeEditor 
	 * (defaults to true)
	 *
	 * @param boolean $editable
	 */
	public function setEditable($editable)
	{
		$this->setAttribute('editable', $editable);
	}	

	/**
	 * False to not allow this node to act as a drop target (defaults to true)
	 *
	 * @param boolean $isTarget
	 */
	public function setIsTarget($isTarget)
	{
		$this->setAttribute('isTarget', $isTarget);
	}

	/**
	 * False to not allow this node to have child nodes (defaults to true)
	 *
	 * @param boolean $allowChildren
	 */
	public function setAllowChildren($allowChildren)
	{
		$this->setAttribute('allowChildren', $allowChildren);
	}
}