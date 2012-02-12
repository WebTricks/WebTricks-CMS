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
 * Base class, basic getter and setter functions for objects.
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class Cream_Object implements ArrayAccess
{
    /**
     * Object data
     *
     * @var array
     */
    protected $_data = array();

    /**
     * True when data has been changed. Otherwise false.
     * 
     * @var boolean
     */
    protected $_hasDataChanges = false;
    
    /**
     * Setter/Getter underscore transformation cache
     *
     * @var array
     */
    protected static $_underscoreCache = array();    
	   
    /**
     * Set/Get attribute wrapper
     *
     * @param   string $method
     * @param   array $args
     * @return  mixed
     */
    public function __call($method, $args)
    {
        switch (substr($method, 0, 3)) {
            case 'get':
                $key = $this->_underscore(substr($method,3));
        		$data = $this->_getData($key, isset($args[0]) ? $args[0] : null);
                return $data;
            case 'set':
                $key = $this->_underscore(substr($method,3));
                $result = $this->_setData($key, isset($args[0]) ? $args[0] : null);
                return $result;
            case 'uns':
                $key = $this->_underscore(substr($method,3));
                $result = $this->_unsetData($key);
                return $result;
            case 'has':
                $key = $this->_underscore(substr($method,3));
                return isset($this->_data[$key]);
        }
        
        throw new Cream_Exceptions_InvalidMethodException("Invalid method ". get_class($this) ."::".$method."(". print_r($args,1) .")");
    }
    
    /**
     * Attribute getter (deprecated)
     *
     * @param string $var
     * @return mixed
     */

    public function __get($var)
    {
        return $this->_getData($var);
    }

    /**
     * Attribute setter (deprecated)
     *
     * @param string $var
     * @param mixed $value
     */
    public function __set($var, $value)
    {
        $this->_setData($var, $value);
    }
    
    /**
     * Converts field names for setters and geters
     *
     * $this->setMyField($value) === $this->_setData('my_field', $value)
     * Uses cache to eliminate unneccessary preg_replace
     *
     * @param string $name
     * @return string
     */
    protected function _underscore($name)
    {
    	if ($name === null) {
    		return null;
    	}
    	
        if (isset(self::$_underscoreCache[$name])) {
            return self::$_underscoreCache[$name];
        }

        $result = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
        self::$_underscoreCache[$name] = $result;
        return $result;
    }

    /**
     * Add data to the object.
     *
     * Retains previous data in the object.
     *
     * @param array $data
     */
    public function addData(array $data)
    {
        foreach($data as $index => $value) {
            $this->_setData($index, $value);
        }
    }

    /**
     * Overwrite data in the object.
     *
     * $key can be string or array.
     * If $key is string, the attribute value will be overwritten by $value
     *
     * If $key is an array, it will overwrite all the data in the object.
     *
     * @param string|array $key
     * @param mixed $value
     */
    protected function _setData($key, $value = null)
    {
		$key = $this->_underscore($key);
        $this->_hasDataChanges = true;
        if(is_array($key)) {
            $this->_data = $key;
        } else {
            $this->_data[$key] = $value;
        }
    }

    /**
     * Unset data from the object.
     *
     * $key can be a string only. Array will be ignored.
     *
     * @param string $key
     */
    protected function _unsetData($key = null)
    {
		$key = $this->_underscore($key);    	
        $this->_hasDataChanges = true;

        if (is_null($key)) {
            $this->_data = array();
        } else {
            unset($this->_data[$key]);
        }
    }

    /**
     * Retrieves data from the object
     *
     * If $key is empty will return all the data as an array
     * Otherwise it will return value of the attribute specified by $key
     *
     * @param string $key
     * @return mixed
     */
    protected function _getData($key = '')
    {
        if ('' === $key) {
            return $this->_data;
        }
        
		$key = $this->_underscore($key);

        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        }
        
        return null;
    }
    
    /**
     * Returns true if the specified key exists, otherwise false.
     * 
     * @param string $key
     * @return boolean
     */
    protected function _hasData($key)
    {
        $key = $this->_underscore($key);    	
    	
        if (isset($this->_data[$key])) {
        	return true;
        } else {
        	return false;
        }
	}
    
    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * @link http://www.php.net/manual/en/arrayaccess.offsetset.php
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->_data[$offset] = $value;
    }

    /**
     * Implementation of ArrayAccess::offsetExists()
     *
     * @link http://www.php.net/manual/en/arrayaccess.offsetexists.php
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->_data[$offset]);
    }

    /**
     * Implementation of ArrayAccess::offsetUnset()
     *
     * @link http://www.php.net/manual/en/arrayaccess.offsetunset.php
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->_data[$offset]);
    }

    /**
     * Implementation of ArrayAccess::offsetGet()
     *
     * @link http://www.php.net/manual/en/arrayaccess.offsetget.php
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->_data[$offset]) ? $this->_data[$offset] : null;
    }
    
    /**
     * Determines if data has been changed on the object.
     * 
     * @return boolean
     */
    public function hasDataChanges()
    {
    	return $this->_hasDataChanges;
    }
}