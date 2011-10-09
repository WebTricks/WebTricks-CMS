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
 * Cream_Exception_HttpException class
 *
 * Cream_Exception_HttpException represents an exception that is caused by invalid operations
 * of end-users. The {@link getStatusCode StatusCode} gives the type of HTTP error.
 * It is used by {@link ErrorHandler} to provide different error output to users.
 *
 * @package		Cream_Exception
 * @author		Danny Verkade
 */
class Cream_Exceptions_HttpException extends Cream_Exceptions_Exception
{
	/**
	 * @var integer
	 */
	private $statusCode;

	/**
	 * Constructor.
	 * 
	 * @param integer HTTP status code, such as 404, 500, etc.
	 * @param string error message. 
	 */
	public function __construct($statusCode, $errorMessage)
	{
		
		// Set the HTTP Status Code
		$this->statusCode = $statusCode;

		// Parent construct
		parent::__construct($errorMessage);
	}

	/**
	 * Returns the HTTP Status code for this error.
	 * 
	 * @return integer HTTP status code, such as 404, 500, etc.
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}
}