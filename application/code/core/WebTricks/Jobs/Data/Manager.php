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
 * Data manager factory for constructing the correct data manager.
 *
 * @package		WebTricks_Jobs
 * @author		Danny Verkade
 */
class WebTricks_Jobs_Data_Manager extends Cream_ApplicationComponent
{
	/**
	 * Factory method for constructing the data manager
	 * 
	 * @param Cream_Config_Xml_Element $config
	 * @return WebTricks_Jobs_Data_Manager_Abstract
	 */
	public static function factory(Cream_Config_Xml_Element $config)
	{
		$className = Cream_Utility::ucWords($config->type);
		$provider = Cream::instance('WebTricks_Jobs_Data_Manager_'. $className, $config);
		
		return $provider;
	}
}