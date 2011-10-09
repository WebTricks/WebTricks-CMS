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
 * Holds all Cream_Data_Row objects which represent the complete result set of
 * a query.
 *
 * @package		Cream_Data
 * @author		Danny Verkade
 */
class Cream_Data_RowCollection extends Cream_Collection_Iterator
{
	/**
	 * Create an instance of this class
	 *
	 * @return Cream_Data_RowCollection
	 */
	public static function instance($data = null)
	{
		return Cream::instance(__CLASS__, $data);
	}

	/**
	 * Get a specific row number, returns Cream_Data_Row when a row is found,
	 * returns null when row number is not found.
	 *
	 * @param integer $rowNumber
	 * @return Cream_Data_Row
	 */
	public function getRow($rowNumber)
	{
		if (isset($this->_data[$rowNumber])) {
			return $this->_data[$rowNumber];
		} else {
			return null;
		}
	}
}