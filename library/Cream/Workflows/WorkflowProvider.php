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
 * Workflow provider provides access to the workflow.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Workflows_WorkflowProvider
{
	/**
	 * Holds the manager object.
	 * 
	 * @var Cream_Workflows_WorkflowManager
	 */
	protected static $_manager;

	/**
	 * Returns the workflow on the given ID. If the workflow can't be
	 * found, returns null.
	 *  
	 * @param Cream_Guid $workflowId
	 * @param Cream_Content_Repository $repository
	 * @return Cream_Workflows_Workflow
	 */	
	public static function getWorkflowById(Cream_Guid $workflowId, Cream_Content_Repository $repository)
	{
		self::_getManager()->getWorkflowById($workflowId, $repository);
	}
	
	/**
	 * Returns the workflow by the given content item. If no workflow
	 * is attached, returns null. If the workflow cann't be found, 
	 * returns null.
	 *  
	 * @param Cream_Content_Item $item
	 * @return Cream_Workflows_Workflow
	 */	
	public static function getWorkflowByItem(Cream_Content_Item $item)
	{
		self::_getManager()->getWorkflowByItem($item);
	}
	
	/**
	 * Returns all workflows from the given repository.
	 *  
	 * @param Cream_Content_Repository $repository
	 * @return array
	 */	
	public static function getWorkflows(Cream_Content_Repository $repository)
	{
		self::_getManager()->getWorkflows($repository);
	}
	
	/**
	 * Returns the workflow history manager
	 * 
	 * @return Cream_Workflows_HistoryManager
	 */
	protected static function _getManager()
	{	
		if (!self::$_manager) {
			self::$_manager = Cream_Workflows_WorkflowManager::instance();
		}		
		
		return self::$_manager;
	}	
}