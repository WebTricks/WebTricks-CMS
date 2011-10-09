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
 * Represents an item definition. 
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_ItemDefinition
{
	/**
	 * Uniquide identifier for the item
	 * 
	 * @var string
	 */
	protected $itemId;
	
	/**
	 * View id of the item
	 * 
	 * @var string
	 */
	protected $templateId;
	
	/**
	 * Parent id of the item
	 * 
	 * @var string
	 */
	protected $parentId;
	
	/**
	 * Name of the item
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * Create a new instance of this object
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Guid $templateId
	 * @param Cream_Guid $parentId
	 * @param string $name
	 * @return Cream_Content_ItemDefinition
	 */
	public static function instance(Cream_Guid $itemId, Cream_Guid $templateId, Cream_Guid $parentId, $name)
	{
		return Cream::instance(__CLASS__, $itemId, $templateId, $parentId, $name);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Guid $templateId
	 * @param Cream_Guid $parentId
	 * @param string $name
	 * @return void
	 */
	public function __init(Cream_Guid $itemId, Cream_Guid $templateId, Cream_Guid $parentId, $name)
	{
		$this->itemId = $itemId;
		$this->templateId = $templateId;
		$this->parentId = $parentId;
		$this->name = $name;
	}
	
	/**
	 * Returns the unique identifier of the content item
	 * 
	 * @return Cream_Guid
	 */
	public function getItemId()
	{
		return $this->itemId;
	}
	
	/**
	 * Returns the template identifier
	 * 
	 * @return Cream_Guid
	 */
	public function getTemplateId()
	{
		return $this->templateId;
	}
	
	/**
	 * Returns the parent id
	 * 
	 * @return Cream_Guid
	 */
	public function getParentId()
	{
		return $this->parentId;
	}
	
	/**
	 * Returns the name of the content item.
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
}