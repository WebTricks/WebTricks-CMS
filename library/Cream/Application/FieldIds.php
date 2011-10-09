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
 * Implements a static class for holding well-known fieldnames 
 * relating to fields. 
 * 
 * @package		Cream_Application
 * @author		Danny Verkade
 */
class Cream_Application_FieldIds extends Cream_ApplicationIds
{
	/**
	 * Id of the base templates field
	 *  
	 * @var string
	 */
	const baseTemplatesId = 'fb5b55f9-1ce2-4e2e-885d-fa4189d336aa';
	
	const created = '7bae5bae-dd1e-47d9-bb49-d2ce679613ad';
	
	const createdBy = '6c27700a-e10b-4bb4-a581-61dfe39bc0fe';
	
	const HIDDEN = '07ed66f6-cdee-4835-9773-354de49b0d1e';
	
	const iconId = 'ecd239b7-e16d-4eaf-8970-d61d7d3bf6d7';
	
	const lock = '104861d6-fa8b-413c-ab7e-111b934bb50c';
	
	/**
	 * Fieldname representing the publish date
	 * 
	 * @var string
	 */
	const publishDate = 'publishDate';
	
	/**
	 * Fieldname respresnting the unpublish date
	 * 
	 * @var string
	 */
	const unpublishDate = 'unpublishDate';

	const READ_ONLY = 'b10954f2-bb66-4a61-85dc-242e5e120c9a';
	
	/**
	 * Represents the sort order field id
	 * 
	 * @var string
	 */
	const sortOrderId = 'd24800bd-918c-4cd0-be9a-bfb6a9950761';
	
	/**
	 * Represents the security field id
	 * 
	 * @var string
	 */
	const security = 'bcf2a4c9-19b5-4ba9-a551-64e7006faa93';
	
	const updated = '639ec89b-2151-4e9b-be35-2a139ffd4b6c';
	
	const updatedBy = 'c1dd18a3-d94e-4e58-8328-e3bc1a307a01';
	
	/**
	 * Fieldname representing the workflow.
	 * 
	 * @var string
	 */
	const workflow = '2cf9e2c3-0e04-43b3-a5b7-3f67873bb1c2';
	
	/**
	 * Fieldname representing the workflow state id
	 * 
	 * @var string
	 */
	const workflowState = 'a2fa1050-cb6c-4510-aa07-333c567ea465'; 	

	/**
	 * Returns the id of the base templates field
	 *
	 * @return Cream_Guid
	 */
	public static function getBaseTemplatesId()
	{
		return self::_getGuid(self::baseTemplatesId);
	}
	
	public static function getCreatedId()
	{
		
	}
	
	public function getCreatedById()
	{
		
	}
	
	/**
	 * Returns the icon id GUID.
	 * 
	 * @return Cream_Guid
	 */
	public static function getIconId()
	{
		return self::_getGuid(self::iconId);
	}
	
	public static function getHidden()
	{
		return self::_getGuid(self::HIDDEN);
	}
	
	/**
	 * Returns the sort order id GUID.
	 * 
	 * @return Cream_Guid
	 */
	public static function getSortOrderId()
	{
		return self::_getGuid(self::sortOrderId);
	}
	
	public static function getReadOnly()
	{
		return self::_getGuid(self::READ_ONLY);
	}
	
	/**
	 * Returns the security id GUIG
	 * 
	 * @return Cream_Guid
	 */
	public static function getSecurity()
	{
		return self::_getGuid(self::security);
	}	
	
	/**
	 * Returns the guid of the field containing the workflow.
	 * 
	 * @return Cream_Guid
	 */
	public static function getWorkflow()
	{
		return self::_getGuid(self::workflow);		
	}
}