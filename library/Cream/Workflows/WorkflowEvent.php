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
 * Holds a workflow event.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Workflows_WorkflowEvent extends Cream_Component
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Guid $oldStateId
	 * @param Cream_Guid $newStateId
	 * @param string $message
	 * @param string $user
	 * @param string $date
	 * @return Cream_Workflows_WorkflowEvent
	 */
	public static function instance(Cream_Guid $oldStateId, Cream_Guid $newStateId, $message, $user, $date)
	{
		return Cream::instance(__CLASS__, $oldStateId, $newStateId, $message, $user, $date);
	}	

	/**
	 * Initialize function
	 * 
	 * @param Cream_Guid $oldStateId
	 * @param Cream_Guid $newStateId
	 * @param string $message
	 * @param string $user
	 * @param string $date
	 * @return void
	 */
	public function _init(Cream_Guid $oldStateId, Cream_Guid $newStateId, $message, $user, $date) 
	{
		$this->_setData('oldStateId', $oldStateId);
		$this->_setData('newStateId', $newStateId);
		$this->_setData('message', $message);
		$this->_setData('user', $user);
		$this->_setData('date', $date);
	}
	
	/**
	 * Returns the old state ID.
	 * 
	 * @return Cream_Guid
	 */
	public function getOldStateId()
	{
		return $this->_getData('oldStateId');
	}
	
	/**
	 * Returns the new state ID.
	 * 
	 * @return Cream_Guid
	 */
	public function getNewStateId()
	{
		return $this->_getData('newStateId');
	}
	
	/**
	 * Returns the comment message.
	 * 
	 * @return string
	 */
	public function getMessage()
	{
		return $this->_getData('message');
	}
	
	/**
	 * Returns the username of the event.
	 * 
	 * @return string
	 */
	public function getUser()
	{
		return $this->_getData('user');
	}
	
	/**
	 * Returns the date when te event occured.
	 * 
	 * @return string
	 */
	public function getDate()
	{
		return $this->_getData('date');
	}
}