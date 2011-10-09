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
 * Site manager class. Manages the retrieval of websites.
 *
 * @package		Cream_Websites
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Websites_SiteManager extends Cream_ApplicationComponent
{
	/**
	 * Collection of the defined websites.
	 * 
	 * @var Cream_Websites_SiteCollection
	 */
	protected $_sites;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Websites_SiteManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Get a website by the name of the site.
	 * 
	 * @param string $name
	 */
	public function getSite($name)
	{
		foreach ($this->getSites() as $site) {
			if ($site->getName == $name) {
				return $site;
			}
		}
	}
	
	/**
	 * Retrieves a site from the given host.
	 * 
	 * @param string $host
	 * @param integer $port
	 * @param string $path
	 * @return Cream_Websites_Site
	 */
	public function getSiteFromHost($host, $port, $path)
	{
		foreach ($this->getSites() as $site) {
			if ($site->matches($host, $port, $path)) {
				return $site;
			}
		}
	}
	
	/**
	 * Returns the collection of sites.
	 * 
	 * @return Cream_Websites_SiteCollection
	 */
	public function getSites()
	{
		if (!$this->_sites) {
			$this->_sites = Cream_Websites_SiteCollection::instance();
			$this->_addSitesFromConfig();
			$this->_addSitesFromRepository();
			//$this->_sites->sort($comparer)		
		}
		
		return $this->_sites;
	}	
	
	/**
	 * Adds websites to the website collection based on the config.
	 * 
	 * @return void
	 */
	protected function _addSitesFromConfig()
	{
		$manager = Cream_Websites_Data_Manager_Config::instance();
		$manager->addSites($this->_sites);
	}
	
	/**
	 * Adds websites to the site collection based on the repository.
	 * 
	 * @return void
	 */
	protected function _addSitesFromRepository()
	{
		$manager = Cream_Websites_Data_Manager_Repository::instance();
		$manager->addSites($this->_sites);
	}
}