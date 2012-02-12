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

class WebTricks_Shell_Applications_Security_SecuritydetailsController extends WebTricks_Shell_Controller_CommandAction
{
	/**
	 * Retrieves the accounts specified in the access rules of the
	 * item.
	 * 
	 * @return void
	 */
	public function accountsAction()
	{
		$data = array();
		$accounts = array();

		foreach ($this->_getAccessRules()->getAccounts() as $account) {			
			$accounts[] = array(
				'name' => $account->getName(),
				'icon' => 'icon-'. $account->getIcon()
			);
		}
		
		$data['data'] = $accounts;
		$data['success'] = true;
		
		$this->getResponse()->setBody(Cream_Json::encode($data));		
	}
	
	public function rightsAction()
	{
		$data = array();
		$source = array();
	
			$source[] = array(
				'name' => 'test',
				'icon' => 'icon-'
			);
		
		$data['data'] = $source;
		$data['success'] = true;
		
		$this->getResponse()->setBody(Cream_Json::encode($data));			
	}

	/**
	 * Changes an access rule.
	 * 
	 * @return void
	 */
	public function changeAction()
	{
		
	}
	
	/** 
	 * Adds an account the the access rule collection
	 * 
	 * @return void
	 */
	public function addAction()
	{
		$add = true; 
		
		foreach ($this->_getAccessRules()->getAccounts() as $account) {			
			
		}

		if ($add) {
		}
	}
	
	/**
	 * Deletes an account and the associated access rules from the
	 * item.
	 * 
	 * @return void
	 */
	public function deleteAction()
	{
		foreach($this->_getAccessRules() as $index => $accessRule) {
			if ($accessRule->getAccount()->getName() == $account->getName()) {
				$this->_getAccessRules()->remove($index);
			}
		}		
	}
	
	/**
	 * Saves the access rules.
	 * 
	 * @return void
	 */
	public function saveAction()
	{
		$this->_getItem()->getEditing()->startEdit();
		$this->_getItem()->getAccess()->setAccessRules($this->_getAccessRules());
		$this->_getItem()->getEditing()->endEdit();
	}
	
	/**
	 * Retrieves the access rules.
	 * 
	 * @return Cream_Security_Access_AccessRuleCollection
	 */
	protected function _getAccessRules()
	{
		$accessRules = $this->_getItem()->getAccess()->getAccessRules();
		return $accessRules;
	}
	
	/**
	 * Returns the item which is edited.
	 * 
	 * @return Cream_Content_Item
	 */
	protected function _getItem()
	{
		return $this->_getApplication()->getContext()->getContentRepository()->getItem(Cream_Application_ItemIds::getRootId());
	}
}