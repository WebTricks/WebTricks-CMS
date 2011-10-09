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
 * Link validation results
 * 
 * @package		Cream_Content
 * @author 		Danny Verkade
 */
class Cream_Content_Links_LinkValidationResult
{
	/**
	 * Array containing the item links
	 * 
	 * @var array
	 */
	protected $links = array();
	
	/**
	 * Item field
	 * 
	 * @var Cream_Content_Fields_Abstract
	 */
	protected $field;
	
	/**
	 * Item link state
	 * 
	 * @var integer
	 */
	protected $itemLinkState;
	
	/**
	 * Create an instance of this class
	 * 
	 * @param Cream_Content_Fields_Abstract $field
	 * @param integer $itemLinkState
	 * @return Cream_Content_Links_LinksValidationResult
	 */
	public static function instance(Cream_Content_Fields_Abstract $field, $itemLinkState)
	{
		Cream::instance(__CLASS__, $field, $itemLinkState);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Fields_Abstract $field
	 * @param integer $itemLinkState
	 * @return void
	 */
	public function __init(Cream_Content_Fields_Abstract $field, $itemLinkState)
	{
		$this->field = $field;
		$this->itemLinkState = $itemLinkState;
	}
	
	/**
	 * Adds a broken link
	 * 
	 * @return Cream_Content_Links_ItemLink
	 */
	public function addBrokenLink()
	{
		if ($this->itemLinkState == Cream_Content_Links_ItemLinkState::VALID) {
			return null;
		} else {
			$itemLink = Cream_Content_Links_ItemLink::instance($this->field->getItem()->getRepository()->getName(), $this->field->getItem()->getItemId(), $this->field->getId(), '', Cream_Guid::emptyGuid());
			$this->links[] = $itemLink;
			return $itemLink;
		}
	}
	
	/**
	 * Adds a valid link.
	 * 
	 * @param Cream_Content_Item $targetItem
	 * @return Cream_Content_Links_ItemLink
	 */
	public function addValidLink(Cream_Content_Item $targetItem)
	{
		if ($this->itemLinkState == Cream_Content_Links_ItemLinkState::BROKEN) {
			return null;
		} else {
			$itemLink = Cream_Content_Links_ItemLink::instance($this->field->getItem()->getRepository()->getName(), $this->field->getItem()->getItemId(), $this->field->getId(), $targetItem->getRepository()->getName(), $targetItem->getItemId());
			$this->links[] = $itemLink;
			return $itemLink;
		}	
	}
	
	/**
	 * Returns all the link items.
	 * 
	 * @return array
	 */
	public function getLinks()
	{
		return $this->links;
	}
	
	/**
	 * Determines if there are any link present. Returns true if there are 
	 * links, otherwise false.
	 * 
	 * @return boolean
	 */
	public function hasLinks()
	{
		if (count($this->links)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns the number of links.
	 *  
	 * @return integer
	 */
	public function getLinkCount()
	{
		return count($this->links);
	}
}