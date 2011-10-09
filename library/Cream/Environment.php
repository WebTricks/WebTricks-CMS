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
 * Provides information about, and means to manipulate, the current PHP
 * environment and platform.
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class Cream_Environment extends Cream_ApplicationComponent
{
	/**
	 * Create an instance of this class
	 *
	 * @return Cream_Environment
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

	/**
	 * Gets the information about a setting an returns it.
	 *
	 * @param string $name
	 * @return string|integer|boolean
	 */
	protected function getSetting($name)
	{
		return ini_get($name);
	}

	/**
	 * Sets an environment setting. Returns true if it has been completed
	 * succesfully, otherwise returns false.
	 *
	 * @param string $name
	 * @param string|integer|boolean $value
	 * @return boolean
	 */
	protected function setSetting($name, $value)
	{
		return ini_set($name, $value);
	}

	/**
	 * This sets the maximum amount of memory in bytes that a script is allowed
	 * to allocate. This helps prevent poorly written scripts for eating up all
	 * available memory on a server. Note that to have no memory limit, set this
	 * directive to -1. Example: 128M for 128 Megabyte of memory limit.
	 *
	 * @param string $memoryLimit
	 */
	public function setMemoryLimit($memoryLimit)
	{
		return $this->setSetting('memory_limit', $memoryLimit);
	}

	/**
	 * Returns the memory limit which can be used by the PHP script
	 *
	 * @return string
	 */
	public function getMemoryLimit()
	{
		return $this->getSetting('memory_limit');
	}

	/**
	 * This sets the maximum time in seconds a script is allowed to run before
	 * it is terminated by the parser. This helps prevent poorly written scripts
	 * from tying up the server.
	 *
	 * @param integer $maxExecutionTime
	 * @return boolean
	 */
	public function setMaxExecutionTime($maxExecutionTime)
	{
		return $this->setSetting('max_execution_time', $maxExecutionTime);
	}

	/**
	 * Returns the maximum time in seconds when a script is terminated.
	 *
	 * @return integer
	 */
	public function getMaxExecutionTime()
	{
		return $this->getSetting('max_execution_time');
	}

	/**
	 * Sets max size of post data allowed.
	 *
	 * @param string $maxPostSize
	 * @return boolean
	 */
	public function setMaxPostSize($maxPostSize)
	{
		return $this->setSetting('max_post_size', $maxPostSize);
	}

	/**
	 * Returns the max post size
	 *
	 * @return string
	 */
	public function getMaxPostSize()
	{
		return $this->getSetting('max_post_size');
	}

	/**
	 * The maximum size of an uploaded file.
	 *
	 * @param string $maxUploadFilesize
	 * @return boolean
	 */
	public function MaxUploadFilesize($maxUploadFilesize)
	{
		return $this->setSetting('upload_max_filesize', $maxUploadFilesize);
	}

	/**
	 * Returns the maximum upload size
	 *
	 * @return string
	 */
	public function getMaxUploadFilesize()
	{
		return $this->getSetting('upload_max_filesize');
	}

	/**
	 * Used under Windows only: host name or IP address of the SMTP server PHP
	 * should use for mail sent with the mail() function.
	 *
	 * @param string $smtpServer
	 * @return boolean
	 */
	public function setSmtpServer($smtpServer)
	{
		return $this->setSetting('SMTP', $smtpServer);
	}

	/**
	 * Returns the name of the SMTP server currently used
	 *
	 * @return string
	 */
	public function getSmtpServer()
	{
		return $this->getSetting('SMTP');
	}

	/**
	 * Used under Windows only: Number of the port to connect to the server
	 * specified with the SMTP setting when sending mail with mail(); defaults
	 * to 25.
	 *
	 * @param integer $smtpPort
	 * @return boolean
	 */
	public function setSmtpPort($smtpPort)
	{
		return $this->setSetting('smtp_port', $smtpPort);
	}

	/**
	 * Returns the SMTP port currently used.
	 *
	 * @return integer
	 */
	public function getSmtpPort()
	{
		return $this->getSetting('smtp_port');
	}
}