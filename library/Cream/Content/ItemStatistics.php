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
 * Represents a statistics of the content item.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemStatistics extends Cream_ApplicationComponent
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
	 * @return Cream_Content_ItemStatistics
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
	 * Returns the creation date and time of the item.
	 * 
	 * @return Cream_Date
	 */
	public function getCreated()
	{
		return $this->item->get(Cream_Application_FieldIds::created)->getDateTime();
	}
	
	/**
	 * Returns the original name of the user which created the item.
	 * 
	 * @return string
	 */
	public function getCreatedBy()
	{
		return $this->item->get(Cream_Application_FieldIds::createdBy)->getValue();		
	}
	
	/**
	 * Returns the date and time of the last update for this item.
	 * 
	 * @return Cream_Date
	 */
	public function getUpdated()
	{
		return $this->item->get(Cream_Application_FieldIds::updated)->getDateTime();		
	}
	
	/**
	 * Returns the name of the user which has last updated this item.
	 * 
	 * @return string
	 */
	public function getUpdatedBy()
	{
		return $this->item->get(Cream_Application_FieldIds::updatedBy)->getValue();		
	}
	
	/**
	 * Updated the statistics
	 * 
	 * @return void
	 */
	public function updateStatistics()
	{
		$username = $this->_getApplication()->getUser()->getAdministratorProfile()->getTitle();
		$dateTime = time();
		
		if (!$this->item->get(Cream_Application_FieldIds::createdBy)->getValue()) {
			$this->item->get(Cream_Application_FieldIds::created)->setValue($dateTime);
			$this->item->get(Cream_Application_FieldIds::createdBy)->setValue($username);
		}
		
		$this->item->get(Cream_Application_FieldIds::updated)->setValue($dateTime);
		$this->item->get(Cream_Application_FieldIds::updatedBy)->setValue($username);
	}
}