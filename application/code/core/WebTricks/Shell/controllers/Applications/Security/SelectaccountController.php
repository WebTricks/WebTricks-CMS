<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

class WebTricks_Shell_Applications_Security_SelectaccountController extends WebTricks_Shell_Controller_CommandAction
{
	public function usersAction()
	{
		$data = array();
		$users = array();
		
		$data['data'] = $users;
		$data['success'] = true;
		
		$this->getResponse()->setBody(Cream_Json::encode($data));			
	}
	
	public function rolesAction()
	{
		$data = array();
		$roles = array();
		
		$data['data'] = $roles;
		$data['success'] = true;
		
		$this->getResponse()->setBody(Cream_Json::encode($data));
	}
}