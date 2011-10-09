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
 * Repository data manager, retrieves website data from the content
 * repository.
 *
 * @package		Cream_Websites
 * @author		WebTicks Core Team <core@webtricksframework.com>
 */
class Cream_Websites_Data_Manager_Repository extends Cream_Websites_Data_Manager_Abstract
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Websites_Data_Manager_Repository
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Adds websites from the repository to the site collection.
	 * 
	 * @param Cream_Websites_SiteCollection $siteCollection
	 */		
	public function addSites($siteCollection)
	{
		
	}
}