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
 * Site collection holding a collection of website objects.
 *
 * @package		WebTricks_Websites
 * @author		WebTicks Core Team <core@webtricksframework.com>
 */
class WebTricks_Websites_SiteCollection extends Cream_Collection_Iterator
{
	/**
	 * The classname of the default comparer to use.
	 * 
	 * @var string
	 */
	const defaultComparer = 'WebTricks_Websites_SiteComparer';
	
	/**
	 * Create a new instance of this class
	 *
	 * @param array $data
	 * @return WebTricks_Websites_SiteCollection
	 */
	public static function instance($data = null)
	{
		return Cream::instance(__CLASS__, $data);
	}
	
	/**
	 * Sort the site collection
	 * 
	 * @param string $comparer
	 */
	public function sort($comparer)
	{
		usort($this->_data, array($comparer, "compare"));
	}
}