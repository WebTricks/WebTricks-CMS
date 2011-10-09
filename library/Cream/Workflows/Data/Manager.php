<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * The data manager class, for creating the correct data manager.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Workflows_Data_Manager
{
	/**
	 * Factory method for constructing the data manager
	 * 
	 * @param Cream_Config_Xml_Element $config
	 * @return Cream_Workflows_Data_Manager_Abstract
	 */
	public static function factory(Cream_Config_Xml_Element $config)
	{
		$className = Cream_Utility::ucWords($config->type);
		$manager = Cream::instance('Cream_Workflows_Data_Manager_'. $className, $config);
		
		return $manager;
	}	
}