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
 * Represents the lock field
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Fields_LockField extends Cream_Content_Fields_XmlField
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @param string $fieldName
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Fields_LockField
	 */
	public static function instance($fieldName, $item)
	{
		return Cream::instance(__CLASS__, $fieldName, $item);
	}
			
	/**
	 * Sets the lock
	 * 
	 * @return unknown_type
	 */
	public function acquireLock()
	{
		$username = $this->_getApplication()->getUser()->getAdministratorProfile()->getTitle();
		$this->setAttribute('owner', $username);
		$this->setAttribute('date', date());
		
		$this->setValue($this->xml);
		$this->getItem()->save();
	}
	
	/**
	 * Release the lock
	 * 
	 * @return unknown_type
	 */
	public function releaseLock()
	{
		$this->removeAttribute('owner');
		$this->removeAttribute('date');
		
		$this->setValue($this->xml);
		$this->getItem()->save();
	}
	
	/**
	 * Returns the username of the user who has locked this item. If no lock is
	 * present returns null
	 * 
	 * @return string
	 */
	public function getOwner()
	{
		return $this->getAttribute('owner');
	}
	
	/**
	 * Returns the date when the lock was set. If no lock is set returns null.
	 * 
	 * @return unknown_type
	 */
	public function getDate()
	{
		return $this->getAttribute('date');
	}
}