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
 * Comparer interface
 * 
 * @package		Cream_Content_Sorting_Comparer
 * @author 		Danny Verkade
 */
interface Cream_Content_Sorting_ComparerInterface 
{
	/**
	 * Compare the two content items.
	 * 
	 * @param Cream_Content_Item $item1
	 * @param Cream_Content_Item $item2
	 * @return boolean
	 */
	public static function compare($item1, $item2);	
}