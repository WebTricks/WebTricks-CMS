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
 * Represents a field linked to another content item.
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Fields_LinkField extends Cream_Content_Fields_Field
{
	/**
	 * Validates the links
	 * 
	 * @param Cream_Content_Links_LinkValidationResult $result
	 */
	public function validateLinks(Cream_Content_Links_LinkValidationResult &$result)
	{	
	}
	
	/**
	 * Relinks the specified item
	 * 
	 * @param Cream_Content_Links_ItemLink $itemLink
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public function relink(Cream_Content_Links_ItemLink $itemLink, Cream_Content_Item $item)
	{	
	}	
	
	/**
	 * Is triggered when an item is removed.
	 * 
	 * @param Cream_Content_Links_ItemLink $itemLink
	 * @return void
	 */
	public function removeLink(Cream_Content_Links_ItemLink $itemLink)
	{	
	}
	
	/**
	 * Is triggered when an item is moved in the content tree
	 * 
	 * @param Cream_Content_Links_ItemLink $itemLink
	 * @return void
	 */
	public function updateLink(Cream_Content_Links_ItemLink $itemLink)
	{	
	}	
}