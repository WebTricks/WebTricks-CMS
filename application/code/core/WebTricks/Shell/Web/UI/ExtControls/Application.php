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
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Shell desktop application
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Web_UI_ExtControls_Application extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 *
	 * @return WebTricks_Shell_Web_UI_ExtControls_Application
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function
	 * 
	 */
	public function __init()
	{
		$this->setControl('WebTricks.Shell.Application');
	}
	
	public function setMemberInfo($name, $group)
	{
		$this->setAttribute('memberInfo', array('name' => $name, 'group' => $group));
	}
	
	public function setModules($modules)
	{
		foreach ($modules as $module) {
			$this->addModule($module);
		}
	}
	
	public function addModule($module)
	{
		$this->addAttribute('modules', $module);
	}
	
	public function setDesktopConfig($desktopConfig)
	{
		$this->setAttribute('desktopConfig', $desktopConfig);
	}
	
	public function setConnection($connection)
	{
		$this->setAttribute('connection', $connection);
	}
}