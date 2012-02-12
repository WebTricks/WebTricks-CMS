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
 * Represents a list of changed fields
 * 
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemChanges
{
	/**
	 * Reference to the content item object
	 * 
	 * @var Cream_Content_Item
	 */
	protected $_item;
	
	/**
	 * Array holding the changed field items
	 * 
	 * @var array
	 */
	protected $_fields = array();
	
	/**
	 * Array holding property changes.
	 * 
	 * @var array
	 */
	protected $_properties = array();
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemChanges
	 */
	public static function instance($item)
	{
		return Cream::instance(__CLASS__, $item);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public function __init($item) 
	{
		$this->_item = $item;	
	}
	
	/**
	 * Returns the value of a changes field.
	 * 
	 * @param Cream_Content_Field $field
	 * @return mixed
	 */
	public function getFieldValue($field)
	{
		$fieldId = $field->getFieldId();
		
		if (isset($this->_fields[$fieldId->toString()])) {
			$change = $this->_fields[$fieldId->toString()];
			
			return $change->getValue();
		}
		
		return null;
	}
	
	/**
	 * Check to see if a field is modified. Return true if the field
	 * has been modified, oterwhise returns false.
	 * 
	 * @param Cream_Content_Field $field
	 * @return boolean
	 */
	public function isFieldModified($field)
	{
		$fieldId = $field->getFieldId();
		
		if (isset($this->_fields[$fieldId->toString()])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Sets a field which has been changed
	 * 
	 * @param Cream_Content_Field $field
	 * @param mixed $value
	 * @return void
	 */
	public function setFieldValue($field, $value)
	{
		$this->_fields[$field->getFieldId()->toString()] = Cream_Content_FieldChange::instance($field, $value);
	}
	
	/**
	 * Determines whether this object holds any fields that has been
	 * changed. True if this instance has fields changed, otherwise 
	 * false. 
	 *
	 * @return boolean
	 */
	public function hasChangedFields()
	{
		if (count($this->_fields)) {
			return true;
		} else {
			return false;
		}	
	}
	
	/**
	 * Determines whether any properties have been changed. True if 
	 * there are changed properties, otherwise false. 
	 *
	 * @return boolean
	 */
	public function hasChangedProperties()
	{
		if (count($this->_properties)) {
			return true;
		} else {
			return false;
		}	
	}	
	
	/**
	 * Returns an array of the field changes.
	 * 
	 * @return array
	 */
	public function getFields()
	{
		return $this->_fields;
	}
	
	/**
	 * Sets a property change.
	 * 
	 * @param string $property
	 * @param misc $value
	 */
	public function setPropertyValue($property, $value)
	{
		$this->_properties[$property] = $value;
	}
	
	/**
	 * Retrieves a property value.
	 * 
	 * @param string $property
	 * @return misc
	 */
	public function getPropertyValue($property)
	{
		if (isset($this->_properties[$property])) {
			return $this->_properties[$property];
		} else {
			return null;
		}
	}
	
	/**
	 * Checks if a property value has been changed. Returns true if 
	 * a change has been made, otherwise false.
	 * 
	 * @param string $property
	 * @return boolean
	 */
	public function isPropertyModified($property)
	{
		if (isset($this->_properties[$property])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Returns all property changes. Returns an empty array when no
	 * properties have been changed.
	 * 
	 * @return array
	 */
	public function getProperties()
	{
		return $this->_properties;
	}
}