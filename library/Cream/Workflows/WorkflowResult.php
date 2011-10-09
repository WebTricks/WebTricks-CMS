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

/**
 * Workflow result, holds the result when an item is going truth the
 * workflow.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Workflows_WorkflowResult
{
	/**
	 * Was transition succesfull.
	 * 
	 * @var boolean
	 */
	protected $_isSuccesfull;
	
	/**
	 * Message when a transition did not complete succesfull.
	 * 
	 * @var string
	 */
	protected $_message;
	
	/**
	 * State ID of the next state.
	 * 
	 * @var Cream_Guid
	 */
	protected $_nextStateId;
	
	/**
	 * 
	 * Enter description here ...
	 * @param boolean $isSuccesfull
	 * @param string $message
	 * @param Cream_Guid $nextStateId
	 * @return Cream_Workflows_WorkflowResult
	 */
	public static function instance($isSuccesfull, $message = '', $nextStateId = null)
	{
		return Cream::instance(__CLASS__, $isSuccesfull, $message, $nextStateId);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param boolean $isSuccesfull
	 * @param string $message
	 * @param Cream_Guid $nextStateId
	 * @return void
	 */
	public function _init($isSuccesfull, $message = '', $nextStateId = null)
	{
		$this->_isSuccesfull = $isSuccesfull;
		$this->_message = $message;
		$this->_nextStateId = $nextStateId;
	}
	
	/**
	 * Returns tue if the transition truth the workflow was
	 * sucessfull, otherwise false.
	 * 
	 * @return boolean
	 */
	public function isSuccesfull()
	{
		return $this->_isSuccesfull;
	}
	
	/**
	 * Message when the transition was unsuccesfull.
	 * 
	 * @return string
	 */
	public function getMessage()
	{
		return $this->_message;
	}
	
	/**
	 * ID of the next state.
	 * 
	 * @return Cream_Guid
	 */
	public function getNextStateId()
	{
		return $this->_nextStateId;
	}
}