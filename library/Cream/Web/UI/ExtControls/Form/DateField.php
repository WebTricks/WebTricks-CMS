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
 * Provides a date input field with a Ext.DatePicker dropdown and automatic 
 * date validation.
 * 
 * @package		Cream_Web_UI_ExtControls_From
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_DateField extends Cream_Web_UI_ExtControls_Form_TriggerField 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_DateField
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
		$this->setControl('Ext.form.DateField');
		$this->setAttribute('xtype', 'datefield');
	}	
	
	/**
	 * The default date format string which can be overriden for localization support. 
	 * The format must be valid according to Date.parseDate (defaults to 'm/d/Y'). 
	 *
	 * @param string $format
	 */
	public function setFormat($format)
	{
		$this->setAttribute('format', $format);
	}

	/**
	 * Multiple date formats separated by "|" to try when parsing a user input value and it 
	 * doesn't match the defined format (defaults to 
	 * 'm/d/Y|n/j/Y|n/j/y|m/j/y|n/d/y|m/j/Y|n/d/Y|m-d-y|m-d-Y|m/d|m-d|md|mdy|mdY|d|Y-m-d'). 
	 *
	 * @param string $altFormats
	 */
	public function setAltFormats($altFormats)
	{
		$this->setAttribute('altFormats', $altFormats);
	}

	/**
	 * An array of days to disable, 0 based. For example, [0, 6] disables Sunday and Saturday 
	 * (defaults to null). 
	 *
	 * @param array $disabledDays
	 */
	public function setDisabledDays($disabledDays)
	{
		$this->setAttribute('disabledDays', $disabledDays);
	}

	/**
	 * The tooltip text to display when the date falls on a disabled date (defaults to 'Disabled') 
	 *
	 * @param string $disabledDaysText
	 */
	public function setDisabledDaysText($disabledDaysText)
	{
		$this->setAttribute('disabledDaysText', $disabledDaysText);
	}

	/**
	 * An array of "dates" to disable, as strings. These strings will be used to build a dynamic regular
	 * expression so they are very powerful. Some examples: 
	 * ["03/08/2003", "09/16/2003"] would disable those exact dates
	 * ["03/08", "09/16"] would disable those days for every year
	 * ["^03/08"] would only match the beginning (useful if you are using short years)
	 * ["03/../2006"] would disable every day in March 2006
	 * ["^03"] would disable every day in every March
	 * In order to support regular expressions, if you are using a date format that has "." in it, you 
	 * will have to escape the dot when restricting dates. For example: ["03\\.08\\.03"]. 
	 *
	 * @param array $disabledDates
	 */
	public function setDisabledDates($disabledDates)
	{
		$this->setAttribute('disabledDates', $disabledDates);
	}

	/**
	 * The tooltip text to display when the date falls on a disabled date (defaults to 'Disabled') 
	 *
	 * @param string $disabledDatesText
	 */
	public function setDisabledDatesText($disabledDatesText)
	{
		$this->setAttribute('disabledDatesText', $disabledDatesText);
	}

	/**
	 * The minimum allowed date. Can be either a Javascript date object or a string date in a valid 
	 * format (defaults to null). 
	 *
	 * @param date/string $minValue
	 */
	public function setMinValue($minValue)
	{
		$this->setAttribute('minValue', $minValue);
	}

	/**
	 * The maximum allowed date. Can be either a Javascript date object or a string date in a valid 
	 * format (defaults to null). 
	 *
	 * @param date/string $maxValue
	 */
	public function setMaxValue($maxValue)
	{
		$this->setAttribute('maxValue', $maxValue);
	}

	/**
	 * The error text to display when the date in the cell is before minValue (defaults to 'The date 
	 * in this field must be after {minValue}'). 
	 *
	 * @param string $minText
	 */
	public function setMinText($minText)
	{
		$this->setAttribute('minText', $minText);
	}

	/**
	 * The error text to display when the date in the cell is after maxValue (defaults to 'The date 
	 * in this field must be before {maxValue}'). 
	 *
	 * @param string $maxText
	 */
	public function setMaxText($maxText)
	{
		$this->setAttribute('maxText', $maxText);
	}

	/**
	 * The error text to display when the date in the field is invalid (defaults to '{value} is not a
	 * valid date - it must be in the format {format}'). 
	 *
	 * @param string $invalidText
	 */
	public function setInvalidText($invalidText)
	{
		$this->setAttribute('invalidText', $invalidText);
	}

	/**
	 * A DomHelper element spec, or true for a default element spec (defaults to {tag: "input", 
	 * type: "text", size: "10", autocomplete: "off"}) 
	 *
	 * @param string/object $autoCreate
	 */
	public function setAutoCreate($autoCreate)
	{
		$this->setAttribute('autoCreate', $autoCreate);
	}
	
	/**
	 * false to hide the footer area of the DatePicker containing the Today 
	 * button and disable the keyboard handler for spacebar that selects the 
	 * current date (defaults to true).
	 * 
	 * @param boolean $showToday
	 */
	public function setShowToday($showToday)
	{
		$this->setAttribute('showToday', $showToday);
	}	
}