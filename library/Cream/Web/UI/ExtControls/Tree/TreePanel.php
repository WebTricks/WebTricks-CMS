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
 * The TreePanel provides tree-structured UI representation of tree-structured 
 * data.
 * 
 * TreeNodes added to the TreePanel may each contain metadata used by your 
 * application in their attributes property.
 * 
 * A TreePanel must have a root node before it is rendered. This may either be 
 * specified using the root config option, or using the setRootNode method. 
 * 
 * @package 	Cream_Web_UI_ExtControls_Tree
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Tree_TreePanel extends Cream_Web_UI_ExtControls_Panel 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Tree_TreeNodeUI
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
		$this->setControl('Ext.tree.TreePanel');
		$this->setXtype('treepanel');
	}

	/**
	 * The root node for the tree.
	 *
	 * @param Cream_Web_UI_ExtControls_Tree_TreeNode $root
	 */
	public function setRoot(Cream_Web_UI_ExtControls_Tree_TreeNode $root)
	{
		$this->setAttribute('root', $root);
	}

	/**
	 * false to hide the root node (defaults to true)
	 *
	 * @param boolean $rootVisible
	 */
	public function setRootVisible($rootVisible)
	{
		$this->setAttribute('rootVisible', $rootVisible);
	}

	/**
	 * false to disable tree lines (defaults to true)
	 *
	 * @param boolean $lines
	 */
	public function setLines($lines)
	{
		$this->setAttribute('lines', $lines);
	}

	/**
	 * true to enable drag and drop
	 *
	 * @param boolean $enableDD
	 */
	public function setEnableDD($enableDD)
	{
		$this->setAttribute('enableDD', $enableDD);
	}

	/**
	 * true to enable just drag
	 *
	 * @param boolean $enableDrag
	 */
	public function setEnableDrag($enableDrag)
	{
		$this->setAttribute('enableDrag', $enableDrag);
	}

	/**
	 * true to enable just drop
	 *
	 * @param boolean $enableDrop
	 */
	public function setEnableDrop($enableDrop)
	{
		$this->setAttribute('enableDrop', $enableDrop);
	}
	
	/**
	 * The URL for the loader to user to fetch data from.
	 *
	 * @param string $dataUrl
	 */
	public function setDataUrl($dataUrl)
	{
		$this->setAttribute('dataUrl', $dataUrl);
	}
	

	/**
	 * Custom config to pass to the Ext.tree.TreeDragZone instance
	 *
	 * @param object $dragConfig
	 */
	public function setDragConfig($dragConfig)
	{
		$this->setAttribute('dragConfig', $dragConfig);
	}
	
	/**
	 * Custom config to pass to the Ext.tree.TreeDropZone instance
	 *
	 * @param object $dropConfig
	 */
	public function setDropConfig($dropConfig)
	{
		$this->setAttribute('dropConfig', $dropConfig);
	}	

	/**
	 * The DD group this TreePanel belongs to
	 *
	 * @param string $ddGroup
	 */
	public function setDdGroup($ddGroup)
	{
		$this->setAttribute('ddGroup', $ddGroup);
	}

	/**
	 * True if the tree should only allow append drops (use for trees which are sorted)
	 *
	 * @param string $ddAppendOnly
	 */
	public function setDdAppendOnly($ddAppendOnly)
	{
		$this->setAttribute('ddAppendOnly', $ddAppendOnly);
	}

	/**
	 * true to enable body scrolling
	 *
	 * @param boolean $ddScroll
	 */
	public function setDdScroll($ddScroll)
	{
		$this->setAttribute('ddScroll', $ddScroll);
	}

	/**
	 * true to register this container with ScrollManager
	 *
	 * @param boolean $containerScroll
	 */
	public function setContainerScroll($containerScroll)
	{
		$this->setAttribute('containerScroll', $containerScroll);
	}

	/**
	 * false to disable node highlight on drop (defaults to the value of Ext.enableFx)
	 *
	 * @param boolean $hlDrop
	 */
	public function setHlDrop($hlDrop)
	{
		$this->setAttribute('hlDrop', $hlDrop);
	}

	/**
	 * The color of the node highlight (defaults to C3DAF9)
	 *
	 * @param string $hlColor
	 */
	public function setHlColor($hlColor)
	{
		$this->setAttribute('hlColor', $hlColor);
	}

	/**
	 * true to enable animated expand/collapse (defaults to the value of 
	 * Ext.enableFx)
	 *
	 * @param boolean $animate
	 */
	public function setAnimate($animate)
	{
		$this->setAttribute('animate', $animate);
	}
	
	/**
	 * An array of events that, when fired, should be bubbled to any parent 
	 * container. See Ext.util.Observable.enableBubble. Defaults to [].
	 *
	 * @param array $bubbleEvents
	 */
	public function setBubbleEvents($bubbleEvents)
	{
		$this->setAttribute('bubbleEvents', $bubbleEvents);
	}	

	/**
	 * true if only 1 node per branch may be expanded
	 *
	 * @param boolean $singleExpand
	 */
	public function setSingleExpand($singleExpand)
	{
		$this->setAttribute('singleExpand', $singleExpand);
	}

	/**
	 * A tree selection model to use with this TreePanel (defaults to a 
	 * Ext.tree.DefaultSelectionModel)
	 *
	 * @param boolean $selModel
	 */
	public function setSelModel($selModel)
	{
		$this->setAttribute('selModel', $selModel);
	}

	/**
	 * A Ext.tree.TreeLoader for use with this TreePanel
	 *
	 * @param Cream_Web_UI_ExtControls_Tree_TreeLoader $loader
	 */
	public function setLoader(Cream_Web_UI_ExtControls_Tree_TreeLoader $loader)
	{
		$this->setAttribute('loader', $loader);
	}

	/**
	 * The token used to separate sub-paths in path strings (defaults to '/')
	 *
	 * @param string $pathSeparator
	 */
	public function setPathSeparator($pathSeparator)
	{
		$this->setAttribute('pathSeparator', $pathSeparator);
	}
	
	/**
	 * false to disable mouse over highlighting
	 * 
	 * @param boolean $trackMouseOver
	 */
	public function setTrackMouseOver($trackMouseOver)
	{
		$this->setAttribute('trackMouseOver', $trackMouseOver);
	}

	/**
	 * True to use Vista-style arrows in the tree (defaults to false)
	 * 
	 * @param boolean $useArrows
	 */
	public function setUseArrows($useArrows)
	{
		$this->setAttribute('useArrows', $useArrows);
	}	
}