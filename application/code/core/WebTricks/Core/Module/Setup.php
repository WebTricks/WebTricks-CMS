<?php


class WebTricks_Core_Module_Setup extends Cream_ApplicationComponent
{
    const VERSION_COMPARE_EQUAL   = 0;
    const VERSION_COMPARE_LOWER   = -1;
    const VERSION_COMPARE_GREATER = 1;	
    
    const DEFAULT_SETUP_CONNECTION = 'default';    
	
    /**
     * Connection
     * 
     * @var Cream_Data_Connection
     */
    protected $_connection;
    
	/**
	 * Name of the resource to setup.
	 * 
	 * @var string
	 */
	protected $_resourceName;
	
	/**
	 * Configuration of the resource
	 * 
	 * @var unknown_type
	 */
	protected $_resourceConfig;
	
	/**
	 * Configuration of the module.
	 * 
	 * @var unknown_type
	 */
	protected $_moduleConfig;
	
	/**
	 * Array holding module versions. Array key is the name of the
	 * module. The value is the version number.
	 * 
	 * @var array
	 */
	protected $_versions;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return WebTricks_Core_Module_Setup
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function.
	 * 
	 * @param string $name
	 */
	public function __init($resourceName)
	{
		$this->_resourceName = $resourceName;
		$this->_resourceConfig = $this->getApplication()->getConfig()->getResourceConfig($this->_resourceName);
		$this->_moduleConfig = $this->getApplication()->getConfig()->getModuleConfig($this->_resourceConfig->setup->module);
		
		if ($this->_resourceConfig->connection) {
			$this->_connection = $this->getApplication()->getConnection((string) $this->_resourceConfig->connection);
		} else {
			$resourceConfig = $this->getApplication()->getConfig()->getResourceConfig(self::DEFAULT_SETUP_CONNECTION);
			$this->_connection = $this->getApplication()->getConnection((string) $resourceConfig->connection); 
		}
	}

    /**
     * Apply module resource install, upgrade and data scripts
     */
    public function applyUpdates()
    {
        $dbVer = $this->_getDbVersion($this->_resourceName);
        $configVer = (string)$this->_moduleConfig->version;
        
        if ($dbVer !== false) {
             $status = version_compare($configVer, $dbVer);
             switch ($status) {
                case self::VERSION_COMPARE_LOWER:
                    $this->_rollbackResourceDb($configVer, $dbVer);
                    break;
                case self::VERSION_COMPARE_GREATER:
                    $this->_upgradeResourceDb($dbVer, $configVer);
                    break;
                default:
                    return true;
                    break;
             }
        } elseif ($configVer) {
            $this->_installResourceDb($configVer);
        }
    }

    /**
     * Get sql files for modifications
     *
     * @param     $actionType
     * @return    array
     */
    protected function _getModifySqlFiles($actionType, $fromVersion, $toVersion, $arrFiles)
    {
        $arrRes = array();

        switch ($actionType) {
            case 'install':
            case 'data-install':
                uksort($arrFiles, 'version_compare');
                foreach ($arrFiles as $version => $file) {
                    if (version_compare($version, $toVersion)!==self::VERSION_COMPARE_GREATER) {
                        $arrRes[0] = array('toVersion'=>$version, 'fileName'=>$file);
                    }
                }
                break;

            case 'upgrade':
            case 'data-upgrade':
                uksort($arrFiles, 'version_compare');
                foreach ($arrFiles as $version => $file) {
                    $version_info = explode('-', $version);

                    // In array must be 2 elements: 0 => version from, 1 => version to
                    if (count($version_info)!=2) {
                        break;
                    }
                    $infoFrom = $version_info[0];
                    $infoTo   = $version_info[1];
                    if (version_compare($infoFrom, $fromVersion)!==self::VERSION_COMPARE_LOWER
                        && version_compare($infoTo, $toVersion)!==self::VERSION_COMPARE_GREATER) {
                        $arrRes[] = array('toVersion'=>$infoTo, 'fileName'=>$file);
                    }
                }
                break;

            case 'rollback':
                break;

            case 'uninstall':
                break;
        }
        return $arrRes;
    }

	/**
     * Get Module version from DB
     *
     * @param   string $moduleName
     * @return  string
     */
    protected function _getDbVersion($resName)
    {
        if (!$this->_connection) {
            return false;
        }

        if (is_null($this->_versions)) {
            try {
                $select = Cream_Data_Statement_Select::instance();
                $select->from('core_modules', array('module', 'version'));
                
				$this->_versions = $this->_connection->fetchPairs($select);                
            }
            catch (Exception $e){
                $this->_versions = array();
            }
        }
        
        if (isset($this->_versions[$resName])) {
        	return $this->_versions[$resName];
        } else {
        	return false;
        }
    }    	
    
    protected function _setDbVersion($resourceName, $version) 
    {
    	$insert = Cream_Data_Statement_Insert::instance();
    	$insert->into('core_modules');
    	$insert->values(array('module' => $resourceName, 'version' => $version));
    	
    	$this->_connection->query($insert);
    }

    /**
     * Run resource installation file
     *
     * @param     string $version
     * @return    boolean
     */
    protected function _installResourceDb($newVersion)
    {
        $oldVersion = $this->_modifyResourceDb('install', '', $newVersion);
        $this->_modifyResourceDb('upgrade', $oldVersion, $newVersion);
    }

    /**
     * Run resource upgrade files from $oldVersion to $newVersion
     *
     * @param string $oldVersion
     * @param string $newVersion
     */
    protected function _upgradeResourceDb($oldVersion, $newVersion)
    {
        $this->_modifyResourceDb('upgrade', $oldVersion, $newVersion);
    }

    /**
     * Roll back resource
     *
     * @param     string $newVersion
     * @return    bool
     */

    protected function _rollbackResourceDb($newVersion, $oldVersion)
    {
        $this->_modifyResourceDb('rollback', $newVersion, $oldVersion);
    }

    /**
     * Uninstall resource
     *
     * @param     $version existing resource version
     * @return    bool
     */

    protected function _uninstallResourceDb($version)
    {
        $this->_modifyResourceDb('uninstall', $version, '');
    }

    /**
     * Run module modification files. Return version of last applied 
     * upgrade (false if no upgrades applied)
     *
     * @param     string $actionType install|upgrade|uninstall
     * @param     string $fromVersion
     * @param     string $toVersion
     * @return    string | false
     */
    protected function _modifyResourceDb($actionType, $fromVersion, $toVersion)
    {   	
        //$resModel = (string)$this->_connectionConfig->model;
        $resModel = 'mysql';
        $modName = (string)$this->_moduleConfig[0]->getName();

        $sqlFilesDir = $this->getApplication()->getOptions()->getModuleDir('sql', $modName);
        
        if (!is_dir($sqlFilesDir) || !is_readable($sqlFilesDir)) {
            return false;
        }

        $arrAvailableFiles = array();
        $sqlDir = dir($sqlFilesDir);
        while (false !== ($sqlFile = $sqlDir->read())) {
            $matches = array();
            if (preg_match('#^'.$resModel.'-'.$actionType.'-(.*)\.(sql|php)$#i', $sqlFile, $matches)) {
                $arrAvailableFiles[$matches[1]] = $sqlFile;
            }
        }
        $sqlDir->close();

        if (empty($arrAvailableFiles)) {
            return false;
        }

        // Get SQL files name
        $arrModifyFiles = $this->_getModifySqlFiles($actionType, $fromVersion, $toVersion, $arrAvailableFiles);
        if (empty($arrModifyFiles)) {
            return false;
        }

        $modifyVersion = false;
        foreach ($arrModifyFiles as $resourceFile) {
            $sqlFile = $sqlFilesDir . DS . $resourceFile['fileName'];
            $fileType = pathinfo($resourceFile['fileName'], PATHINFO_EXTENSION);
            
            if ($this->_connection) {
                try {
                    switch ($fileType) {
                        case 'sql':
                            $sql = file_get_contents($sqlFile);
                            if ($sql!='') {
                                $result = $this->run($sql);
                            } else {
                                $result = true;
                            }
                            break;
                        case 'php':
                            $result = include($sqlFile);
                            break;
                        default:
                            $result = false;
                    }
                    
                    if ($result) {
            			$modifyVersion = $resourceFile['toVersion'];                    	
						$this->_setDbVersion($this->_resourceName, $resourceFile['toVersion']);
                    }
                } catch (Exception $e){
                    echo "<pre>".print_r($e,1)."</pre>";
                    throw new Cream_Exceptions_Exception('Error in file: "'. $sqlFile .'" - '. $e->getMessage());
                }
            }
        }
        return $modifyVersion;
    }
    
    public function startSetup()
    {
        $this->_connection->multiQuery("SET SQL_MODE='';
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
");
    }    
    
    public function endSetup()
    {
        $this->_connection->multiQuery("
SET SQL_MODE=IFNULL(@OLD_SQL_MODE,'');
SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS=0, 0, 1);
");
    }        
    
    public function run($sql)
    {
        $this->_connection->multiQuery($sql);
    }
}