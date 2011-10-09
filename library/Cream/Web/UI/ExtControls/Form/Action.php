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
 * The subclasses of this class provide actions to perform upon Forms.
 * 
 * Instances of this class are only created by a Form when the Form needs to 
 * perform an action such as submit or load. The Configuration options listed 
 * for this class are set through the Form's action methods: submit, load and 
 * doAction
 * 
 * The instance of Action which performed the action is passed to the success 
 * and failure callbacks of the Form's action methods (submit, load and 
 * doAction), and to the actioncomplete and actionfailed event handlers.
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_Action extends Cream_Web_UI_ExtControl 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_Action
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function, set the Ext JS control
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.form.Action');
	}	

	/**
	 * The URL that the Action is to invoke.
	 *
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->setAttribute('url', $url);
	}

	/**
	 * The HTTP method to use to access the requested URL. Defaults to the
	 *
	 * @param string $method
	 */
	public function setMethod($method)
	{
		$this->setAttribute('method', $method);
	}

	/**
	 * Extra parameter values to pass. These are added to the Form's
	 *
	 * @param mixed $params
	 */
	public function setParams($params)
	{
		$this->setAttribute('params', $params);
	}
	
	/**
	 * When set to true, causes the Form to be reset on Action success. If 
	 * specified, this happens before the success callback is called and before 
	 * the Form's actioncomplete event fires.
	 *
	 * @param boolean $success
	 */
	public function setReset($reset)
	{
		$this->setAttribute('reset', $reset);
	}

	/**
	 * The function to call when a valid success return packet is recieved.
	 *
	 * @param function $success
	 */
	public function setSuccess($success)
	{
		$this->setAttribute('success', $success);
	}

	/**
	 * The function to call when a failure packet was recieved, or when an
	 *
	 * @param function $failure
	 */
	public function setFailure($failure)
	{
		$this->setAttribute('failure', $failure);
	}

	/**
	 * The scope in which to call the callback functions (The this reference 
	 * for the callback functions).
	 *
	 * @param object $scope
	 */
	public function setScope($scope)
	{
		$this->setAttribute('scope', $scope);
	}
	
	/**
	 * The number of seconds to wait for a server response before failing with 
	 * the failureType as Action.CONNECT_FAILURE. If not specified, defaults to
	 * the configured timeout of the form.
	 *
	 * @param integer $timeout
	 */
	public function setTimeout($timeout)
	{
		$this->setAttribute('timeout', $timeout);
	}	

	/**
	 * The message to be displayed by a call to Ext.MessageBox#wait
	 *
	 * @param string $waitMsg
	 */
	public function setWaitMsg($waitMsg)
	{
		$this->setAttribute('waitMsg', $waitMsg);
	}

	/**
	 * The title to be displayed by a call to Ext.MessageBox#wait
	 *
	 * @param string $waitTitle
	 */
	public function setWaitTitle($waitTitle)
	{
		$this->setAttribute('waitTitle', $waitTitle);
	}
}