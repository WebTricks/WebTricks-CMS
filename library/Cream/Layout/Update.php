<?php



class Cream_Layout_Update extends Cream_ApplicationComponent 
{
    /**
     * Additional tag for cleaning layout cache convenience
     */
    const LAYOUT_GENERAL_CACHE_TAG = 'LAYOUT_GENERAL_CACHE_TAG';

    /**
     * Layout Update Simplexml Element Class Name
     *
     * @var string
     */
    protected $_elementClass = 'Cream_Layout_Element';

    /**
     * @var Simplexml_Element
     */
    protected $_packageLayout;

    /**
     * Layout object
     *  
     * @var Cream_Layout
     */
    protected $_layout;
    
    /**
     * Cache key
     *
     * @var string
     */
    protected $_cacheId;

    /**
     * Cache prefix
     *
     * @var string
     */
    protected $_cachePrefix;

    /**
     * Cumulative array of update XML strings
     *
     * @var array
     */
    protected $_updates = array();

    /**
     * Handles used in this update
     *
     * @var array
     */
    protected $_handles = array();

    /**
     * Substitution values in structure array('from'=>array(), 'to'=>array())
     *
     * @var array
     */
    protected $_subst = array();

    /**
     * Create a new instance of this class
     * 
     * @param Cream_Layout $layout
     * @return Cream_Layout_Update
     */
    public static function instance(Cream_Layout $layout)
    {
    	return Cream::instance(__CLASS__, $layout);
    }
    
    /**
     * Initialize function
     * 
     * @param Cream_Layout $layout
     * @return void
     */
    public function __init(Cream_Layout $layout)
    {
    	$this->_layout = $layout;
        //$subst = $this->_getApplication()->getConfig()->getPathVars();
        //foreach ($subst as $k=>$v) {
        //    $this->_subst['from'][] = '{{'.$k.'}}';
        //    $this->_subst['to'][] = $v;
        //}
    }
    
    /**
     * Returns the layout instance
     *
     * @return Cream_Layout
     */
    public function getLayout()
    {
    	return $this->_layout;
    }

    public function getElementClass()
    {
        return $this->_elementClass;
    }

    public function resetUpdates()
    {
        $this->_updates = array();
        return $this;
    }

    public function addUpdate($update)
    {
        $this->_updates[] = $update;
        return $this;
    }

    public function asArray()
    {
        return $this->_updates;
    }

    public function asString()
    {
        return implode('', $this->_updates);
    }

    public function resetHandles()
    {
        $this->_handles = array();
        return $this;
    }

    public function addHandle($handle)
    {
        if (is_array($handle)) {
            foreach ($handle as $h) {
                $this->_handles[$h] = 1;
            }
        } else {
            $this->_handles[$handle] = 1;
        }
        return $this;
    }

    public function removeHandle($handle)
    {
        unset($this->_handles[$handle]);
        return $this;
    }

    public function getHandles()
    {
        return array_keys($this->_handles);
    }

    /**
     * Get cache id
     *
     * @return string
     */
    public function getCacheId()
    {
        if (!$this->_cacheId) {
            $this->_cacheId = 'LAYOUT_' .md5(join('__', $this->getHandles()));
        }
        return $this->_cacheId;
    }

    /**
     * Set cache id
     *
     * @param string $cacheId
     * @return void
     */
    public function setCacheId($cacheId)
    {
        $this->_cacheId = $cacheId;
    }

    public function loadCache()
    {
        if (!$this->_getApplication()->getCache()->useCache('layout')) {
            return false;
        }

        if (!$result = $this->_getApplication()->getCache()->load($this->getCacheId())) {
            return false;
        }

        $this->addUpdate($result);

        return true;
    }

    public function saveCache()
    {
        if (!$this->_getApplication()->getCache()->useCache('layout')) {
            return false;
        }
        
        $str = $this->asString();
        $tags = $this->getHandles();
        $tags[] = self::LAYOUT_GENERAL_CACHE_TAG;
        return $this->_getApplication()->getCache()->save($str, $this->getCacheId(), $tags);
    }

    /**
     * Load layout updates by handles
     *
     * @param array|string $handles
     * @return void
     */
    public function load($handles=array())
    {
        if (is_string($handles)) {
            $handles = array($handles);
        } elseif (!is_array($handles)) {
            throw new Cream_Exceptions_Exception('Invalid layout update handle');
        }

        foreach ($handles as $handle) {
            $this->addHandle($handle);
        }

        if ($this->loadCache()) {
            return $this;
        }
        
        foreach ($this->getHandles() as $handle) {
            $this->merge($handle);
        }

        $this->saveCache();
    }

    public function asSimplexml()
    {
        $updates = trim($this->asString());
        $updates = '<'.'?xml version="1.0"?'.'><layout>'.$updates.'</layout>';
        return simplexml_load_string($updates, $this->getElementClass());
    }

    /**
     * Merge layout update by handle
     *
     * @param string $handle
     * @return void
     */
    public function merge($handle)
    {
        $packageUpdatesStatus = $this->fetchPackageLayoutUpdates($handle);

//        if (!$this->fetchPackageLayoutUpdates($handle)
//            && !$this->fetchDbLayoutUpdates($handle)) {
//            #$this->removeHandle($handle);
//        }
    }

    public function fetchFileLayoutUpdates()
    {
        $elementClass = $this->getElementClass();
        $design = $this->getLayout()->getController()->getDesign();
        $cacheKey = 'LAYOUT_'. $design->getArea() .'_'. $design->getPackageName() .'_'. $design->getTheme('layout');
        $cacheTags = array(self::LAYOUT_GENERAL_CACHE_TAG);
        
        if ($this->_getApplication()->getCache()->useCache('layout') && ($layoutStr = $this->_getApplication()->getCache()->load($cacheKey))) {
            $this->_packageLayout = simplexml_load_string($layoutStr, $elementClass);
        }

        if (empty($layoutStr)) {
            $this->_packageLayout = $this->getFileLayoutUpdatesXml(
                $design->getArea(),
                $design->getPackageName(),
                $design->getTheme('layout')
            );
            
            if ($this->_getApplication()->getCache()->useCache('layout')) {
                $this->_getApplication()->getCache()->save($this->_packageLayout->asXml(), $cacheKey, $cacheTags);
            }
        }
    }

    public function fetchPackageLayoutUpdates($handle)
    {
        if (empty($this->_packageLayout)) {
            $this->fetchFileLayoutUpdates();
        }
        
        foreach ($this->_packageLayout->$handle as $updateXml) {
            $this->fetchRecursiveUpdates($updateXml);
            $this->addUpdate($updateXml->innerXml());
        }
    }

    public function fetchRecursiveUpdates($updateXml)
    {
        foreach ($updateXml->children() as $child) {
            if (strtolower($child->getName())=='update' && isset($child['handle'])) {
                $this->merge((string)$child['handle']);
                // Adding merged layout handle to the list of applied hanles
                $this->addHandle((string)$child['handle']);
            }
        }
        return $this;
    }

    /**
     * Collect and merge layout updates from file
     *
     * @param string $area
     * @param string $package
     * @param string $theme
     * @return Cream_Layout_Element
     */
    public function getFileLayoutUpdatesXml($area, $package, $theme)
    {
    	$design = $this->getLayout()->getController()->getDesign();
        $layoutXml = null;
        $elementClass = $this->getElementClass();
        $updatesRoot = $this->_getApplication()->getConfig()->getNode($area.'/layout/updates');
        
        $updateFiles = array();
		
        foreach ($updatesRoot->children() as $updateNode) {
            if ($updateNode->file) {
                $module = $updateNode->getAttribute('module');
                $updateFiles[] = (string)$updateNode->file;
            }
        }

        // custom local layout updates file - load always last
        $updateFiles[] = 'local.xml';
        $layoutStr = '';
        foreach ($updateFiles as $file) {
            $filename = $design->getLayoutFilename($file, array(
                '_area'    => $area,
                '_package' => $package,
                '_theme'   => $theme
            ));

            if (!is_readable($filename)) {
                continue;
            }
            
            $fileStr = file_get_contents($filename);
            //$fileStr = str_replace($this->_subst['from'], $this->_subst['to'], $fileStr);
            $fileXml = simplexml_load_string($fileStr, $elementClass);
            if (!$fileXml instanceof SimpleXMLElement) {
                continue;
            }
            $layoutStr .= $fileXml->innerXml();
        }
        $layoutXml = simplexml_load_string('<layouts>'.$layoutStr.'</layouts>', $elementClass);
        return $layoutXml;
    }
}
