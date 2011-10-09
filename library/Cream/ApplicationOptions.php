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
 * The holding the application options.
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class Cream_ApplicationOptions extends Cream_ApplicationComponent
{
	/**
	 * Module config type constants
	 * 
	 */
	const MODULE_CONFIG_DIRECTORY = 'config';
	const MODULE_CONTROLLERS_DIRECTORY = 'controllers';
	
	/**
	 * Array holding the options data
	 * 
	 * @var array
	 */
	protected $_data = array();
	
    /**
     * Flag cache for existing or already created directories
     *
     * @var array
     */
    protected $_dirExists = array();
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_ApplicationOptions
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
	
    /**
     * Initialize default values of the options
     * 
     */
    public function __init()
    {
    	if (!defined('BP')) {
    		throw new Cream_Exceptions_Exception('Constant "BP" not defined');	
    	}

        $this->_data['base_dir']          = BP;
        $this->_data['app_dir']           = BP . DS .'application';
        $this->_data['code_dir']          = $this->_data['app_dir'] . DS .'code';
        $this->_data['corecode_dir']      = $this->_data['code_dir'] . DS .'core';
        $this->_data['communitycode_dir'] = $this->_data['code_dir'] . DS .'community';
        $this->_data['localcode_dir']     = $this->_data['code_dir'] . DS .'local';
        $this->_data['design_dir']        = $this->_data['app_dir'] . DS .'design';
        $this->_data['config_dir']        = $this->_data['app_dir'] . DS .'config';
        $this->_data['locale_dir']        = $this->_data['app_dir'] . DS .'locale';
        $this->_data['library_dir']       = $this->_data['base_dir'] . DS .'library';
        $this->_data['media_dir']         = $this->_data['base_dir'] . DS .'media';
        $this->_data['skin_dir']          = $this->_data['base_dir'] . DS .'skin';
        $this->_data['var_dir']           = $this->getVarDir();
        $this->_data['tmp_dir']           = $this->_data['var_dir'] . DS .'tmp';
        $this->_data['cache_dir']         = $this->_data['var_dir'] . DS .'cache';
        $this->_data['log_dir']           = $this->_data['var_dir'] . DS .'log';
        $this->_data['session_dir']       = $this->_data['var_dir'] . DS .'session';
        $this->_data['export_dir']        = $this->_data['var_dir'] . DS .'export';
        $this->_data['upload_dir']        = $this->_data['media_dir'] . DS .'upload';        
    }

    /**
     * Returns the directory of the application
     * 
     * @return string
     */
    public function getAppDir()
    {
        return $this->_data['app_dir'];
    }

    /**
     * Returns the base directory.
     * 
     * @return string
     */
    public function getBaseDir()
    {
        return $this->_data['base_dir'];
    }

    public function getCodeDir()
    {
        return $this->_data['code_dir'];
    }
    
    public function getCoreCodeDir()
    {
        return $this->_data['corecode_dir'];    	
    }
    
    public function getCommunityCodeDir()
    {
        return $this->_data['communitycode_dir'];    	
    }
    
    public function getLocalCodeDir()
    {
        return $this->_data['localcode_dir'];    	
    }    

    public function getDesignDir()
    {
        return $this->_data['design_dir'];
    }

    public function getConfigDir()
    {
        return $this->_data['config_dir'];
    }

    public function getLibraryDir()
    {
        return $this->_data['library_dir'];
    }

    public function getLocaleDir()
    {
        return $this->_data['locale_dir'];
    }

    public function getMediaDir()
    {
        return $this->_data['media_dir'];
    }

    public function getSkinDir()
    {
        return $this->_data['skin_dir'];
    }

    public function getSysTmpDir()
    {
        return sys_get_temp_dir();
    }

    public function getVarDir()
    {
        $dir = isset($this->_data['var_dir']) ? $this->_data['var_dir'] : $this->_data['base_dir'].DS.'var';
        if (!$this->createDirIfNotExists($dir)) {
            $dir = $this->getSysTmpDir().DS.'webtricks'.DS.'var';
            if (!$this->createDirIfNotExists($dir)) {
                throw new Cream_Exceptions_Exception('Unable to find writable var_dir');
            }
        }
        return $dir;
    }

    public function getTmpDir()
    {
        $dir = $this->_data['tmp_dir'];
        if (!$this->createDirIfNotExists($dir)) {
            $dir = $this->getSysTmpDir().DS.'webtricks'.DS.'tmp';
            if (!$this->createDirIfNotExists($dir)) {
                throw new Cream_Exceptions_Exception('Unable to find writable tmp_dir');
            }
        }
        return $dir;
    }

    public function getCacheDir()
    {
        $dir = $this->_data['cache_dir'];
        $this->createDirIfNotExists($dir);
        return $dir;
    }

    public function getLogDir()
    {
        $dir = $this->_data['log_dir'];
        $this->createDirIfNotExists($dir);
        return $dir;
    }

    public function getSessionDir()
    {
        $dir = $this->_data['session_dir'];
        $this->createDirIfNotExists($dir);
        return $dir;
    }

    public function getUploadDir()
    {
        $dir = $this->_data['upload_dir'];
        $this->createDirIfNotExists($dir);
        return $dir;
    }

    public function getExportDir()
    {
        $dir = $this->_data['export_dir'];
        $this->createDirIfNotExists($dir);
        return $dir;
    }

    public function createDirIfNotExists($dir)
    {
        if (isset($this->_dirExists[$dir])) {
            return true;
        }
        
        if (file_exists($dir)) {
            if (!is_dir($dir)) {
                return false;
            }
            if (!Cream_IO_Directory::isWritable($dir)) {
                return false;
            }
        } else {
            if (!@mkdir($dir, 0777, true)) {
                return false;
            }
        }
        $this->_dirExists[$dir] = true;
        return true;
    }	
    
    /**
     * Get module directory by directory type
     *
     * @param   string $type
     * @param   string $moduleName
     * @return  string
     */
    public function getModuleDir($type, $moduleName)
    {
        $codePool = (string)$this->getApplication()->getConfig()->getModuleConfig($moduleName)->codePool;
        $dir = $this->getCodeDir() . DS . $codePool . DS . Cream_Utility::ucWords($moduleName, DS);

        switch ($type) {
            case self::MODULE_CONFIG_DIRECTORY:
                $dir .= DS . self::MODULE_CONFIG_DIRECTORY;
                break;
            case self::MODULE_CONTROLLERS_DIRECTORY:
                $dir .= DS . self::MODULE_CONTROLLERS_DIRECTORY;
                break;
            case 'sql':
                $dir .= DS.'sql';
                break;
            case 'locale':
                $dir .= DS.'locale';
                break;
        }

        $dir = str_replace('/', DS, $dir);
        return $dir;
    }    
}