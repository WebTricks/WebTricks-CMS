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
 * Represents a link between to items
 * 
 * @package		Cream_Content
 * @author 		Danny Verkade
 */
class Cream_Content_Links_ItemLink
{
	/**
	 * The name of the source repository
	 * 
	 * @var string
	 */
	protected $sourceRepositoryName;
	
	/**
	 * The ID of the source item
	 * 
	 * @var Cream_Guid
	 */
	protected $sourceItemId;
	
	/**
	 * The source content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $sourceItem;
	
	/**
	 * The field id of the source
	 * 
	 * @var Cream_Guid
	 */
	protected $sourceFieldId;
	
	/**
	 * The name of the target repository
	 * 
	 * @var string
	 */
	protected $targetRepositoryName;
	
	/**
	 * The ID of the target item
	 * 
	 * @var Cream_Guid
	 */
	protected $targetItemId;
	
	/**
	 * The target content item
	 * 
	 * @var Cream_Content_Item
	 */
	protected $targetItem;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param string $sourceRepositoryName
	 * @param Cream_Guid $sourceItemId
	 * @param Cream_Guid $sourceFieldId
	 * @param string $targetRepositoryName
	 * @param Cream_Guid $targetItemId
	 * @return Cream_Content_Links_ItemLink
	 */
	public static function instance($sourceRepositoryName, Cream_Guid $sourceItemId, Cream_Guid $sourceFieldId, $targetRepositoryName, Cream_Guid $targetItemId)
	{
		Cream::instance(__CLASS__, $sourceRepositoryName, $sourceItemId, $sourceFieldId, $targetRepositoryName, $targetItemId);
	}

	/**
	 * Initialize function
	 * 
	 * @param string $sourceRepositoryName
	 * @param Cream_Guid $sourceItemId
	 * @param Cream_Guid $sourceFieldId
	 * @param string $targetRepositoryName
	 * @param Cream_Guid $targetItemId
	 * @return void
	 */
	public function __init($sourceRepositoryName, Cream_Guid $sourceItemId, Cream_Guid $sourceFieldId, $targetRepositoryName, Cream_Guid $targetItemId)
	{
		$this->sourceRepositoryName = $sourceRepositoryName;
		$this->sourceItemId = $sourceItemId;
		$this->sourceFieldId = $sourceFieldId;
		$this->targetRepositoryName = $targetRepositoryName;
		$this->targetItemId = $targetItemId;
	}
	
	public function getTargetItem()
	{
		if (!$this->targetItem) {
			
		}	
		
		return $this->targetItem;
	}
	
	public function getSourceItem()
	{
		if (!$this->sourceItem) {
			
		}	
		
		return $this->sourceItem;
	}
	
	/**
	 * Returns the name of the source repository.
	 * 
	 * @return string
	 */
	public function getSourceRepositoryName()
	{
		return $this->sourceRepositoryName;
	}
	
	/**
	 * Returns the source item ID.
	 * 
	 * @return Cream_Guid
	 */
	public function getSourceItemId()
	{
		return $this->sourceItemId;	
	}
	
	/**
	 * Returns the source field ID.
	 * 
	 * @return Cream_Guid
	 */
	public function getSourceFieldId()
	{
		return $this->sourceFieldId;
	}
	
	/**
	 * Return the name of the target repository
	 * 
	 * @return string
	 */
	public function getTargetRepositoryName()
	{
		return $this->targetRepositoryName;
	}
	
	/**
	 * Returns the target item ID.
	 * 
	 * @return Cream_Guid
	 */
	public function getTargetItemId()
	{
		return $this->targetItemId;
	}
}