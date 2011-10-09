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
 * Base class for a content item field
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Fields_Field
{
	/**
	 * Field ID
	 * 
	 * @var Cream_Guid
	 */
	protected $_fieldId;
	
	/**
	 * Reference to the content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $_item;
	
	/**
	 * Reference to the template field
	 * 
	 * @var Cream_Content_Template_Field
	 */
	protected $_templateField;

	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Guid $fieldId
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Field
	 */
	public static function instance(Cream_Guid $fieldId, Cream_Content_Item $item)
	{
		return Cream::instance(__CLASS__, $fieldId, $item);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Guid $fieldId
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public function __init(Cream_Guid $fieldId, Cream_Content_Item $item)
	{
		$this->_fieldId = $fieldId;
		$this->_item = $item;
	}
	
	/**
	 * Returns the content item this field belongs too.
	 * 
	 * @return Cream_Content_Item
	 */
	public function getItem()
	{
		return $this->_item;
	}

	/**
	 * Returns the id of the field
	 * 
	 * @return Cream_Guid
	 */
	public function getFieldId()
	{
		return $this->_fieldId;
	}
		
	/**
	 * Returns the string value of the field.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->getValue();
	}

	/**
	 * Sets the field value
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function setValue($value)
	{
		$this->_item->getEditing()->assertEditing();
		
		if ($this->isNewValue($value)) {
			$this->_item->getChanges()->setFieldValue($this, $value);
		}		
	}

	/**
	 * Check to see if a value is a new value, or is the same as the 
	 * current value of the field. Returns true if it is a new value,
	 * otherwise returns false. 
	 * 
	 * @param mixed $value
	 * @return boolean
	 */
	protected function isNewValue($value)
	{
		if ($this->getValue() != $value) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Gets the current value of the field. 
	 * 
	 * @param boolean $includeDefaultValue
	 * @return mixed
	 */
	public function getValue($includeDefaultValue = true)
	{
		$changes = $this->_item->getChanges();
		
		if ($changes !== null) {
			$fieldValue = $changes->getFieldValue($this);
		
			if ($fieldValue !== null) {
				return $fieldValue;
			}
		}
		
		$fields = $this->_item->getItemData()->getFieldList();
		
		if (isset($fields[$this->_fieldId->toString()]) && $fields[$this->_fieldId->toString()] !== null) {
			return $fields[$this->_fieldId->toString()];
		}
		
		//if ($includeDefaultValue && $this->_item->getTemplate()->getField($this->_fieldId)) {
		//	return $this->_item->getTemplate()->getField($this->_fieldId)->getDefaultValue();	
		//}
		
		return null;
	}	
	
	/**
	 * Returns the template field associated with this field. 
	 *  
	 * @return Cream_Content_Template_Field
	 */
	public function getTemplateField()
	{
		if (!$this->_templateField) {
			$this->_templateField = Cream_Content_Managers_TemplateProvider::getTemplateField($this->_fieldId, $this->_item);
		}

		return $this->_templateField;
	}	
}