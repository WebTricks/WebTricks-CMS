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
 * The expression class can be used to parse special variables into
 * several components.
 *
 * @package 	Cream
 * @author 		Danny Verkade
 */
class Cream_Expression
{
    /**
     * Storage the expression
     *
     * @var string
     */
    protected $_expression;

    /**
     * Creates an instance of this class
     *
     * @param string $expression
     * @return Cream_Expression
     */
    public static function instance($expression)
    {
    	return Cream::instance(__CLASS__, $expression);
    }
    
    /**
     * Instantiate an expression, which is just a string stored as
     * an instance member variable.
     *
     * @param string $expression The string containing a expression.
     */
    public function __init($expression)
    {
        $this->_expression = (string) $expression;
    }

    /**
     * @return string The string of the SQL expression stored in this object.
     */
    public function __toString()
    {
        return $this->_expression;
    }
}