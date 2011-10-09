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
 * Gives access to the fields of the content item.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_FieldCollection
{
	/**
	 * Reference to the content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $_item;
	
	/**
	 * Array holding item fields.
	 * 
	 * @var array
	 */
	protected $_fields;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_FieldCollection
	 */
	public static function instance(Cream_Content_Item $item)
	{
		return Cream::instance(__CLASS__, $item);
	}
	
	/**
	 * Initialize function 
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public function __init(Cream_Content_Item $item)
	{
		$this->_item = $item;
	}
	
	/**
	 * Returns the field object of the given field name. Throws an 
	 * exception when the field name is not found.
	 * 
	 * @param string $fieldName
	 * @return Cream_Content_Fields_Field
	 */
	public function getField($fieldName)
	{
		if ($fieldName instanceof Cream_Guid) {
			return Cream_Content_Fields_Field::instance($fieldName, $this->_item);
		} else {
			$templateField = $this->_item->getTemplate()->getFieldByName($fieldName);

			if ($templateField) {
				return Cream_Content_Fields_Field::instance($templateField->getId(), $this->_item);
			} else { 
				return null;
			}
		}
		
		//if ($fieldName instanceof Cream_Guid) {
		//	return Cream_Content_Fields_FieldTypeManager::getField($fieldName, $this->_item);
		//} else {
		//	$templateField = $this->_item->getTemplate()->getFieldByName($fieldName);
		//	
		//	if ($templateField) {
		//		return Cream_Content_Fields_FieldTypeManager::getField($templateField->getId(), $this->_item);
		//	} else {
		//		return null;
		//	}
		//}		

		
	}
	
	/**
	 * Check to see if a field exists. Returns true if it exists in the
	 * template, otherwise false.
	 * 
	 * @param Cream_Guid $fieldId
	 * @return boolean
	 */
	public function exists(Cream_Guid $fieldId) 
	{
		$templateField = Cream_Content_Managers_TemplateProvider::getTemplateField($fieldId, $this->_item);
		
		if ($templateField !== null) {
			return true;
		} else { 
			return false;
		}
	}

	/**
	 * Returns all the fields of this item
	 * 
	 * @return array
	 */
	public function getFields()
	{
		if (!$this->_fields) {
			$this->_fields = array();
		
			foreach($this->_item->getItemData()->getFieldList() as $fieldId => $value) {
				$this->_fields[] = $this->getField($fieldId);
			}
		}
		
		return $this->_fields;
	}
	
	/**
	 * Returns the number of fields for this item
	 * 
	 * @return integer
	 */
	public function getCount()
	{
		return count($this->getFields());
	}
	
	/**
	 * Reads all item fields from the template.
	 *  
	 */
	public function readAll()
	{
		$this->_fields = array();
		$template = $this->_item->getTemplate();
		
		foreach ($template->getFields() as $field) {
			$this->_fields[] = $this->getField($field->getId());
		}
	}

	/**
	 * Resets the fields.
	 * 
	 */
	public function reset()
	{
		$this->_fields = null;
	}
}