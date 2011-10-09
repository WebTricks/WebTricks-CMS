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
 * Represents a tree data structure and bubbles all the events for its nodes. 
 * The nodes in the tree have most standard DOM functionality.
 * 
 * @package 	Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_Tree extends Cream_Web_UI_ExtControls_Util_Observable
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_Tree
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function
	 * 
	 * @return void
	 */
	public function __init()
	{
		$this->setControl('Ext.data.Tree');
	}
	
	/**
	 * The token used to separate paths in node ids (defaults to '/').
	 *
	 * @param string $pathSeparator
	 */
	public function setPathSeparator($pathSeparator)
	{
		$this->setAttribute('pathSeparator', $pathSeparator);
	}
} 