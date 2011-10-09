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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Abstract session class. Should be extended by session objects. 
 * Wraps around Zend_Session_Namespace.
 *
 * @package 	Cream
 * @author 		WebTricks Core Team <core@webtricksframework.com>
 */
abstract class Cream_Session_Abstract extends Cream_ApplicationComponent
{
    /**
     * Session namespace object
     *
     * @var Zend_Session_Namespace
     */
    protected $_namespace;

    /**
     * 
     * Enter description here ...
     */
    public function start()
    {
        $options = array(
            'save_path' => $this->getApplication()->getOptions()->getSessionDir(),
            'use_only_cookies'=>'off',
        );

        Zend_Session::setOptions($options);
        Zend_Session::start();
    }

    /**
     * Initialization session namespace
     *
     * @param string $namespace
     */
    public function init($namespace)
    {
        if (!Zend_Session::isStarted()) {
            $this->start();
        }

        $this->_namespace = new Zend_Session_Namespace($namespace);
    }

    /**
     * Redeclaration object setter
     *
     * @param   string $key
     * @param   mixed $value
     */
    protected function _setData($key, $value = '', $isChanged = false)
    {
        if (!$this->_namespace->data) {
            $this->_namespace->data = new Cream_Object();
        }
        
        $this->_namespace->data[$key] = $value;
    }

    /**
     * Redeclaration object getter
     *
     * @param   string $var
     * @param   bool $clear
     * @return  mixed
     */
    protected function _getData($var = null, $clear = false)
    {
        if (!$this->_namespace->data) {
            $this->_namespace->data = new Cream_Object();
        }

        $data = $this->_namespace->data[$var];

        if ($clear) {
            unset($this->_namespace->data[$var]);
        }

        return $data;
    }

    /**
     * Clears all data of this session.
     *
     * @return void
     */
    public function unsetAll()
    {
        $this->_namespace->unsetAll();
    }

    /**
     * Retrieve current session identifier
     *
     * @return string
     */
    public function getSessionId()
    {
        return Zend_Session::getId();
    }

    /**
     * Sets the session id.
     * 
     * @param string $id
     */
    public function setSessionId($id)
    {
		Zend_Session::setId($id);
    }
    
    public function addError($id, $message)
    {
    	$errors = $this->_getData('errors');
    	$errors[$id] = $message;
    	$this->_setData('errors', $errors);
    }
    
    public function getErrors()
    {
    	if (!$this->_getData('errors')) {
    		$this->_setData('errors', array());
    	}
    	
    	return $this->_getData('errors');
    }
    
    public function getError($id)
    {
    	$errors = $this->getErrors();

    	foreach($errors as $key => $error) {
    		if ($key == $id) {
    			unset($errors[$key]);
    			$this->_setData('errors', $errors);
    			return $error;
    		}
    	}
    }
    
    public function hasError($id)
    {
    	$errors = $this->getErrors();    	
    	return array_key_exists($id, $errors);
    }
}