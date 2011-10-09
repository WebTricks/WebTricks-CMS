<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Base config class
 * 
 * @package		Cream_Config
 * @author		Danny Verkade
 */
class Cream_Config_Base extends Cream_ApplicationComponent
{
    /**
     * Configuration xml
     *
     * @var Cream_Config_Xml_Element
     */
    protected $_xml = null;
    	
	/**
     * Class name of simplexml elements for this configuration
     *
     * @var string
     */
    protected $_xmlElementClass = 'Cream_Config_Xml_Element';
    
    /**
     * Create a new instance of this class
     * 
     * @return Cream_Config_Base
     */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}    
	
    /**
     * Returns node found by the $path
     *
     * @see     Cream_Config_Xml_Element::descend
     * @param   string $path
     * @return  Cream_Config_Xml_Element
     */
    public function getNode($path = null)
    {
        if (!$this->_xml instanceof Cream_Config_Xml_Element) {
            return false;
        } elseif ($path === null) {
            return $this->_xml;
        } else {
            return $this->_xml->descend($path);
        }
    }	
    
    /**
     * Imports XML file
     *
     * @param string $file
     * @return boolean
     */
    public function loadFile($file)
    {
    	// Check if file exists
        if (!is_readable($file)) {
        	return false;
        }

        $data = file_get_contents($file);
        return $this->loadString($data);
    }

    /**
     * Imports XML string
     *
     * @param  string $data
     * @return boolean
     */
    public function loadString($data)
    {
        if (is_string($data)) {
            $xml = simplexml_load_string($data, $this->_xmlElementClass);

            if ($xml instanceof Cream_Config_Xml_Element) {
                $this->_xml = $xml;
                return true;
            }
        } else {
            throw new Cream_Exceptions_ConfigurationException('"'. $data .'" parameter for simplexml_load_string is not a string');
        }
        return false;
    }
    
    /**
     * Merge a config object into the current config.
     *
     * @param Cream_Config_Base $config
     * @param boolean $overwrite
     */
    public function merge(Cream_Config_Base $config, $overwrite = true)
    {
        $this->getNode()->merge($config->getNode(), $overwrite);
    }    
    
    /**
     * Sets xml for this configuration
     *
     * @param Cream_Config_Xml_Element $sourceData
     * @return void
     */
    public function setXml(Cream_Config_Xml_Element $node)
    {
        $this->_xml = $node;
    }    
}