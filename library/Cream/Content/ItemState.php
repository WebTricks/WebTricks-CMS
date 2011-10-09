<?php 
/**
 * WebTricks
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
 * Provides information about the workflow state of an item. 
 * 
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemState 
{
	/**
	 * The content item for this state object
	 * 
	 * @var Cream_Content_Item
	 */
	protected $item;

	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Item $item 
	 * @return Cream_Content_State
	 */
	public static function instance(Cream_Content_Item $item)
	{
		return Cream::instance(__CLASS__, $item);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Item $content 
	 * @return void
	 */
	public function __init($item)
	{
		$this->content = $item;
	}
	
	/**
	 * Gets the workflow for this item
	 * 
	 * @return Cream_Workflows_WorkflowInterface
	 */
	public function getWorkflow()
	{
		return Cream_Workflows_WorkflowProvider::getByItem($this->item);
	}
	
	/**
	 * Returns the workflow state of the item
	 * 
	 * @return Cream_Workflows_WorkflowState
	 */
	public function getWorkflowState()
	{
		$workflow = $this->getWorkflow();
		if ($workflow !== null) {
			return $workflow->getState($this->item);
		} else {
			return null;
		}
	}
}