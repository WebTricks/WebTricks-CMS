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
 * A basic tab container. Tab panels can be used exactly like a 
 * standard Ext.Panel for layout purposes, but also have special 
 * support for containing child Panels that get automatically 
 * converted into tabs.
 *
 * @package 	Cream_Web_UI_ExtControls
 * @author Danny Verkade
 */
class Cream_Web_UI_ExtControls_TabPanel extends Cream_Web_UI_ExtControls_Panel 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_TabPanel
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
		$this->setControl('Ext.TabPanel');
		$this->setAttribute('xtype', 'tabpanel');
	}

	/**
	 * Set to true to do a layout of tab items as tabs are changed.
	 *
	 * @param boolean $layoutOnTabChange
	 */
	public function setLayoutOnTabChange($layoutOnTabChange)
	{
		$this->setAttribute('layoutOnTabChange', $layoutOnTabChange);
	}

	/**
	 * Internally, the TabPanel uses a Ext.layout.CardLayout to manage its 
	 * tabs. This property will be passed on to the layout as its 
	 * Ext.layout.CardLayout.deferredRender config value, determining whether
	 * or not each tab is rendered only when first accessed (defaults to true).
	 *
	 * @param boolean $deferredRender
	 */
	public function setDeferredRender($deferredRender)
	{
		$this->setAttribute('deferredRender', $deferredRender);
	}

	/**
	 * The initial width in pixels of each new tab (defaults to 120).
	 *
	 * @param number $tabWidth
	 */
	public function setTabWidth($tabWidth)
	{
		$this->setAttribute('tabWidth', $tabWidth);
	}

	/**
	 * The minimum width in pixels for each tab when #resizeTabs = true 
	 * (defaults to 30).
	 *
	 * @param number $minTabWidth
	 */
	public function setMinTabWidth($minTabWidth)
	{
		$this->setAttribute('minTabWidth', $minTabWidth);
	}

	/**
	 * True to automatically resize each tab so that the tabs will completely 
	 * fill the tab strip (defaults to false). Setting this to true may cause 
	 * specific widths that might be set per tab to be overridden in order to 
	 * fit them all into view (although minTabWidth will always be honored).
	 *
	 * @param boolean $resizeTabs
	 */
	public function setResizeTabs($resizeTabs)
	{
		$this->setAttribute('resizeTabs', $resizeTabs);
	}

	/**
	 * True to enable scrolling to tabs that may be invisible due to 
	 * overflowing the overall TabPanel width. Only available with tabs on top.
	 * (defaults to false).
	 *
	 * @param boolean $enableTabScroll
	 */
	public function setEnableTabScroll($enableTabScroll)
	{
		$this->setAttribute('enableTabScroll', $enableTabScroll);
	}

	/**
	 * The number of pixels to scroll each time a tab scroll button is pressed 
	 * (defaults to 100, or if resizeTabs = true, the calculated tab width). 
	 * Only applies when enableTabScroll = true.
	 *
	 * @param number $scrollIncrement
	 */
	public function setScrollIncrement($scrollIncrement)
	{
		$this->setAttribute('scrollIncrement', $scrollIncrement);
	}

	/**
	 * Number of milliseconds between each scroll while a tab scroll button is 
	 * continuously pressed (defaults to 400).
	 *
	 * @param number $scrollRepeatInterval
	 */
	public function setScrollRepeatInterval($scrollRepeatInterval)
	{
		$this->setAttribute('scrollRepeatInterval', $scrollRepeatInterval);
	}

	/**
	 * The number of milliseconds that each scroll animation should last 
	 * (defaults to .35). Only applies when animScroll = true.
	 *
	 * @param float $scrollDuration
	 */
	public function setScrollDuration($scrollDuration)
	{
		$this->setAttribute('scrollDuration', $scrollDuration);
	}

	/**
	 * True to animate tab scrolling so that hidden tabs slide smoothly into 
	 * view (defaults to true). Only applies when enableTabScroll = true.
	 *
	 * @param boolean $animScroll
	 */
	public function setAnimScroll($animScroll)
	{
		$this->setAttribute('animScroll', $animScroll);
	}

	/**
	 * The position where the tab strip should be rendered (defaults to 'top'). 
	 * The only other supported value is 'bottom'. Note that tab scrolling is 
	 * only supported for position 'top'.
	 *
	 * @param string $tabPosition
	 */
	public function setTabPosition($tabPosition)
	{
		$this->setAttribute('tabPosition', $tabPosition);
	}

	/**
	 * The base CSS class applied to the panel (defaults to 'x-tab-panel').
	 *
	 * @param string $baseCls
	 */
	public function setBaseCls($baseCls)
	{
		$this->setAttribute('baseCls', $baseCls);
	}

	/**
	 * True to query the DOM for any divs with a class of 'x-tab' to be 
	 * automatically converted to tabs and added to this panel (defaults to 
	 * false). Note that the query will be executed within the scope of the 
	 * container element only (so that multiple tab panels from markup can be 
	 * supported via this method).
	 *
	 * This method is only possible when the markup is structured correctly as 
	 * a container with nested divs containing the class 'x-tab'. To create 
	 * TabPanels without these limitations, or to pull tab content from other 
	 * elements on the page, see the example at the top of the class for 
	 * generating tabs from markup.
	 *
	 * There are a couple of things to note when using this method:
	 *
	 * When using the autoTabs config (as opposed to passing individual tab 
	 * configs in the TabPanel's items collection), you must use applyTo to 
	 * correctly use the specified id as the tab container. The autoTabs method
	 * replaces existing content with the TabPanel components.
	 *
	 * Make sure that you set deferredRender to false so that the content 
	 * elements for each tab will be rendered into the TabPanel immediately upon 
	 * page load, otherwise they will not be transformed until each tab is 
	 * activated and will be visible outside the TabPanel.
	 *
	 * @param boolean $autoTabs
	 */
	public function setAutoTabs($autoTabs)
	{
		$this->setAttribute('autoTabs', $autoTabs);
	}

	/**
	 * The CSS selector used to search for tabs in existing markup when 
	 * autoTabs = true (defaults to 'div.x-tab'). This can be any valid 
	 * selector supported by Ext.DomQuery.select. Note that the query will be 
	 * executed within the scope of this tab panel only (so that multiple tab 
	 * panels from markup can be supported on a page).
	 *
	 * @param string $autoTabSelector
	 */
	public function setAutoTabSelector($autoTabSelector)
	{
		$this->setAttribute('autoTabSelector', $autoTabSelector);
	}

	/**
	 * A string id or the numeric index of the tab that should be initially 
	 * activated on render (defaults to none).
	 *
	 * @param string/number $activeTab
	 */
	public function setActiveTab($activeTab)
	{
		$this->setAttribute('activeTab', $activeTab);
	}
	
	/**
	 * This config option is used on child Components of ths TabPanel. A CSS 
	 * class name applied to the tab strip item representing the child 
	 * Component, allowing special styling to be applied.
	 *
	 * @param string $tabCls
	 */
	public function setTabCls($tabCls)
	{
		$this->setAttribute('tabCls', $tabCls);
	}	

	/**
	 * The number of pixels of space to calculate into the sizing and scrolling 
	 * of tabs. If you change the margin in CSS, you will need to update this 
	 * value so calculations are correct with either resizeTabs or scrolling
	 * tabs. (defaults to 2)
	 *
	 * @param number $tabMargin
	 */
	public function setTabMargin($tabMargin)
	{
		$this->setAttribute('tabMargin', $tabMargin);
	}

	/**
	 * True to render the tab strip without a background container image 
	 * (defaults to false).
	 *
	 * @param boolean $plain
	 */
	public function setPlain($plain)
	{
		$this->setAttribute('plain', $plain);
	}

	/**
	 * For scrolling tabs, the number of pixels to increment on mouse wheel 
	 * scrolling (defaults to 20).
	 *
	 * @param number $wheelIncrement
	 */
	public function setWheelIncrement($wheelIncrement)
	{
		$this->setAttribute('wheelIncrement', $wheelIncrement);
	}
	
	/**
	 * A Template or XTemplate which may be provided to process the data object 
	 * returned from getTemplateArgs to produce a clickable selector element in 
	 * the tab strip.
	 *
	 * @param Cream_Web_UI_ExtControls_Template $itemTpl
	 */
	public function setItemTpl($itemTpl)
	{
		$this->setAttribute('itemTpl', $itemTpl);
	}	
}