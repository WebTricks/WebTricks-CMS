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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Item sorting class to sort items.
 *
 * @package		Cream_Content
 * @author		WebTicks Core Team <core@webtricksframework.com>
 */
class Cream_Content_ItemSorting extends Cream_ApplicationComponent
{
	/**
	 * The content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $_item;
	
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
		$this->_item = $item;		
	}
		
	/**
	 * Moves an item down in the content tree.
	 * 
	 * @return void
	 */
	public function moveDown()
	{
		$parent = $this->_item->getParent();
		
		if ($parent) {
			
			$children = $parent->getChildren();
			$count = count($children);
			
			for($i = 0; $i <= $count-1; $i++) {

				$childItem = $children->get($i);
				
				if ($childItem->getItemId() == $this->_item->getItemId()) {
					
					$childItem = $children->get($i+1);
					$childItemSortOrder = $this->_getSortOrder($this->_item);
					$itemSortOrder = $this->_getSortOrder($childItem);
					
					$this->_setSortOrder($this->_item, $itemSortOrder);
					$this->_setSortOrder($childItem, $childItemSortOrder);	
				}
			}		
		}
	}
	
	/**
	 * Moves an item up in the content tree.
	 * 
	 * @return void
	 */
	public function moveUp()
	{
		$parent = $this->_item->getParent();
		
		if ($parent) {
			
			$children = $parent->getChildren();
			$count = count($children);
			
			for($i = 0; $i <= $count-1; $i++) {

				$childItem = $children->get($i);
				
				if ($childItem->getItemId() == $this->_item->getItemId()) {
					
					$childItem = $children->get($i-1);
					$childItemSortOrder = $this->_getSortOrder($this->_item);
					$itemSortOrder = $this->_getSortOrder($childItem);
					
					$this->_setSortOrder($this->_item, $itemSortOrder);
					$this->_setSortOrder($childItem, $childItemSortOrder);	
				}
			}		
		}						
	}
	
	/**
	 * Moves an item to the top of the content tree.
	 * 
	 * @return void
	 */
	public function moveToFirst()
	{
		$parent = $this->_item->getParent();
		
		if ($parent) {
			
			$children = $parent->getChildren();
			$count = count($children);
			
			for($i = 0; $i <= $count-1; $i++) {

				$childItem = $children->get($i);
				
				if ($childItem->getItemId() == $this->_item->getItemId()) {
					
					$newSortOrder = $this->_getSortOrder($this->_item);
					
					for($j = ($i-1); $j = 0; $j--) {
						
						$childItem = $children->get($j);
						$lastSortOrder = $this->_getSortOrder($childItem);
						$this->_setSortOrder($childItem, $newSortOrder);
						$newSortOrder = $lastSortOrder;
					}
					
					$this->_setSortOrder($this->_item, $newSortOrder);
						
				}
			}		
		}				
	}
	
	/**
	 * Moves an item to the bottom of the content tree.
	 * 
	 * @return void
	 */
	public function moveToLast()
	{
		$parent = $this->_item->getParent();
		
		if ($parent) {
			
			$children = $parent->getChildren();
			$count = count($children);
			
			for($i = 0; $i <= $count-1; $i++) {

				$childItem = $children->get($i);
				
				if ($childItem->getItemId() == $this->_item->getItemId()) {
					
					$newSortOrder = $this->_getSortOrder($this->_item);
					
					for($j = ($i+1); $j <= $count-1; $j++) {
						
						$childItem = $children->get($j);
						$lastSortOrder = $this->_getSortOrder($childItem);
						$this->_setSortOrder($childItem, $newSortOrder);
						$newSortOrder = $lastSortOrder;
					}
					
					$this->_setSortOrder($this->_item, $newSortOrder);
						
				}
			}		
		}			
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
		$children = $this->_item->getChildren();
		$children->sort($comparer);
		$this->_updateSortOrder($children);		
	}
	
	/**
	 * Reverse the order of the child items of this item.
	 * 
	 * @return void
	 */
	public function sortChildrenReverse()
	{
		$children = $this->_item->getChildren();
		$children->reverse();
		$this->_updateSortOrder($children);
	}
	
	/**
	 * Updates the sort order of a collection of items.
	 * 
	 * @param Cream_Content_ItemCollection $children 
	 */	
	protected function _updateSortOrder(Cream_Content_ItemCollection $children)
	{
		$count = count($children);
		
		for($i = 0; $i <= $count-1; $i++) {
			$item = $children->get($i);
			$this->_setSortOrder($item, $i);	
		}
	}
	
	/**
	 * Retrieves the sort order of the specified item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return integer
	 */
	protected function _getSortOrder(Cream_Content_Item $item)
	{
		$field = $item->get(Cream_Application_FieldIds::getSortOrderId());
		
		if ($field) {
			return $field->getValue();
		}
	}
	
	/**
	 * Sets the sort order.
	 * 
	 * @param Cream_Content_Item $item
	 * @param integer $sortOrder
	 * @return void
	 */
	protected function _setSortOrder(Cream_Content_Item $item, $sortOrder)
	{
		if ($item->getAccess()->canWrite() && !$item->getAppearance()->isReadOnly()) {
			$field = $item->get(Cream_Application_FieldIds::getSortOrderId());
			
			if ($field) {
				$item->getEditing()->startEdit();
				$field->setValue($sortOrder);
				$item->getEditing()->endEdit();
			}
		}
	}	
}