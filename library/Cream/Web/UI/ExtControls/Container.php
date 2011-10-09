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
 * Base class for any Ext.BoxComponent that can contain other 
 * components. Containers handle the basic behavior of containing 
 * items, namely adding, inserting and removing them. The specific 
 * layout logic required to visually render contained items is 
 * delegated to any one of the different layout classes available. 
 * This class is intended to be extended and should generally not need
 * to be created directly via the new keyword.
 *
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Container extends Cream_Web_UI_ExtControls_BoxComponent 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Container
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
		$this->setControl('Ext.Container');
		$this->setXtype('container');
	}	
	
	/**
	 * True to automatically monitor window resize events to handle anything 
	 * that is sensitive to the current size of the viewport. This value is 
	 * typically managed by the chosen layout and should not need to be set 
	 * manually.
	 *
	 * @param boolean $monitorResize
	 */
	public function setMonitorResize($monitorResize)
	{
		$this->setAttribute('monitorResize', $monitorResize);
	}

	/**
	 * The layout type to be used in this container. If not specified, a 
	 * default Ext.layout.ContainerLayout will be created and used. Valid 
	 * values are: accordion, anchor, border, card, column, fit, form and 
	 * table. Specific config values for the chosen layout type can be 
	 * specified using layoutConfig.
	 *
	 * @param string $layout
	 */
	public function setLayout($layout)
	{
		$this->setAttribute('layout', $layout);
	}

	/**
	 * This is a config object containing properties specific to the chosen 
	 * layout (to be used in conjunction with the layout config value). For 
	 * complete details regarding the valid config options for each layout 
	 * type, see the layout class corresponding to the type specified:
	 *  - Ext.layout.Accordion
	 *  - Ext.layout.AnchorLayout
	 *  - Ext.layout.BorderLayout
	 *  - Ext.layout.CardLayout
	 *  - Ext.layout.ColumnLayout
	 *  - Ext.layout.FitLayout
	 *  - Ext.layout.FormLayout
	 *  - Ext.layout.TableLayout
	 *
	 * @param object $layoutConfig
	 */
	public function setLayoutConfig($layoutConfig)
	{
		$this->setAttribute('layoutConfig', $layoutConfig);
	}

	/**
	 * When set to true (100 milliseconds) or a number of milliseconds, the 
	 * layout assigned for this container will buffer the frequency it 
	 * calculates and does a re-layout of components. This is useful for heavy 
	 * containers or containers with a large amount of sub components that 
	 * frequent calls to layout are expensive.
	 *
	 * @param boolean/number $bufferResize
	 */
	public function setBufferResize($bufferResize)
	{
		$this->setAttribute('bufferResize', $bufferResize);
	}

	/**
	 * A string component id or the numeric index of the component that should 
	 * be initially activated within the container's layout on render. For 
	 * example, activeItem: 'item-1' or activeItem: 0 (index 0 = the  first 
	 * item in the container's collection). activeItem only applies to layout 
	 * styles that can display items one at a time (like Ext.layout.Accordion, 
	 * Ext.layout.CardLayout and Ext.layout.FitLayout). Related to 
	 * Ext.layout.ContainerLayout.activeItem.
	 *
	 * @param string/number $activeItem
	 */
	public function setActiveItem($activeItem)
	{
		$this->setAttribute('activeItem', $activeItem);
	}

	/**
	 * An array of child Components to be added to this container. Each item 
	 * can be any type of object based on Ext.Component.
	 *
	 * Component config objects may also be specified in order to avoid the 
	 * overhead of constructing a real Component object if lazy rendering might 
	 * mean that the added Component will not be rendered immediately. To take 
	 * advantage of this "lazy instantiation", set the Ext.Component.xtype 
	 * config property to the registered type of the Component wanted.
	 *
	 * For a list of all available xtypes, see Ext.Component. If a single item 
	 * is being passed, it should be passed directly as an object reference
	 * (e.g., items: {...}). Multiple items should be passed as an array of 
	 * objects (e.g., items: [{...}, {...}]).
	 *
	 * @param array $items
	 */
	public function setItems($items)
	{
		$this->setAttribute('items', $items);
	}
	
	/**
	 * Adds an item to the child items.
	 * 
	 * @param Cream_Web_UI_ExtControl $item
	 */
	public function addItem(Cream_Web_UI_ExtControl $item)
	{
		$this->addAttribute('items', $item);
	}
	
	/**
	 * Adds an array of items to the control
	 * 
	 * @param array
	 */
	public function addItems($items)
	{
		foreach($items as $item) {
			$this->addItem($item);
		}
	}

	/**
	 * A config object that will be applied to all components added to this 
	 * container either via the items config or via the add or insert methods. 
	 * The defaults config can contain any number of name/value property pairs 
	 * to be added to each item, and should be valid for the types of items 
	 * being added to the container. For example, to automatically apply 
	 * padding to the body of each of a set of contained Ext.Panel items, you 
	 * could pass: defaults: {bodyStyle:'padding:15px'}.
	 *
	 * @param object $defaults
	 */
	public function setDefaults($defaults)
	{
		$this->setAttribute('defaults', $defaults);
	}

	/**
	 * If true the container will automatically destroy any contained 
	 * component that is removed from it, else destruction must be handled
	 * manually (defaults to true).
	 *
	 * @param boolean $autoDestroy
	 */
	public function setAutoDestroy($autoDestroy)
	{
		$this->setAttribute('autoDestroy', $autoDestroy);
	}
	
	/**
	 * An array of events that, when fired, should be bubbled to any parent 
	 * container. See Ext.util.Observable.enableBubble. Defaults to ['add', 
	 * 'remove'].
	 *
	 * @param array $bubbleEvents
	 */
	public function setBubbleEvents($bubbleEvents)
	{
		$this->setAttribute('bubbleEvents', $bubbleEvents);
	}

	/**
	 * True to hide the borders of each contained component, false to defer to 
	 * the component's existing border settings (defaults to false).
	 *
	 * @param boolean $hideBorders
	 */
	public function setHideBorders($hideBorders)
	{
		$this->setAttribute('hideBorders', $hideBorders);
	}

	/**
	 * The default type of container represented by this object as registered 
	 * n Ext.ComponentMgr (defaults to 'panel').
	 *
	 * @param string $defaultType
	 */
	public function setDefaultType($defaultType)
	{
		$this->setAttribute('defaultType', $defaultType);
	}
	
	/**
	 * If true the container will force a layout initially even if hidden or 
	 * collapsed. This option is useful for forcing forms to render in 
	 * collapsed or hidden containers. (defaults to false).
	 *
	 * @param boolean $forceLayout
	 */
	public function setForceLayout($forceLayout)
	{
		$this->setAttribute('forceLayout', $forceLayout);
	}	
	
	/**
	 * The event to listen to for resizing in layouts. Defaults to 'resize'.
	 *
	 * @param string $resizeEvent
	 */
	public function setResizeEvent($resizeEvent)
	{
		$this->setAttribute('resizeEvent', $resizeEvent);
	}	
}