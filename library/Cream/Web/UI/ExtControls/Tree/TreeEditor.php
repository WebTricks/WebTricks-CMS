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
 * Provides editor functionality for inline tree node editing. Any 
 * valid Ext.form.Field can be used as the editor field.
 *
 * @package 	Cream_Web_UI_ExtControls_Tree
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Tree_TreeEditor extends Cream_Web_UI_ExtControls_Editor 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Tree_TreeEditor
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
		$this->setControl('Ext.tree.TreeEditor');
	}	
	
	/**
	 * The position to align to (see Ext.Element.alignTo for more details, 
	 * defaults to "l-l").
	 *
	 * @param string $alignment
	 */
	public function setAlignment($alignment)
	{
		$this->setAttribute('alignment', $alignment);
	}

	/**
	 * True to hide the bound element while the editor is displayed (defaults 
	 * to false)
	 *
	 * @param boolean $hideEl
	 */
	public function setHideEl($hideEl)
	{
		$this->setAttribute('hideEl', $hideEl);
	}

	/**
	 * CSS class to apply to the editor (defaults to "x-small-editor 
	 * x-tree-editor")
	 *
	 * @param string $cls
	 */
	public function setCls($cls)
	{
		$this->setAttribute('cls', $cls);
	}

	/**
	 * True to shim the editor if selects/iframes could be displayed beneath it
	 * (defaults to false)
	 *
	 * @param boolean $shim
	 */
	public function setShim($shim)
	{
		$this->setAttribute('shim', $shim);
	}

	/**
	 * The maximum width in pixels of the editor field (defaults to 250). Note 
	 * that if the maxWidth would exceed the containing tree element's size, it 
	 * will be automatically limited for you to the container width, taking 
	 * scroll and client offsets into account prior to each edit.
	 *
	 * @param number $maxWidth
	 */
	public function setMaxWidth($maxWidth)
	{
		$this->setAttribute('maxWidth', $maxWidth);
	}

	/**
	 * The number of milliseconds between clicks to register a double-click 
	 * that will trigger editing on the current node (defaults to 350). If 
	 * two clicks occur on the same node within this time span, the editor for 
	 * the node will display, otherwise it will be processed as a regular 
	 * click.
	 *
	 * @param number $editDelay
	 */
	public function setEditDelay($editDelay)
	{
		$this->setAttribute('editDelay', $editDelay);
	}
}