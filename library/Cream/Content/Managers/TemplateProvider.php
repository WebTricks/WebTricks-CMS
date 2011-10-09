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
 * The template provider
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Managers_TemplateProvider 
{
	/**
	 * @var Cream_Content_Managers_TemplateManager
	 */
	protected static $_manager = null;			
	
	/**
	 * Retrieves a template based upon the template id of the content
	 * item. Throws an exception when the item does not have a valid 
	 * template. 
	 *  
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Template_Item
	 */
	public static function getTemplate(Cream_Content_Item $item)
	{
		return self::_getManager()->getTemplate($item);
	}
	
	/**
	 * Returns the template of the supplied template id.
	 * 
	 * @param Cream_Guid $templateId
	 * @param Cream_Content_Repository $repository
	 * @return Cream_Content_Template_Item
	 */
	public static function getTemplateById(Cream_Guid $templateId, Cream_Content_Repository $repository)
	{
		return self::_getManager()->getTemplateById($templateId, $repository);
	}
	
	/**
	 * Returns the template field of the specified item.
	 * 
	 * @param Cream_Guid $fieldId
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Template_Field
	 */
	public static function getTemplateField(Cream_Guid $fieldId, Cream_Content_Item $item)
	{
		return self::_getManager()->getTemplateField($fieldId, $item);
	}

	/**
	 * Retrieves the id GUID of the template field.
	 * 
	 * @param string $fieldName
	 * @param Cream_Content_Item $item
	 * @param Cream_Guid
	 */
	public static function getTemplateFieldId(Cream_Guid $fieldId, Cream_Content_Item $item)
	{
		return self::_getManager()->getTemplateFieldId($fieldId, $item);
	}
	
	/**
	 * Returns the item manager
	 * 
	 * @return Cream_Content_Managers_TemplateManager
	 */
	protected static function _getManager()
	{
		if (!self::$_manager) {
			self::$_manager = Cream_Content_Managers_TemplateManager::instance();
		}		
		
		return self::$_manager;
	}	
}