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
 * Encodes PHP to JSON and decodes JSON to PHP. Extends {@link Zend_Json} class.
 *
 * @package		Cream_Json
 * @author		Danny Verkade
 */
class Cream_Json extends Zend_Json
{
    /**
     * @var bool
     */
    public static $useBuiltinEncoderDecoder = true;

    /**
     * Encode the mixed $valueToEncode into the JSON format
     *
     * Encodes using ext/json's json_encode() if available.
     *
     * NOTE: Object should not contain cycles; the JSON format
     * does not allow object reference.
     *
     * NOTE: Only public variables will be encoded
     *
     * NOTE: Encoding native javascript expressions are possible using Zend_Json_Expr.
     *       You can enable this by setting $options['enableJsonExprFinder'] = true
     *
     * @see Zend_Json_Expr
     *
     * @param  mixed $valueToEncode
     * @param  boolean $cycleCheck Optional; whether or not to check for object recursion; off by default
     * @param  array $options Additional options used during encoding
     * @return string JSON encoded object
     */
    public static function encode($valueToEncode, $cycleCheck = false, $options = array())
    {
        if (is_object($valueToEncode) && method_exists($valueToEncode, 'toJson')) {
            return $valueToEncode->toJson();
        }

        // Pre-encoding look for Zend_Json_Expr objects and replacing by tmp ids
        $javascriptExpressions = array();
        if(isset($options['enableJsonExprFinder'])
           && ($options['enableJsonExprFinder'] == true)
        ) {
            $valueToEncode = self::_recursiveJsonExprFinder($valueToEncode, $javascriptExpressions);
        }

        // Encoding
        if (function_exists('json_encode') && self::$useBuiltinEncoderDecoder !== true) {
            $encodedResult = json_encode($valueToEncode);
        } else {
            $encodedResult = Cream_Json_Encoder::encode($valueToEncode, $cycleCheck, $options);
        }

        //only do post-proccessing to revert back the Zend_Json_Expr if any.
        if (count($javascriptExpressions) > 0) {
            $count = count($javascriptExpressions);
            for($i = 0; $i < $count; $i++) {
                $magicKey = $javascriptExpressions[$i]['magicKey'];
                $value    = $javascriptExpressions[$i]['value'];

                $encodedResult = str_replace(
                    //instead of replacing "key:magicKey", we replace directly magicKey by value because "key" never changes.
                    '"' . $magicKey . '"',
                    $value,
                    $encodedResult
                );
            }
        }

         return $encodedResult;
    }
}