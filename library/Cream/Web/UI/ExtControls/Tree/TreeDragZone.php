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
 * Tree drag zone
 * 
 * @package		Cream_Web_UI_ExtControls_Tree
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Tree_TreeDragZone extends Cream_Web_UI_ExtControls_DD_DragZone
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Tree_TreeDragZone
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
}