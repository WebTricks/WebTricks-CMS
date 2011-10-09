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
 * Field where values are delimited by a delimiter.
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Fields_DelimitedField extends Cream_Content_Fields_Field
{
	/**
	 * The character to seperate the items
	 * 
	 * @var string
	 */
	protected $seperator = ",";
	
	/**
	 * Array holding the different values
	 * 
	 * @var array
	 */
	protected $items = array();
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Guid $fieldId
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Fields_MultilistField
	 */
	public static function instance(Cream_Guid $fieldId, $item)
	{
		return Cream::instance(__CLASS__, $fieldId, $item);
	}	
	
	/**
	 * Gets the value as a string
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return $this->toString;
	}
	
	/**
	 * Returns the value as a string
	 * 
	 * @return string
	 */
	public function toString()
	{
		return implode($this->seperator, $this->items);		
	}
	
	/**
	 * Sets the seperator
	 * 
	 * @param string $seperator
	 * @return void
	 */
	public function setSeperator($seperator)
	{
		$this->seperator = $seperator;
	}
	
	/**
	 * Returns the character to seperate items
	 * 
	 * @return string
	 */
	public function getSeperator()
	{
		return $this->seperator;
	}
	
	/**
	 * Adds an value to the item list
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function add($value)
	{
		$this->items[] = $value;
		$this->setValue($this->toString());
	}
	
	public function remove($value)
	{

	}
	
	public function replace($oldValue, $newValue)
	{
		
	}
	
	/**
	 * Returns an array with the list items
	 * 
	 * @return string
	 */
	public function getItems()
	{
		return $this->items;
	}
}