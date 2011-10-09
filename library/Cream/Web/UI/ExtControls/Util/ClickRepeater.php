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
 * A wrapper class which can be applied to any element. Fires a "click" event 
 * while the mouse is pressed. The interval between firings may be specified 
 * in the config but defaults to 20 milliseconds. Optionally, a CSS class may 
 * be applied to the element during the time it is pressed.
 * 
 * @package 	Cream_Web_UI_ExtControls_Util
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Util_ClickRepeater extends Cream_Web_UI_ExtControls_Util_Observable
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Util_ClickRepeater
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
		
	/**
	 * Initialize function, set the Ext JS control
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.util.ClickRepeater');
	}	
	
	/**
	 * True if autorepeating should start slowly and accelerate. "interval" and 
	 * "delay" are ignored.
	 * 	 
	 * @param boolean $accelerate
	 */
	public function setAccelerate($accelerate)
	{
		$this->setAttribute('accelerate', $accelerate);		
	}
	
	/**
	 * The initial delay before the repeating event begins firing. Similar to an 
	 * autorepeat key delay.
	 * 	 
	 * @param integer $delay
	 */
	public function setDelay($delay)
	{
		$this->setAttribute('delay', $delay);		
	}

	/**
	 * The element to act as a button.
	 * 	 
	 * @param mixed $el
	 */
	public function setEl($el)
	{
		$this->setAttribute('el', $el);		
	}

	/**
	 * The interval between firings of the "click" event. Default 20 ms.
	 * 	 
	 * @param integer $interval
	 */
	public function setInterval($interval)
	{
		$this->setAttribute('interval', $interval);		
	}

	/**
	 * A CSS class name to be applied to the element while pressed.
	 * 	 
	 * @param string $pressClass
	 */
	public function setPressClass($pressClass)
	{
		$this->setAttribute('pressClass', $pressClass);		
	}

	/**
	 * True to prevent the default click event
	 * 	 
	 * @param boolean $preventDefault
	 */
	public function setPreventDefault($preventDefault)
	{
		$this->setAttribute('preventDefault', $preventDefault);		
	}

	/**
	 * True to stop the default click event
	 * 	 
	 * @param boolean $stopDefault
	 */
	public function setStopDefault($stopDefault)
	{
		$this->setAttribute('stopDefault', $stopDefault);		
	}	
}