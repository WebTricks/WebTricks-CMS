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

class Cream_Market_Frontend
{
    /**
     * Silent flag. If set no output is produced to view.
     * Should be used in derived classes.
	 * 
     * @var boolean
     */
    protected $_silent = false;

    /**
     * Capture mode. If set command output should be collected
     * by derived class impplementation
	 * 
     * @var boolean
     */
    protected $_capture = false;

    /**
     * push/pop variable for capture
	 * 
     * @var array
     */
    protected $_captureSaved = array();

    /**
     * push/pop variable for silent
	 * 
     * @var array
     */
    protected $_silentSaved = array();

    /**
     * Errors list
	 * 
     * @var array
     */
    protected $_errors = array();

	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Market_Frontend
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

    /**
     * Add error to errors list
	 * 
     * @param mixed $data
     * @return void
     */
    public function addError($data)
    {
        $this->_errors[] = $data;
    }

    /**
     * Get errors, clear errors list with first param
     * @param bool $clear
     * @return array
     */
    public function getErrors($clear = true)
    {
        if(!$clear) {
            return $this->_errors;
        }
        $out = $this->_errors;
        $this->clearErrors();
        return $out;
    }

    /**
     * Clear errors array
     * @return void
     */
    public function clearErrors()
    {
        $this->_errors = array();
    }

    /**
     * Are there any errros?
     * @return bool
     */
    public function hasErrors()
    {
        return count($this->_errors) != 0;
    }

    /**
     * Error processing
	 * 
     * @param string $command
     * @param stting $message
     * @return void
     */
    public function doError($command, $message)
    {
        $this->addError(array($command, $message));
    }

    /**
     * Save capture state
	 * 
     * @return void
     */
    public function pushCapture()
    {
        array_push($this->_captureSaved, $this->_capture);
    }

    /**
     * Restore capture state
	 * 
     * @return void
     */
    public function popCapture()
    {
        $this->_capture = array_pop($this->_captureSaved);
    }

    /**
     * Set capture mode
	 * 
     * @param bool $arg true by default
     * @return void
     */
    public function setCapture($arg = true)
    {
        $this->_capture = $arg;
    }

    /**
     * Getter for capture mode
     * @return bool
     */
    public function isCapture()
    {
        return $this->_capture;
    }

    /**
     * Log stub
     * @param $msg
     * @return
     */
    public function log($msg)
    {

    }

    /**
     * Ouptut method
     * @param array $data
     * @return void
     */
    public function output($data)
    {

    }

    /**
     * Get instance of derived class
     *
     * @param $class CLI for example will produce Cream_Market_Frontend_CLI
     * @return object
     */
    public static function factory($class)
    {
        $class = __CLASS__."_".$class;
        return Cream::instance($class);
    }

    /**
     * Get output if capture mode set
     * Clear prevoius if needed
     * @param bool $clearPrevious
     * @return mixed
     */
    public function getOutput($clearPrevious = true)
    {

    }


    /**
     * Save silent mode
	 * 
     * @return void
     */
    public function pushSilent()
    {
        array_push($this->_silentSaved, $this->_silent);
    }

    /**
     * Restore silent mode
     * @return void
     */
    public function popSilent()
    {
        $this->_silent = array_pop($this->_silentSaved);
    }

    /**
     * Set silent mode
	 * 
     * @param boolean $value
     * @return void
     */
    public function setSilent($value = true)
    {
        $this->_silent = (bool) $value;
    }

    /**
     * Is silent mode?
     * @return bool
     */
    public function isSilent()
    {
        return (bool) $this->_silent;
    }

    /**
    * Method for ask client about rewrite all files.
    *
    * @param $string
    */
    public function confirm($string)
    {
        
    }
}