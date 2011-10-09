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
 * Represents a version number of an item. 
 * 
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Version 
{
	/**
	 * Version constants 
	 */
	const INVALID = -1;
	const LATEST = 0;
	const FIRST = 1;
	
	/**
	 * The version number
	 * 
	 * @var integer
	 */
	protected $number;
	
	/**
	 * Version object of the first version
	 * 
	 * @var Cream_Content_Version
	 */
	protected static $first;
	
	/**
	 * Version object of the invalid version
	 * 
	 * @var Cream_Content_Version
	 */
	protected static $invalid;

	/**
	 * Version object of the latest version
	 * 
	 * @var Cream_Content_Version
	 */
	protected static $latest;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param integer $version
	 */
	public static function instance($version)
	{
		return Cream::instance(__CLASS__, $version);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param integer $version
	 */
	public function __init($version)
	{
		$this->number = $version;
	}
	
	/**
	 * Returns the version number
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return (string)$this->number;
	}
	
	/**
	 * Returns the version number
	 * 
	 * @return integer
	 */
	public function getNumber()
	{
		return $this->number;
	}
	
	/**
	 * Gets the first version number. 
	 * 
	 * @return Cream_Content_Version
	 */
	public static function getFirst()
	{
		if (!self::$first) {
			self::$first = Cream_Content_Version::instance(1);	
		}		
		
		return self::$first;
	}
	
	/**
	 * Gets the invalid version number. 
	 * 
	 * @return Cream_Content_Version
	 */
	public static function getInvalid()
	{
		if (!self::$invalid) {
			self::$invalid = Cream_Content_Version::instance(-1);	
		}
		
		return self::$invalid;		
	}
	
	/**
	 * Gets the latest number. 
	 * 
	 * @return Cream_Content_Version
	 */
	public static function getLatest()
	{
		if (!self::$latest) {
			self::$latest = Cream_Content_Version::instance(0);	
		}
		
		return self::$latest;
	}
}