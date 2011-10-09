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
 * Defines the basic functionality for field types where the value of the field
 * is an XML document.
 * 
 * @package		Cream_Content_Fields
 * @author 		Danny Verkade
 */
class Cream_Content_Fields_XmlField extends Cream_Content_Fields_CustomField
{
	/**
	 * Contains the XML Document
	 * 
	 * @var unknown_type
	 */
	protected $xml;
	
	/**
	 * Initialize function
	 * 
	 * @param string $fieldName
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public function __init($fieldName, $item)
	{
		parent::__init($fieldName, $item);
		
		//$this->xml = new XmlDocument($this->getValue());
		//$this->xml = simplexml_load_string($this->getValue());
	}
	
	/**
	 * Removes an attribute from the XML document
	 * 
	 * @param $attribute
	 * @return unknown_type
	 */
	protected function removeAttribute($attribute)
	{
		
	}
	
	/**
	 * Retrieves an attribute from the XML document
	 * 
	 * @param $atrribute
	 * @return unknown_type
	 */
	protected function getAttribute($atrribute)
	{
		
	}
	
	/**
	 * Sets an attribute in the XML document
	 * 
	 * @param $attribute
	 * @param $value
	 * @return unknown_type
	 */
	protected function setAttribute($attribute, $value)
	{
		
	}	
}