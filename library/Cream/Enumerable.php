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
 * Cream_Enumerable is the base class for all enumerable types. To define an
 * enumerable type, extend Cream_Enumberable and define string constants. Each
 * constant represents an enumerable value. For example:
 * <code>
 * class TextAlign extends Cream_Enumerable
 * {
 *     const left = 'left';
 *     const right = 'right';
 * }
 * </code>
 * Then, one can use the enumerable values such as TextAlign::Left and
 * TextAlign::Right.
 *
 * @package 	Cream
 * @author 		Danny Verkade
 */
class Cream_Enumerable
{
}