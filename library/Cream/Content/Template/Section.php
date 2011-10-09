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
 * Represents a section of a view.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Template_Section 
{
	/**
	 * Array containing the view fields for this section.
	 * 
	 * @var array
	 */
	protected $_fields = array();
	
	/**
	 * GUID for this view section
	 * 
	 * @var string
	 */
	protected $_id;
	
	/**
	 * Icon of the view section
	 * 
	 * @var string
	 */
	protected $_icon;

	/**
	 * The name of the view section
	 * 
	 * @var string
	 */
	protected $_name;
	
	/**
	 * Template this section belongs too.
	 * 
	 * @var Cream_Content_Template_Item
	 */
	protected $_template;
		
	/**
	 * Array containing the titles in all specified languages. Array key
	 * is the locale, array value is the title in that specific language. 
	 * 
	 * @var array
	 */
	protected $_title = array();
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Content_Template_Item $template
	 * @return Cream_Content
	 */
	public static function instance(Cream_Content_Template_Item $template)
	{
		return Cream::instance(__CLASS__, $template);
	}
	
	/**
	 * Initialize this class
	 * 
	 * @param Cream_Content_Template_Item $template
	 * @return void
	 */
	public function __init(Cream_Content_Template_Item $template)
	{
		$this->_template = $template;
	}
	
	/**
	 * Retrieves a template field by it's name. Returns the template field when
	 * a match is found, otherwise returns null.
	 * 
	 * @param string $fieldName
	 * @return Cream_Content_Template_Field
	 */
	public function getField($fieldName)
	{
		foreach ($this->_fields as $field) {
			if ($field->getName() == $fieldName) {
				return $field;
			}
		}
		
		return null;
	}
	
	/**
	 * Returns the fields for this template section.
	 * 
	 * @return array
	 */
	public function getFields()
	{
		return $this->_fields;
	}
	
	/**
	 * Adds a field to this view section
	 * 
	 * @param Cream_Content_Template_Field $templateField
	 * @return void
	 */
	public function addField(Cream_Content_Template_Field $templateField)
	{
		$this->_fields[] = $templateField;
	}
	
	/**
	 * Returns the name of the section
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
	 * Sets the name of the section
	 * 
	 * @param string $name
	 * @return void
	 */
	public function setName($name)
	{
		$this->_name = $name;
	}
	
	/**
	 * Returns the title of a specific language. If the language is not
	 * initialised returns null.
	 *  
	 * @param Cream_Globalization_Culture $culture
	 * @return string
	 */
	public function getTitle(Cream_Globalization_Culture $culture)
	{
		if (isset($this->_title[$culture->getCulture()])) {
			return $this->_title[$culture->getCulture()];
		} else {
			return null;
		}
	}
	
	/**
	 * Sets the title for a specific language
	 * 
	 * @param Cream_Globalization_Culture $culture
	 * @param string $title
	 * @return void
	 */
	public function setTitle(Cream_Globalization_Culture $culture, $title)
	{
		$this->_title[$culture->getCulture()] = $title;	
	}
	
	/**
	 * Returns the icon for the view section.
	 * 
	 * @return string
	 */
	public function getIcon()
	{
		return $this->_icon;
	}
	
	/**
	 * Sets the icon for the view section.
	 * 
	 * @param string $icon
	 * @return void
	 */
	public function setIcon($icon)
	{
		$this->_icon = $icon;
	}
	
	/**
	 * Returns the template item
	 * 
	 * @return Cream_Content_Template_Item
	 */
	public function getTemplate()
	{
		return $this->_template;
	}
}