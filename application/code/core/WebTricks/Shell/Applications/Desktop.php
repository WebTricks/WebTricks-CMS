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
class WebTricks_Shell_Applications_Desktop extends Cream_ApplicationComponent
{
	const APPLICATION = '7e0d2319-bf15-4e12-831e-322fafaaa981';
	
	const APPLICATION_FOLDER = 'e49d8005-0305-471a-898b-f82f579fc599';
	
	const FOLDER = '5c321d23-6ab4-4276-bc19-a93b14299ed3';
	
	/**
	 * Repository path of applications  
	 * 
	 * @var string
	 */
	const REPOSITORY_PATH_APPLICATION = 'webtricks/content/applications';
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return WebTricks_Shell_Applications_Desktop
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function getDesktop()
	{
		$repository = $this->_getApplication()->getContext()->getRepository();
		$startMenuItem = $repository->getItemByPath('webtricks/content/documents and settings/all users/start menu');
		$startMenu = WebTricks_Shell_Applications_Desktop_StartMenu::instance();
		$startMenuConfig = $startMenu->getExtControl($startMenuItem);
		
		$trayItem = $repository->getItemByPath('webtricks/content/applications/desktop/tray');
		$trayConfig = $this->_getTrayConfig($trayItem);
		
		$itemId = $this->_getApplication()->getContext()->getRepository()->getDataManager()->resolvePath(self::REPOSITORY_PATH_APPLICATION);
		$item = $this->_getApplication()->getContext()->getRepository()->getItem($itemId);
		
		
		$application = WebTricks_Shell_Web_UI_ExtControls_Application::instance();
		$application->setModules($this->_getModules($item));
		$application->setConnection('/index.php/webtricks/desktop/run');
		$application->setDesktopConfig(array(
		'launchers' => array('shortcut' => array('16192c38-8337-4895-9364-4d29e78b7b40'), 'quickstart' => array('47a2f005-e136-44ef-81c2-af1761674445')),
		'background' => array('color' => '3769b0', 'wallpaperPosition' => 'center', 'wallpaper' => '/media/shell/base/default/images/background.png'),
		'taskbarConfig' => array('startMenuConfig' => $startMenuConfig, 'trayConfig' => $trayConfig)));
		
		return $application;
	}
	
	protected function _getModules(Cream_Content_Item $item)
	{
		$modules = array();
		
		foreach ($item->getChildren() as $childItem) {
			switch ($childItem->getTemplateId()) {
				case self::APPLICATION:
					$modules[] = $this->_getModule($childItem); 
				case self::APPLICATION_FOLDER:
				case self::FOLDER:
					$modules = array_merge($modules, $this->_getModules($childItem));
					break;					
			}
		}
		
		return $modules;
	}
		
	protected function _getModule(Cream_Content_Item $item)
	{	
		$module = WebTricks_Shell_Web_UI_ExtControls_Desktop_Module::instance();
		$module->setId((string) $item->getItemId());
		$module->setType($item->getName());
		$module->setClassName($this->_getJavascriptClass((string) $item->get('Application')));
		$module->setLauncher(array(
			'iconCls' => $item->getAppearance()->getIcon(),
			'text' => $item->getName(),
			'tooltip' => (string) $item->get('Tooltip')
		));
		
		return $module;
	}
	
	protected function _getJavascriptClass($class)
	{
		return str_replace('_', '.', $class);
	}
	
	protected function _getTrayConfig(Cream_Content_Item $item)
	{
		$config = array();
		
		foreach($item->getChildren() as $child) {
			
			
			$config[] = array('text' => $child->get('Tool tip'), 'iconCls' => 'icon-'. $child->getAppearance()->getIcon());	
		}
		
		return $config;
	}
}