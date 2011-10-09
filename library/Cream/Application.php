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
 * The Application class coordinates the MVC pattern, and serves as a configuration
 * context for all components.
 *
 * @package		Cream_Exception
 * @author		Danny Verkade
 */
class Cream_Application extends Cream_Component
{
	/**
	 * Cache object
	 * 
	 * @var Cream_Cache
	 */
	protected $_cache;
	
	/**
	 * Configuration object
	 * 
	 * @var Cream_Config
	 */	
	protected $_config;
	
	/**
	 * Array holding connection objects
	 *  
	 * @var array
	 */
	protected $_connection = array();
	
	/**
	 * Object holding the context information
	 * 
	 * @var Cream_Application_Context
	 */
	protected $_context;
	
	/**
	 * Application environment object
	 * 
	 * @var Cream_Environment
	 */
	protected $_environment;
	
	/**
	 * Error handler object
	 * 
	 * @var Cream_Exception_ErrorHanlder
	 */
	protected $_errorHandler;	
	
	/**
	 * Front controller object
	 * 
	 * @var Cream_Controller_Front
	 */
	protected $_frontController;
	
	/**
	 * Flag determining if the application is installed
	 * 
	 * @var boolean
	 */
	protected $_isInstalled;
	
	/**
	 * Application options
	 * 
	 * @var Cream_ApplicationOptions
	 */
	protected $_options;
	
	/**
	 * Array holding the repositories.
	 * 
	 * @var array
	 */
	protected $_repository = array();
	
	/**
	 * Request object
	 * 
	 * @var Cream_Controller_Request_Http
	 */
	protected $_request;
	
	/**
	 * Response object
	 *  
	 * @var Cream_Controller_Request_Response
	 */
	protected $_response;
	
	/**
	 * Constructor function
	 * 
	 */
    public function __construct()
    {
    	Cream::setApplication($this);	
    }   	
    
    /**
     * Initializes the application and sets the include path
     * 
     * @return void
     */
    protected function _initApplication()
    {
    	$paths = array();
    	$paths[] = $this->getOptions()->getCoreCodeDir();
    	$paths[] = $this->getOptions()->getCommunityCodeDir();
    	$paths[] = $this->getOptions()->getLocalCodeDir();
    	$paths[] = $this->getOptions()->getLibraryDir();
    	
    	$appPath = implode(PS, $paths);
    	set_include_path($appPath . PS . get_include_path());   	
    }
    
    /**
     * Initiales the application cache. Cache options can be set in
     * the /global/cache section of the configuration file.
     * 
     * @return void
     */
    protected function _initCache()
    {
        $options = $this->getConfig()->getNode('global/cache');
        if ($options) {
            $options = $options->asArray();
        } else {
            $options = array();
        }
        
        $this->_cache = Cream_Cache::instance($options);
    }
    
    /**
     * Initialises the environment variables of the application.
     * These variables can bet set in the config in the 
     * /global/environment section.
     * 
     * @return void
     */
    protected function _initEnvironment()
    {
    	$config = $this->getConfig()->getNode('global/environment');
    	
    	foreach($config->children() as $configElement) {
    		$function = 'set'. Cream_Utility::ucWords($configElement->getName(), '');
    		if (method_exists($this->getEnvironment(), $function)) {
    			$this->getEnvironment()->$function($configElement);
    		} else {
    			throw new Cream_Exceptions_Exception('Environment variable "'. $configElement->getName() .'" can not be set.');
    		}
    	}
    }
    
    /**
     * Initialize active modules configuration and data
     *
     */
    protected function _initModules()
    {
        //if (!$this->getConfig()->loadModulesCache()) {
            $this->getConfig()->loadModules();
            if ($this->getConfig()->isLocalConfigLoaded()) {
                //WebTricks_Shell_Setup::applyAllUpdates();
            }
        //    $this->getConfig()->loadDb();
        //    $this->getConfig()->saveCache();
        //}
    }
    
    /**
     * Determines if the application is installed
     * 
     * @return boolean
     */
    public function isInstalled()
    {
        if ($this->_isInstalled === null) {
            $localConfigFile = $this->getOptions()->getConfigDir() . DS . 'local.xml';

            $this->_isInstalled = false;

            if (is_readable($localConfigFile)) {
                $localConfig = simplexml_load_file($localConfigFile);
                date_default_timezone_set('UTC');
                if (($date = $localConfig->global->install->date) && strtotime($date)) {
                    $this->_isInstalled = true;
                }
            }
        }
        
        return $this->_isInstalled;
    }

    /**
     * Get the cache.
     * 
     * @return Cream_Cache
     */
    public function getCache()
    {
    	if (!$this->_cache) {
    		$this->_initCache();
    	}
    	
    	return $this->_cache;
    }
    
    /**
     * Retrieve the configuration
     *
     * @return Cream_Config
     */
    public function getConfig()
    {
    	if (!$this->_config) {
    		$this->_config = Cream_Config::instance();
    	}
    	
    	return $this->_config;
    }
    
    /**
     * Returns a database connection
     * 
     * @param $name
     * @return Cream_Data_Connection
     */
    public function getConnection($name = 'default_read')
    {
    	if (!isset($this->_connection[$name])) {
    		
    		$config = $this->getConfig()->getNode('global/data/connection/'. $name);
    		
    		if ($name) {
    			$this->_connection[$name] = Cream_Data_Connection::instance($config);
    		} else {
    			throw new Cream_Exceptions_Exception('Connection with name "'. $name .'" not configured.');
    		}
    		
    	}
    	
    	return $this->_connection[$name];
    }
    
    /**
     * Sets a connection.
     * 
     * @param string $name
     * @param Cream_Data_Connection $connection
     * @return void
     */
    public function setConnection($name, Cream_Data_Connection $connection)
    {
    	$this->_connection[$name] = $connection;
    }
    
    /**
     * Returns the object holding 
     * 
     * @return Cream_Application_Context
     */
    public function getContext()
    {
    	if (!$this->_context) {
    		$this->_context = Cream_Application_Context::instance();
    	}
    	
    	return $this->_context;
    }
    
    /**
     * Retrieves the environment object
     * 
     * @return Cream_Environment
     */
    public function getEnvironment()
    {
    	if (!$this->_environment) {
    		$this->_environment = Cream_Environment::instance();
    	}
    	
    	return $this->_environment;
    }
    
    /**
     * Returns the application options object
     * 
     * @return Cream_ApplicationOptions
     */
    public function getOptions()
    {
    	if (!$this->_options) {
    		$this->_options = Cream_ApplicationOptions::instance();
    	}
    	
    	return $this->_options;
    }
    
    /**
     * Retrieves a content repository.
     * 
     * @param string $name
     * @return Cream_Content_Repository
     */
    public function getRepository($name)
    {
    	if (!isset($this->_repository[$name])) {

    		$config = $this->getConfig()->getNode('global/content/repository/'. $name);

    		if ($config) {
    			$repository = Cream_Content_Repository::instance($name, $config);
	    		$this->_repository[$name] = $repository;
    		} else {
    			throw new Cream_Exceptions_Exception('Repository with name "'. $name .'" not found.');
    		}
    	}
    	
    	return $this->_repository[$name];
    }
	
    /**
     * Retrieve request object
     *
     * @return Cream_Controller_Request_Http
     */
    public function getRequest()
    {
        if (!$this->_request) {
            $this->_request = Cream_Controller_Request_Http::instance();
        }
        
        return $this->_request;
    }
    
    /**
     * Retrieve response object
     *
     * @return Cream_Controller_Response_Http
     */
    public function getResponse()
    {
        if (!$this->_response) {
            $this->_response = Cream_Controller_Response_Http::instance();
            $this->_response->setHeader("Content-Type", "text/html; charset=UTF-8");
        }
        return $this->_response;
    }	
	
	/**
	 * Returns the error handler module
	 *
	 * @return Cream_Exception_ErrorHandler
	 */
	public function getErrorHandler()
	{
		if(!$this->_errorHandler) {
			$this->_errorHandler = Cream_Exceptions_ErrorHandler::instance();
		}

		return $this->_errorHandler;
	}

	/**
	 * Executes the lifecycles of the application. This is the main entry
	 * function that leads to the running of the whole application.
	 */
	public function run()
	{
		try {
			
			$this->_initApplication();
			$this->getConfig()->loadBase();
			$this->_initModules();
			$this->_initEnvironment();
			
            $this->getFrontController()->dispatch();			

		} catch (Exception $e) {
			$this->onError($e);
		}
	}
	
	public function init()
	{
		try {
			
			$this->_initApplication();
			$this->getConfig()->loadBase();
			$this->_initModules();
			$this->_initEnvironment();
			
		} catch (Exception $e) {
			$this->onError($e);
		}
	}

	/**
	 * Raises OnError event. This method is invoked when an exception is raised
	 * during the lifecycles of the application.
	 *
	 * @param mixed event parameter
	 */
	public function onError($param)
	{
		// Log application lifecycle step
		//$this->getLog()->log(__CLASS__, $param->getMessage(), __FILE__, __LINE__);

		// Raise onError event
		//$this->getEventHandler()->raiseEvent('OnError', $this, $param);

		// Handler error
		print $param;
		exit;
		$this->getErrorHandler()->handleError($param);
	}
	
    /**
     * Retrieve front controller object
     *
     * @return Cream_Controller_Front
     */
    public function getFrontController()
    {
        if (!$this->_frontController) {
            $this->_frontController = Cream_Controller_Front::instance();
        }

        return $this->_frontController;
    }
}