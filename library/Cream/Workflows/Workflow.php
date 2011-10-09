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
 * Workflow class. Handles the specific workflow.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Workflows_Workflow 
{
	/**
	 * Holds the repository to which the workflow belongs.
	 * 
	 * @var Cream_Content_Repository
	 */
	protected $_repository;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Guid $workflowId
	 * @param Cream_Content_Repository $repository
	 * @return Cream_Workflows_Workflow
	 */
	public static function instance(Cream_Guid $workflowId, Cream_Content_Repository $repository)
	{
		return Cream::instance(__CLASS__, $workflowId, $repository);
	}
	
	/**
	 * Initialize function.
	 * 
	 * @param Cream_Guid $workflowId
	 * @param Cream_Content_Repository $repository
	 * @return void
	 */
	public function __init(Cream_Guid $workflowId, Cream_Content_Repository $repository)
	{
		$this->_workflowId = $workflowId;
		$this->_repository = $repository;
	}

	public function execute(Cream_Guid $commandId, Cream_Content_Item $item, $message)
	{

		$workflowState = $item->getState()->getWorkflowState();
		$stateItem = $this->_getStateItem($workflowState->getStateId());
		$commandItem = $stateItem->getChildren()->getById($commandId);
		
		if (!$commandItem) {
			return Cream_Workflows_WorkflowResult::instance(false, "Couldn't find command definition: ". commandId);		
		}
		
		$workflowResult = $this->_executeCommandActions($commandItem, $item);

		if ($workflowResult->getNextStateId()) {
			$nextStateId = $workflowResult->getNextStateId();
		} else {
			$nextStateId = $this->_getNextStateId($commandItem);
		}
		
		if (!$nextStateId) {
			throw new Cream_Exceptions_WorkflowStateMissingException("The next state couldn't be found for command: ". $commandItem->getPaths()->getPath());
		}
		
		$this->_executeStateActions($stateItem, $item);
		
		return Cream_Workflows_WorkflowResult::instance(true);
		
	}
	
	protected function _executeCommandActions(Cream_Content_Item $commandItem, Cream_Content_Item $item)
	{
		if (!$commandItem->getChildren()) {
			return Cream_Workflows_WorkflowResult::instance(true);
		}
	}
	
	protected function _executeStateActions(Cream_Content_Item $stateItem, Cream_Content_Item $item) 
	{
		
	}
	
	public function getStates()
	{
		$states = array();
		$workflowItem = $this->_getWorkflowItem();
		
		foreach ($workflowItem->getChildren() as $stateItem) {
			
		}
		
		return $states;
	}
	
	public function setState(Cream_Content_Item $item, Cream_Guid $workflowId, Cream_Guid $workflowStateId)
	{
		$item->getEditing()->startEdit();
		$item->getFields()->getField(Cream_Application_FieldIds::getWorkflow())->setValue($workflowId);
		$item->getFields()->getField(Cream_Application_FieldIds::getWorkflowState())->setValue($workflowStateId);
		$item->getEditing()->endEdit();		
	}
	
	/**
	 * Returns the content item of the workflow
	 * 
	 * @return Cream_Content_Item
	 */
	protected function _getWorkflowItem()
	{
		
	}
	
	
	protected function _getStateItem(Cream_Guid $itemId)
	{
		return $this->_repository->getItem($itemId);
	}
	
	protected function _getNextStateId(Cream_Content_Item $commandItem)
	{
		$field = $commandItem->getFields()->getField('next state');
		
		if ($field) {
			return Cream_Guid::parseGuid($field->getValue());
		}
	}
}