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
 * relating to template fields. 
 * 
 * @package		Cream_Application
 * @author		Danny Verkade
 */
class Cream_Application_TemplateFieldIds extends Cream_ApplicationIds
{
	/**
	 * The GUID id for the default value field. 
	 * 
	 * @var string
	 */
	const defaultValue = '4d09ce1a-44b5-483a-a9b4-dc59e57dc54b';	
	
	/**
	 * The GUID id for the description field.
	 * 
	 * @var string
	 */
	const description = '';	
	
	/**
	 * The GUID for the template section item.
	 * 
	 * @var string
	 */
	const shared = 'f47bf51d-476b-4c3b-93d1-c4ced837b839'; 
	
	/**
	 * The GUID for the template section item.
	 * 
	 * @var string
	 */
	const source = '741656f1-cc8c-4134-9a0c-b9e2f7b93dce'; 
	
	/**
	 * The GUID for the template section item.
	 * 
	 * @var string
	 */
	const title = 'ef3f886b-cbda-485a-9fdf-c1cd5565e6c1'; 
	
	/**
	 * The GUID for the template section item.
	 * 
	 * @var string
	 */
	const type = '1289277f-ca7c-4ae6-a92e-a611198ef99a'; 
	
	/**
	 * Unversioned guid.
	 * 
	 * @var string
	 */
	const unversioned = '7c7c3fb6-04e1-406b-8c2a-d048fb8db5af';
	
	/**
	 * Returns the id GUID of the default value field.
	 * 
	 * @return Cream_Guid
	 */
	public static function getDefaultValue()
	{
		return self::_getGuid(self::defaultValue);		
	}
	
	/**
	 * Returns the id GUID of the description field.
	 * 
	 * @return Cream_Guid
	 */
	public static function getDescription()
	{
		return self::_getGuid(self::description);		
	}
	
	/**
	 * Returns the id GUID of the shared field.
	 * 
	 * @return Cream_Guid
	 */
	public static function getShared()
	{
		return self::_getGuid(self::shared);		
	}
	
	/**
	 * Returns the id GUID of the source field.
	 * 
	 * @return Cream_Guid
	 */
	public static function getSource()
	{
		return self::_getGuid(self::source);		
	}

	/**
	 * Returns the id GUID of the title field.
	 * 
	 * @return Cream_Guid
	 */
	public static function getTitle()
	{
		return self::_getGuid(self::title);		
	}	

	/**
	 * Returns the id GUID of the type field.
	 * 
	 * @return Cream_Guid
	 */
	public static function getType()
	{
		return self::_getGuid(self::type);		
	}		
}