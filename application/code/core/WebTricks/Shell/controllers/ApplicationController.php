<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Application controller
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_ApplicationController extends WebTricks_Shell_Controller_Action
{
	/**
	 * Heartbeat action, keeps the user logged in, if the user is nog
	 * logged in anymore, will redirect to the login page.
	 *
	 * @return void
	 */
	public function heartbeatAction() 
	{
		$this->getResponse()->setBody($this->_getHeartbeatJson());
	}

	/**
	 * Returns a JSON encode string succesfully completing the heartbeat.
	 * 
	 * @return string
	 */
	protected function _getHeartbeatJson()
	{
    	return Cream_Json::encode(
            array(
                'success'  => true,
            )
        );
	}
}