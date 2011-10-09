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

class WebTricks_Shell_Applications_Security_UsermanagerController extends WebTricks_Shell_Controller_CommandAction
{
	public function dataAction()
	{
		$data = array();
		$users = array();
		$accountCollection = Cream_Security_Managers_UserProvider::getAllUsers();

		foreach ($accountCollection as $account) {
			$user = array(
				'email' => $account->getName(),
				'domain' => $account->getDomain()->getName(),
				'isApproved' => $account->isApproved(),
				'isLocked' => $account->isLocked(),
				'createDate' => $account->getCreateDate()
			);
			
			$users[] = $user;
		}
		
		$data['data'] = $users;
		$data['success'] = true;
		
		$this->getResponse()->setBody(Cream_Json::encode($data));		
	}
}