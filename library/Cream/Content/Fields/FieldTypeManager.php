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
 * Factory class getting the correct field class.
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Fields_FieldTypeManager
{
    /**
     * Get the correct field
     *
     * @param Cream_Guid $fieldId
     * @param Cream_Content_Item $item
     * @return Cream_Content_Fields_Field
     */
    public static function getField(Cream_Guid $fieldId, Cream_Content_Item $item)
    {
    	$templateId = $item->getItemData()->getItemDefinition()->getTemplateId();
    	
		switch($templateId) {
			case Cream_Application_TemplateIds::getTemplateId():
			case Cream_Application_TemplateIds::getTemplateFieldId():
			case Cream_Application_TemplateIds::getTemplateSectionId():
				return Cream::instance('Cream_Content_Fields_Field', $fieldId, $item);
			break;
			default:
				
				$templateField = Cream_Content_Managers_TemplateProvider::getTemplateField($fieldId, $item);
				
				return Cream::instance('Cream_Content_Fields_TextField', $fieldId, $item);
				
				if (Cream::exists('Cream_Content_Fields_'. $templateField->getType() .'Field')) {
					return Cream::instance('Cream_Content_Fields_'. $templateField->getType() .'Field', $fieldId, $item);			
				} else {
					throw new Cream_Content_Fields_Exception('Field type "'. $templateField->getType() .'" not found');
				}
			break;
		}
    }
}