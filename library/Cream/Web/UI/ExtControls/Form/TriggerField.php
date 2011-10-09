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
 * Provides a convenient wrapper for TextFields that adds a clickable trigger 
 * button (looks like a combobox by default). The trigger has no default 
 * action, so you must assign a function to implement the trigger click handler
 * by overriding onTriggerClick. You can create a TriggerField directly, as it 
 * renders exactly like a combobox for which you can provide a custom 
 * implementation. 
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_TriggerField extends Cream_Web_UI_ExtControls_Form_TextField 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_TriggerField
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
		$this->setControl('Ext.form.TriggerField');
		$this->setAttribute('xtype', 'trigger');		
	}	

	/**
	 * A CSS class to apply to the trigger
	 *
	 * @param string $triggerClass
	 */
	public function setTriggerClass($triggerClass)
	{
		$this->setAttribute('triggerClass', $triggerClass);
	}

	/**
	 * A DomHelper element spec, or true for a default element spec. Used to 
	 * create the Element which will encapsulate this Component. See autoEl for
	 * details. 
	 *
	 * @param string/object $autoCreate
	 */
	public function setAutoCreate($autoCreate)
	{
		$this->setAttribute('autoCreate', $autoCreate);
	}
	
	/**
	 * False to prevent the user from typing text directly into the field, the 
	 * field will only respond to a click on the trigger to set the value. 
	 * (defaults to true).
	 * 
	 * @param boolean $editable
	 */
	public function setEditable($editable)
	{
		$this->setAttribute('editable', $editable);
	}	

	/**
	 * True to hide the trigger element and display only the base text field 
	 * (defaults to false)
	 *
	 * @param boolean $hideTrigger
	 */
	public function setHideTrigger($hideTrigger)
	{
		$this->setAttribute('hideTrigger', $hideTrigger);
	}

	/**
	 * A DomHelper config object specifying the structure of the trigger 
	 * element for this Field. (Optional).
	 * 
	 * Specify this when you need a customized element to act as the trigger 
	 * button for a TriggerField.
	 * 
	 * Note that when using this option, it is the developer's responsibility 
	 * to ensure correct sizing, positioning and appearance of the trigger.
	 * 
	 * @param mixed $triggerConfig
	 */
	public function setTriggerConfig($triggerConfig)
	{
		$this->setAttribute('triggerConfig', $triggerConfig);		
	}

	/**
	 * The class added to the to the wrap of the trigger element. Defaults to 
	 * x-trigger-wrap-focus.
	 * 
	 * @param $wrapFocusClass
	 */
	public function setWrapFocusClass($wrapFocusClass)
	{
		$this->setAttribute('wrapFocusClass', $wrapFocusClass);		
	}	
}