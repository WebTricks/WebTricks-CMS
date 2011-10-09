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
 * Sort items
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Sorting_ItemSorting extends Cream_ApplicationComponent
{
	/**
	 * The content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $item;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemSorting
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
		
	public function moveDown()
	{
		
	}
	
	public function moveUp()
	{
		
	}
	
	public function moveToFirst()
	{
		
	}
	
	public function moveToLast()
	{
		
	}
	
	/**
	 * Sort the children items of this item by the display name.
	 * 
	 * @return void
	 */
	public function sortChildrenByDisplayName()
	{
		$this->sort(Cream_Content_Sorting_DisplayNameComparer::instance());
	}
	
	/**
	 * Sort the children items of this item by the date it was last
	 * updated.
	 * 
	 * @return void
	 */
	public function sortChildrenByUpdate()
	{
		$this->sort(Cream_Content_Sorting_UpdatedComparer::instance());		
	}
	
	/**
	 * Sort the children of this item.
	 * 
	 * @param Cream_Collections_Compare_Interface $comparer
	 * @return void
	 */
	public function sortChildren(Cream_Collections_Compare_Interface $comparer)
	{
		
	}
	
	/**
	 * Reverse the order of the child items of this item.
	 * 
	 * @return void
	 */
	public function sortChildrenReverse()
	{
		
	}
	
	/**
	 * Updates the sort order of the child items of this item
	 * 
	 * @return void
	 */
	protected function updateSortOrder()
	{
		$sortOrder = 0;
		foreach($this->item->getChildren() as $child) {
			$child->getAppearance()->setSortOrder($sortOrder);
			$child->save();
			
			$sortOrder++;
		}
	} 
}