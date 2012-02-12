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


class Cream_Market_Command
{
    /**
     * All commands list
     * @var array
     */
    protected static $_commandsAll = array();

    /**
     * Commands list hash (key=class)
     * @var array
     */
    protected static $_commandsByClass = array();

    /**
     * Frontend object
     * @var Cream_Market_Frontend
     */
    protected static $_frontend = null;
    protected static $_config = null;
    protected static $_registry = null;
    protected static $_validator = null;
    protected static $_rest = null;
    protected static $_sconfig = null;

    protected $_data;
    protected $_class;
    protected static $_packager = null;

    protected static $_return = array();

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $class = $this->_class = get_class($this);
        if(__CLASS__ == $class) {
            throw new Exception("You shouldn't instantiate {$class} directly!");
        }
        $this->commandsInfo = self::$_commandsByClass[$class];
    }


    /**
     * Get command info (static)
     * @param string $name command name
     * @return array/bool
     */
    public static function commandInfo($name)
    {
        $name = strtolower($name);
        if(!isset(self::$_commandsAll[$name])) {
            return false;
        }
        return self::$_commandsAll[$name];
    }

    /**
     * Get command info for current command object
     * @param string $name
     * @return array/bool
     */

    public function getCommandInfo($name)
    {
        if(!isset(self::$_commandsByClass[$this->_class][$name])) {
            return false;
        }
        return self::$_commandsByClass[$this->_class][$name];
    }

    /**
     * Run command
     * @param string $command
     * @param string $options
     * @param string $params
     * @throws Exception if there's no needed method
     * @return mixed
     */
    public function run($command, $options, $params)
    {
        $data = $this->getCommandInfo($command);
        $method = $data['function'];
        if(! method_exists($this, $method)) {
            throw new Exception("$method does't exist in class ".$this->_class);
        }
        return $this->$method($command, $options, $params);
    }

    /**
     * Static functions
     */

    /**
     * Static
     * @param $commandName
     * @return unknown_type
     */
    public static function factory($commandName)
    {
    	$commands = self::getCommands();
		
        if(!isset($commands[$commandName])) {
            throw new UnexpectedValueException("Cannot find command $commandName");
        }
        $currentCommand = $commands[$commandName];
        return Cream::instance($currentCommand['class']());
    }

    
    public static function setSconfig($obj)
    {
        self::$_sconfig = $obj;
    }
    
    /**
     * 
     * @return Cream_Market_Singleconfig
     */
    public function getSconfig()
    {
        return self::$_sconfig;
    }
    
    
    /**
     * Sets frontend object for all commands
     *
     * @param Cream_Market_Frontend $obj
     * @return void
     */
    public static function setFrontendObject($obj)
    {
        self::$_frontend = $obj;
    }


    /**
     * Set config object for all commands
     * @param Cream_Market_Config $obj
     * @return void
     */
    public static function setConfigObject($obj)
    {
        self::$_config = $obj;
    }

  
    /**
     * Non-static getter for config
     * @return Cream_Market_Config
     */
    public function config()
    {
        return self::$_config;
    }

    /**
     * Non-static getter for UI
     * @return Cream_Market_Frontend
     */
    public function ui()
    {
        return self::$_frontend;
    }


    /**
     * Get validator object
     * @return Cream_Market_Validator
     */
    public function validator()
    {
        if(is_null(self::$_validator)) {
            self::$_validator = Cream_Market_Validator::instance();
        }
        return self::$_validator;
    }

    /**
     * Get rest object
     * @return Cream_Market_Rest
     */
    public function rest()
    {
        if(is_null(self::$_rest)) {
            self::$_rest = Cream_Market_Rest::instance(self::config()->protocol);
        }
        return self::$_rest;
    }


    /**
     * Get commands list sorted
     * @return array
     */
    public static function getCommands()
    {
        if(!count(self::$_commandsAll)) {
            self::registerCommands();
        }
        ksort(self::$_commandsAll);
        return self::$_commandsAll;
    }


    /**
     * Get Getopt args from command definitions
     * and parse them
     * @param $command
     * @return array
     */
    public static function getGetoptArgs($command)
    {
        $commandInfo = self::commandInfo($command);
        $short_args = '';
        $long_args = array();
        if (empty($commandInfo) || empty($commandInfo['options'])) {
            return;
        }
        reset($commandInfo['options']);
        while (list($option, $info) = each($commandInfo['options'])) {
            $larg = $sarg = '';
            if (isset($info['arg'])) {
                if ($info['arg']{0} == '(') {
                    $larg = '==';
                    $sarg = '::';
                    $arg = substr($info['arg'], 1, -1);
                } else {
                    $larg = '=';
                    $sarg = ':';
                    $arg = $info['arg'];
                }
            }
            if (isset($info['shortopt'])) {
                $short_args .= $info['shortopt'] . $sarg;
            }
            $long_args[] = $option . $larg;
        }
        return array($short_args, $long_args);
    }

    /**
     * Try to register commands automatically
     * @return void
     */
    public static function registerCommands()
    {
        $pathCommands = dirname(__FILE__).DIRECTORY_SEPARATOR.basename(__FILE__, ".php");
        $f = new DirectoryIterator($pathCommands);
        foreach($f as $file) {
            if (! $file->isFile()) {
                continue;
            }
            $pattern = preg_match("/(.*)_Header\.php/imsu", $file->getFilename(), $matches);
            if(! $pattern) {
                continue;
            }
            include($file->getPathname());
            if(! isset($commands)) {
                continue;
            }
            $class = __CLASS__."_".$matches[1];
            foreach ($commands as $k=>$v) {
                $commands[$k]['class'] = $class;
                self::$_commandsAll[$k] = $commands[$k];
            }
            self::$_commandsByClass[$class] = $commands;
        }
    }

    public function doError($command, $message)
    {
        return $this->ui()->doError($command, $message);
    }


    /**
     * Set command return
     * @param string $key
     * @param mixed $val
     * @return void
     */
    public static function setReturn($key, $val)
    {
        self::$_return[$key] = $val;
    }

    /**
     * Get command return
     * @param $key
     * @param $clear
     * @return mixed
     */
    public static function getReturn($key, $clear = true)
    {
        if(isset(self::$_return[$key])) {
            $out = self::$_return[$key];
            if($clear) {
                unset(self::$_return[$key]);
            }
            return $out;
        }
        return null;
    }

    /**
     * Cleanup command params from empty strings
     *
     * @param array $params by reference
     */
    public function cleanupParams(array & $params)
    {
        $newParams = array();
        if(!count($params)) {
            return;
        }
        foreach($params as $k=>$v) {
            if(is_string($v)) {
                $v = trim($v);
                if(!strlen($v)) {
                    continue;
                }
            }
            $newParams[] = $v;
        }
        $params = $newParams;
    }

    /**
     * Splits first command argument: channel/package
     * to two arguments if found in top of array
     *
     * @param array $params
     */
    public function splitPackageArgs(array & $params)
    {
        if(!count($params) || !isset($params[0])) {
            return;
        }
        if($this->validator()->validateUrl($params[0])) {
            return;
        }
        if(preg_match("@([a-zA-Z0-9_]+)/([a-zA-Z0-9_]+)@ims", $params[0], $subs)) {
           $params[0] = $subs[2];
           array_unshift($params, $subs[1]);
        }
    }

    
    /**
     * Get packager instance
     * @return Cream_Market_Pacakger
     */
    public function getPackager() 
    {
        if(!self::$_packager) {
            self::$_packager = Cream_Market_Packager::instance();
        }
        return self::$_packager;    
    }
    
}