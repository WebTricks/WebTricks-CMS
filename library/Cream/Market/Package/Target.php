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
 * @copyright Copyright (c) 2007-2012 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Class to get targets and their basepath from target.xml.
 *
 * @category    Cream
 * @package     Cream_Market
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Market_Package_Target
{
    /**
     * Object contains all contents from target.xml.
     *
     * @var array
     */
    protected $_targetMap = null;

    /**
     * Cache for targets.
     *
     * @var array
     */
    protected $_targets;

    /**
     * Retrieve content from target.xml.
     *
     * @return array
     */
    protected function _getTargetMap()
    {
        if (is_null($this->_targetMap)) {
            $this->_targetMap = array();
            $this->_targetMap[] = array('name'=>"webtricks_local" ,'label'=>"WebTrics Local module file" , 'uri'=>"./application/code/local");
            $this->_targetMap[] = array('name'=>"webtricks_community" ,'label'=>"WebTricks Community module file" , 'uri'=>"./application/code/community");
            $this->_targetMap[] = array('name'=>"webtricks_core" ,'label'=>"WebTricks Core team module file" , 'uri'=>"./application/code/core");
            $this->_targetMap[] = array('name'=>"webtricks_design" ,'label'=>"WebTricks User Interface (layouts, templates)" , 'uri'=>"./application/design");
            $this->_targetMap[] = array('name'=>"webtricks_config" ,'label'=>"WebTricks Global Configuration" , 'uri'=>"./application/config");
            $this->_targetMap[] = array('name'=>"webtricks_library" ,'label'=>"WebTricks PHP Library file" , 'uri'=>"./library");
            $this->_targetMap[] = array('name'=>"webtricks_media" ,'label'=>"WebTricks Media library" , 'uri'=>"./media");
            $this->_targetMap[] = array('name'=>"webtricks_web" ,'label'=>"WebTricks Other web accessible file" , 'uri'=>".");
            $this->_targetMap[] = array('name'=>"webtricks_test" ,'label'=>"WebTricks PHPUnit test" , 'uri'=>"./tests");
            $this->_targetMap[] = array('name'=>"webtricks" ,'label'=>"WebTricks other" , 'uri'=>".");
        }        

        return $this->_targetMap;
    }

    /**
     * Retrieve targets as associative array from target.xml.
     *
     * @return array
     */
    public function getTargets()
    {
        if (!is_array($this->_targets)) {            
            $this->_targets = array();
            if($this->_getTargetMap()) {           
                foreach ($this->_getTargetMap() as $_target) {
                    $this->_targets[$_target['name']] = (string)$_target['uri'];
                }
            }
        }
        return $this->_targets;
    }

    /**
     * Retrieve tragets with label for select options.
     *
     * @return array
     */
    public function getLabelTargets()
    {
        $targets = array();
        foreach ($this->_getTargetMap() as $_target) {
            $targets[$_target['name']] = $_target['label'];
        }
        return $targets;
    }

    /**
     * Get uri by target's name.
     *
     * @param string $name
     * @return string
     */
    public function getTargetUri($name)
    {
        foreach ($this->getTargets() as $_name=>$_uri) {
            if ($name == $_name) {
                return $_uri;
            }
        }
        return '';
    }
}