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
	 * @return Cream_Web_UI_ExtControls_Form_TextField
	 */
	public static function getField(Cream_Content_Template_Field $field)
	{
		$item = self::getFieldTypeItem($field->getType());
		
		if ($item) {
			$control = $item->get('Control');
			
			if (Cream::exists($control)) {
				$webcontrol = Cream::instance((string) $control);

				if (method_exists($webcontrol, 'setSource')) {
					$webcontrol->setSource($field->getSource());
				}
				
				return $webcontrol;
			} else {
				return Cream_Web_UI_ExtControls_Form_TextField::instance();
			}
			
		} else {
			return Cream_Web_UI_ExtControls_Form_TextField::instance();
		}
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
			$repository = Cream::getApplication()->getRepository('core');
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
				$repository = Cream::getApplication()->getRepository('core');
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