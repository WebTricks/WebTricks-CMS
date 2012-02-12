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
 * Represents a template item.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Template_Item
{
	/**
	 * The unique ID of the template
	 * 
	 * @var Cream_Guid
	 */
	protected $_id;
	
	/**
	 * Repository for this template.
	 * 
	 * @var Cream_Content_Repository
	 */
	protected $_repository;
	
	/**
	 * The template sections
	 * 
	 * @var array
	 */
	protected $_sections = array();
	
	/**
	 * Array holding the base templates
	 * 
	 * @var array
	 */
	protected $_baseTemplates = array();
	
	protected $_fields;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Guid $templateId
	 * @param Cream_Content_Repository $repository
	 * @return Cream_Content_Template_Item
	 */
	public static function instance(Cream_Guid $templateId, Cream_Content_Repository $repository)
	{
		return Cream::instance(__CLASS__, $templateId, $repository);
	}
	
	/**
	 * Initialize this class
	 * 
	 * @param Cream_Guid $templateId
	 * @param Cream_Content_Repository $repository 
	 * @return void
	 */
	public function __init(Cream_Guid $templateId, Cream_Content_Repository $repository)
	{
		$this->_id = $templateId;
		$this->_repository = $repository;
	}
	
	/**
	 * Array holding the base templates
	 * 
	 * @return array
	 */
	public function getBaseTemplates()
	{
		return $this->_baseTemplates;
	}
	
	/**
	 * Adds a base template
	 * 
	 * @param Cream_Content_Template_Item $template
	 */
	public function addBaseTemplate(Cream_Content_Template_Item $template)
	{
		$this->_baseTemplates[] = $template;
	}
	
	/**
	 * Retrieves a template field by it's id. Returns the template field when
	 * a match is found, otherwise returns null.
	 * 
	 * @param Cream_Guid $fieldId
	 * @return Cream_Content_Template_Field
	 */
	public function getField(Cream_Guid $fieldId)
	{
		foreach($this->getFields() as $field) {
			if ($field->getId() == $fieldId) {
				return $field;
			}
		}
		
		foreach($this->getBaseTemplates() as $template) {
			
			$field = $template->getField($fieldId);
			
			if ($field) {
				return $field;
			}
		}
		
		return null;
	}
	
	/**
	 * Retrieves a template field by it's name. Returns the template field when
	 * a match is found, otherwise returns null.
	 * 
	 * @param Cream_Guid $fieldId
	 * @return Cream_Content_Template_Field
	 */
	public function getFieldByName($name)
	{
		$name = strtolower($name);
		
		foreach($this->getFields() as $field) {
			if (strtolower($field->getName()) == $name) {
				return $field;
			}
		}
		
		return null;
	}
	
	/**
	 * Returns an array with all fields of this view.
	 * 
	 * @return array
	 */
	public function getFields()
	{
		if (!$this->_fields) {
			$fields = array();
		
			foreach($this->getSections() as $section) {
				$fields = array_merge($fields, $section->getFields());
			}
			
			$this->_fields = $fields;
		}
		
		return $this->_fields;
	}
	
	/**
	 * Returns the repository.
	 * 
	 * @return Cream_Content_Repository
	 */
	public function getRepository()
	{
		return $this->_repository;
	}
	
	/**
	 * Adds a section to the internal collection of sections.
	 * 
	 * @param Cream_Content_Template_Section $templateSection
	 * @return void
	 */
	public function addSection(Cream_Content_Template_Section $templateSection)
	{
		$this->_sections[] = $templateSection;
	}
	
	/**
	 * Retrieves a section by it's name. Returns a template section when a
	 * match is found, otherwise returns null.
	 * 
	 * @param string $sectionName
	 * @return Cream_Content_Template_Section
	 */
	public function getSection($sectionName)
	{
		foreach($this->_sections as $section) {
			if ($section->getName() == $sectionName) {
				return $section;
			}
		}
		
		return null;
	}
	
	/**
	 * Returns an array of the sections
	 * 
	 * @param boolean $includeBaseTemplates 
	 * @return array
	 */
	public function getSections($includeBaseTemplates = true)
	{
		$sections = $this->_sections;
		
		if ($includeBaseTemplates) {
			foreach($this->getBaseTemplates() as $template) {
				$baseSections = $template->getSections();
				$sections = array_merge($sections, $baseSections);
			}
		}
		
		return $sections;
	}
	
	public function getContextMenuItemId()
	{
		return null;
	}
}