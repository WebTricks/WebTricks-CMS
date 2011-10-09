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
 * Base class for all Ext components. All subclasses of Component can automatically participate in the
 * standard Ext component lifecycle of creation, rendering and destruction. They also have automatic
 * support for basic hide/show and enable/disable behavior. Component allows any subclass to be
 * lazy-rendered into any Ext.Container and to be automatically registered with the Ext.ComponentMgr so
 * that it can be referenced at any time via Ext.getCmp. All visual widgets that require rendering into
 * a layout should subclass Component (or Ext.BoxComponent if managed box model handling is required).
 *
 * Every component has a specific xtype, which is its Ext-specific type name, along with methods for
 * checking the xtype like getXType and isXType. This is the list of all valid xtypes:
 *
 * xtype            Class
 * -------------    ------------------
 * box              Ext.BoxComponent
 * button           Ext.Button
 * colorpalette     Ext.ColorPalette
 * component        Ext.Component
 * container        Ext.Container
 * cycle            Ext.CycleButton
 * dataview         Ext.DataView
 * datepicker       Ext.DatePicker
 * editor           Ext.Editor
 * editorgrid       Ext.grid.EditorGridPanel
 * grid             Ext.grid.GridPanel
 * paging           Ext.PagingToolbar
 * panel            Ext.Panel
 * progress         Ext.ProgressBar
 * splitbutton      Ext.SplitButton
 * tabpanel         Ext.TabPanel
 * treepanel        Ext.tree.TreePanel
 * viewport         Ext.ViewPort
 * window           Ext.Window
 *
 * Toolbar components
 * ---------------------------------------
 * toolbar          Ext.Toolbar
 * tbbutton         Ext.Toolbar.Button
 * tbfill           Ext.Toolbar.Fill
 * tbitem           Ext.Toolbar.Item
 * tbseparator      Ext.Toolbar.Separator
 * tbspacer         Ext.Toolbar.Spacer
 * tbsplit          Ext.Toolbar.SplitButton
 * tbtext           Ext.Toolbar.TextItem
 *
 * Form components
 * ---------------------------------------
 * form             Ext.FormPanel
 * checkbox         Ext.form.Checkbox
 * combo            Ext.form.ComboBox
 * datefield        Ext.form.DateField
 * field            Ext.form.Field
 * fieldset         Ext.form.FieldSet
 * hidden           Ext.form.Hidden
 * htmleditor       Ext.form.HtmlEditor
 * numberfield      Ext.form.NumberField
 * radio            Ext.form.Radio
 * textarea         Ext.form.TextArea
 * textfield        Ext.form.TextField
 * timefield        Ext.form.TimeField
 * trigger          Ext.form.TriggerField
 *
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Component extends Cream_Web_UI_ExtControls_Util_Observable 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Component
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
		$this->setControl('Ext.Component');
	}	
	
	/**
	 * The unique id of this component (defaults to an auto-assigned id).
	 *
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->setAttribute('id', $id);
	}
	
	/**
	 * Note: this config is only used when this Component is rendered by a 
	 * Container which has been configured to use the FormLayout layout 
	 * manager (e.g. Ext.form.FormPanel or specifying layout:'form').
	 *
	 * @param string $itemCls
	 */
	public function setItemCls($itemCls)
	{
		$this->setAttribute('itemCls', $itemCls);
	}

	/**
	 * An itemId can be used as an alternative way to get a reference to a 
	 * component when no object reference is available. Instead of using an id 
	 * with Ext.getCmp, use itemId with Ext.Container.getComponent which will 
	 * retrieve itemId's or id's. Since itemId's are an index to the 
	 * container's internal MixedCollection, the itemId is scoped locally to 
	 * the container -- avoiding potential conflicts with Ext.ComponentMgr 
	 * which requires a unique id.
	 *
	 * @param string $itemId
	 */
	public function setItemId($itemId)
	{
		$this->setAttribute('itemId', $itemId);
	}	

	/**
	 * The registered xtype to create. This config option is not used when passing a config object into a
	 * constructor. This config option is used only when lazy instantiation is being used, and a child item
	 * of a Container is being specified not as a fully instantiated Component, but as a Component config
	 * object. The xtype will be looked up at render time up to determine what type of child Component to create.
	 *
	 * The predefined xtypes are listed here.
	 *
	 * If you subclass Components to create your own Components, you may register them using
	 * .ComponentMgr.registerType in order to be able to take advantage of lazy instantiation and rendering.
	 *
	 * @param string $xtype
	 */
	public function setXtype($xtype)
	{
		$this->setAttribute('xtype', $xtype);
	}

	/**
	 * An optional extra CSS class that will be added to this component's 
	 * container. This can be useful for adding customized styles to the 
	 * container or any of its children using standard CSS rules. See 
	 * Ext.layout.ContainerLayout.extraCls also.
	 *
	 * @param string $ctCls
	 */
	public function setCtCls($ctCls)
	{
		$this->setAttribute('ctCls', $ctCls);
	}
	
	/**
	 * An optional extra CSS class that will be added to this component's Element (defaults to '').
	 * This can be useful for adding customized styles to the component or any of its children using
	 * standard CSS rules.
	 *
	 * @param string $cls
	 */
	public function setCls($cls)
	{
		$this->setAttribute('cls', $cls);
	}	

	/**
	 * A custom style specification to be applied to this component's Element. 
	 * Should be a valid argument to Ext.Element.applyStyles.
	 *
	 * @param string $style
	 */
	public function setStyle($style)
	{
		$this->setAttribute('style', $style);
	}

	/**
	 * The CSS class used to to apply to the special clearing div rendered 
	 * directly after each form field wrapper to provide field clearing 
	 * (defaults to 'x-form-clear-left').
	 *
	 * @param string $clearCls
	 */
	public function setClearCls($clearCls)
	{
		$this->setAttribute('clearCls', $clearCls);
	}

	/**
	 * An object or array of objects that will provide custom functionality for 
	 * this component. The only requirement for a valid plugin is that it 
	 * contain an init method that accepts a reference of type Ext.Component. 
	 * When a component is created, if any plugins are available, the component 
	 * will call the init method on each plugin, passing a reference to itself. 
	 * Each plugin can then call methods or respond to events on the component 
	 * as needed to provide its functionality.
	 *
	 * @param object/array $plugins
	 */
	public function setPlugins($plugins)
	{
		$this->setAttribute('plugins', $plugins);
	}
	
	/**
	 * The separator to display after the text of each fieldLabel. 
	 * 
	 * @param string $labelSeparator
	 */
	public function setLabelSeparator($labelSeparator)
	{
		$this->setAttribute('labelSeparator', $labelSeparator);
	}	
	
	/**
	 * A CSS style specification string to apply directly to this field's label. 
	 * Defaults to the container's labelStyle value if set (e.g., 
	 * Ext.layout.FormLayout.labelStyle , or '').
	 * 
	 * @param string $labelStyle
	 */
	public function setLabelStyle($labelStyle)
	{
		$this->setAttribute('labelStyle', $labelStyle);
	}		
	
	/**
	 * An optional extra CSS class that will be added to this component's 
	 * Element when the mouse moves over the Element, and removed when the 
	 * mouse moves out. (defaults to ''). This can be useful for adding 
	 * customized 'active' or 'hover' styles to the component or any of its 
	 * children using standard CSS rules.
	 * 
	 * @param string $overCls
	 */
	public function setOverCls($overCls)
	{
		$this->setAttribute('overCls', $overCls);
	}		

	/**
	 * The id of the node, a DOM node or an existing Element corresponding to a 
	 * DIV that is already present in the document that specifies some 
	 * structural markup for this component. When applyTo is used, constituent 
	 * parts of the component can also be specified by id or CSS class name 
	 * within the main element, and the component being created may attempt to 
	 * create its subcomponents from that markup if applicable. Using this 
	 * config, a call to render() is not required. If applyTo is specified, any 
	 * value passed for renderTo will be ignored and the target element's 
	 * parent node will automatically be used as the component's container.
	 *
	 * @param mixed $applyTo
	 */
	public function setApplyTo($applyTo)
	{
		$this->setAttribute('applyTo', $applyTo);
	}

	/**
	 * The id of the node, a DOM node or an existing Element that will be the container to render this component
	 * into. Using this config, a call to render() is not required.
	 *
	 * @param mixed $renderTo
	 */
	public function setRenderTo($renderTo)
	{
		$this->setAttribute('renderTo', $renderTo);
	}
	
	/**
	 * The registered ptype to create. This config option is not used when 
	 * passing a config object into a constructor. This config option is used 
	 * only when lazy instantiation is being used, and a Plugin is being 
	 * specified not as a fully instantiated Component, but as a Component 
	 * config object. The ptype will be looked up at render time up to 
	 * determine what type of Plugin to create. 
	 * 
	 * @param string $ptype
	 */
	public function setPtype($ptype)
	{
		$this->setAttribute('ptype', $ptype);		
	}
	
	/**
	 * A path specification, relative to the Component's ownerCt specifying 
	 * into which ancestor Container to place a named reference to this 
	 * Component.
	 * 
	 * @param string $ref
	 */
	public function setRef($ref)
	{
		$this->setAttribute('ref', $ref);		
	}	

	/**
	 * A flag which causes the Component to attempt to restore the state of 
	 * internal properties from a saved state on startup.
	 *
	 * For state saving to work, the state manager's provider must have been 
	 * set to an implementation of Ext.state.Provider which overrides the set 
	 * and get methods to save and recall name/value pairs. A built-in 
	 * implementation, Ext.state.CookieProvider is available.
	 *
	 * To set the state provider for the current page:
	 * Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
	 *
	 * Components attempt to save state when one of the events listed in the 
	 * stateEvents configuration fires.
	 *
	 * You can perform extra processing on state save and restore by attaching 
	 * handlers to the beforestaterestore, staterestore, beforestatesave and 
	 * statesave events
	 *
	 * @param boolean $stateful
	 */
	public function setStateful($stateful)
	{
		$this->setAttribute('stateful', $stateful);
	}

	/**
	 * The unique id for this component to use for state management purposes 
	 * (defaults to the component id).
	 *
	 * See stateful for an explanation of saving and restoring Component state.
	 *
	 * @param string $stateId
	 */
	public function setStateId($stateId)
	{
		$this->setAttribute('stateId', $stateId);
	}

	/**
	 * An array of events that, when fired, should trigger this component to 
	 * save its state (defaults to none). These can be any types of events 
	 * supported by this component, including browser or custom events (e.g., 
	 * ['click', 'customerchange']).
	 *
	 * See stateful for an explanation of saving and restoring Component state.
	 *
	 * @param array $stateEvents
	 */
	public function setStateEvents($stateEvents)
	{
		$this->setAttribute('stateEvents', $stateEvents);
	}
	
	/**
	 * The initial set of data to apply to the tpl to update the content area 
	 * of the Component.
	 *
	 * @param mixed $data
	 */
	public function setData($data)
	{
		$this->setAttribute('data', $data);
	}

	/**
	 * Render this component disabled (default is false).
	 *
	 * @param boolean $disabled
	 */
	public function setDisabled($disabled)
	{
		$this->setAttribute('disabled', $disabled);
	}	

	/**
	 * CSS class added to the component when it is disabled (defaults to 
	 * "x-item-disabled").
	 *
	 * @param string $disabledClass
	 */
	public function setDisabledClass($disabledClass)
	{
		$this->setAttribute('disabledClass', $disabledClass);
	}

	/**
	 * Whether the component can move the Dom node when rendering (defaults to 
	 * true).
	 *
	 * @param boolean $allowDomMove
	 */
	public function setAllowDomMove($allowDomMove)
	{
		$this->setAttribute('allowDomMove', $allowDomMove);
	}
	
	/**
	 * A tag name or DomHelper spec used to create the Element which will 
	 * encapsulate this Component.
	 *
	 * @param mixed $autoEl
	 */
	public function setAutoEl($autoEl)
	{
		$this->setAttribute('autoEl', $autoEl);
	}	
	
	/**
	 * Specify an existing HTML element, or the id of an existing HTML element 
	 * to use as the content for this component.
	 *
	 * @param mixed $contentEl
	 */
	public function setContentEl($contentEl)
	{
		$this->setAttribute('contentEl', $contentEl);
	}	

	/**
	 * True if the component should check for hidden classes (e.g. 'x-hidden'
	 * or 'x-hide-display') and remove them on render (defaults to false).
	 *
	 * @param boolean $autoShow
	 */
	public function setAutoShow($autoShow)
	{
		$this->setAttribute('autoShow', $autoShow);
	}

	/**
	 * How this component should hidden. Supported values are "visibility" (css 
	 * visibility), "offsets" (negative offset position) and "display" (css 
	 * display) - defaults to "display".
	 *
	 * @param string $hideMode
	 */
	public function setHideMode($hideMode)
	{
		$this->setAttribute('hideMode', $hideMode);
	}

	/**
	 * True to completely hide the label element (label and separator). 
	 * Defaults to false. By default, even if you do not specify a fieldLabel 
	 * the space will still be reserved so that the field will line up with 
	 * other fields that do have labels. Setting this to true will cause the 
	 * field to not reserve that space.
	 * 
	 * @param boolean $hideLabel
	 */
	public function setHideLabel($hideLabel)
	{
		$this->setAttribute('hideLabel', $hideLabel);
	}
	
	
	/**
	 * True to hide and show the component's container when hide/show is called 
	 * on the component, false to hide and show the component itself (defaults 
	 * to false). For example, this can be used as a shortcut for a hide button 
	 * on a window by setting hide:true on the button when adding it to its
	 * parent container.
	 *
	 * @param boolean $hideParent
	 */
	public function setHideParent($hideParent)
	{
		$this->setAttribute('hideParent', $hideParent);
	}
	
	/**
	 * An HTML fragment, or a DomHelper specification to use as the layout 
	 * element content (defaults to ''). The HTML content is added after the 
	 * component is rendered, so the document will not contain this HTML at the
	 * time the render event is fired. This content is inserted into the body 
	 * before any configured contentEl is appended.
	 * 
	 * @param string $html
	 */
	public function setHtml($html)
	{
		$this->setAttribute('html', $html);
	}	
	
	/**
	 * The label text to display next to this Component (defaults to '').
	 * 
	 * @param string $fieldLabel
	 */
	public function setFieldLabel($fieldLabel)
	{
		$this->setAttribute('fieldLabel', $fieldLabel);		
	}
	
	/**
	 * Render this component hidden (default is false). If true, the hide 
	 * method will be called internally.
	 * 
	 * @param boolean $hidden
	 */
	public function setHidden($hidden)
	{
		$this->setAttribute('hidden', $hidden);		
	}	
	
	/**
	 * An Ext.Template, Ext.XTemplate or an array of strings to form an 
	 * Ext.XTemplate. Used in conjunction with the data and tplWriteMode 
	 * configurations.
	 * 
	 * @param mixed $tpl
	 */
	public function setTpl($tpl)
	{
		$this->setAttribute('tpl', $tpl);		
	}	

	/**
	 * The Ext.(X)Template method to use when updating the content area of the 
	 * Component. Defaults to 'overwrite' (see Ext.XTemplate.overwrite).
	 * 
	 * @param boolean $tplWriteMode
	 */
	public function setTplWriteMode($tplWriteMode)
	{
		$this->setAttribute('tplWriteMode', $tplWriteMode);		
	}		
}