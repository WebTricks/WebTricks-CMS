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
 * URL utility class
 *
 * @package		Cream_Url
 * @author		Danny Verkade
 */
class Cream_Url_Utility extends Cream_ApplicationComponent
{
    /**
     *  base64_encode() for URLs encoding
     *
     *  @param    string $url
     *  @return	  string
     */
    public static function encode($url)
    {
        return strtr(base64_encode($url), '+/=', '-_,');
    }

    /**
     *  base64_decode() for URLs decoding
     *
     *  @param    string $url
     *  @return	  string
     */
    public static function decode($url)
    {
        return base64_decode(strtr($url, '-_,', '+/='));
    }	
}