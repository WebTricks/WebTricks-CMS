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
 * Represents a field change of an item.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_FieldChange
{
	/**
	 * Reference to the field object
	 * 
	 * @var Cream_Content_Field
	 */
	protected $field;
	
	/**
	 * Value of the field
	 * 
	 * @var mixed
	 */
	protected $value;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Field $field
	 * @param mixed $value
	 * @return Cream_Content_FieldChange
	 */
	public static function instance($field, $value)
	{
		return Cream::instance(__CLASS__, $field, $value);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Field $field
	 * @param mixed $value
	 * @return void
	 */
	public function __init($field, $value)
	{
		$this->field = $field;
		$this->value = $value;
	}
	
	/**
	 * Returns the view field for this field.
	 * 
	 * @return Cream_Content_Template_Field
	 */
	public function getTemplateField()
	{
		return $this->field->getTemplateField();	
	}
	
	/**
	 * Returns the field name
	 * 
	 * @return string
	 */
	public function getFieldId()
	{
		return $this->field->getFieldId();
	}
	
	/**
	 * Returns the culture for this field change
	 * 
	 * @return Cream_Globalization_Culture
	 */
	public function getCulture()
	{
		return $this->field->getItem()->getCulture();
	}
	
	/**
	 * Returns the version
	 * 
	 * @return Cream_Content_Version
	 */
	public function getVersion()
	{
		return $this->field->getItem()->getVersion();
	}
	
	/**
	 * Returns the value
	 * 
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
}