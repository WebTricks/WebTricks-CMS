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
 * Class representation of the globally unique identifier or GUID, a 
 * special type of identifier used in software applications in order 
 * to provide a reference number which is unique in any context.
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class Cream_Guid extends Cream_ApplicationComponent
{
	/**
	 * @var array
	 */
	protected $_bytes;
	
	protected $_string;

	/**
	 * @var Cream_Guid
	 */
	protected static $_emptyGuid;

	/**
	 * Create an instance of this class
	 *
	 * @param array $bytes
	 * @return Cream_Guid
	 */
	public static function instance($bytes)
	{
		return Cream::instance(__CLASS__, $bytes);
	}	
	
	/**
	 * Constructs a new Guid instance given its underlying value as a byte
	 * array.
	 *
	 * @param array $bytes a 16 element byte array.
	 */
	function __init($bytes)
	{
		if (!is_array($bytes) || count($bytes) != 16) {
			throw new Cream_Exceptions_Exception("The argument must be a 16 element byte array");
		}
		for ($i = 0; $i < 16; $i++) {
			$b = $bytes[$i];
			if ((string)(int)$b !== (string)$b || $b < 0 || $b > 255) {
				throw new Cream_Exceptions_Exception("Value other than a byte at offset {$i}");
			}
		}
		$this->_bytes = $bytes;
	}

	/**
	 * Returns a Guid object that has all its bits set to zero.
	 *
	 * @return Cream_Guid a nil Guid.
	 * @static
	 */
	public static function emptyGuid()
	{
		//if (!self::_emptyGuid) {
		//	self::_emptyGuid = Cream_Guid::instance(array_pad(array(), 16, 0));
		//}
		return Cream_Guid::instance(array_pad(array(), 16, 0));
	}

	/**
	 * Returns a new, pseudo-randomly generated Guid object.
	 *
	 * @return Cream_Guid a new Guid object.
	 */
	public static function generateGuid()
	{
		$bytes = array();
		for ($i = 0; $i < 16; $i++) {
			if ($i == 6) { // Version field (version 4)
				$b = mt_rand(0, 15) | 64;
			} else if ($i == 8) { // Variant field (type 2)
				$b = mt_rand(0, 63) | 128;
			} else {
				$b = mt_rand(0, 255);
			}
			$bytes[] = $b;
		}
		return Cream_Guid::instance($bytes);
	}

	/**
	 * Parses a Guid object from the specified 32 character hexadecimal
	 * string. Returns null if the string could not be parsed.
	 *
	 * @param string $str the string representation of a Guid.
	 * @return Cream_Guid a Guid object parsed from its string representation.
	 */
	public static function parseGuid($str)
	{
		$guid = null;
		$str = str_replace(array('{', '(', '-', ')', '}'), '', $str);
		if (strlen($str) == 32) {
			$bytes = array();
			for ($i = 1; $i <= 32; $i++) {
				$ch = $str{$i - 1};
				if (($ch < '0' || $ch > '9')
					  && ($ch < 'a' || $ch > 'f')
					  && ($ch < 'A' || $ch > 'F')) {
					break;
				}
				$n = hexdec($ch);
				if ($i % 2 != 0) {
					$b = $n;
				} else {
					$bytes[] = $b * 16 + $n;
				}
			}
			if (count($bytes) == 16) {
				$guid = Cream_Guid::instance($bytes);
			}
		}

		return $guid;
	}
	
	/**
	 * Checks if the given string is a valid GUID. If it is, returns
	 * true, otherwise false
	 * 
	 * @param string $guid
	 * @return boolean
	 */
	public static function isGuid($guid)
	{
		if (self::parseGuid($guid)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns a string representation of this Guid object.
	 *
	 * @return string a string in the format
	 *  "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx", where "x" is a
	 *  hexadecimal digit.
	 */
	public function toString()
	{
		if (!$this->_string) {
			$str = '';
			for ($i = 1; $i <= 16; $i++) {
				$b = $this->_bytes[$i - 1];
				if ($b < 16) {
					$str .= '0';
				}
				$str .= dechex($b);
				if ($i == 4 || $i == 6 || $i == 8 || $i == 10) {
					$str .= '-';
				}
			}
			$this->_string = $str;
		}
		
		return $this->_string;
	}

	/**
	 * Returns a string representation of this Guid object.
	 *
	 * @return string a string in the format
	 *  "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx", where "x" is a
	 *  hexadecimal digit.
	 */
	public function __toString()
	{
		return $this->toString();
	}

	/**
	 * Returns a 16 element byte array containing the underlying value of
	 * this Guid object.
	 *
	 * @return array
	 */
	public function toByteArray()
	{
		return $this->bytes;
	}
}