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
class WebTricks_Shell_Web_UI_ExtControls_Form_DateTimeField extends Cream_Web_UI_ExtControls_Form_Field 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_DateTimeField
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
		$this->setControl('Ext.ux.form.DateTime');
		$this->setAttribute('xtype', 'xdatetime');
	}

	/**
	 * Width of time field in pixels (defaults to 100)
	 *
	 * @param integer $timeWidth
	 */
	public function setTimeWidth($timeWidth)
	{
		$this->setAttribute('timeWidth', $timeWidth);
	}

	/**
	 * Date - Time separator. Used to split date and time (defaults to ' ' (space))
	 *
	 * @param string $dtSeperator
	 */
	public function setDtSeperator($dtSeperator)
	{
		$this->setAttribute('dtSeperator', $dtSeperator);
	}

	/**
	 * Format of datetime used to store value in hidden field
     * and submitted to server (defaults to 'Y-m-d H:i:s' that is mysql format)
	 *
	 * @param string $hiddenFormat
	 */
	public function setHiddenFormat($hiddenFormat)
	{
		$this->setAttribute('hiddenFormat', $hiddenFormat);
	}
	
	/**
	 * Format of DateField. Can be localized. (defaults to 'm/y/d')
	 *
	 * @param string $dateFormat
	 */
	public function setDateFormat($dateFormat)
	{
		$this->setAttribute('dateFormat', $dateFormat);
	}	
	
	/**
	 * Format of TimeField. Can be localized. (defaults to 'g:i A')
	 *
	 * @param string $timeFormat
	 */
	public function setTimeFormat($timeFormat)
	{
		$this->setAttribute('timeFormat', $timeFormat);
	}		
}