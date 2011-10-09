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
 * Simple Button class
 *
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Button extends Cream_Web_UI_ExtControls_BoxComponent
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Button
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
		$this->setControl('Ext.Button');
		$this->setXtype('button');
	}

	/**
	 * The button text
	 *
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->setAttribute('text', $text);
	}

	/**
	 * The path to an image to display in the button (the image will 
	 * be set as the background-image CSS property of the button by 
	 * default, so if you want a mixed icon/text button, set 
	 * cls:"x-btn-text-icon")
	 *
	 * @param string $icon
	 */
	public function setIcon($icon)
	{
		$this->setAttribute('icon', $icon);
	}

	/**
	 * A function called when the button is clicked (can be used 
	 * instead of click event)
	 *
	 * @param function $handler
	 */
	public function setHandler($handler)
	{
		$this->setAttribute('handler', $handler);
	}

	/**
	 * The scope of the handler
	 *
	 * @param object $scope
	 */
	public function setScope($scope)
	{
		$this->setAttribute('scope', $scope);
	}

	/**
	 * The minimum width for this button (used to give a set of 
	 * buttons a common width)
	 *
	 * @param number $minWidth
	 */
	public function setMinWidth($minWidth)
	{
		$this->setAttribute('minWidth', $minWidth);
	}
	
	/**
	 * If used in a Toolbar, the text to be used if this item is shown in the
	 * overflow menu. See also Ext.Toolbar.Item.overflowText.
	 * 
	 * @param string $overflowText
	 */
	public function setOverflowText($overflowText)
	{
		$this->setAttribute('overflowText', $overflowText);
	}	

	/**
	 * The tooltip for the button - can be a string or QuickTips 
	 * config object
	 *
	 * @param string/object $tooltip
	 */
	public function setTooltip($tooltip)
	{
		$this->setAttribute('tooltip', $tooltip);
	}

	/**
	 * True to start disabled (defaults to false)
	 *
	 * @param boolean $disabled
	 */
	public function setDisabled($disabled)
	{
		$this->setAttribute('disabled', $disabled);
	}

	/**
	 * True to start pressed (only if enableToggle = true)
	 *
	 * @param boolean $pressed
	 */
	public function setPressed($pressed)
	{
		$this->setAttribute('pressed', $pressed);
	}

	/**
	 * The group this toggle button is a member of (only 1 per group can be pressed,
	 * only applies if enableToggle = true)
	 *
	 * @param string $toggleGroup
	 */
	public function setToggleGroup($toggleGroup)
	{
		$this->setAttribute('toggleGroup', $toggleGroup);
	}

	/**
	 * True to repeat fire the click event while the mouse is down. This can also be an
	 * Ext.util.ClickRepeater config object (defaults to false).
	 *
	 * @param boolean/object $repeat
	 */
	public function setRepeat($repeat)
	{
		$this->setAttribute('repeat', $repeat);
	}

	/**
	 * Set a DOM tabIndex for this button (defaults to undefined)
	 *
	 * @param number $tabIndex
	 */
	public function setTabIndex($tabIndex)
	{
		$this->setAttribute('tabIndex', $tabIndex);
	}

	/**
	 * True to enable pressed/not pressed toggling (defaults to false)
	 *
	 * @param boolean $enableToggle
	 */
	public function setEnableToggle($enableToggle)
	{
		$this->setAttribute('enableToggle', $enableToggle);
	}

	/**
	 * Standard menu attribute consisting of a reference to a menu object, a menu id or a menu
	 * config blob (defaults to undefined).
	 *
	 * @param mixed $menu
	 */
	public function setMenu($menu)
	{
		$this->setAttribute('menu', $menu);
	}

	/**
	 * The position to align the menu to (see Ext.Element.alignTo for more details, defaults to 'tl-bl?').
	 *
	 * @param string $menuAlign
	 */
	public function setMenuAlign($menuAlign)
	{
		$this->setAttribute('menuAlign', $menuAlign);
	}

	/**
	 * A css class which sets a background image to be used as the icon for this button
	 *
	 * @param string $iconCls
	 */
	public function setIconCls($iconCls)
	{
		$this->setAttribute('iconCls', $iconCls);
	}

	/**
	 * submit, reset or button - defaults to 'button'
	 *
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->setAttribute('type', $type);
	}

	/**
	 * The type of event to map to the button's event handler (defaults to 'click')
	 *
	 * @param string $clickEvent
	 */
	public function setClickEvent($clickEvent)
	{
		$this->setAttribute('clickEvent', $clickEvent);
	}

	/**
	 * False to disable visual cues on mouseover, mouseout and mousedown 
	 * (defaults to true)
	 *
	 * @param boolean $handleMouseEvents
	 */
	public function setHandleMouseEvents($handleMouseEvents)
	{
		$this->setAttribute('handleMouseEvents', $handleMouseEvents);
	}

	/**
	 * The type of tooltip to use. Either "qtip" (default) for QuickTips or 
	 * "title" for title attribute.
	 *
	 * @param string $tooltipType
	 */
	public function setTooltipType($tooltipType)
	{
		$this->setAttribute('tooltipType', $tooltipType);
	}

	/**
	 * A CSS class string to apply to the button's main element.
	 *
	 * @param string $cls
	 */
	public function setCls($cls)
	{
		$this->setAttribute('cls', $cls);
	}

	/**
	 * (Optional)
	 *
	 * @param ext.template $template
	 */
	public function setTemplate($template)
	{
		$this->setAttribute('template', $template);
	}

	/**
	 * The side of the Button box to render the arrow if the button has an
	 * associated menu. Two values are allowed:
	 *  - right
	 *  - bottom
	 *
	 * @param string $arrowAlign
	 */
	public function setArrowAlign($arrowAlign)
	{
		$this->setAttribute('arrowAlign', $arrowAlign);
	}
	
	/**
	 * A DomQuery selector which is used to extract the active, clickable 
	 * element from the DOM structure created.
	 * 
	 * When a custom template is used, you must ensure that this selector 
	 * results in the selection of a focussable element. Defaults to 
	 * 'button:first-child'.
	 *
	 * @param string $buttonSelector
	 */
	public function setButtonSelector($buttonSelector)
	{
		$this->setAttribute('buttonSelector', $buttonSelector);
	}	

	/**
	 * The side of the Button box to render the icon. Four values are allowed:
	 *  - top
	 *  - right
	 *  - bottom
	 *  - left
	 * Defaults to left.
	 *
	 * @param string $iconAlign
	 */
	public function setIconAlign($iconAlign)
	{
		$this->setAttribute('iconAlign', $iconAlign);
	}

	/**
	 * The size of the Button. Three values are allowed:
	 * - small, results in the button element being 16px high.
	 * - medium, results in the button element being 24px high.
	 * - large, results in the button element being 32px high.
	 *
	 * @param string $scale
	 */
	public function setScale($scale)
	{
		$this->setAttribute('scale', $scale);
	}

	/**
	 * False to not allow a pressed Button to be depressed (defaults to
	 * undefined). Only valid when enableToggle is true.
	 *
	 * @param boolean $allowDepress
	 */
	public function setAllowDepress($allowDepress)
	{
		$this->setAttribute('allowDespress', $allowDepress);
	}

	/**
	 * Function called when a Button with enableToggle set to true is clicked.
	 * Two arguments are passed:
	 * button : Ext.Button, this Button object
	 * state : Boolean, the next state if the Button, true means pressed.
	 *
	 * @param string $toggleHandler
	 */
	public function setToggleHandler($toggleHandler)
	{
		$this->setAttribute('toggleHandler', $toggleHandler);
	}
}