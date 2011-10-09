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
 * The template manager
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Managers_TemplateManager extends Cream_ApplicationComponent
{
	/**
	 * Inner cache of items already loaded
	 * 
	 * @var array
	 */
	protected $_innerCache = array();
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Content_Managers_TemplateManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Retrieves a template based upon the template id of the content
	 * item. Throws an exception when the item does not have a valid 
	 * template. 
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Template_Item
	 */
	public function getTemplate(Cream_Content_Item $item)
	{
		$templateId = $item->getItemData()->getItemDefinition()->getTemplateId();
		return $this->getTemplateById($templateId, $item->getRepository());
	}
	
	/**
	 * Returns the template of the supplied template id.
	 * 
	 * @param Cream_Guid $templateId
	 * @param Cream_Content_Repository $repository
	 * @throws Cream_Content_Managers_Exception
	 * @return Cream_Content_Template_Item
	 */
	public function getTemplateById(Cream_Guid $templateId, Cream_Content_Repository $repository)
	{
		$cacheTemplate = false;
		$template = $this->getItemFromCache($templateId);
				
		if ($template === null) {
			$cacheTemplate = true;
			$templateItem = $repository->getItem($templateId);

			if (!$templateItem) {
				return null;
			}
			
			if ($templateItem->getItemData()->getItemDefinition()->getTemplateId() == Cream_Application_TemplateIds::getTemplateId()) {
				$template = $this->buildTemplate($templateItem);
			} else {
				throw new Cream_Content_Managers_Exception('Item with ID "'. $templateId .'" is not a template.');				
			}
		}
		
		// Always set to cache the item, so changes will be cached automatically
		$this->addItemToCache($templateId, $template, $cacheTemplate);
		
		return $template;
	}
	
	/**
	 * Returns the template field, or when the template field is not found,
	 * return null.
	 * 
	 * @param Cream_Guid $fieldId
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Template_Field
	 */
	public function getTemplateField(Cream_Guid $fieldId, Cream_Content_Item $item)
	{
		$template = $this->getTemplate($item);
				
		if ($template !== null) {
			return $template->getField($fieldId);
		} else {
			return null;
		}
	}
	
	/**
	 * Retrieves the id GUID of the template field.
	 * 
	 * @param string $fieldName
	 * @param Cream_Content_Item $item
	 * @param Cream_Guid
	 */
	public function getTemplateFieldId($fieldName, Cream_Content_Item $item)
	{
		$template = $this->getTemplate($item);
		
		if ($template !== null) {
			$field = $template->getFieldByName($fieldName);
			if ($field !== null) {
				return $field->getId();
			} else {
				return null;
			}
		} else {
			return null;
		}		
	}
	
	/**
	 * Returns the unique cache key to cache this item by.
	 * 
	 * @param Cream_Guid $templateId
	 * @return string
	 */
	protected function getCacheKey(Cream_Guid $templateId) 
	{
		return 'Template'. $templateId;	
	}
	
	/**
	 * Returns a template item from the cache. It will first hit the
	 * inner cache and then tries to get it from the applications
	 * cache.
	 * 
	 * @param Cream_Guid $templateId
	 * @return Cream_Content_Template_Item
	 */
	protected function getItemFromCache(Cream_Guid $templateId)
	{
		$key = $this->getCacheKey($templateId);
		if (isset($this->_innerCache[$key])) {
			return $this->_innerCache[$key];
		} else {
			$cache = $this->getApplication()->getCache()->load($key);
			
			if ($cache === false) {
				return null;
			} else {
				return $cache;
			}
		}
	}
	
	/**
	 * Caches a template item in the inner cache and the application
	 * cache. 
	 * 
	 * @param Cream_Guid $templateId
	 * @param Cream_Content_Template_Item $item
	 * @param boolean $external
	 * @return void
	 */
	protected function addItemToCache(Cream_Guid $templateId, Cream_Content_Template_Item $item, $external = false)
	{
		$key = $this->getCacheKey($templateId);
		$this->_innerCache[$key] = $item;
		
		if ($external) {
			$this->getApplication()->getCache()->save($item, $key);
		}
	}	
	
	/**
	 * Build the template by the given item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Template_Item
	 */
	protected function buildTemplate(Cream_Content_Item $item)
	{
		$baseTemplatesIds = array();
		$template = Cream_Content_Template_Item::instance($item->getItemId(), $item->getRepository());
		$fieldValue = $item->getFields()->getField(Cream_Application_FieldIds::getBaseTemplatesId())->getValue();
		
		if ($fieldValue) {
			$baseTemplatesIds = explode("|", $fieldValue);
		}
		
		foreach($baseTemplatesIds as $id) {
			$baseTemplateId = Cream_Guid::parseGuid($id);
			$baseTemplate = $this->getTemplateById($baseTemplateId, $item->getRepository());
			$template->addBaseTemplate($baseTemplate);
		}
		
		foreach($item->getChildren() as $childItem) {
			if ($this->isTemplateSection($childItem)) {
				$this->addSection($childItem, $template);
			}
		}

		return $template;
	}
	
	/**
	 * Determines if the given content item is a template section.
	 * 
	 * @param Cream_Content_Item $item
	 * @return boolean
	 */
	protected function isTemplateSection(Cream_Content_Item $item)
	{	
		if ($item->getItemData()->getItemDefinition()->getTemplateId() == Cream_Application_TemplateIds::getTemplateSectionId()) {
			return true;		
		} else {
			return false;
		}
	}
	
	/**
	 * Determines if the given content item is a template field.
	 * 
	 * @param Cream_Content_Item $item
	 * @return boolean
	 */
	protected function isTemplateField(Cream_Content_Item $item)
	{
		if ((string) $item->getItemData()->getItemDefinition()->getTemplateId() == (string) Cream_Application_TemplateIds::getTemplateFieldId()) {
			return true;		
		} else {
			return false;
		}
	}	
	
	/**
	 * Adds a template section to the template
	 * 
	 * @param Cream_Content_Item $item
	 * @param Cream_Content_Template_Item $template
	 * @return void
	 */
	protected function addSection(Cream_Content_Item $item, Cream_Content_Template_Item &$template)
	{
		$data = $item->getItemData()->getFieldList();
		
		$templateSection = Cream_Content_Template_Section::instance($template);
		$templateSection->setName($item->getName());
		$templateSection->setIcon($data[Cream_Application_FieldIds::iconId]);	
		
		foreach($item->getCultures() as $culture) {
			$cultureItem = Cream_Content_Managers_ItemProvider::getItem($item->getRepository(), $item->getItemId(), $culture);
			$cultureData = $cultureItem->getItemData()->getFieldList();

			// $templateSection->setTitle($culture, $cultureData[Cream_Application_TemplateFieldIds::title]);
			
			//if ($cultureItem->getFields()->getField(Cream_Application_TemplateFieldIds::getDescription())) {
			//	$templateField->setDescription($culture, $cultureItem->getFields()->getField(Cream_Application_TemplateFieldIds::getDescription())->getValue());
			//}
		}		
		
		foreach($item->getChildren() as $childItem) {
			if ($this->isTemplateField($childItem)) {
				$this->addField($childItem, $templateSection);
			}
		}
		
		$template->addSection($templateSection);
	}
	
	/**
	 * Adds a template field to the template section.
	 * 
	 * @param Cream_Content_Item $item
	 * @param Cream_Content_Template_Section $templateSection
	 * @return void
	 */
	protected function addField(Cream_Content_Item $item, Cream_Content_Template_Section &$templateSection)
	{
		$data = $item->getItemData()->getFieldList();
		
		$templateField = Cream_Content_Template_Field::instance($templateSection);
		$templateField->setId($item->getItemId());
		$templateField->setName($item->getName());
		
		$templateField->setSource($data[Cream_Application_TemplateFieldIds::source]);
		$templateField->setShared($data[Cream_Application_TemplateFieldIds::shared]);
		$templateField->setUnversioned($data[Cream_Application_TemplateFieldIds::unversioned]);
		$templateField->setType($data[Cream_Application_TemplateFieldIds::type]);
		
		foreach($item->getCultures() as $culture) {
			$cultureItem = Cream_Content_Managers_ItemProvider::getItem($item->getRepository(), $item->getItemId(), $culture);
			$cultureData = $cultureItem->getItemData()->getFieldList();

			$templateField->setTitle($culture, $cultureData[Cream_Application_TemplateFieldIds::title]);
			
			//if ($cultureItem->getFields()->getField(Cream_Application_TemplateFieldIds::getDescription())) {
			//	$templateField->setDescription($culture, $cultureItem->getFields()->getField(Cream_Application_TemplateFieldIds::getDescription())->getValue());
			//}
		}
				
		$templateSection->addField($templateField);
	}
}