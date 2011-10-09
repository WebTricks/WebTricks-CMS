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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Utility class with functions for serializing items and parsing
 * back.
 *
 * @package		Cream_Content
 * @author		Webtricks Core Team <core@webtricksframework.com>
 */
class Cream_Content_Serialization_Util
{
	/**
	 * Creates a splitter. Returns the string of the splitter based
	 * on the given key.
	 *  
	 * @param string $key
	 * @return string
	 */
	private static function _getSplitter($key)
	{
		return "----". $key ."----";
	}

    /**
     * Writes header information to the tokenizer.
     * 
     * @param string $header
     * @param string $value
     * @param Cream_Content_Serialization_Tokenizer $tokenizer
     */
    public static function writeHeader($header, $value, Cream_Content_Serialization_Tokenizer $tokenizer)
    {
    	$tokenizer->addLine($header .': '. $value);
    }

    /**
     * Writes a new line to the tokenizer.
     * 
     * @param Cream_Content_Serialization_Tokenizer $tokenizer
     */
    public static function writeNewLine(Cream_Content_Serialization_Tokenizer $tokenizer)
    {
        $tokenizer->addLine();
    }

    /**
     * Writes a splitter to the tokenizer.
     * 
     * @param string $key
     * @param Cream_Content_Serialization_Tokenizer $tokenizer
     */
    public static function writeSplitter($key, Cream_Content_Serialization_Tokenizer $tokenizer)
    {
    	$tokenizer->addLine(self::_getSplitter($key));
    }

    /**
     * Writes text to the tokenizer.
     * 
     * @param string $text
     * @param Cream_Content_Serialization_Tokenizer $tokenizer
     */
    public static function writeText($text, Cream_Content_Serialization_Tokenizer $tokenizer)
    {
    	$tokenizer->addLine($text);
    }
    
    /**
     * Reads the headers from the tokenizer. Returns an array holding
     * the header key as array key and the value as value of the
     * array.

     * @param Cream_Content_Serialization_Tokenizer $tokenizer
     * @return array
     */
    public static function readHeaders(Cream_Content_Serialization_Tokenizer $tokenizer)
    {
    	$values = array();
    	
    	while($tokenizer->getLine() !== '') {
    		$split = explode(':', $tokenizer->getLine());
    		$key = trim($split[0]);
    		$value = trim($split[1]);
    		$values[$key] = $value;
    		
    		$tokenizer->nextLine();
    	}
    	
    	return $values;
    }
}