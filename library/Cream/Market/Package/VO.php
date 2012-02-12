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

class Cream_Market_Package_VO implements Iterator
{
    protected $properties = array(
        'name' => '',
	    'package_type_vesrion' => '',
        'cahnnel' => '',
        'extends' => '',
		'summary' => '',
		'description' => '',
		'authors' => '',
		'date' => '',
	    'time' => '',
		'version' => '',
	    'stability' => 'dev',
	    'license' => '',
	    'license_uri' => '',
	    'contents' => '',
	    'compatible' => '',	  
		'hotfix' => ''  
		);
		
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

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
	    return $this->properties;
	}
}