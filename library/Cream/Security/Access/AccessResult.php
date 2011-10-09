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

class Cream_Security_Access_AccessResult
{
	/**
	 * Access result permission
	 * 
	 * @var mixed
	 */
	protected $_permission;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param mixed $accessPermission
	 * @return Cream_Acl_AccessResult
	 */
	public static function instance($accessPermission)
	{
		return Cream::instance(__CLASS__, $accessPermission);
	}
	
	/**
	 * Init function
	 * 
	 * @param mixed $accessPermission
	 */
	public function __init($accessPermission)
	{
		$this->_permission = $accessPermission;
	}
	
	/**
	 * Get the permission
	 * 
	 * @return mixed
	 */
	public function getPermission()
	{
		return $this->_permission;
	}
}