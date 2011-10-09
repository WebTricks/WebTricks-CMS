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
 * Base class for all routers.
 *
 * @package		Cream_Controller
 * @author		Danny Verkade
 */
abstract class Cream_Controller_Router_Abstract extends Cream_ApplicationComponent
{
	/**
	 * Front controller object
	 * 
	 * @var Cream_Controller_Front
	 */
    protected $_front;

    /**
     * Sets the front controller object
     * 
     * @param Cream_Controller_Front $front
     */
    public function setFront(Cream_Controller_Front $front)
    {
        $this->_front = $front;
    }

    /**
     * Returns the front controller
     * 
     * @return Cream_Controller_Front
     */
    public function getFront()
    {
        return $this->_front;
    }

    public function getFrontNameByRoute($routeName)
    {
        return $routeName;
    }

    public function getRouteByFrontName($frontName)
    {
        return $frontName;
    }

    abstract public function match(Cream_Controller_Request_Http $request);
}