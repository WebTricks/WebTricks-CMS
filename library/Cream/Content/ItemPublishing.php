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
 * Retrieves information about the publishing of a source item. 
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemPublishing 
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
	 * @param Cream_ContentItem $content
	 * @return Cream_Content_Publishing
	 */
	public static function instance(Cream_Content_Item $item)
	{
		return Cream::instance(__CLASS__, $item);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Item $content
	 * @return void
	 */
	public function __init(Cream_Content_Item $item)
	{
		$this->item = $item;
	}
	
	/**
	 * Gets the valid version on a specific date. 
	 * 
	 * @param Cream_Date $date
	 * @param boolean $requireApproved
	 * @return Cream_Content
	 */
	public function getValidVersion(Cream_Date $date, $requireApproved)
	{
		$versions = $this->item->getVersions()->getAllVersions();

		for ($i = ($versions->getCount() - 1); $i >= 0; $i--) {
			if ($versions[$i]->getPublishing()->isValid($date, $requireApproved)) {
				return $versions[$i];
			}
		}
		
		return null;
	}
	
	/**
	 * Determines whether the item is published on a specified date. 
	 * 
	 * @param Cream_Date $date
	 * @param boolean $requireApproved
	 * @return boolean
	 */
	public function isPublished(Cream_Date $date, $requireApproved)
	{
	    if (!$this->InValidRange($date)) {
	        return false;
	    }
	    if ($requireApproved && !$this->IsApproved()) {
	        return false;
	    }
	    return true;
	}
	
	/**
	 * Returns the publish date of the entire item.
	 * 
	 * @return date
	 */
	public function getPublishDate()
	{
		return $this->item->get(Cream_Application_FieldIds::publishDate);
	}
	
	/**
	 * Sets the publish date of the entire item.
	 * 
	 * @param Cream_Date $date
	 * @return void
	 */
	public function setPublishDate(Cream_Date $date)
	{
		$this->item->set(Cream_Application_FieldIds::publishDate, $date);		
	}
	
	/**
	 * Returns the unpublish date of the entire item.
	 * 
	 * @return date
	 */
	public function getUnpublishDate()
	{
		return $this->item->get(Cream_Application_FieldIds::unpublishDate);
	}
	
	/**
	 * Sets the unpublish date of the entire item.
	 * 
	 * @param Cream_Date $date
	 * @return void
	 */
	public function setUnpublishDate(Cream_Date $date)
	{
		$this->item->set(Cream_Application_FieldIds::unpublishDate, $date);
	}
	
	/**
	 * Check to see if the given date is within the published range.
	 * 
	 * @param Cream_Date $date
	 * @return boolean
	 */
	protected function inValidRange(Cream_Date $date)
	{
		return (($date >= $this->getPublishDate()) && ($date < $this->getUnpublishDate()));
	}
	
	/**
	 * Determines whether this instance is approved i.e. published. 
	 * 
	 * @return boolean
	 */
	protected function isApproved()
	{
		if ($this->item->getState()->getWorkflowState()) {
			return $this->item->getState()->getWorkflowState()->isFinal();
		} else {
			// No workflow attached, so item is published.
			return true;
		}
	}
}