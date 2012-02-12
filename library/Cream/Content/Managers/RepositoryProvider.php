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
 * @copyright Copyright (c) 2007-2012 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * The repository provider
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Managers_RepositoryProvider
{
	/**
	 * Repository manager
	 *  
	 * @var Cream_Content_Managers_RepositoryManager
	 */
	protected static $_manager = null;
	
	/**
	 * Gets the repository given by the name.
	 * 
	 * @return Cream_Content_Repository
	 */
	public static function getRepository($name)
	{
		return self::_getManager()->getRepository($name);
	}
	
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Content_Managers_RepositoryManager
	 */
	protected static function _getManager()
	{
		if (!self::$_manager) {
			self::$_manager = Cream_Content_Managers_RepositoryManager::instance();
		}		
		
		return self::$_manager;
	}
}