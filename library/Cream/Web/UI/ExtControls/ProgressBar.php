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
 * An updateable progress bar component. The progress bar supports two 
 * different modes: manual and automatic.
 * 
 * In manual mode, you are responsible for showing, updating (via 
 * updateProgress) and clearing the progress bar as needed from your own code. 
 * This method is most appropriate when you want to show progress throughout an 
 * operation that has predictable points of interest at which you can update 
 * the control.
 * 
 * In automatic mode, you simply call wait and let the progress bar run 
 * indefinitely, only clearing it once the operation is complete. You can 
 * optionally have the progress bar wait for a specific amount of time and then 
 * clear itself. Automatic mode is most appropriate for timed operations or 
 * asynchronous operations in which you have no need for indicating intermediate 
 * progress.
 * 
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_ProgressBar extends Cream_Web_UI_ExtControls_BoxComponent 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_ProgressBar
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
		$this->setControl('Ext.Resizable');
		$this->setXtype('progressbar');
	}
	
	/**
	 * True to animate the progress bar during transitions (defaults to false)
	 *
	 * @param boolean $animate
	 */
	public function setAnimate($animate) 
	{
		$this->setAttribute('animate', $animate);
	}	
		
	/**
	 * A floating point value between 0 and 1 (e.g., .5, defaults to 0)
	 *
	 * @param float $value
	 */
	public function setValue($value) 
	{
		$this->setAttribute('value', $value);
	}

	/**
	 * The progress bar text (defaults to '')
	 *
	 * @param string $text
	 */
	public function setText($text) 
	{
		$this->setAttribute('text', $text);
	}

	/**
	 * The element to render the progress text to (defaults to the progress 
	 * bar's internal text element)
	 *
	 * @param mixed $textEl
	 */
	public function setTextEl($textEl) 
	{
		$this->setAttribute('textEl', $textEl);
	}

	/**
	 * The progress bar element's id (defaults to an auto-generated id)
	 *
	 * @param string $id
	 */
	public function setId($id) 
	{
		$this->setAttribute('id', $id);
	}

	/**
	 * The base CSS class to apply to the progress bar's wrapper element 
	 * (defaults to 'x-progress')
	 *
	 * @param string $baseCls
	 */
	public function setBaseCls($baseCls) 
	{
		$this->setAttribute('baseCls', $baseCls);
	}
}