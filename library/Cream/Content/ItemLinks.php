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
 * Represents the links of an item.
 * 
 * @package		Cream_Content
 * @author 		Danny Verkade
 */
class Cream_Content_ItemLinks extends Cream_ApplicationComponent
{
	/**
	 * The content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $item;
	
	/**
	 * Create an instance of this class
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemLinks
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
		$this->item = $item;
	}
	
	/**
	 * Retrieves all the links (broken and valid) of an item.
	 * 
	 * @param boolean $allVersions
	 * @return array
	 */
	public function getAllLinks($allVersions = false)
	{
		return $this->getLinks(Cream_Content_Links_ItemLinkState::ANY, $allVersions);
	}
	
	/**
	 * Retrieves all the broken links of the item
	 * 
	 * @param boolean $allVersions
	 * @return array
	 */
	public function getBrokenLinks($allVersions = false)
	{
		return $this->getLinks(Cream_Content_Links_ItemLinkState::BROKEN, $allVersions);
	}
	
	/**
	 * Retrieves all the valid links of the item
	 * 
	 * @param boolean $allVersions
	 * @return array
	 */
	public function getValidLinks($allVersions = false)
	{
		return $this->getLinks(Cream_Content_Links_ItemLinkState::VALID, $allVersions);
	}
	
	/**
	 * Retrieves the links
	 * 
	 * @param integer $itemLinkState
	 * @param boolean $allVersions
	 * @return array
	 */
	protected function getLinks($itemLinkState, $allVersions)
	{
		$links = array();
		
		if ($allVersions) {
			$versions = $this->item->getVersions()->getVersions(true);
		} else {
			$versions = array($this->item);
		}
		
		foreach($versions as $version) {
			foreach($version->getFields() as $field) {
				foreach($field->validateLinks($itemLinkState)->getFields() as $link) {
					$links[] = $link;
				}
			}
		}
		
		return $links;
	}
}