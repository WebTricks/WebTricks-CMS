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
 * Encodes PHP variables (string, array, objects) into JSON. Extends 
 * {@link Zend_Json_Encoder} class.
 * 
 * @package		Cream_Json
 * @author		Danny Verkade
 */
class Cream_Json_Encoder extends Zend_Json_Encoder
{
    /**
     * Use the JSON encoding scheme for the value specified
     *
     * @param mixed $value The value to be encoded
     * @param boolean $cycleCheck Whether or not to check for possible object recursion when encoding
     * @param array $options Additional options used during encoding
     * @return string  The encoded value
     */
    public static function encode($value, $cycleCheck = false, $options = array())
    {
        $encoder = new self(($cycleCheck) ? true : false, $options);

        return $encoder->_encodeValue($value);
    }
    
    /**
     * Encode an object to JSON by encoding each of the public properties
     *
     * A special property is added to the JSON object called '__className'
     * that contains the name of the class of $value. This is used to decode
     * the object on the client into a specific class.
     *
     * @param $value object
     * @return string
     * @throws Zend_Json_Exception If recursive checks are enabled and the object has been serialized previously
     */
    protected function _encodeObject(&$value)
    {
    	if ($value instanceof Cream_Expression) {
    		return $value->__toString();
    	}
    	
        if (is_object($value) && method_exists($value, 'toJson')) {
            return $value->toJson();
        }
    	
        if ($this->_cycleCheck) {
            if ($this->_wasVisited($value)) {

                if (isset($this->_options['silenceCyclicalExceptions'])
                    && $this->_options['silenceCyclicalExceptions']===true) {

                    return '"* RECURSION (' . get_class($value) . ') *"';

                } else {
                    require_once 'Zend/Json/Exception.php';
                    throw new Zend_Json_Exception(
                        'Cycles not supported in JSON encoding, cycle introduced by '
                        . 'class "' . get_class($value) . '"'
                    );
                }
            }

            $this->_visited[] = $value;
        }

        $props = '';

        if ($value instanceof Iterator) {
            $propCollection = $value;
        } else {
            $propCollection = get_object_vars($value);
        }

        foreach ($propCollection as $name => $propValue) {
            if (isset($propValue)) {
                $props .= ','
                        . $this->_encodeString($name)
                        . ':'
                        . $this->_encodeValue($propValue);
            }
        }

        return '{"__className":"' . get_class($value) . '"'
                . $props . '}';
    }
}