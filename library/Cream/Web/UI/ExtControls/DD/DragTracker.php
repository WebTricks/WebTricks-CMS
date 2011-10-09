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
 * The DragTracker
 * 
 * @package		Cream_Web_UI_ExtControls_DD
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_DD_DragTracker extends Cream_Web_UI_ExtControls_Util_Observable
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_DD_DragTracker
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
		$this->setControl('Ext.dd.DragTracker');
	}

	/**
	 * Defaults to false.
	 *
	 * @param boolean $active
	 */
	public function setActive($active)
	{
		$this->setAttribute('active', $active);
	}	
	
	/**
	 * Defaults to false. Specify true to defer trigger start by 1000 ms. 
	 * Specify a Number for the number of milliseconds to defer trigger start.
	 *
	 * @param boolean|integer $dropAllowed
	 */
	public function setAutoStart($autoStart)
	{
		$this->setAttribute('autoStart', $autoStart);
	}	

	/**
	 * Defaults to 5.
	 *
	 * @param integer $tolerance
	 */
	public function setTolerance($tolerance)
	{
		$this->setAttribute('tolerance', $tolerance);
	}		
}