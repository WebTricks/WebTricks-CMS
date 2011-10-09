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
 * Represents the path of the item.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemPath extends Cream_ApplicationComponent
{
	/**
	 * The content item for this state object
	 * 
	 * @var Cream_Content_Item
	 */
	protected $item;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_ItemPath
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
	 * Returns the path of the item
	 * 
	 * @return string
	 */
	public function getPath()
	{
		$path = "/". $this->item->getName();
		$item = $this->item;
		
		while($item->getParentId() != Cream_Guid::emptyGuid()) {
			$path = "/". $item->getParent()->getName() . $path;
			
			$item = $item->getParent();
		}
		
		return $path;
	}

	/**
	 * Checks if the item is a content item.
	 * 
	 *  @return boolean
	 */
	public function isContentItem()
	{
		$contentPath = 'webtricks/content';
		$path = $this->getPath();
		
		if (substr($path, 0, strlen($contentPath)) == $contentPath) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Checks if the item is a media item.
	 * 
	 * @return boolean
	 */
	public function isMediaItem()
	{
		$mediaPath = 'webtricks/media library';
		$path = $this->getPath();
		
		if (substr($path, 0, strlen($mediaPath)) == $mediaPath) {
			return true;
		} else {
			return false;
		}
	}
}