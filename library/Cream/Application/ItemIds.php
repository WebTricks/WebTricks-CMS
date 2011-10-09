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
 * Implements a static class for holding well-known item ids.
 * 
 * @package		Cream_Application
 * @author		Danny Verkade
 */
class Cream_Application_ItemIds extends Cream_ApplicationIds
{
	/**
	 * GUID of the root node of the tree
	 * 
	 * @var string
	 */
	const rootId = '11111111-1111-1111-1111-111111111111';
	
	/**
	 * GUID of the root node of the workflow items.
	 * 
	 * @var string
	 */
	const workflowRoot = '66a70e67-4736-438f-b40f-a05ae114fdea';
	
	/**
	 * Returns the root id GUID
	 * 
	 * @return Cream_Guid
	 */
	public static function getRootId()
	{
		return self::_getGuid(self::rootId);
	}
	
	/**
	 * Returns the root GUID of the workflow items.
	 * 
	 * @return Cream_Guid
	 */
	public static function getWorkflowRoot()
	{
		return self::_getGuid(self::workflowRoot);
	}
}