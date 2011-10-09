<?php
/**
 * WebTricks
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
 * Wrapper class around Zend_Date so it will be available withing our
 * custom instance creation.
 *
 * @package		Cream_Date
 * @author		Danny Verkade
 */
class Cream_Date extends Zend_Date
{
	/**
	 * Create a new instance of this class
	 * 
     * @param  string|integer|Zend_Date|array  $date    OPTIONAL Date value or value of date part to set
     *                                                 ,depending on $part. If null the actual time is set
     * @param  string                          $part    OPTIONAL Defines the input format of $date
     * @param  string|Zend_Locale              $locale  OPTIONAL Locale for parsing input
	 * @return Cream_Date
	 */
	public static function instance($date = null, $part = null, $locale = null)
	{
		Cream::instance(__CLASS__, $date, $format, $locale);
	}
	
	/**
	 * Initialize function
	 * 
     * @param  string|integer|Zend_Date|array  $date    OPTIONAL Date value or value of date part to set
     *                                                 ,depending on $part. If null the actual time is set
     * @param  string                          $part    OPTIONAL Defines the input format of $date
     * @param  string|Zend_Locale              $locale  OPTIONAL Locale for parsing input
	 */
	public function __init($date = null, $part = null, $locale = null)
	{
		$this->set($date, $part, $locale);
	}
}