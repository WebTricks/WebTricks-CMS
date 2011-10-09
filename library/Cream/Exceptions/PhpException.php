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
 * Cream_Exception_PhpException represents an exception caused by a 
 * PHP error. This exception is thrown within a PHP error handler.
 *
 * @package		Cream_Exception
 * @author		Danny Verkade
 */
class Cream_Exceptions_PhpException extends Cream_Exceptions_Exception
{
	/**
	 * @var array
	 */
	private $errorTypes = array(
		E_ERROR           => "Error",
		E_WARNING         => "Warning",
		E_PARSE           => "Parsing Error",
		E_NOTICE          => "Notice",
		E_CORE_ERROR      => "Core Error",
		E_CORE_WARNING    => "Core Warning",
		E_COMPILE_ERROR   => "Compile Error",
		E_COMPILE_WARNING => "Compile Warning",
		E_USER_ERROR      => "User Error",
		E_USER_WARNING    => "User Warning",
		E_USER_NOTICE     => "User Notice",
		E_STRICT          => "Runtime Notice"
	);
			
	/**
	 * Constructor function
	 * 
	 * @param integer error number
	 * @param string error string
	 * @param string error file
	 * @param integer error line number
	 */
	public function __construct($errno, $errstr, $errfile, $errline)
	{
		if (isset($this->errorTypes[$errno])) {
			$errorType = $this->errorTypes[$errno];
		} else {
			$errorType = 'Unknown Error';
		}
		
		parent::__construct("[$errorType] $errstr (@line $errline in file $errfile).");
		
		print $this;
	}
}