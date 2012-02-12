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
 * Webtricks cache model
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class Cream_Cache extends Cream_ApplicationComponent
{
    const DEFAULT_LIFETIME  = 7200;

    /**
     * @var string
     */
    protected $_idPrefix = '';

    /**
     * Cache frontend API
     *
     * @var Zend_Cache_Core
     */
    protected $_frontend = null;

    /**
     * Shared memory backend models list (required TwoLevels backend model)
     *
     * @var array
     */
    protected $_shmBackends = array(
        'apc', 
        'memcached', 
        'xcache',
        'zendserver_shmem', 
        'zendserver_disk'
    );

    /**
     * Fefault cache backend type
     *
     * @var string
     */
    protected $_defaultBackend = 'File';

    /**
     * Default iotions for default backend
     *
     * @var array
     */
    protected $_defaultBackendOptions = array(
        'hashed_directory_level'    => 1,
        'hashed_directory_umask'    => 0777,
        'file_name_prefix'          => 'webtricks',
    );

    /**
     * List of available request processors
     *
     * @var array
     */
    protected $_requestProcessors = array();

    /**
     * List of allowed cache options
     *
     * @var array
     */
    protected $_allowedCacheOptions = null;

    /**
     * Create a new instance of this class
     * 
     * @param array $options
     * @return Cream_Cache
     */
    public static function instance(array $options = array())
    {
    	return Cream::instance(__CLASS__, $options);	
    }
    
    /**
     * Class constructor. Initialize cache instance based on options
     *
     * @param array $options
     */
    public function __init(array $options = array())
    {	
        $this->_defaultBackendOptions['cache_dir'] = $this->_getApplication()->getOptions()->getCacheDir();

        /**
         * Initialize id prefix
         */
        $this->idPrefix = isset($options['id_prefix']) ? $options['id_prefix'] : '';
        if (!$this->idPrefix && isset($options['prefix'])) {
            $this->idPrefix = $options['prefix'];
        }

        if (empty($this->idPrefix)) {
            $this->idPrefix = substr(md5($this->_getApplication()->getOptions()->getConfigDir()), 0, 3) .'_';
        }

        $backend    = $this->_getBackendOptions($options);
        $frontend   = $this->_getFrontendOptions($options);

        $this->_frontend = Zend_Cache::factory('Cream_Cache_Frontend', $backend['type'], $frontend, $backend['options'], true, true, true);

        if (isset($options['request_processors'])) {
            $this->_requestProcessors = $options['request_processors'];
        }
    }

    /**
     * Get cache backend options. Result array contain backend type ('type' key) and backend options ('options')
     *
     * @param   array $cacheOptions
     * @return  array
     */
    protected function _getBackendOptions(array $cacheOptions)
    {
        $enable2levels = false;
        $type   = isset($cacheOptions['backend']) ? $cacheOptions['backend'] : $this->_defaultBackend;
        if (isset($cacheOptions['backend_options']) && is_array($cacheOptions['backend_options'])) {
            $options = $cacheOptions['backend_options'];
        } else {
            $options = array();
        }

        $backendType = false;
        switch (strtolower($type)) {
            case 'sqlite':
                if (extension_loaded('sqlite') && isset($options['cache_db_complete_path'])) {
                    $backendType = 'Sqlite';
                }
                break;
            case 'memcached':
                if (extension_loaded('memcache')) {
                    if (isset($cacheOptions['memcached'])) {
                        $options = $cacheOptions['memcached'];
                    }
                    $enable2levels = true;
                    $backendType = 'Memcached';
                }
                break;
            case 'apc':
                if (extension_loaded('apc') && ini_get('apc.enabled')) {
                    $enable2levels = true;
                    $backendType = 'Apc';
                }
                break;
            case 'xcache':
                if (extension_loaded('xcache')) {
                    $enable2levels = true;
                    $backendType = 'Xcache';
                }
                break;
            case 'eaccelerator':
            case 'cream_cache_backend_eaccelerator':
                if (extension_loaded('eaccelerator') && ini_get('eaccelerator.enable')) {
                    $enable2levels = true;
                    $backendType = 'Cream_Cache_Backend_Eaccelerator';
                }
                break;
            case 'database':
                $backendType = 'Cream_Cache_Backend_Database';
                $options = $this->getDbAdapterOptions();
                break;
            default:
                if ($type != $this->_defaultBackend) {
                    try {
                        if (class_exists($type, true)) {
                            $implements = class_implements($type, true);
                            if (in_array('Zend_Cache_Backend_Interface', $implements)) {
                                $backendType = $type;
                            }
                        }
                    } catch (Exception $e) {
                    }
                }
        }

        if (!$backendType) {
            $backendType = $this->_defaultBackend;
            foreach ($this->_defaultBackendOptions as $option => $value) {
                if (!array_key_exists($option, $options)) {
                    $options[$option] = $value;
                }
            }
        }

        $backendOptions = array('type' => $backendType, 'options' => $options);
        if ($enable2levels) {
            $backendOptions = $this->_getTwoLevelsBackendOptions($backendOptions, $cacheOptions);
        }
        return $backendOptions;
    }

    /**
     * Initialize two levels backend model options
     *
     * @param array $fastOptions fast level backend type and options
     * @param array $cacheOptions all cache options
     * @return array
     */
    protected function _getTwoLevelsBackendOptions($fastOptions, $cacheOptions)
    {
        $options = array();
        $options['fast_backend']                = $fastOptions['type'];
        $options['fast_backend_options']        = $fastOptions['options'];
        $options['fast_backend_custom_naming']  = true;
        $options['fast_backend_autoload']       = true;
        $options['slow_backend_custom_naming']  = true;
        $options['slow_backend_autoload']       = true;

        if (isset($cacheOptions['slow_backend'])) {
            $options['slow_backend'] = $cacheOptions['slow_backend'];
        } else {
            $options['slow_backend'] = $this->_defaultBackend;
        }
        if (isset($cacheOptions['slow_backend_options'])) {
            $options['slow_backend_options'] = $cacheOptions['slow_backend_options'];
        } else {
            $options['slow_backend_options'] = $this->_defaultBackendOptions;
        }
        if ($options['slow_backend'] == 'database') {
            $options['slow_backend'] = 'Cream_Cache_Backend_Database';
            $options['slow_backend_options'] = $this->getDbAdapterOptions();
        }

        $backend = array(
            'type'      => 'TwoLevels',
            'options'   => $options
        );
        return $backend;
    }

    /**
     * Get options of cache frontend (options of Zend_Cache_Core)
     *
     * @param   array $cacheOptions
     * @return  array
     */
    protected function _getFrontendOptions(array $cacheOptions)
    {
    	if (isset($cacheOptions['frontend_options'])) {
    		$options = $cacheOptions['frontend_options'];
    	} else {
    		$options = array();
    	}
        
        if (!array_key_exists('caching', $options)) {
            $options['caching'] = true;
        }
        
        if (!array_key_exists('lifetime', $options)) {
        	if (isset($cacheOptions['lifetime'])) {
        		$options['lifetime'] = $cacheOptions['lifetime'];
        	} else {
        		$options['lifetime'] = self::DEFAULT_LIFETIME;
        	}
        }
        
        if (!array_key_exists('automatic_cleaning_factor', $options)) {
            $options['automatic_cleaning_factor'] = 0;
        }
        
        $options['cache_id_prefix'] = $this->idPrefix;
        
        return $options;
    }

    /**
     * Prepare unified valid identifier with preffix
     *
     * @param   string $id
     * @return  string
     */
    protected function _id($id)
    {
        if ($id) {
            $id = strtoupper($id);
        }
        return $id;
    }

    /**
     * Prepare cache tags.
     *
     * @param   array $tags
     * @return  array
     */
    protected function _tags($tags = array())
    {
        foreach ($tags as $key => $value) {
            $tags[$key] = $this->_id($value);
        }
        return $tags;
    }

    /**
     * Get cache frontend API object
     *
     * @return Zend_Cache_Core
     */
    public function getFrontend()
    {
        return $this->_frontend;
    }
    
    public function useCache($name)
    {
    	return false;
    }

    /**
     * Load data from cache by id
     *
     * @param   string $id
     * @return  string
     */
    public function load($id)
    {
        return unserialize($this->_frontend->load($this->_id($id)));
    }

    /**
     * Save data
     *
     * @param string $data
     * @param string $id
     * @param array $tags
     * @param int $lifeTime
     * @return bool
     */
    public function save($data, $id, $tags = array(), $lifeTime = null)
    {
        return $this->_frontend->save(serialize($data), $this->_id($id), $this->_tags($tags), $lifeTime);
    }

    /**
     * Remove cached data by identifier
     *
     * @param   string $id
     * @return  bool
     */
    public function remove($id)
    {
        return $this->_frontend->remove($this->_id($id));
    }

    /**
     * Clean cached data by specific tag
     *
     * @param   array $tags
     * @return  bool
     */
    public function clean($tags = array())
    {
        $mode = Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG;
        if (!empty($tags)) {
            if (!is_array($tags)) {
                $tags = array($tags);
            }
            $res = $this->_frontend->clean($mode, $this->_tags($tags));
        } else {
            $res = $this->_frontend->clean($mode, array(Cream_Application::CACHE_TAG));
            $res = $res && $this->_frontend->clean($mode, array(Cream_Config::CACHE_TAG));
        }
        
        return $res;
    }

    /**
     * Clean cached data by specific tag
     *
     * @return  bool
     */
    public function flush()
    {
        $res = $this->_frontend->clean();
        return $res;
    }

    /**
     * Initialize cache types options
     *
     * @return void
     */
    protected function _initOptions()
    {
        $options = $this->load(self::OPTIONS_CACHE_ID);
        if ($options === false) {
            $options = $this->getResource()->getAllOptions();
            if (is_array($options)) {
                $this->_allowedCacheOptions = $options;
                $this->save(serialize($this->allowedCacheOptions), self::OPTIONS_CACHE_ID);
            } else {
                $this->allowedCacheOptions = array();
            }
        } else {
            $this->allowedCacheOptions = unserialize($options);
        }
    }

    /**
     * Save cache usage options
     *
     * @param array $options
     * @return void
     */
    public function saveOptions($options)
    {
        $this->remove(self::OPTIONS_CACHE_ID);
        $options = $this->getResource()->saveAllOptions($options);
    }

    /**
     * Check if cache can be used for specific data type
     *
     * @param string $typeCode
     * @return bool
     */
    public function canUse($typeCode)
    {
        if (is_null($this->allowedCacheOptions)) {
            $this->initOptions();
        }

        if (empty($typeCode)) {
            return $this->_allowedCacheOptions;
        } else {
            if (isset($this->_allowedCacheOptions[$typeCode])) {
                return (bool)$this->_allowedCacheOptions[$typeCode];
            } else {
                return false;
            }
        }
    }

    /**
     * Disable cache usage for specific data type
     * @param string $typeCode
     * @return void
     */
    public function banUse($typeCode)
    {
    }

    /**
     * Get cache tags by cache type from configuration
     *
     * @param string $type
     * @return array
     */
    public function getTagsByType($type)
    {
        $path = self::XML_PATH_TYPES.'/'.$type.'/tags';
        $tagsConfig = $this->_getApplication()->getConfig()->getNode($path);
        if ($tagsConfig) {
            $tags = (string) $tagsConfig;
            $tags = explode(',', $tags);
        } else {
            $tags = false;
        }
        return $tags;
    }

    /**
     * Get information about all declared cache types
     *
     * @return array
     */
    public function getTypes()
    {
        $types = array();
        $config = $this->_getApplication()->getConfig()->getNode(self::XML_PATH_TYPES);
        
        if ($config) {
            foreach ($config->children() as $type => $node) {
                $types[$type] = array(
                    'id'            => $type,
                    'cache_type'    => (string)$node->label,
                    'description'   => (string)$node->description,
                    'tags'          => strtoupper((string) $node->tags),
                    'status'        => (int)$this->canUse($type)
                );
            }
        }
        
        return $types;
    }

    /**
     * Save invalicated cache types
     *
     * @param array $types
     */
    protected function _saveInvalidatedTypes($types)
    {
        $this->save(serialize($types), self::INVALIDATED_TYPES);
    }

    /**
     * Get array of all invalidated cache types
     *
     * @return array
     */
    public function getInvalidatedTypes()
    {
        $invalidatedTypes = array();
        
        $types = $this->load(self::INVALIDATED_TYPES);
        if ($types) {
            $types = unserialize($types);
        } else {
            $types = array();
        }
        
        if ($types) {
            $allTypes = $this->getTypes();
            foreach ($types as $type => $flag) {
                if (isset($allTypes[$type]) && $this->canUse($type)) {
                    $invalidatedTypes[$type] = $allTypes[$type];
                }
            }
        }
        return $invalidatedTypes;
    }
    
    /**
     * Mark specific cache type(s) as invalidated
     *
     * @param string|array $typeCode
     * @return void
     */
    public function invalidateType($typeCode)
    {
        $types = $this->_getInvalidatedTypes();
        if (!is_array($typeCode)) {
            $typeCode = array($typeCode);
        }
        foreach ($typeCode as $code) {
            $types[$code] = 1;
        }
        $this->_saveInvalidatedTypes($types);
    }

    /**
     * Clean cached data for specific cache type
     *
     * @param $typeCode
     * @return void
     */
    public function cleanType($typeCode)
    {
        $tags = $this->getTagsByType($typeCode);
        $this->clean($tags);

        $types = $this->_getInvalidatedTypes();
        unset($types[$typeCode]);
        $this->_saveInvalidatedTypes($types);
    }

    /**
     * Try to get response body from cache storage with predefined processors
     *
     * @return bool
     */
    public function processRequest()
    {
        if (empty($this->_requestProcessors)) {
            return false;
        }

        $content = false;
        foreach ($this->_requestProcessors as $processor) {
            $processor = $this->_getProcessor($processor);
            if ($processor) {
                $content = $processor->extractContent($content);
            }
        }

        if ($content) {
            $this->_getApplication()->getResponse()->appendBody($content);
            return true;
        }
        return false;
    }

    /**
     * Get request processor object
     */
    protected function _getProcessor($processor)
    {
        $processor = new $processor;
        return $processor;
    }
}
