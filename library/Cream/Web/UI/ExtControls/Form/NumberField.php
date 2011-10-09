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
 * Numeric text field that provides automatic keystroke filtering and
 * numeric validation.
 * 
 * @package		Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_NumberField extends Cream_Web_UI_ExtControls_Form_TextField 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_NumberField
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
		$this->setControl('Ext.form.NumberField');
		$this->setAttribute('xtype', 'numberfield');
	}		
	
	/**
	 * The default CSS class for the field (defaults to "x-form-field x-form-num-field")
	 *
	 * @param string $fieldClass
	 */
	public function setFieldClass($fieldClass)
	{
		$this->setAttribute('fieldClass', $fieldClass);
	}

	/**
	 * False to disallow decimal values (defaults to true)
	 *
	 * @param boolean $allowDecimals
	 */
	public function setAllowDecimals($allowDecimals)
	{
		$this->setAttribute('allowDecimals', $allowDecimals);
	}

	/**
	 * Character(s) to allow as the decimal separator (defaults to '.')
	 *
	 * @param string $decimalSeparator
	 */
	public function setDecimalSeparator($decimalSeparator)
	{
		$this->setAttribute('decimalSeparator', $decimalSeparator);
	}

	/**
	 * The maximum precision to display after the decimal separator (defaults 
	 * to 2)
	 *
	 * @param number $decimalPrecision
	 */
	public function setDecimalPrecision($decimalPrecision)
	{
		$this->setAttribute('decimalPrecision', $decimalPrecision);
	}

	/**
	 * False to prevent entering a negative sign (defaults to true)
	 *
	 * @param boolean $allowNegative
	 */
	public function setAllowNegative($allowNegative)
	{
		$this->setAttribute('allowNegative', $allowNegative);
	}

	/**
	 * The minimum allowed value (defaults to Number.NEGATIVE_INFINITY)
	 *
	 * @param number $minValue
	 */
	public function setMinValue($minValue)
	{
		$this->setAttribute('minValue', $minValue);
	}

	/**
	 * The maximum allowed value (defaults to Number.MAX_VALUE)
	 *
	 * @param number $maxValue
	 */
	public function setMaxValue($maxValue)
	{
		$this->setAttribute('maxValue', $maxValue);
	}

	/**
	 * Error text to display if the minimum value validation fails (defaults to
	 * "The minimum value for this field is {minValue}")
	 *
	 * @param string $minText
	 */
	public function setMinText($minText)
	{
		$this->setAttribute('minText', $minText);
	}

	/**
	 * Error text to display if the maximum value validation fails (defaults to
	 * "The maximum value for this field is {maxValue}")
	 *
	 * @param string $maxText
	 */
	public function setMaxText($maxText)
	{
		$this->setAttribute('maxText', $maxText);
	}

	/**
	 * Error text to display if the value is not a valid number. For example,
	 * this can happen.
	 *
	 * @param string $nanText
	 */
	public function setNanText($nanText)
	{
		$this->setAttribute('nanText', $nanText);
	}

	/**
	 * The base set of characters to evaluate as valid numbers (defaults to
	 * '0123456789').
	 *
	 * @param string $baseChars
	 */
	public function setBaseChars($baseChars)
	{
		$this->setAttribute('baseChars', $baseChars);
	}
}