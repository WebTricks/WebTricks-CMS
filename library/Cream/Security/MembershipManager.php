<?php 

class Cream_Security_MembershipManager extends Cream_ApplicationComponent
{
	protected $_dataManager;
	
	protected $_innerCache = array();
	
	/**
	 * Create an instance of this class.
	 * 
	 * @return Cream_Security_MembershipManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function getUserByEmail($email, $domain)
	{
		return $this->_getDataManager()->getUserByEmail($email, $domain);
	}
	
	public function isUserInRole(Cream_Security_Accounts_User $user, Cream_Security_Accounts_Role $role)
	{
		$accounts = $this->getUsersInRole($role);
		
		foreach($accounts as $account) {
			if ($account->getName() == $user->getName()) {
				return true;
			}
		}
		
		return false;
	}
	
	public function getUsersInRole($role)
	{
		if (!isset($this->_innerCache[$role->getName()])) {
			$this->_innerCache[$role->getName()] = $this->_getDataManager()->getUsersInRole($role);
		}
		
		return $this->_innerCache[$role->getName()];
	}
	
	public function changePassword($email, $domain, $newPassword)
	{
		return $this->_getDataManager()->changePassword($email, $domain, $newPassword);
	}
	
	protected function _getDataManager()
	{
		if (!$this->_dataManager) {
			$config = $this->getApplication()->getConfig()->getNode('global/security/data');
			$this->_dataManager = Cream_Security_Data_Manager::factory($config);
		}
		
		return $this->_dataManager;
	}
}