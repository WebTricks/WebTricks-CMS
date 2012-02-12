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


class Cream_Market_Channel_VO implements Iterator
{
    private $_validator = null;
    
    protected $properties = array(
        'name' => '',
        'uri' => '',
        'summary' => '',
    );

    public function rewind() 
    {
        reset($this->properties);
    }

    public function valid() 
    {
        return current($this->properties) !== false;
    }

    public function key() 
    {
        return key($this->properties);
    }

    public function current() 
    {
        return current($this->properties);
    }

    public function next() 
    {
        next($this->properties);
    }

    public function __get($var)
    {
        if (isset($this->properties[$var])) {
            return $this->properties[$var];
        }
        return null;
    }

    public function __set($var, $value)
    {
        if (is_string($value)) {
            $value = trim($value);
        }
        if (isset($this->properties[$var])) {
            if ($value === null) {
                $value = '';
            }
            $this->properties[$var] = $value;
        }
    }

    public function toArray()
    {
        return array('channel' => $this->properties);
    }
     
    public function fromArray(array $arr)
    {
        foreach($arr as $k=>$v) {
            $this->$k = $v;
        }
    }

    
    protected function _validator()
    { 
        if(is_null($this->_validator)) {
            $this->_validator = Cream_Market_Validator::instance();
        }
        return $this->_validator;
    }
    
    /**
     Stub for validation result
     */
    public function validate()
    {
        $v = $this->_validator();
        if(!$v->validatePackageName($this->name)) {
            return false;
        }
        return true;
    }

}