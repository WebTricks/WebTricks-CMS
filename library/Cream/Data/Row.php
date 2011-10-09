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
 * Holds a representation of a database row in the result set of a query
 *
 * @package		Cream_Data
 * @author		Danny Verkade
 */
class Cream_Data_Row
{
	/**
	 * @var array
	 */
	protected $_data = array();

	/**
	 * Initialize function
	 *
	 * @param array $data
	 */
	public function __init($data) 
	{
		$this->_data = $data;
	}

	/**
	 * Create an instance of this class, representing a database row.
	 *
	 * @param array $data
	 * @return Cream_Data_Row
	 */
	public static function instance($data)
	{
		return Cream::instance(__CLASS__, $data);
	}

	/**
	 * Returns the value of a column
	 *
	 * @param string $column
	 * @return mixed
	 */
	public function __get($column)
	{
		return $this->_data[$column];
	}

	/**
	 * Sets the value of a column in a row.
	 *
	 * @param string $column
	 * @param mixed $value
	 */
	public function __set($column, $value)
	{
		$this->_data[$column] = $value;
	}

	/**
	 * Check to see if a column exists
	 *
	 * @param string $column
	 * @return boolean
	 */
	public function __isset($column)
	{
		return array_key_exists($column, $this->_data);
	}

	/**
	 * Returns to row as an array
	 *
	 * @return array
	 */
	public function toArray()
	{
		return $this->_data;
	}
}