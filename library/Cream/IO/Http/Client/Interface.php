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

/**
 * Interface for different HTTP clients
 *
 * @category    Cream
 * @package     Cream_IO
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
interface Cream_IO_Http_Client_Interface
{
    /**
     * Set request timeout
	 * 
     * @param int $value
     */
    function setTimeout($value);
    
    /**
     * Set request headers from hash
	 * 
     * @param array $headers
     */
    function setHeaders($headers);
    
    /**
     * Add header to request 
	 * 
     * @param string $name
     * @param string $value
     */
    function addHeader($name, $value);
    
    /**
     * Remove header from request
	 * 
     * @param string $name
     */
    function removeHeader($name);
	
    /**
     * Set login credentials
     * for basic auth.
	 * 
     * @param string $login
     * @param string $pass
     */
    function setCredentials($login, $pass);
    
    /**
     * Add cookie to request 
	 * 
     * @param string $name
     * @param string $value
     */
    function addCookie($name, $value);

    /**
     * Remove cookie from request
	 * 
     * @param string $name
     */
    function removeCookie($name);
    
    /**
     * Set request cookies from hash
	 * 
     * @param array $cookies
     */ 
    function setCookies($cookies);

    /**
     * Remove cookies from request
     */
    function removeCookies();

    /**
     * Make GET request
	 * 
     * @param string full uri
     */
    function get($uri);

    /**
     * Make POST request
	 * 
     * @param string $uri full uri
     * @param array $params POST fields array
     */ 
    function post($uri, $params);
    
    /**
     * Get response headers
	 * 
     * @return array
     */ 
    function getHeaders();
    
    /**
     * Get response body
	 * 
     * @return string
     */
    function getBody(); 
    
    /**
     * Get response status code
	 * 
     * @return int
     */
    function getStatus();
    
    /**
     * Get response cookies (k=>v) 
	 * 
     * @return array
     */
    function getCookies();
    
    /**
     * Set additional option
	 * 
     * @param string $key
     * @param string $value
     */
    function setOption($key, $value);

    /**
     * Set additional options
	 * 
     * @param array $arr
     */
    function setOptions($arr);
}