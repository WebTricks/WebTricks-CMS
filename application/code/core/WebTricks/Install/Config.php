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
 * Install config
 * 
 * @package		WebTricks_Install
 * @author		Danny Verkade
 */
class WebTricks_Install_Config extends Cream_Config_Base
{
    const XML_PATH_WIZARD_STEPS     = 'wizard/steps';
    const XML_PATH_CHECK_WRITEABLE  = 'check/filesystem/writeable';
    const XML_PATH_CHECK_EXTENSIONS = 'check/php/extensions';

    /**
     * Create a new instance of this class.
     * 
     * @return WebTricks_Install_Config
     */
    public static function singleton()
    {
    	return Cream::singleton(__CLASS__);
    }

    /**
     * Initialize function
     * 
     */
    public function __init()
    {
        $this->loadString('<?xml version="1.0"?><config></config>');
        $this->getApplication()->getConfig()->loadModulesConfiguration('install.xml', $this);    	
    } 
    
    /**
     * Retrieve writable path for checking
     *
     * array(
     *      ['writeable'] => array(
     *          [$index] => array(
     *              ['path']
     *              ['recursive']
     *          )
     *      )
     * )
     *
     * @return array
     */
    public function getPathForCheck()
    {
        $res = array();

        $items = (array) $this->getNode(self::XML_PATH_CHECK_WRITEABLE);

        foreach ($items as $item) {
            $res['writeable'][] = (array) $item;
        }

        return $res;
    }  

    /**
     * Retrieve required PHP extensions
     *
     * @return array
     */
    public function getExtensionsForCheck()
    {
        $res = array();
        $items = (array) $this->getNode(self::XML_PATH_CHECK_EXTENSIONS);

        foreach ($items as $name=>$value) {
            if (!empty($value)) {
                $res[$name] = array();
                foreach ($value as $subname=>$subvalue) {
                    $res[$name][] = $subname;
                }
            }
            else {
                $res[$name] = (array) $value;
            }
        }

        return $res;
    }    
}