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
 * Represents a field of a template.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Template_Field
{
	/**
	 * The view section this template field is attached too.
	 * 
	 * @var Cream_Content_Template_Section
	 */
	protected $_templateSection;
	
	/**
	 * Id Guid of the field
	 * 
	 * @var Cream_Guid
	 */
	protected $_id;
	
	/**
	 * Name of the field
	 * 
	 * @var string
	 */
	protected $_name;
	
	/**
	 * Xpath string to the source.
	 * 
	 * @var string
	 */
	protected $_source;
	
	/**
	 * Array holding description of the different languages 
	 * 
	 * @var array
	 */
	protected $_description = array();
	
	/**
	 * Array holding title of the different languages
	 * 
	 * @var array
	 */
	protected $_title = array();

	/**
	 * Shared field.
	 * 
	 * @var boolean
	 */
	protected $_shared = false;
	
	/**
	 * The field type
	 * 
	 * @var string
	 */
	protected $_type;
	
	/**
	 * The default value
	 * 
	 * @var string
	 */
	protected $_defaultValue;
	
	/**
	 * Is field unversioned.
	 * 
	 * @var boolean
	 */
	protected $_unversioned = false;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Content_Template_Section $templateSection
	 * @return Cream_Content_Template_Field
	 */
	public static function instance(Cream_Content_Template_Section $templateSection)
	{
		return Cream::instance(__CLASS__, $templateSection);
	}
	
	/**
	 * Initialize this class
	 * 
	 * @param Cream_Content_Template_Section $templateSection
	 * @return void
	 */
	public function __init(Cream_Content_Template_Section $templateSection)
	{
		$this->_templateSection = $templateSection;
	}
	
	/**
	 * Returns the id GUID of this field
	 * 
	 * @return Cream_Guid
	 */
	public function getId()
	{
		return $this->_id;
	}
	
	/**
	 * Sets the id GUID of this field
	 * 
	 * @param Cream_Guid $fieldId
	 */
	public function setId(Cream_Guid $fieldId)
	{
		$this->_id = $fieldId;
	}
	
	/**
	 * Returns the description of the field in the specified language, when
	 * the title is not set in the given language, returns null.
	 * 
	 * @param Cream_Globalization_Culture $culture
	 * @return string
	 */
	public function getDescription(Cream_Globalization_Culture $culture)
	{
		if (isset($this->_description[$culture->getCulture()])) {
			return $this->_description[$culture->getCulture()];
		} else {
			return null;
		}		
	}
	
	/**
	 * Sets the description of a specific language
	 * 
	 * @param Cream_Globalization_Culture $culture
	 * @param string $description
	 * @return void
	 */
	public function setDescription(Cream_Globalization_Culture $culture, $description)
	{
		$this->_description[$culture->getCulture()] = $description;		
	}
	
	/**
	 * Returns the title of the field in the specified language, when
	 * the title is not set in the given language, returns null.
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
	 * Sets a title of a specific language
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
	 * Sets the name of the field.
	 * 
	 * @param string $name
	 * @return void
	 */
	public function setName($name)
	{
		$this->_name = $name;
	}
	
	/**
	 * Returns the name of the field.
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
	 * Returns the view section where this field is attached too. 
	 * 
	 * @return Cream_Content_Template_Section
	 */
	public function getSection()
	{
		return $this->_templateSection;
	}
	
	/**
	 * Returns the source of the field. This is a xpath string for
	 * an item in the content tree.
	 * 
	 * @return string
	 */
	public function getSource()
	{
		return $this->_source;
	}
	
	/**
	 * Sets the source of the field.
	 * 
	 * @param string $source
	 * @return void
	 */
	public function setSource($source)
	{
		$this->_source = $source;
	}
	
	/**
	 * Sets the field type
	 * 
	 * @param string $type
	 * @return void
	 */
	public function setType($type)
	{
		$this->_type = $type;
	}
	
	/**
	 * Returns the field type
	 * 
	 * @return string
	 */
	public function getType()
	{
		return $this->_type;
	}
	
	/**
	 * Returns if the field is shared among languages.
	 * 
	 * @return boolean
	 */
	public function isShared()
	{
		return $this->_shared;
	}
	
	/**
	 * Sets if the field is shared among languages.
	 * 
	 * @param boolean $shared
	 * @return void
	 */
	public function setShared($shared)
	{
		$this->_shared = $shared;
	}
	
	/**
	 * Returns the default value
	 * 
	 * @return string
	 */
	public function getDefaultValue()
	{
		return $this->_defaultValue;
	}
	
	/**
	 * Sets the default value
	 * 
	 * @param string $value
	 * @return void
	 */
	public function setDefaultValue($value) 
	{
		$this->_defaultValue = $value;
	}
	
	/**
	 * Returns if the field is unversioned.
	 * 
	 * @return boolean
	 */
	public function isUnversioned()
	{
		return $this->_unversioned;
	}
	
	/**
	 * Sets if the field is unversioned.
	 * 
	 * @param boolean $unversioned
	 * @return void
	 */
	public function setUnversioned($unversioned)
	{
		$this->_unversioned = $unversioned;
	}
	
	/**
	 * Returns if the field is versioned.
	 * 
	 * @return boolean
	 */
	public function isVersioned()
	{
		if (!$this->_shared && !$this->_unversioned) {
			return true;
		} else {
			return false;
		}
	}
}