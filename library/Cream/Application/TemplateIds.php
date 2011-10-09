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
 * Implements a static class for holding well-known GUIDs 
 * relating to templates.
 * 
 * @package		Cream_Application
 * @author		Danny Verkade
 */
class Cream_Application_TemplateIds extends Cream_ApplicationIds
{	
	const culture = '24ecd8eb-b3aa-4439-b200-4fde450f2b21';
	/**
	 * the GUID for the domain template item.
	 * 
	 * @var strings
	 */
	const domainId = 'f6983415-c259-4f93-98f5-98b0725370f6';
	
	const FOLDER = '5c321d23-6ab4-4276-bc19-a93b14299ed3';
	
	const referenceId = 'dfde573b-5b5c-4953-968e-9b211b529ea6';
	
	/**
	 * The GUID for the template item. 
	 * 
	 * @var string
	 */
	const templateId = '3deaa51d-c661-4aed-95ee-373f05ad5473';	
	
	/**
	 * The GUID for the template field item.
	 * 
	 * @var string
	 */
	const templateFieldId = 'd5031ced-ea68-4b2b-a489-bc112d0a3d17';	
	
	const TEMPLATE_FIELD_TYPE = '6949a1a4-6874-4070-9ab6-9b591e2a1dec';
	
	/**
	 * The GUID for the template section item.
	 * 
	 * @var string
	 */
	const templateSectionId = 'bacb124c-51e8-4b98-abb4-336ed3227635'; 

	/**
	 * Returns the GUID ID of the culture item.
	 * 
	 * @return Cream_Guid
	 */
	public static function getCulture()
	{
		return self::_getGuid(self::culture);
	}
	
	/**
	 * Returns the domain template GUID.
	 * 
	 * @return Cream_Guid
	 */
	public static function getDomainId()
	{
		return self::_getGuid(self::domainId);
	}
	
	public static function getFolder()
	{
		return self::_getGuid(self::FOLDER);
	}
	
	/**
	 * Returns the template id GUID
	 * 
	 * @return Cream_Guid
	 */
	public static function getTemplateId()
	{	
		return self::_getGuid(self::templateId);
	}
	
	/**
	 * Returns the template field id GUID.
	 * 
	 * @return Cream_Guid
	 */
	public static function getTemplateFieldId()
	{
		return self::_getGuid(self::templateFieldId);		
	}
	
	public static function getTemplateFieldType()
	{
		return self::_getGuid(self::TEMPLATE_FIELD_TYPE);
	}
	
	/**
	 * Returns the template section id GUID.
	 * 
	 * @return Cream_Guid
	 */
	public static function getTemplateSectionId()
	{
		return self::_getGuid(self::templateSectionId);		
	}
	
	public static function getReferenceId()
	{
		return self::_getGuid(self::referenceId);
	}
}