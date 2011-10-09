<?php

class Cream_Security_Data_Manager_Database extends Cream_Security_Data_Manager_Abstract
{
	/**
	 * Name of the read connection to use
	 * 
	 * @var string
	 */
	protected $readConnection;
	
	/**
	 * Name of the write connection to use
	 * 
	 * @var string
	 */
	protected $writeConnection;
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Config_Xml_Element $config
	 */
	public function __init(Cream_Config_Xml_Element $config)
	{
		$this->readConnection = (string) $config->connection->read;
		$this->writeConnection = (string) $config->connection->write;
	}

	/**
	 * Returns the read connection
	 *
	 * @return Cream_Data_Connection
	 */
	protected function _getReadConnection()
	{
		return $this->getApplication()->getConnection($this->readConnection);
	}

	/**
	 * Returns the write connection
	 *
	 * @return Cream_Data_Connection
	 */	
	protected function _getWriteConnection()
	{
		return $this->getApplication()->getConnection($this->writeConnection);
	}	
	
	public function getUserByEmail($email, $domain)
	{
		$select = Cream_Data_Statement_Select::instance();
		$select->from('security_users');
		$select->where('email = ?', $email);
		$select->where('domain = ?', $domain);
		
		$result = $this->_getReadConnection()->query($select);
		
		if ($result->getNumRows()) {
			$username = $result->getRow()->domain .'\\'. $result->getRow()->email;
			$user = Cream_Security_Accounts_User::instance($username);
			
			return $user;
		}
	}
	
	public function getAllUsers($search = '', $domain = '', $start = 0, $size = 50, $order = 'email', $orderDirection = 'asc')
	{
		$accountCollection = Cream_Security_Accounts_AccountCollection::instance();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from('security_users');
		$select->limit($start, ($start+$size));
		$select->orderBy($order, $orderDirection);
		
		if ($search) {
			$select->where('email LIKE ?', '%search%');
		}
		
		if ($domain) {
			$select->where('domain = ?', $domain);
		}

		$result = $this->_getReadConnection()->query($select);
		
		if ($result) {
			foreach($result->getRows() as $row) {
				$accountCollection->add($this->_buildUser($row));		
			}
		}		
		
		return $accountCollection;
	}
	
	/**
	 * Returns all the user accounts in the given role. 
	 * 
	 * @param Cream_Security_Accounts_Role $role
	 * @return Cream_Security_Accounts_AccountCollection
	 */
	public function getUsersInRole(Cream_Security_Accounts_Role $role)
	{
		$accountCollection = Cream_Security_Accounts_AccountCollection::instance();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from('security_userroles');
		$select->where('roleName = ?', $role->getName());
		
		$result = $this->_getReadConnection()->query($select);
		
		if ($result) {
			foreach($result->getRows() as $row) {
				$accountCollection->add($this->_buildUser($row->userName));		
			}
		}		
		
		return $accountCollection;
		
	}
	
	public function changePassword($email, $domain, $newPassword)
	{
		$update = Cream_Data_Statement_Update::instance();
		$update->from('security_users');
		$update->set('password', md5($newPassword));
		$update->where('email = ?', $email);
		$update->where('domain = ?', $domain);
		
		$this->_getWriteConnection()->query($update);
	}
	
	protected function _buildUser($name)
	{
		return Cream_Security_Accounts_User::instance($name);
	}
	
}