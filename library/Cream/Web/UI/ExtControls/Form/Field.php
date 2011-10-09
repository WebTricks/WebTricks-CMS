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
 * Base class for form fields that provides default event handling, sizing, 
 * value handling and other functionality.
 * 
 * @package		Cream_Web_UI_ExtControl
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_Field extends Cream_Web_UI_ExtControls_BoxComponent 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_Field
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
		$this->setControl('Ext.form.Field');
	}		
	
	/**
	 * A CSS style specification to apply directly to this field's label (defaults to the
	 *
	 * @param string $labelStyle
	 */
	public function setLabelStyle($labelStyle)
	{
		$this->setAttribute('labelStyle', $labelStyle);
	}

	/**
	 * The standard separator to display after the text of each form label (defaults
	 *
	 * @param string $labelSeparator
	 */
	public function setLabelSeparator($labelSeparator)
	{
		$this->setAttribute('labelSeparator', $labelSeparator);
	}

	/**
	 * The CSS class to use when marking a field invalid (defaults to 
	 * "x-form-invalid")
	 *
	 * @param string $invalidClass
	 */
	public function setInvalidClass($invalidClass)
	{
		$this->setAttribute('invalidClass', $invalidClass);
	}

	/**
	 * The error text to use when marking a field invalid and no message is
	 * provided
	 *
	 * @param string $invalidText
	 */
	public function setInvalidText($invalidText)
	{
		$this->setAttribute('invalidText', $invalidText);
	}

	/**
	 * The CSS class to use when the field receives focus (defaults to "x-form-focus")
	 *
	 * @param string $focusClass
	 */
	public function setFocusClass($focusClass)
	{
		$this->setAttribute('focusClass', $focusClass);
	}

	/**
	 * The event that should initiate field validation. Set to false to disable
	 *
	 * @param string/boolean $validationEvent
	 */
	public function setValidationEvent($validationEvent)
	{
		$this->setAttribute('validationEvent', $validationEvent);
	}

	/**
	 * Whether the field should validate when it loses focus (defaults to true).
	 *
	 * @param boolean $validateOnBlur
	 */
	public function setValidateOnBlur($validateOnBlur)
	{
		$this->setAttribute('validateOnBlur', $validateOnBlur);
	}

	/**
	 * The length of time in milliseconds after user input begins until validation
	 *
	 * @param number $validationDelay
	 */
	public function setValidationDelay($validationDelay)
	{
		$this->setAttribute('validationDelay', $validationDelay);
	}

	/**
	 * A DomHelper element spec, or true for a default element spec (defaults to
	 *
	 * @param string/object $autoCreate
	 */
	public function setAutoCreate($autoCreate)
	{
		$this->setAttribute('autoCreate', $autoCreate);
	}

	/**
	 * The default CSS class for the field (defaults to "x-form-field")
	 *
	 * @param string $fieldClass
	 */
	public function setFieldClass($fieldClass)
	{
		$this->setAttribute('fieldClass', $fieldClass);
	}

	/**
	 * The location where error text should display.  Should be one of the following values
	 *
	 * @param string $msgTarget
	 */
	public function setMsgTarget($msgTarget)
	{
		$this->setAttribute('msgTarget', $msgTarget);
	}

	/**
	 * <b>Experimental</b> The effect used when displaying a validation message under the field
	 *
	 * @param string $msgFx
	 */
	public function setMsgFx($msgFx)
	{
		$this->setAttribute('msgFx', $msgFx);
	}

	/**
	 * True to mark the field as readOnly in HTML (defaults to false).
	 * 
	 *  Note: this only sets the element's readOnly DOM attribute. Setting 
	 *  readOnly=true, for example, will not disable triggering a ComboBox or
	 *  DateField; it gives you the option of forcing the user to choose via 
	 *  the trigger without typing in the text box. To hide the trigger use 
	 *  hideTrigger.
	 *
	 * @param boolean $readOnly
	 */
	public function setReadOnly($readOnly)
	{
		$this->setAttribute('readOnly', $readOnly);
	}

	/**
	 * True to disable the field (defaults to false).
	 *
	 * @param boolean $disabled
	 */
	public function setDisabled($disabled)
	{
		$this->setAttribute('disabled', $disabled);
	}

	/**
	 * The type attribute for input fields -- e.g. radio, text, password 
	 * (defaults to "text").
	 *
	 * @param string $inputType
	 */
	public function setInputType($inputType)
	{
		$this->setAttribute('inputType', $inputType);
	}

	/**
	 * The tabIndex for this field. Note this only applies to fields that are 
	 * rendered, not those which are built via applyTo (defaults to undefined).
	 *
	 * @param number $tabIndex
	 */
	public function setTabIndex($tabIndex)
	{
		$this->setAttribute('tabIndex', $tabIndex);
	}
	
	/**
	 * False to clear the name attribute on the field so that it is not 
	 * submitted during a form post. Defaults to true.
	 *
	 * @param boolean $submitValue
	 */
	public function setSubmitValue($submitValue)
	{
		$this->setAttribute('submitValue', $submitValue);
	}	

	/**
	 * A value to initialize this field with.
	 *
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		$this->setAttribute('value', $value);
	}

	/**
	 * The field's HTML name attribute.
	 *
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->setAttribute('name', $name);
	}
	
	/**
	 * True to disable marking the field invalid. Defaults to false.
	 *
	 * @param boolean $preventMark
	 */
	public function setPreventMark($preventMark)
	{
		$this->setAttribute('preventMark', $preventMark);
	}	

	/**
	 * A CSS class to apply to the field's underlying element.
	 *
	 * @param string $cls
	 */
	public function setCls($cls)
	{
		$this->setAttribute('cls', $cls);
	}
}