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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Utility class
 *
 * @package		Cream
 * @author		WebTicks Core Team <core@webtricksframework.com>
 */
class Cream_Utility
{
	/**
	 * Tiny function to enhance functionality of ucwords
	 *
	 * Will capitalize first letters and convert separators if needed
	 *
	 * @param string $str
	 * @param string $destSep
	 * @param string $srcSep
	 * @return string
	 */
	public static function ucWords($str, $destSep='_', $srcSep='_')
	{
	    return str_replace(' ', $destSep, ucwords(str_replace($srcSep, ' ', $str)));
	}	
}