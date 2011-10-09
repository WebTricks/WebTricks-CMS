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
 * Custom HTTP request object based upon the Zend object.
 *
 * @package		Cream_Controller
 * @author		Danny Verkade
 */
class Cream_Controller_Request_Http extends Zend_Controller_Request_Http
{   
    /**
     * ORIGINAL_PATH_INFO
     * @var string
     */
    protected $_originalPathInfo= '';
    protected $_storeCode       = null;
    protected $_requestString   = '';

    /**
     * Path info array used before applying rewrite from config
     *
     * @var null || array
     */
    protected $_rewritedPathInfo= null;
    protected $_requestedRouteName = null;

    protected $_route;

    protected $_directFrontNames = array();
    protected $_controllerModule = null;

    /**
     * Streight request flag.
     * If flag is determined no additional logic is applicable
     *
     * @var $_isStraight bool
     */
    protected $_isStraight = false;

    /**
     * Request's original information before forward.
     *
     * @var array
     */
    protected $_beforeForwardInfo = array();

    /**
     * Create a new instance of this class
     * 
     * @return Cream_Controller_Request_Http
     */
    public static function instance()
    {
    	return Cream::instance(__CLASS__);
    }

    /**
     * Returns ORIGINAL_PATH_INFO.
     * This value is calculated instead of reading PATH_INFO
     * directly from $_SERVER due to cross-platform differences.
     *
     * @return string
     */
    public function getOriginalPathInfo()
    {
        if (empty($this->_originalPathInfo)) {
            $this->setPathInfo();
        }

        return $this->_originalPathInfo;
    }

    /**
     * Set the PATH_INFO string
     * Set the ORIGINAL_PATH_INFO string
     *
     * @param string|null $pathInfo
     */
    public function setPathInfo($pathInfo = null)
    {
        if ($pathInfo === null) {
            $requestUri = $this->getRequestUri();
            if (null === $requestUri) {
                return $this;
            }

            // Remove the query string from REQUEST_URI
            $pos = strpos($requestUri, '?');
            if ($pos) {
                $requestUri = substr($requestUri, 0, $pos);
            }

            $baseUrl = $this->getBaseUrl();
            $pathInfo = substr($requestUri, strlen($baseUrl));

            if ((null !== $baseUrl) && (false === $pathInfo)) {
                $pathInfo = '';
            } elseif (null === $baseUrl) {
                $pathInfo = $requestUri;
            }

            $this->_originalPathInfo = (string) $pathInfo;
            $this->_requestString = $pathInfo . ($pos!==false ? substr($requestUri, $pos) : '');
        }

        $this->_pathInfo = (string) $pathInfo;
    }

    /**
     * Specify new path info
     * It happen when occur rewrite based on configuration
     *
     * @param   string $pathInfo
     */
    public function rewritePathInfo($pathInfo)
    {
        if (($pathInfo != $this->getPathInfo()) && ($this->_rewritedPathInfo === null)) {
            $this->_rewritedPathInfo = explode('/', trim($this->getPathInfo(), '/'));
        }
        $this->setPathInfo($pathInfo);
    }

    public function getOriginalRequest()
    {
        $request = new Zend_Controller_Request_Http();
        $request->setPathInfo($this->getOriginalPathInfo());
        return $request;
    }

    public function getRequestString()
    {
        return $this->_requestString;
    }

    public function getBasePath()
    {
        $path = parent::getBasePath();
        if (empty($path)) {
            $path = '/';
        } else {
            $path = str_replace('\\', '/', $path);
        }
        return $path;
    }

    public function getBaseUrl()
    {
        $url = parent::getBaseUrl();
        $url = str_replace('\\', '/', $url);
        return $url;
    }

    public function setRouteName($route)
    {
        $this->_route = $route;
        $router = Cream::getApplication()->getFrontController()->getRouterByRoute($route);
        if (!$router) return $this;
        $module = $router->getFrontNameByRoute($route);
        if ($module) {
            $this->setModuleName($module);
        }
        return $this;
    }

    public function getRouteName()
    {
        return $this->_route;
    }

    /**
     * Retrieve HTTP HOST
     *
     * @param bool $trimPort
     * @return string
     */
    public function getHttpHost($trimPort = true)
    {
        if (!isset($_SERVER['HTTP_HOST'])) {
            return false;
        }
        if ($trimPort) {
            $host = explode(':', $_SERVER['HTTP_HOST']);
            return $host[0];
        }
        return $_SERVER['HTTP_HOST'];
    }
    
    /**
     * Returns the port of the request.
     * 
     * @return integer
     */
    public function getHttpPort()
    {
        $host = explode(':', $_SERVER['HTTP_HOST']);
        if (isset($host[1])) {
        	return $host[1];
        } else {
        	return 80;
        }
    }

    /**
     * Set a member of the $_POST superglobal
     *
     * @param striing|array $key
     * @param mixed $value
     *
     * @return Cream_Controller_Request_Http
     */
    public function setPost($key, $value = null)
    {
        if (is_array($key)) {
            $_POST = $key;
        }
        else {
            $_POST[$key] = $value;
        }
        return $this;
    }

    /**
     * Specify module name where was found currently used controller
     *
     * @param   string $module
     */
    public function setControllerModule($module)
    {
        $this->_controllerModule = $module;
    }

    /**
     * Get module name of currently used controller
     *
     * @return string
     */
    public function getControllerModule()
    {
        return $this->_controllerModule;
    }

    /**
     * Retrieve the module name
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->_module;
    }
    /**
     * Retrieve the controller name
     *
     * @return string
     */
    public function getControllerName()
    {
        return $this->_controller;
    }
    /**
     * Retrieve the action name
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->_action;
    }

    /**
     * Get route name used in request (ignore rewrite)
     *
     * @return string
     */
    public function getRequestedRouteName()
    {
        if ($this->_requestedRouteName === null) {
            if ($this->_rewritedPathInfo !== null && isset($this->_rewritedPathInfo[0])) {
                $fronName = $this->_rewritedPathInfo[0];
                $router = Cream::getApplication()->getFrontController()->getRouterByFrontName($fronName);
                $this->_requestedRouteName = $router->getRouteByFrontName($fronName);
            } else {
                // no rewritten path found, use default route name
                return $this->getRouteName();
            }
        }
        return $this->_requestedRouteName;
    }

    /**
     * Get controller name used in request (ignore rewrite)
     *
     * @return string
     */
    public function getRequestedControllerName()
    {
        if (($this->_rewritedPathInfo !== null) && isset($this->_rewritedPathInfo[1])) {
            return $this->_rewritedPathInfo[1];
        }
        return $this->getControllerName();
    }

    /**
     * Get action name used in request (ignore rewrite)
     *
     * @return string
     */
    public function getRequestedActionName()
    {
        if (($this->_rewritedPathInfo !== null) && isset($this->_rewritedPathInfo[2])) {
            return $this->_rewritedPathInfo[2];
        }
        return $this->getActionName();
    }

    /**
     * Collect properties changed by _forward in protected storage
     * before _forward was called first time.
     *
     * @return Cream_Controller_Action
     */
    public function initForward()
    {
        if (empty($this->_beforeForwardInfo)) {
            $this->_beforeForwardInfo = array(
                'params' => $this->getParams(),
                'action_name' => $this->getActionName(),
                'controller_name' => $this->getControllerName(),
                'module_name' => $this->getModuleName()
            );
        }

        return $this;
    }

    /**
     * Retrieve property's value which was before _forward call.
     * If property was not changed during _forward call null will be returned.
     * If passed name will be null whole state array will be returned.
     *
     * @param string $name
     * @return array|string|null
     */
    public function getBeforeForwardInfo($name = null)
    {
        if (is_null($name)) {
            return $this->_beforeForwardInfo;
        } elseif (isset($this->_beforeForwardInfo[$name])) {
            return $this->_beforeForwardInfo[$name];
        }

        return null;
    }

    /**
     * Specify/get _isStraight flag value
     *
     * @param bool $flag
     * @return bool
     */
    public function isStraight($flag = null)
    {
        if ($flag !== null) {
            $this->_isStraight = $flag;
        }
        return $this->_isStraight;
    }
}