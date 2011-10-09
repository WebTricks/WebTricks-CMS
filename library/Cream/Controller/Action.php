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
 * Custom Zend_Controller_Action class (formally)
 *
 * Allows dispatching before and after events for each controller action
 *
 * @package		Cream_Controller
 * @author		Danny Verkade
 */
abstract class Cream_Controller_Action extends Cream_ApplicationComponent
{
    const PARAM_NAME_SUCCESS_URL        = 'success_url';
    const PARAM_NAME_ERROR_URL          = 'error_url';
    const PARAM_NAME_REFERER_URL        = 'referer_url';
    const PARAM_NAME_BASE64_URL         = 'r64';
    const PARAM_NAME_URL_ENCODED        = 'uenc';
    
    /**
     * Design object
     * 
     * @var Cream_Design
     */
    protected $_design;
    
    /**
     * Layout object
     * 
     * @var Cream_Layout
     */
    protected $_layout;
    
    /**
     * Request object
     *
     * @var Zend_Controller_Request_Abstract
     */
    protected $_request;

    /**
     * Response object
     *
     * @var Zend_Controller_Response_Abstract
     */
    protected $_response;

    /**
     * Real module name (like 'Cream_Module')
     *
     * @var string
     */
    protected $_realModuleName;

    /**
     * Action list where need check enabled cookie
     *
     * @var array
     */
    protected $_cookieCheckActions = array();

    /**
     * Currently used area
     *
     * @var string
     */
    protected $_currentArea;

    /**
     * Namespace for session.
     * Should be defined for proper working session.
     *
     * @var string
     */
    protected $_sessionNamespace;

    /**
     * Whether layout is loaded
     *
     * @see self::loadLayout()
     * @var bool
     */
    protected $_isLayoutLoaded = false;

    /**
     * Title parts to be rendered in the page head title
     *
     * @see self::_title()
     * @var array
     */
    protected $_titles = array();

    /**
     * Whether the default title should be removed
     *
     * @see self::_title()
     * @var bool
     */
    protected $_removeDefaultTitle = false;

    /**
     * Constructor
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array $invokeArgs
     */
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $this->_request = $request;
        $this->_response= $response;
        $this->__init();
    }
    
    /**
     * Initialize function
     *
     * @return void
     */
    protected function __init()
    {
    }

    public function hasAction($action)
    {   	
		return is_callable(array($this, $this->getActionMethodName($action)));
    }

    /**
     * Retrieve request object
     *
     * @return Cream_Controller_Request_Http
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Retrieve response object
     *
     * @return Cream_Controller_Response_Http
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Retrieve full bane of current action current controller and
     * current module
     *
     * @param   string $delimiter
     * @return  string
     */
    public function getFullActionName($delimiter='_')
    {
        return $this->getRequest()->getRequestedRouteName().$delimiter.
            $this->getRequest()->getRequestedControllerName().$delimiter.
            $this->getRequest()->getRequestedActionName();
    }

    /**
     * Retrieve current layout object
     *
     * @return Cream_Design_Package
     */
    public function getDesign()
    {
    	if (!$this->_design) {
        	$this->_design = Cream_Design_Package::instance();
    	}
    	
    	return $this->_design;
    }    
    
    /**
     * Retrieve current layout object
     *
     * @return Cream_Layout
     */
    public function getLayout()
    {
    	if (!$this->_layout) {
        	$this->_layout = Cream_Layout::instance();
        	$this->_layout->setController($this);
    	}
    	
    	return $this->_layout;
    }

    /**
     * Load layout by handles(s)
     *
     * @param   string $handles
     * @param   string $cacheId
     * @param   boolean $generateBlocks
     */
    public function loadLayout($handles = null, $generateBlocks = true, $generateXml = true)
    {
        // if handles were specified in arguments load them first
        if (false !== $handles && '' !== $handles) {
            $this->getLayout()->getUpdate()->addHandle($handles ? $handles : 'default');
        }

        $this->loadLayoutUpdates();

        if (!$generateXml) {
            return;
        }
        $this->generateLayoutXml();
        
        if (!$generateBlocks) {
            return;
        }
        $this->generateLayoutBlocks();
        $this->_isLayoutLoaded = true;
    }

    public function loadLayoutUpdates()
    {
        $this->getLayout()->getUpdate()->load();
    }

    public function generateLayoutXml()
    {
        $this->getLayout()->generateXml();
    }

    public function generateLayoutBlocks()
    {
        $this->getLayout()->generateBlocks();
    }

    /**
     * Rendering layout
     *
     * @param   string $output
     */
    public function renderLayout($output='')
    {
        //if ($this->getApplication()->getFrontController()->getNoRender()) {
        //    return;
        //}

        //$this->_renderTitles();

        if ('' !== $output) {
            $this->getLayout()->addOutputBlock($output);
        }

        $this->getLayout()->setDirectOutput(false);

        $output = $this->getLayout()->getOutput();

        $this->getResponse()->appendBody($output);
    }

    public function dispatch($action)
    {
        try {
            $actionMethodName = $this->getActionMethodName($action);

            if (!is_callable(array($this, $actionMethodName))) {
                $actionMethodName = 'norouteAction';
            }

            $this->preDispatch();

            if ($this->getRequest()->isDispatched()) {
				$this->$actionMethodName();
				$this->postDispatch();
            }
        } catch (Cream_Controller_Exception $e) {
            list($method, $parameters) = $e->getResultCallback();
            switch ($method) {
                case Cream_Controller_Exception::RESULT_REDIRECT:
                    list($path, $arguments) = $parameters;
                    $this->_redirect($path, $arguments);
                    break;
                case Cream_Controller_Exception::RESULT_FORWARD:
                    list($action, $controller, $module, $params) = $parameters;
                    $this->_forward($action, $controller, $module, $params);
                    break;
                default:
                    $actionMethodName = $this->getActionMethodName($method);
                    $this->getRequest()->setActionName($method);
                    $this->$actionMethodName($method);
                    break;
            }
        }
    }

    /**
     * Returns the method name of the action.
     * 
     * @param string $action
     */
    public function getActionMethodName($action)
    {
        $method = $action .'Action';
        return $method;
    }

    /**
     * Dispatches event before action
     */
    public function preDispatch()
    {
    }

    /**
     * Dispatches event after action
     */
    public function postDispatch()
    {
    }

    public function norouteAction($coreRoute = null)
    {
        $status = $this->getRequest()->getParam('__status__');
        
        if (!$status) {
        	$status = Cream::instance('Cream_Object');
        }
        
		if ($status->getLoaded() !== true
            || $status->getForwarded() === true
            || !is_null($coreRoute) ) {
            $this->loadLayout(array('frontend', 'noroute'));
            $this->renderLayout();
        } else {
            $status->setForwarded(true);
            #$this->_forward('cmsNoRoute', 'index', 'cms');
            $this->_forward(
                $status->getForwardAction(),
                $status->getForwardController(),
                $status->getForwardModule(),
                array('__status__' => $status));
        }
    }

    /**
     * Throw control to different action (control and module if was specified).
     *
     * @param string $action
     * @param string|null $controller
     * @param string|null $module
     * @param string|null $params
     */
    protected function _forward($action, $controller = null, $module = null, array $params = null)
    {
        $request = $this->getRequest();
        $request->initForward();

        if (!is_null($params)) {
            $request->setParams($params);
        }

        if (!is_null($controller)) {
            $request->setControllerName($controller);

            // Module should only be reset if controller has been specified
            if (!is_null($module)) {
                $request->setModuleName($module);
            }
        }

        $request->setActionName($action);
        $request->setDispatched(false);
    }
    
    protected function getUrl($path, $arguments = array())
    {
    	$url = Cream_Url::instance();
    	return $url->getUrl($path, $arguments);
    }

    /**
     * Set redirect url into response
     *
     * @param   string $url
     */
    protected function _redirectUrl($url)
    {
        $this->getResponse()->setRedirect($url);
    }

    /**
     * Set redirect into response
     *
     * @param   string $path
     * @param   array $arguments
     */
    protected function _redirect($path, $arguments=array())
    {
        $this->getResponse()->setRedirect($this->getUrl($path, $arguments));
    }

    /**
     * Redirect to error page
     *
     * @param string $defaultUrl
     */
    protected function _redirectError($defaultUrl)
    {
        $errorUrl = $this->getRequest()->getParam(self::PARAM_NAME_ERROR_URL);
        if (empty($errorUrl)) {
            $errorUrl = $defaultUrl;
        }
        if (!$this->_isUrlInternal($errorUrl)) {
            $errorUrl = $this->getApplication()->getSite()->getBaseUrl();
        }
        $this->getResponse()->setRedirect($errorUrl);
    }

    /**
     * Set referer url for redirect in responce
     *
     * @param   string $defaultUrl
     */
    protected function _redirectReferer($defaultUrl=null)
    {
        $refererUrl = $this->_getRefererUrl();
        if (empty($refererUrl)) {
            $refererUrl = $defaultUrl;
        }

        $this->getResponse()->setRedirect($refererUrl);
    }

    /**
     * Identify referer url via all accepted methods (HTTP_REFERER, regular or base64-encoded request param)
     *
     * @return string
     */
    protected function _getRefererUrl()
    {
        $refererUrl = $this->getRequest()->getServer('HTTP_REFERER');

        if ($url = $this->getRequest()->getParam(self::PARAM_NAME_REFERER_URL)) {
            $refererUrl = $url;
        }
        
        if ($url = $this->getRequest()->getParam(self::PARAM_NAME_BASE64_URL)) {
            $refererUrl = Cream_Url::decode($url);
        	        }
        
        if ($url = $this->getRequest()->getParam(self::PARAM_NAME_URL_ENCODED)) {
            $refererUrl = Cream_Url::decode($url);
        }

        if (!$this->_isUrlInternal($refererUrl)) {
            $refererUrl = Cream::getApplication()->getWebsite()->getBaseUrl();
        }

        return $refererUrl;
    }

    /**
     * Check url to be used as internal
     *
     * @param   string $url
     * @return  bool
     */
    protected function _isUrlInternal($url)
    {
        if (strpos($url, 'http') !== false) {
            if (strpos($url, $this->getApplication()->getSite()->getBaseUrl()) === 0) {
		        return true;
            }
        }
        
        return false;
    }

    /**
     * Get real module name (like 'Cream_Module')
     *
     * @return  string
     */
    protected function _getRealModuleName()
    {
        if (empty($this->_realModuleName)) {
            $class = get_class($this);
            $this->_realModuleName = substr($class, 0, strpos(strtolower($class), '_' . strtolower($this->getRequest()->getControllerName() . 'Controller')));
        }
        
        return $this->_realModuleName;
    }

    /**
     * Validate Form Key
     *
     * @return bool
     */
    protected function _validateFormKey()
    {
        if (!($formKey = $this->getRequest()->getParam('form_key', null))
            || $formKey != $this->getApplication()->getSession()->getFormKey()) {
            return false;
        }
        return true;
    }

    /**
     * Add an extra title to the end or one from the end, or remove all
     *
     * Usage examples:
     * $this->_title('foo')->_title('bar');
     * => bar / foo / <default title>
     *
     * $this->_title()->_title('foo')->_title('bar');
     * => bar / foo
     *
     * $this->_title('foo')->_title(false)->_title('bar');
     * bar / <default title>
     *
     * @see self::_renderTitles()
     * @param string|false|-1|null $text
     */
    protected function _title($text = null, $resetIfExists = true)
    {
        if (is_string($text)) {
            $this->_titles[] = $text;
        } elseif (-1 === $text) {
            if (empty($this->_titles)) {
                $this->_removeDefaultTitle = true;
            } else {
                array_pop($this->_titles);
            }
        } elseif (empty($this->_titles) || $resetIfExists) {
            if (false === $text) {
                $this->_removeDefaultTitle = false;
                $this->_titles = array();
            } elseif (null === $text) {
                $this->_removeDefaultTitle = true;
                $this->_titles = array();
            }
        }
    }

    /**
     * Prepare titles in the 'head' layout block
     * Supposed to work only in actions where layout is rendered
     * Falls back to the default logic if there are no titles eventually
     *
     * @see self::loadLayout()
     * @see self::renderLayout()
     */
    protected function _renderTitles()
    {
        if ($this->_isLayoutLoaded && $this->_titles) {
            $titleBlock = $this->getLayout()->getBlock('head');
            if ($titleBlock) {
                if (!$this->_removeDefaultTitle) {
                    $title = trim($titleBlock->getTitle());
                    if ($title) {
                        array_unshift($this->_titles, $title);
                    }
                }
                $titleBlock->setTitle(implode(' / ', array_reverse($this->_titles)));
            }
        }
    }
}