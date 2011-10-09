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
 * Base class for website data managers.
 *
 * @package		Cream_Websites
 * @author		WebTicks Core Team <core@webtricksframework.com>
 */
abstract class Cream_Websites_Data_Manager_Abstract extends Cream_ApplicationComponent
{
	/**
	 * Adds websites to the site collection
	 * 
	 * @param Cream_Websites_SiteCollection $siteCollection
	 */
	abstract public function addSites($siteCollection);
	
	/**
	 * Builds a site object and returns it.
	 * 
	 * @param object $siteInfo
	 * @param Cream_Websites_Site
	 */
	protected function _buildSite($siteInfo)
	{
		$domain = Cream_Security_Managers_DomainProvider::getDomain((string) $siteInfo->domain); 	
		
		$site = Cream_Websites_Site::instance();	
		$site->setContentRepositoryName((string) $siteInfo->content_repository);
		$site->setCultureName((string) $siteInfo->culture);
		$site->setHost((string) $siteInfo->host);
		$site->setName((string) $siteInfo->name);
		$site->setPath((string) $siteInfo->path);
		$site->setPort((string) $siteInfo->port);
		$site->setRepositoryName((string) $siteInfo->repository);
		$site->setRootPath((string) $siteInfo->rootPath);
		$site->setRouterName((string) $siteInfo->router);
		$site->setDomain($domain);
		
		return $site;
	}
}