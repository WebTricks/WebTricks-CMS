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
 * Represents a HTML field
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Fields_HtmlField extends Cream_Content_Fields_CustomField
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @param string $fieldName
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Fields_HtmlField
	 */
	public static function instance($fieldName, $item)
	{
		return Cream::instance(__CLASS__, $fieldName, $item);
	}	
	
	public function validateLinks(Cream_Content_Links_LinkValidationResult &$result)
	{
		//$this->addTextLinks($result, $document);
		//$this->addMediaLinks($result, $document);
	}
	
	public function removeLink(Cream_Content_Links_ItemLink $itemLink)
	{
		
	}
	
	public function relink(Cream_Content_Links_ItemLink $itemLink)
	{
		
	}
		
	protected function addTextLinks(Cream_Content_Links_LinkValidationResult &$result, $document)
	{
		//foreach($nodes as $node) {
		//	$this->addTextLink($result, $node);
		//}
	}
	
	protected function addMediaLinks(Cream_Content_Links_LinkValidationResult &$result, $document)
	{
		//foreach($nodes as $node) {
		//	$this->addMediaLink($result, $node);
		//}
	}	
	
	protected function addTextLink(Cream_Content_Links_LinkValidationResult &$result, $node)
	{
		
	}
	
	protected function addMediaLink(Cream_Content_Links_LinkValidationResult &$result, $node)
	{
		
	}	
	
	/**
	 * Adds the link
	 * 
	 * @param Cream_Content_Links_LinkValidationResult $result
	 * @param Cream_Content_Item $targetItem
	 */
	protected function addLink(Cream_Content_Links_LinkValidationResult &$result, $targetItem)
	{
		if ($targetItem != null) {
			$result->addValidLink($targetItem);
		} else {
			$result->addBrokenLink();
		}
	}
}