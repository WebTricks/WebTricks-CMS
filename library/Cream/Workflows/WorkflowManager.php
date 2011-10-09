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
 * Workflow manager manages access to the workflow.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Workflows_WorkflowManager
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Workflows_WorkflowManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Returns the workflow on the given ID. If the workflow can't be
	 * found, returns null.
	 *  
	 * @param Cream_Guid $workflowId
	 * @param Cream_Content_Repository $repository
	 * @return Cream_Workflows_Workflow
	 */
	public function getWorkflowById(Cream_Guid $workflowId, Cream_Content_Repository $repository)
	{
		if ($repository->getItem($workflowId)) {
			return Cream_Workflows_Workflow::instance($workflowId, $repository);
		}		
	}
	
	/**
	 * Returns the workflow by the given content item. If no workflow
	 * is attached, returns null. If the workflow cann't be found, 
	 * returns null.
	 *  
	 * @param Cream_Content_Item $item
	 * @return Cream_Workflows_Workflow
	 */
	public function getWorkflowByItem(Cream_Content_Item $item)
	{
		$workflowId = $this->_getWorkflowId($item);
		
		if ($workflowId) {
			return $this->getWorkflowById($workflowId, $item->getRepository());
		}
	}
	
	/**
	 * Returns all workflows from the given repository.
	 *  
	 * @param Cream_Content_Repository $repository
	 * @return array
	 */
	public function getWorkflows(Cream_Content_Repository $repository)
	{
		$workflows = array();
		$root = $repository->getItem(Cream_Application_ItemIds::getWorkflowRoot());
		
		if ($root) {
			foreach ($root as $child) {
				$workflows[] = Cream_Workflows_Workflow::instance($child->getItemId(), $child->getRepository());
			}
		}
		
		return $workflows;
	}	
	
	/**
	 * Returns the workflow id of a content item.
	 *  
	 * @param Cream_Content_Item $item
	 * @return Cream_Guid
	 */
	protected function _getWorkflowId(Cream_Content_Item $item)
	{
		$field = $item->getFields()->getField(Cream_Application_FieldIds::getWorkflow());
		
		if ($field) {
			return Cream_Guid::parseGuid($field->getValue());
		}
	}
}