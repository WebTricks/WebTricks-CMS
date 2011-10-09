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
 * A popup date picker. This class is used by the DateField class to allow 
 * browsing and selection of valid dates. All the string values documented 
 * below may be overridden by including an Ext locale file in your page.
 * 
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_DatePicker extends Cream_Web_UI_ExtControls_Component 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_DatePicker
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
		$this->setControl('Ext.DatePicker');
		$this->setAttribute('xtype', 'datepicker');
	}
	
	/**
	 * The text to display on the button that selects the current date 
	 * (defaults to 'Today')
	 *
	 * @param string $todayText
	 */
	public function setTodayText($todayText) 
	{
		$this->setAttribute('todayText', $todayText);
	}

	/**
	 * The text to display on the ok button (defaults to ' OK ' to give the 
	 * user extra clicking room)
	 *
	 * @param string $okText
	 */
	public function setOkText($okText) 
	{
		$this->setAttribute('okText', $okText);
	}

	/**
	 * The text to display on the cancel button (defaults to 'Cancel')
	 *
	 * @param string $cancelText
	 */
	public function setCancelText($cancelText) 
	{
		$this->setAttribute('cancelText', $cancelText);
	}

	/**
	 * A string used to format the message for displaying in a tooltip over the 
	 * button that selects the current date. Defaults to '{0} (Spacebar)' where 
	 * the {0} token is replaced by today's date.
	 *
	 * @param string $todayTip
	 */
	public function setTodayTip($todayTip) 
	{
		$this->setAttribute('todayTip', $todayTip);
	}

	/**
	 * Minimum allowable date (JavaScript date object, defaults to null)
	 *
	 * @param date $minDate
	 */
	public function setMinDate($minDate) 
	{
		$this->setAttribute('minDate', $minDate);
	}

	/**
	 * Maximum allowable date (JavaScript date object, defaults to null)
	 *
	 * @param date $maxDate
	 */
	public function setMaxDate($maxDate) 
	{
		$this->setAttribute('maxDate', $maxDate);
	}

	/**
	 * The error text to display if the minDate validation fails (defaults to 
	 * 'This date is before the minimum date')
	 *
	 * @param string $minText
	 */
	public function setMinText($minText) 
	{
		$this->setAttribute('minText', $minText);
	}

	/**
	 * The error text to display if the maxDate validation fails (defaults to 
	 * 'This date is after the maximum date')
	 *
	 * @param string $maxText
	 */
	public function setMaxText($maxText) 
	{
		$this->setAttribute('maxText', $maxText);
	}

	/**
	 * The default date format string which can be overriden for localization 
	 * support. The format must be valid according to Date.parseDate (defaults 
	 * to 'm/d/y').
	 *
	 * @param string $format
	 */
	public function setFormat($format) 
	{
		$this->setAttribute('format', $format);
	}
	
	/**
	 * A function that will handle the select event of this picker. The handler 
	 * is passed the following parameters:
	 * - picker : DatePicker
	 *   This DatePicker.
	 * - date : Date
	 *   The selected date.
	 *
	 * @param function $handler
	 */
	public function setHandler($handler) 
	{
		$this->setAttribute('handler', $handler);
	}	

	/**
	 * An array of days to disable, 0-based. For example, [0, 6] disables 
	 * Sunday and Saturday (defaults to null).
	 * 
	 * @param array $disabledDays
	 */
	public function setDisabledDays($disabledDays) 
	{
		$this->setAttribute('disabledDays', $disabledDays);
	}

	/**
	 * The tooltip to display when the date falls on a disabled day (defaults 
	 * to 'Disabled')
	 *
	 * @param string $disabledDaysText
	 */
	public function setDisabledDaysText($disabledDaysText) 
	{
		$this->setAttribute('disabledDaysText', $disabledDaysText);
	}

	/**
	 * JavaScript regular expression used to disable a pattern of dates 
	 * (defaults to null). The disabledDates config will generate this regex 
	 * internally, but if you specify disabledDatesRE it will take precedence 
	 * over the disabledDates value.
	 *
	 * @param regexp $disabledDatesRE
	 */
	public function setDisabledDatesRE($disabledDatesRE) 
	{
		$this->setAttribute('disabledDatesRE', $disabledDatesRE);
	}

	/**
	 * The tooltip text to display when the date falls on a disabled date 
	 * (defaults to 'Disabled')
	 *
	 * @param string $disabledDatesText
	 */
	public function setDisabledDatesText($disabledDatesText) 
	{
		$this->setAttribute('disabledDatesText', $disabledDatesText);
	}

	/**
	 * An array of 'dates' to disable, as strings. These strings will be used 
	 * to build a dynamic regular expression so they are very powerful.
	 *  
	 * @param array $disabledDates
	 */
	public function setDisabledDates($disabledDates) 
	{
		$this->setAttribute('disabledDates', $disabledDates);
	}

	/**
	 * An array of textual month names which can be overriden for localization 
	 * support (defaults to Date.monthNames)
	 *
	 * @param array $monthNames
	 */
	public function setMonthNames($monthNames) 
	{
		$this->setAttribute('monthNames', $monthNames);
	}

	/**
	 * An array of textual day names which can be overriden for localization 
	 * support (defaults to Date.dayNames)
	 *
	 * @param array $dayNames
	 */
	public function setDayNames($dayNames) 
	{
		$this->setAttribute('dayNames', $dayNames);
	}

	/**
	 * The next month navigation button tooltip (defaults to 'Next Month 
	 * (Control+Right)')
	 *
	 * @param string $nextText
	 */
	public function setNextText($nextText) 
	{
		$this->setAttribute('nextText', $nextText);
	}

	/**
	 * The previous month navigation button tooltip (defaults to 'Previous 
	 * Month (Control+Left)')
	 *
	 * @param string $prevText
	 */
	public function setPrevText($prevText) 
	{
		$this->setAttribute('prevText', $prevText);
	}

	/**
	 * The header month selector tooltip (defaults to 'Choose a month 
	 * (Control+Up/Down to move years)')
	 *
	 * @param string $monthYearText
	 */
	public function setMonthYearText($monthYearText) 
	{
		$this->setAttribute('monthYearText', $monthYearText);
	}

	/**
	 * Day index at which the week should begin, 0-based (defaults to 0, which
	 * is Sunday)
	 *
	 * @param number $startDay
	 */
	public function setStartDay($startDay) 
	{
		$this->setAttribute('startDay', $startDay);
	}
	
	/**
	 * False to hide the footer area containing the Today button and disable 
	 * the keyboard handler for spacebar that selects the current date 
	 * (defaults to true).
	 *
	 * @param boolean $showToday
	 */
	public function setShowToday($showToday) 
	{
		$this->setAttribute('showToday', $showToday);
	}	
}