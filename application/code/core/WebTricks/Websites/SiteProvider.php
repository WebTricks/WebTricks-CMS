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
 * Site provider. Static class for returning site objects.
 *
 * @package		WebTricks_Websites
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class WebTricks_Websites_SiteProvider
{
	/**
	 * Holds an instance of the site manager.
	 * 
	 * @var Cream_Content_Managers_TemplateManager
	 */
	protected static $_manager = null;	
	
	/**
	 * Returns a website by the given name. If no site is found, 
	 * returns null.
	 * 
	 * @param string $name
	 * @return WebTricks_Websites_Site
	 */
	public static function getSite($name)
	{
		return self::_getManager()->getSite($name);
	}
	
	/**
	 * Returns a website by the given hostname, port and path. If no
	 * site if found, returns null.
	 * 
	 * @param string $host
	 * @param integer $port
	 * @param string $path
	 */
	public static function getSiteFromHost($host, $port, $path)
	{
		return self::_getManager()->getSiteFromHost($host, $port, $path);
	}
	
	/**
	 * Returns the site manager
	 * 
	 * @return WebTricks_Websites_SiteManager
	 */
	protected static function _getManager()
	{
		if (!self::$_manager) {
			self::$_manager = WebTricks_Websites_SiteManager::instance();
		}		
		
		return self::$_manager;
	}		
}