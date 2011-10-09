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
 * Class for loading classes and files.
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class Cream_Autoload
{
	/**
	 * @var Cream_Autoload
	 */
    static protected $_instance;	

	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Autoload
	 */
	public static function getSingelton()
	{
        if (!self::$_instance) {
            self::$_instance = new Cream_Autoload();
        }
        
        return self::$_instance;
	}
	
	/**
	 * Register the autoload function
	 *
	 */
	public static function register()
	{
		spl_autoload_register(array(self::getSingelton(), 'autoload'));
	}

	/**
	 * Autoload function is called when a class can't be found. It will be
	 * autoloaded.
	 *
	 * @param string $class
	 */
	public function autoload($class)
	{
		if (class_exists($class, false) || interface_exists($class, false)) {
			return;
		} else { 
			$this->load($class);
		}
	}

	/**
	 * Loads a class from a PHP file.  The filename must be formatted
	 * as "$class.php". It will split the class name at underscores to
	 * generate a path hierarchy (e.g., "Cream_Example_Class" will map
	 * to "Cream/Example/Class.php").
	 *
	 * @param string $class
	 */
	private function load($class)
	{
        $classFile = str_replace(' ', DIRECTORY_SEPARATOR, ucwords(str_replace('_', ' ', $class)));
        $classFile .= '.php';
        
        if ($this->_exists($classFile)) {
        	require_once $classFile;
        } else {
        	throw new Cream_Exceptions_Exception('File not found: '. $classFile);
        }
	}
		
    /**
     * Check if a file exists in the include path. Returns true if it
     * the file exists, otherwise returns false.
     * 
     * @param string $filename
     * @return boolean
     */
    protected function _exists($filename)
    {
        // Check for absolute path
        if (realpath($filename) == $filename) {
            return file_exists($filename);
        }
        
        // Otherwise, treat as relative path
        $paths = explode(PS, get_include_path());
        foreach ($paths as $path) {
            if (substr($path, -1) == DS) {
                $fullpath = $path . $filename;
            } else {
                $fullpath = $path . DS. $filename;
            }
            if (file_exists($fullpath)) {
                return true;
            }
        }

        return false;
    }
    
    /**
     * Check if a class name exists. Returns true if the class exists,
     * otherwise false.
     * 
     * @param string $class
     * @return boolean
     */
    public function exists($class)
    {
		if (class_exists($class, false) || interface_exists($class, false)) {
    		return true;
    	}
    	
		$classFile = str_replace(' ', DIRECTORY_SEPARATOR, ucwords(str_replace('_', ' ', $class)));
        $classFile .= '.php';
        
        if ($this->_exists($classFile)) {
        	return true;
        } else {
        	return false;
        }    	
    }
}