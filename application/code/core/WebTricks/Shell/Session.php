<?php

class WebTricks_Shell_Session extends Cream_Session_Abstract
{
	/**
	 * Gets the singleton of this class.
	 * 
	 * @return WebTricks_Shell_Session
	 */
	public static function singleton()
	{
		return Cream::singleton(__CLASS__);
	}
	
	/**
	 * Initialize function
	 *  
	 */
    public function __init()
    {
        $this->init('shell');
    }	
    
    /**
     * Returns the history
     * 
     * @return WebTricks_Shell_Applications_ContentManager_History
     */
    public function getHistory()
    { 
    	if (!$this->_getData('history')) {
    		$this->_setData('history', WebTricks_Shell_Applications_ContentManager_History::instance());
    	}
    	
    	return $this->_getData('history');
    }
    
    /**
     * Returns the user
     * 
     * @return Cream_Security_Accounts_User
     */
    public function getUser()
    {
    	if (!$this->_getData('user')) {
    		$this->_setData('user', $this->_getApplication()->getContext()->getDomain()->getAnonymousUser());
    	}
    	
    	return $this->_getData('user');    	
    }
}