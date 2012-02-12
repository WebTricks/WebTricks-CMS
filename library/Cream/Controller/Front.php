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
 * Front controller
 *
 * @package		Cream_Controller
 * @author		Danny Verkade
 */
class Cream_Controller_Front extends Cream_ApplicationComponent
{
    const CONFIG_ROUTERS_PATH = 'system/web/routers';
	
    protected $_defaults = array();
    
    protected $_resolvers = array(
    	'Cream_Controller_Request_Resolver_Website',
    	'Cream_Controller_Request_Resolver_Repository',
    	'Cream_Controller_Request_Resolver_Item',
    	'Cream_Controller_Request_Resolver_Culture',
       	'Cream_Controller_Request_Resolver_Device'
    );

    /**
     * Available routers array
     *
     * @var array
     */
    protected $routers = array();
    
    /**
     * Create a new instance of this class
     *
     * @return Cream_Controller_Front
     */
    public static function instance()
    {
    	return Cream::instance(__CLASS__);
    }
    
    /**
     * Init Front Controller
     *
     * @return Cream_Controller_Front
     */
    public function __init()
    {
        $routersInfo = $this->_getApplication()->getConfig()->getNode(self::CONFIG_ROUTERS_PATH)->asArray();
                
        if (is_array($routersInfo)) {
        	foreach ($routersInfo as $routerCode => $routerInfo) {
	            if (isset($routerInfo['disabled']) && $routerInfo['disabled']) {
                	continue;
            	}
            	if (isset($routerInfo['class'])) {
	                $router = new $routerInfo['class'];
                	if (isset($routerInfo['area'])) {
	                    $router->collectRoutes($routerInfo['area'], $routerCode);
                	}
                	$this->addRouter($routerCode, $router);
            	}
        	}
        } else {
        	throw new Cream_Controller_Exception("No routers defined.");
        }
	
        // Add default router at the last
        $default = new Cream_Controller_Router_Default();
        $this->addRouter('default', $default);
    }
    
    public function setDefault($key, $value=null)
    {
        if (is_array($key)) {
            $this->_defaults = $key;
        } else {
            $this->_defaults[$key] = $value;
        }
        return $this;
    }

    public function getDefault($key=null)
    {
        if (is_null($key)) {
            return $this->_defaults;
        } elseif (isset($this->_defaults[$key])) {
            return $this->_defaults[$key];
        }
        return false;
    }

    /**
     * Retrieve request object
     *
     * @return Cream_Controller_Request_Http
     */
    public function getRequest()
    {
        return Cream::getApplication()->getRequest();
    }

    /**
     * Retrieve response object
     *
     * @return Cream_Controller_Response_Http
     */
    public function getResponse()
    {
        return Cream::getApplication()->getResponse();
    }

    /**
     * Adding new router
     *
     * @param   string $name
     * @param   Cream_Controller_Router_Abstract $router
     */
    public function addRouter($name, Cream_Controller_Router_Abstract $router)
    {
        $router->setFront($this);
        $this->routers[$name] = $router;
    }

    /**
     * Retrieve router by name
     *
     * @param   string $name
     * @return  Cream_Controller_Router_Abstract
     */
    public function getRouter($name)
    {
        if (isset($this->routers[$name])) {
            return $this->routers[$name];
        }
        
        return false;
    }

    /**
     * Retrieve routers collection
     *
     * @return array
     */
    public function getRouters()
    {
        return $this->routers;
    }

    public function dispatch()
    {
        $request = $this->getRequest();
        $request->setPathInfo();
        $request->setDispatched(false);
        
        foreach($this->_resolvers as $resolver)
        {
        	$resolver = Cream::instance($resolver);
        	$resolver->process();
        }

        $i = 0;
        while (!$request->isDispatched() && $i++<25) {      	
            foreach ($this->routers as $router) {
                if ($router->match($this->getRequest())) {
                    break;
                }
            }
        }

        if ($i>25) {
            throw new Cream_Controller_Exception('Front controller reached 25 router match iterations');
        }

        $this->getResponse()->sendResponse();
    }

    public function getRouterByRoute($routeName)
    {
        // empty route supplied - return base url
        if (empty($routeName)) {
            $router = $this->getRouter('standard');
        } elseif ($this->getRouter('webtricks')->getFrontNameByRoute($routeName)) {
            // try standard router url assembly
            $router = $this->getRouter('webtricks');
        } elseif ($this->getRouter('frontend')->getFrontNameByRoute($routeName)) {
            // try standard router url assembly
            $router = $this->getRouter('frontend');
        } elseif ($router = $this->getRouter($routeName)) {
            // try custom router url assembly
        } else {
            // get default router url
            $router = $this->getRouter('default');
        }

        return $router;
    }

    public function getRouterByFrontName($frontName)
    {
        // empty route supplied - return base url
        if (empty($frontName)) {
            $router = $this->getRouter('standard');
        } elseif ($this->getRouter('admin')->getRouteByFrontName($frontName)) {
            // try standard router url assembly
            $router = $this->getRouter('admin');
        } elseif ($this->getRouter('standard')->getRouteByFrontName($frontName)) {
            // try standard router url assembly
            $router = $this->getRouter('standard');
        } elseif ($router = $this->getRouter($frontName)) {
            // try custom router url assembly
        } else {
            // get default router url
            $router = $this->getRouter('default');
        }

        return $router;
    }

    /**
     * Apply configuration rewrites to current url
     *
     */
    public function rewrite()
    {
        $request = $this->getRequest();
        $config = $this->_getApplication()->getConfig()->getNode('global/rewrite');
        if (!$config) {
            return;
        }
        foreach ($config->children() as $rewrite) {
            $from = (string)$rewrite->from;
            $to = (string)$rewrite->to;
            if (empty($from) || empty($to)) {
                continue;
            }
            $from = $this->_processRewriteUrl($from);
            $to   = $this->_processRewriteUrl($to);

            $pathInfo = preg_replace($from, $to, $request->getPathInfo());

            if (isset($rewrite->complete)) {
                $request->setPathInfo($pathInfo);
            } else {
                $request->rewritePathInfo($pathInfo);
            }
        }
    }

    /**
     * Replace route name placeholders in url to front name
     *
     * @param   string $url
     * @return  string
     */
    protected function _processRewriteUrl($url)
    {
        $startPos = strpos($url, '{');
        if ($startPos!==false) {
            $endPos = strpos($url, '}');
            $routeName = substr($url, $startPos+1, $endPos-$startPos-1);
            $router = $this->getRouterByRoute($routeName);
            if ($router) {
                $fronName = $router->getFrontNameByRoute($routeName);
                $url = str_replace('{'.$routeName.'}', $fronName, $url);
            }
        }
        return $url;
    }
}