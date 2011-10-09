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
 * Represents a checkbox field
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Fields_CheckboxField extends Cream_Content_Fields_CustomField
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Guid $fieldId
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Field
	 */
	public static function instance(Cream_Guid $fieldId, Cream_Content_Item $item)
	{
		Cream::instance(__CLASS__, $fieldId, $item);
	}
	
	/**
	 * Indicated whether this checkbox field is checked or not. Returns
	 * true of it is checked, otherwise false.
	 * 
	 * @return boolean
	 */
	public function isChecked()
	{
		if ($this->getValue()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Sets if the checkbox is checked or not. True if it is checked, otherwise
	 * false.
	 * 
	 * @param boolean $value
	 * @return void
	 */
	public function setChecked($value)
	{
		$this->setValue($value);
	}
}