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
 * Represents a date field
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Fields_DateField extends Cream_Content_Fields_CustomField
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @param string $fieldName
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Fields_DateField
	 */
	public static function instance($fieldName, $item)
	{
		return Cream::instance(__CLASS__, $fieldName, $item);
	}	
	
	/**
	 * Returns the value as an Date object
	 * 
	 * @return Cream_Date
	 */
	public function getDate()
	{
		return Cream_Date::instance($this->getValue());
	}
}