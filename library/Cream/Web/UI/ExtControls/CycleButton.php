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
 * A specialized SplitButton that contains a menu of Ext.menu.CheckItem 
 * elements. The button automatically cycles through each menu item on click,
 * raising the button's change event (or calling the button's changeHandler 
 * function, if supplied) for the active menu item. Clicking on the arrow 
 * section of the button displays the dropdown menu just like a normal 
 * SplitButton.
 *
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_CycleButton extends Cream_Web_UI_ExtControls_SplitButton 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_CycleButton
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
		
	/**
	 * Initialize function, set the Ext JS control
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.CycleButton');
		$this->setXtype('cyclebutton');
	}
		
	/**
	 * An array of Ext.menu.CheckItem config objects to be used when creating 
	 * the button's menu items (e.g., {text:'Foo', iconCls:'foo-icon'})
	 *
	 * @param array $items
	 */
	public function setItems($items) 
	{
		$this->setAttribute('items', $items);
	}

	/**
	 * True to display the active item's text as the button text (defaults to 
	 * false)
	 *
	 * @param boolean $showText
	 */
	public function setShowText($showText) 
	{
		$this->setAttribute('showText', $showText);
	}

	/**
	 * A static string to prepend before the active item's text when displayed 
	 * as the button's text (only applies when showText = true, defaults to '')
	 *
	 * @param string $prependText
	 */
	public function setPrependText($prependText) 
	{
		$this->setAttribute('prependText', $prependText);
	}

	/**
	 * A callback function that will be invoked each time the active menu item 
	 * in the button's menu has changed. If this callback is not supplied, the 
	 * SplitButton will instead fire the change event on active item change. 
	 * The changeHandler function will be called with the following argument 
	 * list: (SplitButton this, Ext.menu.CheckItem item)
	 *
	 * @param function $changeHandler
	 */
	public function setChangeHandler($changeHandler) 
	{
		$this->setAttribute('changeHandler', $changeHandler);
	}
	
	/**
	 * A css class which sets an image to be used as the static icon for this 
	 * button. This icon will always be displayed regardless of which item is 
	 * selected in the dropdown list. This overrides the default behavior of 
	 * changing the button's icon to match the selected item's icon on change.
	 *
	 * @param string $forceIcon
	 */
	public function setForceIcon($forceIcon) 
	{
		$this->setAttribute('forceIcon', $forceIcon);
	}	
}