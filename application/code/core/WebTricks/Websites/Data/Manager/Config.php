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
 * Config data manager, retrieves website data from the config file.
 *
 * @package		WebTricks_Websites
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class WebTricks_Websites_Data_Manager_Config extends WebTricks_Websites_Data_Manager_Abstract
{
	/**
	 * Path to the website in the config file.
	 * 
	 * @var string
	 */
	const CONFIG_PATH_SITES = 'global/websites';

	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Websites_Data_Manager_Config
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Adds websites from the config to the site collection.
	 * 
	 * @param WebTricks_Websites_SiteCollection $siteCollection
	 */	
	public function addSites($siteCollection)
	{
		$config = $this->_getApplication()->getConfig()->getNode(self::CONFIG_PATH_SITES);
		
		if ($config) {
			foreach($config->children() as $siteInfo) {
				if ($siteInfo->getName() == 'site') {
					$site = $this->_buildSite($siteInfo);
					$siteCollection->add($site);
				}
			}
		}
	}
}