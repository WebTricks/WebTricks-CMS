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
 * Field type manager
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_ContentManager_Editor_Fields_FieldTypeManager extends Cream_ApplicationComponent
{
	/**
	 * Key to cache the field type ids.
	 * 
	 * @var string
	 */
	const CACHE_KEY_FIELDTYPEIDS = 'shell_content_fieldtypeids';

	/**
	 * Defeault field type
	 * 
	 * @var string
	 */	
	const DEFAULT_FIELD_TYPE = 'WebTricks_Shell_Applications_ContentManager_Editor_Fields_TextField';
	
	/**
	 * Path the the item fields.
	 * 
	 * @var string
	 */
	const REPOSITORY_PATH_FIELDS = 'webtricks/system/Field types';
	
	/**
	 * Array holding field type ids. Key of the array is the name of
	 * the field, value is the item id.
	 *  
	 * @var array
	 */
	protected static $_fieldTypeIds;
	
	/**
	 * Retrieves a field
	 *  
	 * @param Cream_Content_Template_Field $field
	 * @param Cream_Content_Item $item 
	 * @return WebTricks_Shell_Applications_ContentManager_Editor_Field_Abstract
	 */
	public static function getField(Cream_Content_Template_Field $field, Cream_Content_Item $contentItem)
	{
		$item = self::getFieldTypeItem($field->getType());
		
		if ($item) {
			$control = $item->get('Control');
			
			if (Cream::exists($control)) {
				$fieldControl = Cream::instance((string) $control, $field, $contentItem);
			}
		} 
		
		if (!isset($fieldControl)) {
			$fieldControl = Cream::instance(self::DEFAULT_FIELD_TYPE, $field, $contentItem);
		}
		
		return $fieldControl;
	}
	
	/**
	 * Returns the field item of the specified type, returns null when
	 * the field type is not found.
	 * 
	 * @param string $type
	 * @return Cream_Content_Item
	 */
	public static function getFieldTypeItem($type)
	{
		$type = strtolower($type);
		$fieldTypeIds = self::getFieldTypeIds();

		if (isset($fieldTypeIds[$type])) {
			$itemId = $fieldTypeIds[$type];
			$repository = Cream_Content_Managers_RepositoryProvider::getRepository('core');
			return $repository->getItem($itemId);
		}
	}
	
	public static function getFieldTypeIds()
	{
		if (!self::$_fieldTypeIds) {
			
			$fieldTypeIds = Cream::getApplication()->getCache()->load(self::CACHE_KEY_FIELDTYPEIDS);
						
			if ($fieldTypeIds) {
				self::$_fieldTypeIds = $fieldTypeIds;
			} else {
				$repository = Cream_Content_Managers_RepositoryProvider::getRepository('core');
				$item = $repository->getItemByPath(self::REPOSITORY_PATH_FIELDS);

				if ($item) {
					self::_setFieldTypeIds($item);
					Cream::getApplication()->getCache()->save(self::$_fieldTypeIds, self::CACHE_KEY_FIELDTYPEIDS);
				}
			}
		}
		
		return self::$_fieldTypeIds;
	}
	
	protected static function _setFieldTypeIds(Cream_Content_Item $item)
	{
		foreach ($item->getChildren() as $child) {
			if ($child->getTemplateId() == Cream_Application_TemplateIds::getFolder()) {
				self::_setFieldTypeIds($child);
			}
			if ($child->getTemplateId() == Cream_Application_TemplateIds::getTemplateFieldType()) {
				self::$_fieldTypeIds[strtolower($child->getName())] = $child->getItemId();
			}
		}
	}
}