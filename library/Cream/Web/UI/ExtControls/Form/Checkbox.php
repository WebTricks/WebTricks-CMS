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
 * Single checkbox field. Can be used as a direct replacement for traditional 
 * checkbox fields.
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_Checkbox extends Cream_Web_UI_ExtControls_Form_Field 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_Checkbox
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
		$this->setControl('Ext.form.Checkbox');
		$this->setAttribute('xtype', 'checkbox');
	}	
	
	/**
	 * The CSS class to use when the checkbox receives focus (defaults to undefined)
	 *
	 * @param string $focusClass
	 */
	public function setFocusClass($focusClass)
	{
		$this->setAttribute('focusClass', $focusClass);
	}

	/**
	 * The default CSS class for the checkbox (defaults to "x-form-field")
	 *
	 * @param string $fieldClass
	 */
	public function setFieldClass($fieldClass)
	{
		$this->setAttribute('fieldClass', $fieldClass);
	}

	/**
	 * True if the the checkbox should render already checked (defaults to false)
	 *
	 * @param boolean $checked
	 */
	public function setChecked($checked)
	{
		$this->setAttribute('checked', $checked);
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
	 * The text that appears beside the checkbox
	 *
	 * @param string $boxLabel
	 */
	public function setBoxLabel($boxLabel)
	{
		$this->setAttribute('boxLabel', $boxLabel);
	}

	/**
	 * The value that should go into the generated input element's value attribute
	 *
	 * @param string $inputValue
	 */
	public function setInputValue($inputValue)
	{
		$this->setAttribute('inputValue', $inputValue);
	}
	
	/**
	 * A function called when the checked value changes (can be used instead of 
	 * handling the check event). The handler is passed the following 
	 * parameters: 
	 * checkbox : Ext.form.Checkbox
	 * The Checkbox being toggled.
	 * checked : Boolean
	 * The new checked state of the checkbox.
	 *
	 * @param string $handler
	 */
	public function setHandler($handler)
	{
		$this->setAttribute('handler', $handler);
	}

	/**
	 * An object to use as the scope ('this' reference) of the handler function 
	 * (defaults to this Checkbox).
	 *
	 * @param string $scope
	 */
	public function setScope($scope)
	{
		$this->setAttribute('scope', $scope);
	}	
}