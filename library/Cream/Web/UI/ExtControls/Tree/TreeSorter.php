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
 * Provides sorting of nodes in a Ext.tree.TreePanel. The TreeSorter 
 * automatically monitors events on the associated TreePanel that might affect
 * the tree's sort order (beforechildrenrendered, append, insert and 
 * textchange). 
 * 
 * @package		Cream_Web_UI_ExtControls_Tree
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Tree_TreeSorter 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Tree_TreeSorter
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
	
	/**
	 * True to sort leaf nodes under non leaf nodes
	 *
	 * @param boolean $folderSort
	 */
	public function setFolderSort($folderSort)
	{
		$this->setAttribute('folderSort', $folderSort);
	}

	/**
	 * The named attribute on the node to sort by (defaults to text)
	 *
	 * @param string $property
	 */
	public function setProperty($property)
	{
		$this->setAttribute('property', $property);
	}

	/**
	 * The direction to sort (asc or desc) (defaults to asc)
	 *
	 * @param string $dir
	 */
	public function setDir($dir)
	{
		$this->setAttribute('dir', $dir);
	}

	/**
	 * The attribute used to determine leaf nodes in folder sort (defaults to "leaf")
	 *
	 * @param string $leafAttr
	 */
	public function setLeafAttr($leafAttr)
	{
		$this->setAttribute('leafAttr', $leafAttr);
	}

	/**
	 * true for case sensitive sort (defaults to false)
	 *
	 * @param boolean $caseSensitive
	 */
	public function setCaseSensitive($caseSensitive)
	{
		$this->setAttribute('caseSensitive', $caseSensitive);
	}

	/**
	 * A custom "casting" function used to convert node values before sorting. 
	 * The function will be called with a single parameter (the 
	 * Ext.tree.TreeNode being evaluated) and is expected to return the node's 
	 * sort value cast to the specific data type required for sorting. This 
	 * could be used, for example, when a node's text (or other attribute) 
	 * should be sorted as a date or numeric value. See the class description 
	 * for example usage. Note that if a sortType is specified, any property 
	 * config will be ignored.
	 *
	 * @param function $sortType
	 */
	public function setSortType($sortType)
	{
		$this->setAttribute('sortType', $sortType);
	}
}