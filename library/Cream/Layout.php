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
 * Layout class
 *
 * @package		Cream_Layout
 * @author		Danny Verkade
 */
class Cream_Layout extends Cream_Config_Base
{
	/**
	 * Controller object
	 * 
	 * @var Cream_Controller_Action
	 */
	protected $_controller;
	
    /**
     * Layout Update module
     *
     * @var Cream_Layout_Update
     */
    protected $_update;

    /**
     * Blocks registry
     *
     * @var array
     */
    protected $_blocks = array();

    /**
     * Cache of block callbacks to output during rendering
     *
     * @var array
     */
    protected $_output = array();

    /**
     * Layout area (f.e. admin, frontend)
     *
     * @var string
     */
    protected $_area;

    /**
     * Helper blocks cache for this layout
     *
     * @var array
     */
    protected $_helpers = array();

    /**
     * Flag to have blocks' output go directly to browser as oppose to return result
     *
     * @var boolean
     */
    protected $_directOutput = false;
    
    /**
     * Create a new instance of this class.
     *  
     * @return Cream_Layout
     */
    public static function instance()
    {
    	return Cream::instance(__CLASS__);
    }

    /**
     * Initialize function
     *
     * @param Cream_Controller_Action $controller
     * @return void
     */
    public function __init()
    {
        //$this->_elementClass = Mage::getConfig()->getModelClassName('core/layout_element');
        $this->_xmlElementClass = 'Cream_Layout_Element';
        $this->setXml(simplexml_load_string('<layout/>', $this->_xmlElementClass));
        $this->_update = Cream_Layout_Update::instance($this);
        //parent::__init($data);
    }

    /**
     * Returns the controller
     * 
     * @return Cream_Controller_Action
     */
    public function getController()
    {
    	return $this->_controller;
    }
    
    /**
     * Sets the controller

     * @param Cream_Controller_Action $controller
     */
    public function setController(Cream_Controller_Action $controller)
    {
    	$this->_controller = $controller;
    }
    
    /**
     * Layout update instance
     *
     * @return Cream_Layout_Update
     */
    public function getUpdate()
    {
        return $this->_update;
    }

    /**
     * Set layout area
     *
     * @param   string $area
     * @return  void
     */
    public function setArea($area)
    {
        $this->_area = $area;
    }

    /**
     * Retrieve layout area
     *
     * @return string
     */
    public function getArea()
    {
        return $this->_area;
    }

    /**
     * Declaring layout direct output flag
     *
     * @param   bool $flag
     * @return  void
     */
    public function setDirectOutput($flag)
    {
        $this->_directOutput = $flag;
    }

    /**
     * Retrieve derect output flag
     *
     * @return bool
     */
    public function getDirectOutput()
    {
        return $this->_directOutput;
    }

    /**
     * Layout xml generation
     *
     * @return Cream_Layout
     */
    public function generateXml()
    {
        $xml = $this->getUpdate()->asSimplexml();
        $removeInstructions = $xml->xpath("//remove");
        if (is_array($removeInstructions)) {
            foreach ($removeInstructions as $infoNode) {
                $attributes = $infoNode->attributes();
                $blockName = (string)$attributes->name;
                if ($blockName) {
                    $ignoreNodes = $xml->xpath("//block[@name='".$blockName."']");
                    if (!is_array($ignoreNodes)) {
                        continue;
                    }
                    $ignoreReferences = $xml->xpath("//reference[@name='".$blockName."']");
                    if (is_array($ignoreReferences)) {
                        $ignoreNodes = array_merge($ignoreNodes, $ignoreReferences);
                    }

                    foreach ($ignoreNodes as $block) {
                        if ($block->getAttribute('ignore') !== null) {
                            continue;
                        }
                        //if (($acl = (string)$attributes->acl) && Mage::getSingleton('admin/session')->isAllowed($acl)) {
                        //    continue;
                        //}
                        if (!isset($block->attributes()->ignore)) {
                            $block->addAttribute('ignore', true);
                        }
                    }
                }
            }
        }
        
        $this->setXml($xml);
    }

    /**
     * Create layout blocks hierarchy from layout xml configuration
     *
     * @param Cream_Layout_Element|null $parent
     */
    public function generateBlocks($parent=null)
    {
        if (empty($parent)) {
            $parent = $this->getNode();
        }
        foreach ($parent as $node) {
            $attributes = $node->attributes();
            if ((bool)$attributes->ignore) {
                continue;
            }
            switch ($node->getName()) {
                case 'block':
                    $this->_generateBlock($node, $parent);
                    $this->generateBlocks($node);
                    break;

                case 'reference':
                    $this->generateBlocks($node);
                    break;

                case 'action':
                    $this->_generateAction($node, $parent);
                    break;
            }
        }
    }

    /**
     * Add block object to layout based on xml node data
     *
     * @param Cream_Config_Xml_Element $node
     * @param Cream_Config_Xml_Element $parent
     * @return void
     */
    protected function _generateBlock($node, $parent)
    {
        if (!empty($node['class'])) {
            $className = (string)$node['class'];
        } else {
            $className = (string)$node['type'];
        }

        $blockName = (string)$node['name'];   

        $block = $this->addBlock($className, $blockName);

        if (!$block) {
            return;
        }

        if (!empty($node['parent'])) {
            $parentBlock = $this->getBlock((string)$node['parent']);
        } else {
            $parentName = $parent->getBlockName();
            if (!empty($parentName)) {
                $parentBlock = $this->getBlock($parentName);
            }
        }
        if (!empty($parentBlock)) {
            $alias = isset($node['as']) ? (string)$node['as'] : '';
            if (isset($node['before'])) {
                $sibling = (string)$node['before'];
                if ('-'===$sibling) {
                    $sibling = '';
                }
                $parentBlock->insert($block, $sibling, false, $alias);
            } elseif (isset($node['after'])) {
                $sibling = (string)$node['after'];
                if ('-'===$sibling) {
                    $sibling = '';
                }
                $parentBlock->insert($block, $sibling, true, $alias);
            } else {
                $parentBlock->append($block, $alias);
            }
        }
        if (!empty($node['template'])) {
            $block->setTemplate((string)$node['template']);
        }

        if (!empty($node['output'])) {
            $method = (string)$node['output'];
            $this->addOutputBlock($blockName, $method);
        }
    }

    /**
     * Enter description here...
     *
     * @param Cream_Config_Xml_Element $node
     * @param Cream_Config_Xml_Element $parent
     * @return void
     */
    protected function _generateAction($node, $parent)
    {
        if (isset($node['ifconfig']) && ($configPath = (string)$node['ifconfig'])) {
            //if (!Mage::getStoreConfigFlag($configPath)) {
                return $this;
            //}
        }

        $method = (string)$node['method'];
        if (!empty($node['block'])) {
            $parentName = (string)$node['block'];
        } else {
            $parentName = $parent->getBlockName();
        }
        
        if (!empty($parentName)) {
            $block = $this->getBlock($parentName);
        }
        if (!empty($block)) {

            $args = (array)$node->children();
            unset($args['@attributes']);

            foreach ($args as $key => $arg) {
                if (($arg instanceof Mage_Core_Model_Layout_Element)) {
                    if (isset($arg['helper'])) {
                        $helperName = explode('/', (string)$arg['helper']);
                        $helperMethod = array_pop($helperName);
                        $helperName = implode('/', $helperName);
                        $arg = $arg->asArray();
                        unset($arg['@']);
                        $args[$key] = call_user_func_array(array(Mage::helper($helperName), $helperMethod), $arg);
                    } else {
                        /**
                         * if there is no helper we hope that this is assoc array
                         */
                        $arr = array();
                        foreach($arg as $subkey => $value) {
                            $arr[(string)$subkey] = $value->asArray();
                        }
                        if (!empty($arr)) {
                            $args[$key] = $arr;
                        }
                    }
                }
            }

            if (isset($node['json'])) {
                $json = explode(' ', (string)$node['json']);
                foreach ($json as $arg) {
                    $args[$arg] = Mage::helper('core')->jsonDecode($args[$arg]);
                }
            }

            $this->_translateLayoutNode($node, $args);
            call_user_func_array(array($block, $method), $args);
        }
    }

    /**
     * Translate layout node
     *
     * @param Cream_Config_Xml_Element $node
     * @param array $args
     **/
    protected function _translateLayoutNode($node, &$args)
    {
        if (isset($node['translate'])) {
            $items = explode(' ', (string)$node['translate']);
            foreach ($items as $arg) {
                if (isset($node['module'])) {
                    $args[$arg] = Mage::helper((string)$node['module'])->__($args[$arg]);
                }
                else {
                    $args[$arg] = Mage::helper('core')->__($args[$arg]);
                }
            }
        }
    }

    /**
     * Save block in blocks registry
     *
     * @param string $name
     * @param Cream_Web_UI_Control $block
     */
    public function setBlock($name, $block)
    {
        $this->_blocks[$name] = $block;
        return $this;
    }

    /**
     * Remove block from registry
     *
     * @param string $name
     */
    public function unsetBlock($name)
    {
        $this->_blocks[$name] = null;
        unset($this->_blocks[$name]);
        return $this;
    }

    /**
     * Block Factory
     *
     * @param     string $type
     * @param     string $blockName
     * @param     array $attributes
     * @return    Cream_Web_UI_Control
     */
    public function createBlock($type, $name='', array $attributes = array())
    {
		$block = $this->_getBlockInstance($type, $attributes);

        if (empty($name) || '.'===$name{0}) {
            $block->setIsAnonymous(true);
            if (!empty($name)) {
                $block->setAnonSuffix(substr($name, 1));
            }
            $name = 'ANONYMOUS_'.sizeof($this->_blocks);
        } elseif (isset($this->_blocks[$name])) {
            throw new Cream_Exceptions_Exception('Block with name "'. $name .'" already exists');
        }

        //$block->setType($type);
        $block->setNameInLayout($name);
        //$block->addData($attributes);
        $block->setLayout($this);

        $this->_blocks[$name] = $block;
        
        return $block;
    }

    /**
     * Add a block to registry, create new object if needed
     *
     * @param string|Cream_Web_UI_Control $blockClass
     * @param string $blockName
     * @return Cream_Web_UI_Control
     */
    public function addBlock($block, $blockName)
    {
        return $this->createBlock($block, $blockName);
    }

    /**
     * Create block object instance based on block type
     *
     * @param string $block
     * @param array $attributes
     * @return Cream_Web_UI_Control
     */
    protected function _getBlockInstance($block, array $attributes=array())
    {
        if (is_string($block)) {
            if (strpos($block, '/')!==false) {
                if (!$block = $this->getApplication()->getConfig()->getBlockClassName($block)) {
                    throw new Cream_Layout_Exception_InvalidBlockTypeException('Invalid block type: '. $block);
                }
            }
            if (class_exists($block)) {
                $block = Cream::instance($block, $attributes);
            }
        }
        
        if (!$block instanceof Cream_Web_UI_Control) {
        	throw new Cream_Layout_Exception_InvalidBlockTypeException('Invalid block type: '. $block);
		}
		
        return $block;
    }


    /**
     * Retrieve all blocks from registry as array
     *
     * @return array
     */
    public function getAllBlocks()
    {
        return $this->_blocks;
    }

    /**
     * Get block object by name
     *
     * @param string $name
     * @return Cream_Web_UI_Control
     */
    public function getBlock($name)
    {
        if (isset($this->_blocks[$name])) {
            return $this->_blocks[$name];
        } else {
            return false;
        }
    }

    /**
     * Add a block to output
     *
     * @param string $blockName
     * @param string $method
     */
    public function addOutputBlock($blockName, $method='toHtml')
    {
        $this->_output[$blockName] = array($blockName, $method);
    }

    public function removeOutputBlock($blockName)
    {
        unset($this->_output[$blockName]);
    }

    /**
     * Get all blocks marked for output
     *
     * @return string
     */
    public function getOutput()
    {
        $out = '';
        if (!empty($this->_output)) {
            foreach ($this->_output as $callback) {
                $out .= $this->getBlock($callback[0])->$callback[1]();
            }
        }

        return $out;
    }

    /**
     * Enter description here...
     *
     * @param string $type
     * @return Mage_Core_Helper_Abstract
     */
    public function getBlockSingleton($type)
    {
        if (!isset($this->_helpers[$type])) {
            $className = Mage::getConfig()->getBlockClassName($type);
            if (!$className) {
                throw new Cream_Exceptions_Exception('Invalid block type: '. $type);
            }

            $helper = new $className();
            if ($helper) {
                if ($helper instanceof Cream_Web_UI_Control) {
                    $helper->setLayout($this);
                }
                $this->_helpers[$type] = $helper;
            }
        }
        return $this->_helpers[$type];
    }

    /**
     * Lookup module name for translation from current specified layout node
     *
     * Priorities:
     * 1) "module" attribute in the element
     * 2) "module" attribute in any ancestor element
     * 3) layout handle name - first 1 or 2 parts (namespace is determined automatically)
     *
     * @param Cream_Config_Xml_Element $node
     * @return string
     */
    public static function findTranslationModuleName(Cream_Config_Xml_Element $node)
    {
        $result = $node->getAttribute('module');
        if ($result) {
            return (string)$result;
        }
        foreach (array_reverse($node->xpath('ancestor::*[@module]')) as $element) {
            $result = $element->getAttribute('module');
            if ($result) {
                return (string)$result;
            }
        }
        foreach ($node->xpath('ancestor-or-self::*[last()-1]') as $handle) {
            $name = Mage::getConfig()->determineOmittedNamespace($handle->getName());
            if ($name) {
                return $name;
            }
        }
        return 'core';
    }
}