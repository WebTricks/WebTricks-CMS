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
 * The base class implements a few fundamental static methods.
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class Cream
{
	/**
	 * Application instance
	 * 
	 * @var Cream_Application
	 */
	private static $_application = null;
	
	/**
	 * Array holding singleton objects.
	 * 
	 * @var array
	 */
	private static $_singletons = array();

	/**
	 * Stores the application instance in the class static member.
	 *
	 * @param Application instantie van de applicatie.
	 * @throws Exception wanneer deze functie meer dan twee keer wordt aangeroepen.
	 */
	public static function setApplication(Cream_Application $application)
	{
		if(self::$_application instanceof Cream_Application) {
			throw new Cream_Exceptions_Exception('Application already set.');
		}

		self::$_application = $application;
	}

	/**
	 * Returns an instance of the application class
	 *
	 * @return Cream_Application
	 */
	public static function getApplication()
	{
		if (self::$_application) {
			return self::$_application;		
		} else {
			throw new Cream_Exceptions_Exception('Application not set.');
		}
	}

	/**
	 * Factory method to instantiate a new class. Parameters can be added, these
	 * will be forwarded to the class __init function. An example:
	 *
	 * <code>
	 * // Instantiate a new class
	 * $class = Cream::instance('Foo_Bar');
	 *
	 * // Instantiate a new class with params
	 * $class = Cream::instance('Foo_Bar', $param1, $param2);
	 * </code>
	 *
	 * @param string $class
	 */
	public static function instance($class)
	{	
		// Retrieve the given arguments
		$args = func_get_args();
        array_shift($args);
		
        $instance = new $class;

		if (count($args)) {
        	call_user_func_array(array($instance, "__init"), $args);
		} else {
			if (method_exists($instance, '__init')) {
				$instance->__init();
			}
		}

        return $instance;
	}
	
	public static function singleton($class)
	{
		if (!isset(self::$_singletons[$class])) {
			self::$_singletons[$class] = Cream::instance($class);
		} 
		
		return self::$_singletons[$class];
	}
	
	/**
	 * Determines if the given object is an instance of the given namespace. The
	 * function can also be used to determine whether a variable is an
	 * instantiated object of a class that inherits from a parent class.
	 *
	 * @param object $object
	 * @param string $namespace
	 * @return boolean
	 */
	public static function isInstanceOf($object, $className)
	{
		// Check of object een instantie van de classe is
		if ($object instanceof $className) {
			return true;
		}

		return false;
	}

	/**
	 * Initializes error handlers. This method set error and exception handlers
	 * to be functions defined in this class.
	 */
	public static function initErrorHandlers()
	{
		// Sets error handler to be Cream::phpErrorHandler
		set_error_handler(array('Cream','phpErrorHandler'));

		// Sets exception handler to be Cream::exceptionHandler
		set_exception_handler(array('Cream','exceptionHandler'));
	}

	/**
	 * The PHP error handler. This method should be registered as PHP error
	 * handler using {@link set_error_handler}. The method throws an exception
	 * that contains the error information.
	 *
	 * @param integer the level of the error raised
	 * @param string the error message
	 * @param string the filename that the error was raised in
	 * @param integer the line number the error was raised at
	 */
	public static function phpErrorHandler($errno, $errstr, $errfile, $errline)
	{		
		if (error_reporting()!=0) {
			require_once('Zend/Exception.php');			
			require_once('Cream/Exceptions/Exception.php');
			require_once('Cream/Exceptions/PhpException.php');
			
			throw new Cream_Exceptions_PhpException($errno, $errstr, $errfile, $errline);
		}
	}

	/**
	 * The Default exception handler. This method should be registered as
	 * default exception handler using {@link set_exception_handler}. The
	 * method tries to use the errorhandler module of the application to handle
	 * the exception.
	 *
	 * If the application or the module does not exist, it simply echoes the
	 * exception.
	 *
	 * @param Exception exception that is not caught
	 */
	public static function exceptionHandler($exception)
	{					
		if (self::$_application !== null && self::$_application->getErrorHandler() !== null) {
			$errorHandler = self::$_application->getErrorHandler();			
			$errorHandler->handleError($exception);
		} else {
			echo $exception;
		}

		exit;
	}
	
	/**
	 * Check if a particular class exists.
	 * 
	 * @param string $class
	 * @return boolean
	 */
	public static function exists($class)
	{
		return Cream_Autoload::getSingelton()->exists($class);
	}
	
    /**
     * Gets the current WebTricks version
     *
     * @return string
     */
    public static function getVersion()
    {
        $i = self::getVersionInfo();
        return trim("{$i['major']}.{$i['minor']}.{$i['revision']}" . ($i['patch'] != '' ? ".{$i['patch']}" : "") . "-{$i['stability']}{$i['number']}", '.-');
    }

    /**
     * Gets the detailed WebTricks version information
     *
     * @return array
     */
    public static function getVersionInfo()
    {
        return array(
            'major'     => '5',
            'minor'     => '0',
            'revision'  => '1',
            'patch'     => '0',
            'stability' => 'alpha',
            'number'    => '',
        );
    }
    
    public static function getRoot()
    {
    	return realpath(dirname(__FILE__));
    }
}