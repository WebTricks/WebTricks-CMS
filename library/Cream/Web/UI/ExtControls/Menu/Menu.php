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
 * A menu object. This is the container to which you may add menu items. Menu 
 * can also serve as a base class when you want a specialized menu based off of
 * another component (like Ext.menu.DateMenu for example).
 * 
 *  Menus may contain either menu items, or general Components.
 *  
 *  To make a contained general Component line up with other menu items specify 
 *  iconCls: 'no-icon'. This reserves a space for an icon, and indents the 
 *  Component in line with the other menu items. See 
 *  Ext.form.ComboBox.getListParent for an example.
 *  
 *  By default, Menus are absolutely positioned, floating Components. By 
 *  configuring a Menu with floating:false, a Menu may be used as child of a 
 *  Container.
 * 
 * @package 	Cream_Web_UI_ExtControls_Menu
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Menu_Menu extends Cream_Web_UI_ExtControls_Container 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Menu_Menu
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
		$this->setControl('Ext.menu.Menu');		
	}
		
	
	/**
	 * True to allow multiple menus to be displayed at the same time 
	 * (defaults to false)
	 *
	 * @param boolean $allowOtherMenus
	 */
	public function setAllowOtherMenus($allowOtherMenus) 
	{
		$this->setAttribute('allowOtherMenus', $allowOtherMenus);
	}
	
	/**
	 * The default Ext.Element.alignTo anchor position value for this menu relative 
	 * to its element of origin (defaults to "tl-bl?")
	 *
	 * @param string $defaultAlign
	 */
	public function setDefaultAlign($defaultAlign) 
	{
		$this->setAttribute('defaultAlign', $defaultAlign);
	}	
	
	/**
	 * An array specifying the [x, y] offset in pixels by which to change the 
	 * default Menu popup position after aligning according to the defaultAlign 
	 * configuration. Defaults to [0, 0].
	 *
	 * @param array $defaultOffsets
	 */
	public function setDefaultOffsets($defaultOffsets) 
	{
		$this->setAttribute('defaultOffsets', $defaultOffsets);
	}
	
	/**
	 * True to allow the menu container to have scroller controls if the menu
	 * is too long (defaults to true).
	 *
	 * @param boolean $enableScrolling
	 */
	public function setEnableScrolling($enableScrolling) 
	{
		$this->setAttribute('enableScrolling', $enableScrolling);
	}		
	
	/**
	 * By default, a Menu configured as floating:true will be rendered as an 
	 * Ext.Layer (an absolutely positioned, floating Component with 
	 * zindex=15000). If configured as floating:false, the Menu may be used as 
	 * child item of another Container instead of a free-floating Layer.
	 *
	 * @param boolean $floating
	 */
	public function setFloating($floating) 
	{
		$this->setAttribute('floating', $floating);
	}	
	
	/**
	 * True to ignore clicks on any item in this menu that is a parent item 
	 * (displays a submenu) so that the submenu is not dismissed when clicking 
	 * the parent item (defaults to false).
	 * 
	 * @param boolean $ignoreParentClicks
	 */
	public function setIgnoreParentClicks($ignoreParentClicks) 
	{
		$this->setAttribute('ignoreParentClicks', $ignoreParentClicks);
	}	

	/**
	 * The maximum height of the menu. Only applies when enableScrolling is set 
	 * to True (defaults to null).
	 *
	 * @param integer $maxHeight
	 */
	public function setMaxHeight($maxHeight) 
	{
		$this->setAttribute('maxHeight', $maxHeight);
	}		
	
	/**
	 * The minimum width of the menu in pixels (defaults to 120)
	 *
	 * @param integer $minWidth
	 */
	public function setMinWidth($minWidth) 
	{
		$this->setAttribute('minWidth', $minWidth);
	}	
	
	/**
	 * True to remove the incised line down the left side of the menu. Defaults 
	 * to false.
	 *
	 * @param boolean $plain
	 */
	public function setPlain($plain) 
	{
		$this->setAttribute('plain', $plain);
	}		
	
	/**
	 * The amount to scroll the menu. Only applies when enableScrolling is set 
	 * to True (defaults to 24).
	 *
	 * @param integer $scrollIncrement
	 */
	public function setScrollIncrement($scrollIncrement) 
	{
		$this->setAttribute('scrollIncrement', $scrollIncrement);
	}	

	/**
	 * True or "sides" for the default effect, "frame" for 4-way shadow, and 
	 * "drop" for bottom-right shadow (defaults to "sides")
	 *
	 * @param boolean|string $shadow
	 */
	public function setShadow($shadow) 
	{
		$this->setAttribute('shadow', $shadow);
	}	
	
	/**
	 * True to show the icon separator. (defaults to true).
	 *
	 * @param boolean $showSeperator
	 */
	public function setShowSeperator($showSeperator) 
	{
		$this->setAttribute('showSeperator', $showSeperator);
	}		
	
	/**
	 * The Ext.Element.alignTo anchor position value to use for submenus of
	 * this menu (defaults to "tl-tr?")  
	 *
	 * @param string $subMenuAlign
	 */
	public function setSubMenuAlign($subMenuAlign) 
	{
		$this->setAttribute('subMenuAlign', $subMenuAlign);
	}
	
	/**
	 * zIndex to use when the menu is floating.
	 * 
	 * @param integer $zIndex
	 */
	public function setZIndex($zIndex)
	{
		$this->setAttribute('zIndex', $zIndex);
	}
}