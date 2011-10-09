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
 * Item Collection holding a collection of content item objects.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemCollection extends Cream_Collection_Iterator
{
	const defaultComparer = 'Cream_Content_Sorting_SortOrderComparer';
	
	/**
	 * Create a new instance of this class
	 *
	 * @param array $data
	 * @return Cream_Content_ItemCollection
	 */
	public static function instance($data = null)
	{
		return Cream::instance(__CLASS__, $data);
	}
	
	/**
	 * Sort the item collection
	 * 
	 * @param string $comparer
	 */
	public function sort($comparer)
	{
		usort($this->_data, array($comparer, "compare"));
	}
	
	/**
	 * Returns the child by the given name. Of no matching item is 
	 * found, returns null.
	 * 
	 * @param string $name
	 * @return Cream_Content_Item
	 */
	public function getByName($name) 
	{
		$name = strtolower($name);
		
		foreach($this->_data as $item) {
			if (strtolower($item->getName()) == $name) {
				return $item;
			}
		}	
	}
	
	/**
	 * Returns the child by the given id. If no matching item is
	 * found, returns null.
	 * 
	 * @param Cream_Guid $id
	 * @return Cream_Content_Item
	 */
	public function getById(Cream_Guid $id)
	{
		$id = (string) $id;
		
		foreach($this->_data as $item) {
			if ((string) $item->getItemId() == $id) {
				return $item;
			}
		}			
	}
}