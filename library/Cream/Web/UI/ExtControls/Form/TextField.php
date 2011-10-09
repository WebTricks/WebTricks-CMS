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
 * Basic text field. Can be used as a direct replacement for traditional text 
 * inputs, or as the base class for more sophisticated input controls (like 
 * Ext.form.TextArea and Ext.form.ComboBox).
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_TextField extends Cream_Web_UI_ExtControls_Form_Field 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_TextField
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
		$this->setControl('Ext.form.TextField');
		$this->setAttribute('xtype', 'textfield');
	}

	/**
	 * A custom error message to display in place of the default message provided
	 *
	 * @param string $vtypeText
	 */
	public function setVtypeText($vtypeText)
	{
		$this->setAttribute('vtypeText', $vtypeText);
	}

	/**
	 * True if this field should automatically grow and shrink to its content
	 *
	 * @param boolean $grow
	 */
	public function setGrow($grow)
	{
		$this->setAttribute('grow', $grow);
	}

	/**
	 * The minimum width to allow when grow = true (defaults to 30)
	 *
	 * @param number $growMin
	 */
	public function setGrowMin($growMin)
	{
		$this->setAttribute('growMin', $growMin);
	}

	/**
	 * The maximum width to allow when grow = true (defaults to 800)
	 *
	 * @param number $growMax
	 */
	public function setGrowMax($growMax)
	{
		$this->setAttribute('growMax', $growMax);
	}

	/**
	 * A validation type name as defined in Ext.form.VTypes (defaults to null)
	 *
	 * @param string $vtype
	 */
	public function setVtype($vtype)
	{
		$this->setAttribute('vtype', $vtype);
	}

	/**
	 * An input mask regular expression that will be used to filter keystrokes that don't match
	 *
	 * @param regexp $maskRe
	 */
	public function setMaskRe($maskRe)
	{
		$this->setAttribute('maskRe', $maskRe);
	}

	/**
	 * True to disable input keystroke filtering (defaults to false)
	 *
	 * @param boolean $disableKeyFilter
	 */
	public function setDisableKeyFilter($disableKeyFilter)
	{
		$this->setAttribute('disableKeyFilter', $disableKeyFilter);
	}

	/**
	 * False to validate that the value length > 0 (defaults to true)
	 *
	 * @param boolean $allowBlank
	 */
	public function setAllowBlank($allowBlank)
	{
		$this->setAttribute('allowBlank', $allowBlank);
	}

	/**
	 * Minimum input field length required (defaults to 0)
	 *
	 * @param number $minLength
	 */
	public function setMinLength($minLength)
	{
		$this->setAttribute('minLength', $minLength);
	}

	/**
	 * Maximum input field length allowed (defaults to Number.MAX_VALUE)
	 *
	 * @param number $maxLength
	 */
	public function setMaxLength($maxLength)
	{
		$this->setAttribute('maxLength', $maxLength);
	}

	/**
	 * Error text to display if the minimum length validation fails (defaults to
	 *
	 * @param string $minLengthText
	 */
	public function setMinLengthText($minLengthText)
	{
		$this->setAttribute('minLengthText', $minLengthText);
	}

	/**
	 * Error text to display if the maximum length validation fails (defaults to
	 *
	 * @param string $maxLengthText
	 */
	public function setMaxLengthText($maxLengthText)
	{
		$this->setAttribute('maxLengthText', $maxLengthText);
	}

	/**
	 * True to automatically select any existing field text when the field receives
	 *
	 * @param boolean $selectOnFocus
	 */
	public function setSelectOnFocus($selectOnFocus)
	{
		$this->setAttribute('selectOnFocus', $selectOnFocus);
	}
	
	/**
	 * A JavaScript RegExp object used to strip unwanted content from the value 
	 * before validation (defaults to null).
	 *
	 * @param string $stripCharsRe
	 */
	public function setStripCharsRe($stripCharsRe)
	{
		$this->setAttribute('stripCharsRe', $stripCharsRe);
	}	

	/**
	 * Error text to display if the allow blank validation fails (defaults to "This field is required")
	 *
	 * @param string $blankText
	 */
	public function setBlankText($blankText)
	{
		$this->setAttribute('blankText', $blankText);
	}

	/**
	 * A custom validation function to be called during field validation (defaults to null).
	 *
	 * @param function $validator
	 */
	public function setValidator($validator)
	{
		$this->setAttribute('validator', $validator);
	}

	/**
	 * A JavaScript RegExp object to be tested against the field value during validation (defaults to null).
	 *
	 * @param regexp $regex
	 */
	public function setRegex($regex)
	{
		$this->setAttribute('regex', $regex);
	}

	/**
	 * The error text to display if #regex is used and the test fails during
	 *
	 * @param string $regexText
	 */
	public function setRegexText($regexText)
	{
		$this->setAttribute('regexText', $regexText);
	}

	/**
	 * The default text to display in an empty field (defaults to null).
	 *
	 * @param string $emptyText
	 */
	public function setEmptyText($emptyText)
	{
		$this->setAttribute('emptyText', $emptyText);
	}
	
	/**
	 * true to enable the proxying of key events for the HTML input field 
	 * (defaults to false)
	 *
	 * @param boolean $enableKeyEvents
	 */
	public function setEnableKeyEvents($enableKeyEvents)
	{
		$this->setAttribute('enableKeyEvents', $enableKeyEvents);
	}	

	/**
	 * The CSS class to apply to an empty field to style the #emptyText (defaults to
	 *
	 * @param string $emptyClass
	 */
	public function setEmptyClass($emptyClass)
	{
		$this->setAttribute('emptyClass', $emptyClass);
	}

 }