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
 * The ApplicationComponent class is the base class for all components that are
 * application-related, such as controllers, modules, services, etc. The class
 * gives access to the application instance.
 *
 * @package		Cream
 * @author		Danny Verkade
 */
abstract class Cream_ApplicationComponent extends Cream_Component
{
	/**
	 * Returns the application instance
	 *
	 * @return Cream_Application
	 */
	protected function getApplication() 
	{
		return Cream::getApplication();
	}
}