<?php



class Cream_Design_Package extends Cream_ApplicationComponent
{
    const DEFAULT_AREA    = 'frontend';
    const DEFAULT_PACKAGE = 'default';
    const DEFAULT_THEME   = 'default';
    const BASE_PACKAGE    = 'base';

    private static $_regexMatchCache      = array();
    private static $_customThemeTypeCache = array();

    /**
     * Current Store for generation ofr base_dir and base_url
     *
     * @var string|integer|Mage_Core_Model_Store
     */
    protected $_store = null;

    /**
     * Package area
     *
     * @var string
     */
    protected $_area;

    /**
     * Package name
     *
     * @var string
     */
    protected $_name;

    /**
     * Package theme
     *
     * @var string
     */
    protected $_theme;

    /**
     * Package root directory
     *
     * @var string
     */
    protected $_rootDir;

    protected $_config = null;

    /**
     * Whether theme/skin hierarchy should be checked via fallback mechanism
     * @TODO: implement setter for this value
     * @var bool
     */
    protected $_shouldFallback = true;
    
    /**
     * Create a new instance of this class
     * 
     * @return Cream_Design_Package
     */
    public static function instance()
    {
    	return Cream::instance(__CLASS__);
    }

    /**
     * Set store
     *
     * @param  string|integer|Mage_Core_Model_Store $store
     * @return Mage_Core_Model_Design_Package
     */
    public function setStore($store)
    {
        $this->_store = $store;
        return $this;
    }

    /**
     * Retrieve store
     *
     * @return string|integer|Mage_Core_Model_Store
     */
    //public function getStore()
    //{
        //if ($this->_store === null) {
        //    return Mage::app()->getStore();
        //}
        //return $this->_store;
    //}

    /**
     * Set package area
     *
     * @param  string $area
     * @return Mage_Core_Model_Design_Package
     */
    public function setArea($area)
    {
        $this->_area = $area;
        return $this;
    }

    /**
     * Retrieve package area
     *
     * @return unknown
     */
    public function getArea()
    {
        if (is_null($this->_area)) {
            $this->_area = self::DEFAULT_AREA;
        }
        return $this->_area;
    }

    /**
     * Set package name
     * In case of any problem, the default will be set.
     *
     * @param  string $name
     * @return Mage_Core_Model_Design_Package
     */
    public function setPackageName($name = '')
    {
        if (empty($name)) {
            // see, if exceptions for user-agents defined in config
            $customPackage = $this->_checkUserAgentAgainstRegexps('design/package/ua_regexp');
            if ($customPackage) {
                $this->_name = $customPackage;
            }
            else {
                //$this->_name = Mage::getStoreConfig('design/package/name', $this->getStore());
            }
        }
        else {
            $this->_name = $name;
        }
        // make sure not to crash, if wrong package specified
        if (!$this->designPackageExists($this->_name, $this->getArea())) {
            $this->_name = self::DEFAULT_PACKAGE;
        }
        return $this;
    }

    /**
     * Set store/package/area at once, and get respective values, that were before
     *
     * $storePackageArea must be assoc array. The keys may be:
     * 'store', 'package', 'area'
     *
     * @param array $storePackageArea
     * @return array
     */
    public function setAllGetOld($storePackageArea)
    {
        $oldValues = array();
        if (array_key_exists('store', $storePackageArea)) {
            $oldValues['store'] = $this->getStore();
            $this->setStore($storePackageArea['store']);
        }
        if (array_key_exists('package', $storePackageArea)) {
            $oldValues['package'] = $this->getPackageName();
            $this->setPackageName($storePackageArea['package']);
        }
        if (array_key_exists('area', $storePackageArea)) {
            $oldValues['area'] = $this->getArea();
            $this->setArea($storePackageArea['area']);
        }
        return $oldValues;
    }

    /**
     * Retrieve package name
     *
     * @return string
     */
    public function getPackageName()
    {
        if (null === $this->_name) {
            $this->setPackageName();
        }
        return $this->_name;
    }

    public function designPackageExists($packageName, $area = self::DEFAULT_AREA)
    {
        return is_dir($this->getApplication()->getOptions()->getDesignDir() . DS . $area . DS . $packageName);
    }

    /**
     * Declare design package theme params
     * Polymorph method:
     * 1) if 1 parameter specified, sets everything to this value
     * 2) if 2 parameters, treats 1st as key and 2nd as value
     *
     * @return Mage_Core_Model_Design_Package
     */
    public function setTheme()
    {
        switch (func_num_args()) {
            case 1:
                foreach (array('layout', 'template', 'skin', 'locale') as $type) {
                    $this->_theme[$type] = func_get_arg(0);
                }
                break;

            case 2:
                $this->_theme[func_get_arg(0)] = func_get_arg(1);
                break;

            default:
                throw new Cream_Exceptions_Exception('Wrong number of arguments for '. __METHOD__);
        }
        return $this;
    }

    public function getTheme($type)
    {
        if (empty($this->_theme[$type])) {
            //$this->_theme[$type] = Mage::getStoreConfig('design/theme/'.$type, $this->getStore());
            if ($type!=='default' && empty($this->_theme[$type])) {
                $this->_theme[$type] = $this->getTheme('default');
                if (empty($this->_theme[$type])) {
                    $this->_theme[$type] = self::DEFAULT_THEME;
                }

                // "locale", "layout", "template"
            }
        }

        // + "default", "skin"

        // set exception value for theme, if defined in config
        $customThemeType = $this->_checkUserAgentAgainstRegexps("design/theme/{$type}_ua_regexp");
        if ($customThemeType) {
            $this->_theme[$type] = $customThemeType;
        }

        return $this->_theme[$type];
    }

    public function getDefaultTheme()
    {
        return self::DEFAULT_THEME;
    }

    public function updateParamDefaults(array &$params)
    {
        if ($this->getStore()) {
            $params['_store'] = $this->getStore();
        }
        if (empty($params['_area'])) {
            $params['_area'] = $this->getArea();
        }
        if (empty($params['_package'])) {
            $params['_package'] = $this->getPackageName();
        }
        if (empty($params['_theme'])) {
            $params['_theme'] = $this->getTheme( (isset($params['_type'])) ? $params['_type'] : '' );
        }
        if (empty($params['_default'])) {
            $params['_default'] = false;
        }
        return $this;
    }

    public function getBaseDir(array $params)
    {
        $this->updateParamDefaults($params);
        $baseDir = (empty($params['_relative']) ? $this->getApplication()->getOptions()->getDesignDir() . DS : '').
            $params['_area'].DS.$params['_package'].DS.$params['_theme'].DS.$params['_type'];
        return $baseDir;
    }

    public function getSkinBaseDir(array $params=array())
    {
        $params['_type'] = 'skin';
        $this->updateParamDefaults($params);
        $baseDir = (empty($params['_relative']) ? $this->getApplication()->getOptions()->getSkinDir() .DS : '').
            $params['_area'].DS.$params['_package'].DS.$params['_theme'];
        return $baseDir;
    }

    public function getLocaleBaseDir(array $params=array())
    {
        $params['_type'] = 'locale';
        $this->updateParamDefaults($params);
        $baseDir = (empty($params['_relative']) ? $this->getApplication()->getOptions()->getDesignDir() .DS : '').
            $params['_area'].DS.$params['_package'].DS.$params['_theme'] . DS . 'locale' . DS .
            $this->getApplication()->getContext()->getCulture()->getCulture();
        return $baseDir;
    }

    public function getSkinBaseUrl(array $params=array())
    {
        $params['_type'] = 'skin';
        $this->updateParamDefaults($params);
        $baseUrl = '/media/'.$params['_area'].'/'.$params['_package'].'/'.$params['_theme'].'/';
        return $baseUrl;
    }

    /**
     * Check whether requested file exists in specified theme params
     *
     * Possible params:
     * - _type: layout|template|skin|locale
     * - _package: design package, if not set = default
     * - _theme: if not set = default
     * - _file: path relative to theme root
     *
     * @param string $file
     * @param array $params
     * @return string|false
     */
    public function validateFile($file, array $params)
    {
        $fileName = $this->_renderFilename($file, $params);
        $testFile = (empty($params['_relative']) ? '' : $this->getApplication()->getOptions()->getDesignDir() . DS) . $fileName;
        if (!file_exists($testFile)) {
            return false;
        }
        return $fileName;
    }

    /**
     * Get filename by specified theme parameters
     *
     * @param array $file
     * @param $params
     * @return string
     */
    protected function _renderFilename($file, array $params)
    {
        switch ($params['_type']) {
            case 'skin':
                $dir = $this->getSkinBaseDir($params);
                break;

            case 'locale':
                $dir = $this->getLocaleBasedir($params);
                break;

            default:
                $dir = $this->getBaseDir($params);
                break;
        }
        return $dir . DS . $file;
    }

    /**
     * Check for files existence by specified scheme
     *
     * If fallback enabled, the first found file will be returned. Otherwise the base package / default theme file,
     *   regardless of found or not.
     * If disabled, the lookup won't be performed to spare filesystem calls.
     *
     * @param string $file
     * @param array &$params
     * @param array $fallbackScheme
     * @return string
     */
    protected function _fallback($file, array &$params, array $fallbackScheme = array(array()))
    {
        if ($this->_shouldFallback) {
            foreach ($fallbackScheme as $try) {
                $params = array_merge($params, $try);
                $filename = $this->validateFile($file, $params);
                if ($filename) {
                    return $filename;
                }
            }
            $params['_package'] = self::BASE_PACKAGE;
            $params['_theme']   = self::DEFAULT_THEME;
        }
        return $this->_renderFilename($file, $params);
    }

    /**
     * Use this one to get existing file name with fallback to default
     *
     * $params['_type'] is required
     *
     * @param string $file
     * @param array $params
     * @return string
     */
    public function getFilename($file, array $params)
    {
 		$this->updateParamDefaults($params);
        $result = $this->_fallback($file, $params, array(
            array(),
            array('_theme' => $this->getFallbackTheme()),
            array('_theme' => self::DEFAULT_THEME),
        ));
        return $result;
    }

    /**
     * Default theme getter
     * @return string
     */
    public function getFallbackTheme()
    {
        return 'default';
    }

    public function getLayoutFilename($file, array $params=array())
    {
        $params['_type'] = 'layout';
        return $this->getFilename($file, $params);
    }

    public function getTemplateFilename($file, array $params=array())
    {
        $params['_type'] = 'template';
        return $this->getFilename($file, $params);
    }

    public function getLocaleFileName($file, array $params=array())
    {
        $params['_type'] = 'locale';
        return $this->getFilename($file, $params);
    }

    /**
     * Get skin file url
     *
     * @param string $file
     * @param array $params
     * @return string
     */
    public function getSkinUrl($file = null, array $params = array())
    {
        if (empty($params['_type'])) {
            $params['_type'] = 'skin';
        }
        if (empty($params['_default'])) {
            $params['_default'] = false;
        }
        $this->updateParamDefaults($params);
        if (!empty($file)) {
            $result = $this->_fallback($file, $params, array(
                array(),
                array('_theme' => $this->getFallbackTheme()),
                array('_theme' => self::DEFAULT_THEME),
            ));
        }
        $result = $this->getSkinBaseUrl($params) . (empty($file) ? '' : $file);

        return $result;
    }

    /**
     * Design packages list getter
     * @return array
     */
    public function getPackageList()
    {
        $directory = $this->getApplication()->getOptions()->getDesignDir() . DS . 'frontend';
        return $this->_listDirectories($directory);
    }

    /**
     * Design package (optional) themes list getter
     * @param string $package
     * @return string
     */
    public function getThemeList($package = null)
    {
        $result = array();

        if (is_null($package)){
            foreach ($this->getPackageList() as $package){
                $result[$package] = $this->getThemeList($package);
            }
        } else {
            $directory = $this->getApplication()->getOptions()->getDesignDir() . DS . 'frontend' . DS . $package;
            $result = $this->_listDirectories($directory);
        }

        return $result;
    }

    /**
     * Directories lister utility method
     *
     * @param string $path
     * @param string|false $fullPath
     * @return array
     */
    private function _listDirectories($path, $fullPath = false)
    {
        $result = array();
        $dir = opendir($path);
        if ($dir) {
            while ($entry = readdir($dir)) {
                if (substr($entry, 0, 1) == '.' || !is_dir($path . DS . $entry)){
                    continue;
                }
                if ($fullPath) {
                    $entry = $path . DS . $entry;
                }
                $result[] = $entry;
            }
            unset($entry);
            closedir($dir);
        }

        return $result;
    }

    /**
     * Get regex rules from config and check user-agent against them
     *
     * Rules must be stored in config as a serialized array(['regexp']=>'...', ['value'] => '...')
     * Will return false or found string.
     *
     * @param string $regexpsConfigPath
     * @return mixed
     */
    protected function _checkUserAgentAgainstRegexps($regexpsConfigPath)
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            if (!empty(self::$_customThemeTypeCache[$regexpsConfigPath])) {
                return self::$_customThemeTypeCache[$regexpsConfigPath];
            }
            $configValueSerialized = $this->getApplication()->getConfig()->getNode($regexpsConfigPath);
            if ($configValueSerialized) {
                $regexps = @unserialize($configValueSerialized);
                if (!empty($regexps)) {
                    foreach ($regexps as $rule) {
                        if (!empty(self::$_regexMatchCache[$rule['regexp']][$_SERVER['HTTP_USER_AGENT']])) {
                            self::$_customThemeTypeCache[$regexpsConfigPath] = $rule['value'];
                            return $rule['value'];
                        }
                        $regexp = $rule['regexp'];
                        if (false === strpos($regexp, '/', 0)) {
                            $regexp = '/' . $regexp . '/';
                        }
                        if (@preg_match($regexp, $_SERVER['HTTP_USER_AGENT'])) {
                            self::$_regexMatchCache[$rule['regexp']][$_SERVER['HTTP_USER_AGENT']] = true;
                            self::$_customThemeTypeCache[$regexpsConfigPath] = $rule['value'];
                            return $rule['value'];
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * Prepare url for css replacement
     *
     * @param string $uri
     * @return string
     */
    protected function _prepareUrl($uri)
    {
        // check absolute or relative url
        if (!preg_match('/^[http|https]/i', $uri) && !preg_match('/^\//i', $uri)) {

            $fileDir = '';
            $pathParts = explode(DS, $uri);
            $fileDirParts = explode(DS, $this->_callbackFileDir);
            $baseUrl = Mage::getBaseUrl('web');

            foreach ($pathParts as $key=>$part) {
                if ($part == '.' || $part == '..') {
                    unset($pathParts[$key]);
                }

                if ($part == '..' && count($fileDirParts)) {
                    $fileDirParts = array_slice($fileDirParts, 0, count($fileDirParts) - 1);
                }
            }

            if (count($fileDirParts)) {
                $fileDir = implode('/', $fileDirParts).'/';
            }

            $uri = $baseUrl.$fileDir.implode('/', $pathParts);
        }
        return $uri;
    }
}
