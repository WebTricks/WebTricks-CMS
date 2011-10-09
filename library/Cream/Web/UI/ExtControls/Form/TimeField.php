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
 * Provides a time input field with a time dropdown and automatic time 
 * validation.
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_TimeField extends Cream_Web_UI_ExtControls_Form_ComboBox 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_TimeField
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
		$this->setControl('Ext.form.TimeField');
		$this->setAttribute('xtype', 'timefield');
	}	
	
	/**
	 * 
	 *
	 * @param date/string $minValue
	 */
	public function setMinValue($minValue)
	{
		$this->setAttribute('minValue', $minValue);
	}

	/**
	 * 
	 *
	 * @param date/string $maxValue
	 */
	public function setMaxValue($maxValue)
	{
		$this->setAttribute('maxValue', $maxValue);
	}

	/**
	 * 
	 *
	 * @param string $minText
	 */
	public function setMinText($minText)
	{
		$this->setAttribute('minText', $minText);
	}

	/**
	 * 
	 *
	 * @param string $maxText
	 */
	public function setMaxText($maxText)
	{
		$this->setAttribute('maxText', $maxText);
	}

	/**
	 * The error text to display when the time in the field is invalid (defaults 
	 * to '{value} is not a valid time').
	 *
	 * @param string $invalidText
	 */
	public function setInvalidText($invalidText)
	{
		$this->setAttribute('invalidText', $invalidText);
	}

	/**
	 * The default time format string which can be overriden for localization 
	 * support. The format must be valid according to Date.parseDate (defaults 
	 * to 'g:i A', e.g., '3:15 PM'). For 24-hour time format try 'H:i' instead.
	 *
	 * @param string $format
	 */
	public function setFormat($format)
	{
		$this->setAttribute('format', $format);
	}

	/**
	 * Multiple date formats separated by "|" to try when parsing a user input 
	 * value and it doesn't match the defined format (defaults to 
	 * 'g:ia|g:iA|g:i a|g:i A|h:i|g:i|H:i|ga|ha|gA|h a|g a|g A|gi|hi|gia|hia|g|H').
	 *
	 * @param string $altFormats
	 */
	public function setAltFormats($altFormats)
	{
		$this->setAttribute('altFormats', $altFormats);
	}

	/**
	 * The number of minutes between each time value in the list (defaults to 
	 * 15).
	 *
	 * @param number $increment
	 */
	public function setIncrement($increment)
	{
		$this->setAttribute('increment', $increment);
	}
} 