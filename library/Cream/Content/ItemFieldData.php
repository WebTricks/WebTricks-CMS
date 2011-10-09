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
 * Represents the data of an content item as an array. The key of the
 * array is the id of the field. The value of the array is the value
 * of the field.
 * 
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemFieldData implements ArrayAccess 
{
	/**
	 * Array of fields, the key in the array is the field name, the
	 * array value is the value of the field.
	 * 
	 * @var array
	 */
	protected $fields = array();
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Content_FieldList
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Add a field to the field list
	 * 
	 * @param Cream_Guid $fieldId
	 * @param mixed $value
	 * @return void
	 */
	public function add(Cream_Guid $fieldId, $value)
	{
		$this->fields[$fieldId->toString()] = $value;
	}
	
	/**
	 * Returns an array containing al the field names.
	 * 
	 * @return array
	 */
	public function getFieldNames()
	{
		return array_keys($this->fields);
	}
	
	/**
	 * Returns whether there is an item at the specified offset.
	 * This method is required by the interface ArrayAccess.
	 * 
	 * @param integer the offset to check on
	 * @return boolean
	 */
	public function offsetExists($offset)
	{
		return isset($this->fields[$offset]);
	}

	/**
	 * Returns the item at the specified offset.
	 * This method is required by the interface ArrayAccess.
	 * 
	 * @param integer the offset to retrieve item
	 * @return mixed the item at the offset
	 * @throws TInvalidDataValueException if the offset is invalid
	 */
	public function offsetGet($offset)
	{
		if ($this->offsetExists($offset)) {
			return $this->fields[$offset];
		} else {
			return null;
		}
	}

	/**
	 * Sets the item at the specified offset.
	 * This method is required by the interface ArrayAccess.
	 * 
	 * @param integer the offset to set item
	 * @param mixed the item value
	 */
	public function offsetSet($offset, $value)
	{
		$this->fields[$offset] = $value;
	}

	/**
	 * Unsets the item at the specified offset.
	 * This method is required by the interface ArrayAccess.
	 * 
	 * @param integer the offset to unset item
	 */
	public function offsetUnset($offset)
	{
		unset($this->fields[$offset]);
	}	
}