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
 * Collection of cultures
 *
 * @package		Cream_Globalization
 * @author		Danny Verkade
 */
class Cream_Globalization_CultureCollection extends Cream_Collection_Iterator
{
	/**
	 * Create a new instance of this class
	 * 
	 * @param array $data
	 * @return Cream_Globalization_CultureCollection
	 */
	public static function instance($data = null) 
	{
		return Cream::instance(__CLASS__, $data);		
	}
}