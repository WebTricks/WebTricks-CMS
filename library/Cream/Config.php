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
 * Config class
 *
 * @package		Cream_Config
 * @author		Danny Verkade
 */
class Cream_Config extends Cream_Config_Base
{
    const CACHE_TAG         = 'CONFIG';
    	
    /**
     * Class name cache 
     * 
     * @var array
     */
	protected $_classNameCache = array();    	
	
	/**
     * Flag which identifies if local configuration is loaded.
     *
     * @var boolean
     */
    protected $_isLocalConfigLoaded = false;	
	
    /**
     * Empty configuration object for loading and merging 
     * configuration parts.
     *
     * @var Cream_Config_Base
     */
    protected $_prototype;  
    	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Config
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Constructor function
	 * 
	 */
	public function __construct()
	{
		$this->_prototype = Cream_Config_Base::instance();
	}
	
    /**
     * Check if local configuration is loaded
     *
     * @return bool
     */
    public function isLocalConfigLoaded()
    {
        return $this->_isLocalConfigLoaded;
    }	
	
    /**
     * Load base system configuration (config.xml and local.xml files)
     *
     */
    public function loadBase()
    {
        $configDir = $this->getApplication()->getOptions()->getConfigDir();
        $files = glob($configDir . DS .'*.xml');
        
        if (!count($files)) {
        	throw new Cream_Exceptions_ConfigurationException("No config files found in directory: ". $configDir);
        }
        
        $this->loadFile(current($files));
        
        while (next($files)) {
            $merge = clone $this->_prototype;
            $merge->loadFile(current($files));
            $this->merge($merge);
        }
        
        if (in_array($configDir . DS .'local.xml', $files)) {
            $this->_isLocalConfigLoaded = true;
        }
    }	
    
    /**
     * Load modules configuration
     *
     */
    public function loadModules()
    {
        $this->_loadDeclaredModules();
        $this->loadModulesConfiguration('config.xml', $this);

        /**
         * Prevent local.xml directives overwriting
         */
        $mergeConfig = clone $this->_prototype;
        $this->_isLocalConfigLoaded = $mergeConfig->loadFile($this->getApplication()->getOptions()->getConfigDir().DS.'local.xml');
        if ($this->_isLocalConfigLoaded) {
            $this->merge($mergeConfig);
        }
    } 

    /**
     * Iterate all active modules "etc" folders and combine data from
     * specidied xml file name to one object
     *
     * @param   string $fileName
     * @param   null|Cream_Config_Base $mergeToObject
     * @return  Cream_Config_Base
     */
    public function loadModulesConfiguration($fileName, $mergeToObject = null, $mergeModel=null)
    {
        if ($mergeToObject === null) {
            $mergeToObject = clone $this->_prototype;
            $mergeToObject->loadString('<config/>');
        }
        
        if ($mergeModel === null) {
            $mergeModel = clone $this->_prototype;
        }
        
        $modules = $this->getNode('modules')->children();
        foreach ($modules as $modName => $module) {
            if ($module->is('active')) {
                $configFile = $this->getApplication()->getOptions()->getModuleDir(Cream_ApplicationOptions::MODULE_CONFIG_DIRECTORY, $modName) . DS . $fileName;
                if ($mergeModel->loadFile($configFile)) {
                    $mergeToObject->merge($mergeModel, true);
                }
            }
        }
        return $mergeToObject;
    }    

    /**
     * Load declared modules configuration
     *
     * @param   null $mergeConfig depricated
     */
    protected function _loadDeclaredModules($mergeConfig = null)
    {
        $moduleFiles = $this->_getDeclaredModuleFiles();
        
        if (!$moduleFiles) {
            return;
        }

        $unsortedConfig = Cream_Config_Base::instance();
        $unsortedConfig->loadString('<config/>');
        $fileConfig = Cream_Config_Base::instance();

        // load modules declarations
        foreach ($moduleFiles as $file) {
            $fileConfig->loadFile($file);
            $unsortedConfig->merge($fileConfig);
        }
        
        $moduleDepends = array();
        foreach ($unsortedConfig->getNode('modules')->children() as $moduleName => $moduleNode) {
            $depends = array();
            if ($moduleNode->depends) {
                foreach ($moduleNode->depends->children() as $depend) {
                    $depends[$depend->getName()] = true;
                }
            }
            $moduleDepends[$moduleName] = array(
                'module'    => $moduleName,
                'depends'   => $depends,
                'active'    => ('true' === (string)$moduleNode->active ? true : false),
            );
        }

        // check and sort module dependens
        $moduleDepends = $this->_sortModuleDepends($moduleDepends);

        // create sorted config
        $sortedConfig = Cream_Config_Base::instance();
        $sortedConfig->loadString('<config><modules/></config>');

        foreach ($unsortedConfig->getNode()->children() as $nodeName => $node) {
            if ($nodeName != 'modules') {
                $sortedConfig->getNode()->appendChild($node);
            }
        }

        foreach ($moduleDepends as $moduleProp) {
            $node = $unsortedConfig->getNode('modules/'.$moduleProp['module']);
            $sortedConfig->getNode('modules')->appendChild($node);
        }

        $this->merge($sortedConfig);
    }

    /**
     * Retrive Declared Module file list
     *
     * @return array
     */
    protected function _getDeclaredModuleFiles()
    {
        $configDir = $this->getApplication()->getOptions()->getConfigDir();
        $moduleFiles = glob($configDir . DS . 'modules' . DS . '*.xml');
        $collectModuleFiles = array();

        if (!$moduleFiles) {
            return false;
        }

        foreach ($moduleFiles as $file) {
			$collectModuleFiles[] = $file;
        }

        return $collectModuleFiles;
    }
    
    /**
     * Get module config node
     *
     * @param string $moduleName
     * @return Cream_Config_Xml_Element
     */
    function getModuleConfig($moduleName = '')
    {
        $modules = $this->getNode('modules');
        if ('' === $moduleName) {
            return $modules;
        } else {
            return $modules->$moduleName;
        }
    }
    
    /**
     * Get resource configuration for resource name
     *
     * @param string $name
     * @return Varien_Simplexml_Object
     */
    public function getResourceConfig($name)
    {
        return $this->_xml->global->resources->{$name};
    }    
    
    /**
     * Sort modules and check depends
     *
     * @param array $modules
     * @return array
     */
    protected function _sortModuleDepends($modules)
    {
        foreach ($modules as $moduleName => $moduleProps) {
            $depends = $moduleProps['depends'];
            foreach ($moduleProps['depends'] as $depend => $true) {
                if ($moduleProps['active'] && ((!isset($modules[$depend])) || empty($modules[$depend]['active']))) {
                    throw new Cream_Exceptions_ConfigurationException('Module "'. $moduleName .'" requires module "'. $depend .'".');
                }
                $depends = array_merge($depends, $modules[$depend]['depends']);
            }
            $modules[$moduleName]['depends'] = $depends;
        }
        $modules = array_values($modules);

        $size = count($modules) - 1;
        for ($i = $size; $i >= 0; $i--) {
            for ($j = $size; $i < $j; $j--) {
                if (isset($modules[$i]['depends'][$modules[$j]['module']])) {
                    $value       = $modules[$i];
                    $modules[$i] = $modules[$j];
                    $modules[$j] = $value;
                }
            }
        }

        $definedModules = array();
        foreach ($modules as $moduleProp) {
            foreach ($moduleProp['depends'] as $dependModule => $true) {
                if (!isset($definedModules[$dependModule])) {
                    throw new Cream_Exceptions_ConfigurationException('Module "'. $moduleProp['module'] .'" cannot depend on "'. $dependModule .'".'); 
                }
            }
            $definedModules[$moduleProp['module']] = true;
        }

        return $modules;
    }    
    
    /**
     * Retrieve class name by class group
     *
     * @param   string $groupType currently supported model, block, helper
     * @param   string $classId slash separated class identifier, ex. group/class
     * @param   string $groupRootNode optional config path for group config
     * @return  string
     */
    public function getGroupedClassName($groupType, $classId, $groupRootNode=null)
    {
        if (empty($groupRootNode)) {
            $groupRootNode = 'global/'.$groupType.'s';
        }

        $classArr = explode('/', trim($classId));
        $group = $classArr[0];
        $class = !empty($classArr[1]) ? $classArr[1] : null;

        if (isset($this->_classNameCache[$groupRootNode][$group][$class])) {
            return $this->_classNameCache[$groupRootNode][$group][$class];
        }

        //$config = $this->getNode($groupRootNode.'/'.$group);
        $config = $this->_xml->global->{$groupType.'s'}->{$group};

        if (isset($config->rewrite->$class)) {
            $className = (string)$config->rewrite->$class;
        } else {
            if (!empty($config)) {
                $className = (string)$config->class;
            }
            if (empty($className)) {
                $className = 'Cream_'.$group.'_'.$groupType;
            }
            if (!empty($class)) {
                $className .= '_'.$class;
            }
            $className = Cream_Utility::ucWords($className);
        }

        $this->_classNameCache[$groupRootNode][$group][$class] = $className;
        return $className;
    }

    /**
     * Retrieve block class name
     *
     * @param   string $blockType
     * @return  string
     */
    public function getBlockClassName($blockType)
    {
        if (strpos($blockType, '/')===false) {
            return $blockType;
        }
        
        $class = $this->getGroupedClassName('webcontrol', $blockType);
        $class .= 'Control';
        
        return $class;
    }    
}