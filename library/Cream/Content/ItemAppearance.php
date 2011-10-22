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
 * The appareance of the item
 * 
 * @package		Cream_Content
 * @author 		Danny Verkade
 */
class Cream_Content_ItemAppearance extends Cream_ApplicationComponent
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
	 * @return Cream_Content_ItemAppearance
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

	public function getDisplayName()
	{
		return $this->item->getName();
	}
	
	/**
	 * Returns the sort order of the item.
	 * 
	 * @return integer
	 */
	public function getSortOrder()
	{
		$field = $this->item->getFields()->getField(Cream_Application_FieldIds::getSortOrderId());
		return $field->getValue();
	}
	
	/**
	 * Sets the sort order of the item
	 * 
	 * @param integer $sortOrder
	 * @return void
	 */
	public function setSortOrder($sortOrder)
	{
		$field = $this->item->getFields()->getField(Cream_Application_FieldIds::getSortOrderId());
		$field->setValue($sortOrder);
	}
	
	/**
	 * Returns the name of the icon to be used for the item.
	 * 
	 * @return string
	 */
	public function getIcon()
	{
		$field = $this->item->getFields()->getField(Cream_Application_FieldIds::getIconId());
		
		if ($field && $field->getValue()) {
			return $field->getValue();
		}
		
		//$this->item->getTemplate()->getIcon();
	}
	
	/**
	 * Returns true if the item is hidden, otherwise false.
	 * 
	 * @return boolean
	 */
	public function isHidden()
	{
		$field = $this->item->getFields()->getField(Cream_Application_FieldIds::getHidden());
		return $field->getValue();
	}
	
	/**
	 * Set if the item is hidden. 
	 *  
	 * @param boolean $hidden
	 * @return void
	 */
	public function setHidden($hidden)
	{
		$field = $this->item->getFields()->getField(Cream_Application_FieldIds::getHidden());
		$field->setValue($hidden);
	}
	
	/**
	 * Returns true if the item is read only, otherwise false.
	 * 
	 * @return boolean
	 */
	public function isReadOnly()
	{
		$field = $this->item->getFields()->getField(Cream_Application_FieldIds::getReadOnly());
		return $field->getValue();
	}
	
	/**
	 * Set if the item is read only.
	 * 
	 * @param boolean $readOnly
	 * @return void
	 */
	public function setReadOnly($readOnly)
	{
		$field = $this->item->getFields()->getField(Cream_Application_FieldIds::getReadOnly());
		$field->setValue($readOnly);
	}
}