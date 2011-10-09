<?php

class WebTricks_Install_Session extends Cream_Session_Abstract
{
	/**
	 * Get singleton instance
	 * 
	 * @return WebTricks_Install_Session
	 */
	public static function singleton()
	{
		return Cream::singleton(__CLASS__);
	}
	
	/**
	 * Initialize function
	 * 
	 * @return void
	 */
    public function __init() 
    {
        $this->init('install');
    }
}