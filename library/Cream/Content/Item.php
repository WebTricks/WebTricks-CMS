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
 * Represents an item. The item is culture-specific and represents 
 * a single version.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Item extends Cream_ApplicationComponent implements Cream_Security_SecurableInterface
{
	/**
	 * The GUID of the content item
	 * 
	 * @var Cream_Guid
	 */
	protected $_itemId;

	/**
	 * The access of the item
	 * 
	 * @var Cream_Content_ItemAccess
	 */
	protected $_access;	
	
	/**
	 * The appearance of the item
	 * 
	 * @var Cream_Content_ItemAppearance
	 */
	protected $_appearance;	
	
	/**
	 * Collection of child items.
	 * 
	 * @var Cream_Content_ItemCollection
	 */
	protected $_children;
	
	/**
	 * Item editing object
	 * 
	 * @var Cream_Content_ItemEditing
	 */
	protected $_editing;
	
	/**
	 * The item data
	 * 
	 * @var Cream_Content_ItemData
	 */
	protected $_itemData;
	
	/**
	 * Reference to the object representing the changes to the 
	 * field value of the item.
	 * 
	 * @var Cream_Content_ItemChanges
	 */
	protected $_itemChanges;
	
	/**
	 * Collection of item fields
	 * 
	 * @var Cream_Content_FieldCollection
	 */
	protected $_fields;
	
	/**
	 * The item links
	 * 
	 * @var Cream_Content_ItemLinks
	 */
	protected $_links;
	
	/**
	 * Item locking
	 *  
	 * @var Cream_Content_ItemLocking
	 */
	protected $_locking;

	/**
	 * Publish information abount the item
	 * 
	 * @var Cream_Content_ItemPath
	 */
	protected $_paths;
	
	/**
	 * Publish information abount the item
	 * 
	 * @var Cream_Content_ItemPublishing
	 */
	protected $_publishing;
	
	/**
	 * The repository where this item is in
	 * 
	 * @var Cream_Content_Repository
	 */
	protected $_repository;
	
	/**
	 * Item runtime settings object
	 * 
	 * @var Cream_Content_ItemRuntimeSettings
	 */
	protected $_runtimeSettings;
	
	/**
	 * Workflow state of the item
	 * 
	 * @var Cream_Content_ItemState
	 */
	protected $_state;	
	
	/**
	 * Template item
	 * 
	 * @var Cream_Content_Template_Item
	 */
	protected $_template;
	
	/**
	 * Item versions object instance.
	 * 
	 * @var Cream_Content_ItemVersions
	 */
	protected $_versions;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_ItemData $data
	 * @param Cream_Content_Repository $repository
	 * @return Cream_Content_Item
	 */
	public static function instance(Cream_Guid $itemId, Cream_Content_ItemData $data, Cream_Content_Repository $repository)
	{
		return Cream::instance(__CLASS__, $itemId, $data, $repository);
	}
	
	/**
	 * Initialize this class
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_ItemData $data
	 * @param Cream_Content_Repository $repository
	 * @return void
	 */
	public function __init(Cream_Guid $itemId, Cream_Content_ItemData $data, Cream_Content_Repository $repository)
	{
		$this->_itemId = $itemId;
		$this->_itemData = $data;
		$this->_repository = $repository;
	}
	
	/**
	 * Returns the properties to cache
	 * 
	 * @return array
	 */
	public function __sleep()
	{
		return array(
			'_itemId', 
			'_itemData',
			'_repository'
		);
	}
	
	/**
	 * Returns the unique id of the content item
	 * 
	 * @return Cream_Guid
	 */
	public function getItemId()
	{
		return $this->_itemId;	
	}
	
	/**
	 * Returns the unique URI object of this item.
	 * 
	 * @return Cream_Content_ItemUri
	 */
	public function getItemUri()
	{
		return Cream_Content_ItemUri::instance($this);
	}

	/**
	 * Returns the content data object
	 * 
	 * @return Cream_Content_ItemData
	 */
	public function getItemData()
	{
		return $this->_itemData;		
	}	
	
	/**
	 * Gets the item appearance 
	 * 
	 * @return Cream_Content_ItemAccess
	 */
	public function getAccess()
	{
		if (!$this->_access) {
			$this->_access = Cream_Content_ItemAccess::instance($this);
		}
		
		return $this->_access;
	}	
	
	/**
	 * Gets the item appearance 
	 * 
	 * @return Cream_Content_ItemAppearance
	 */
	public function getAppearance()
	{
		if (!$this->_appearance) {
			$this->_appearance = Cream_Content_ItemAppearance::instance($this);
		}
		
		return $this->_appearance;
	}
	
	/**
	 * Gets the changes to this item
	 * 
	 * @return Cream_Content_ItemChanges
	 */
	public function getChanges()
	{
		if (!$this->_itemChanges) {
			$this->_itemChanges = Cream_Content_ItemChanges::instance($this);
		}
		
		return $this->_itemChanges;
	}
	
	/**
	 * Get the full changes of the item.
	 * 
	 *  @return Cream_Content_ItemChanges
	 */
	public function getFullChanges()
	{
		$changes = $this->getChanges();
		$fields = $this->getFields();
		$fields->readAll();

		foreach($fields->getFields() as $field) {
			$value = $field->getValue(false);			
			$changes->setFieldValue($field, $value);
    	}
    	
    	return $changes;
	}
	
	/**
	 * Reload the current content item.
	 * 
	 * @return void
	 */
	public function reload()
	{
		$itemData = Cream_Content_Managers_ItemProvider::getItemData($this->getRepository(), $this->getItemId(), $this->getCulture(), $this->getVersion());

		if ($itemData) {
			$this->_itemData = $itemData;
			$this->getFields()->reset();
		}
	}
	
	/**
	 * Cancels the changes to the item.
	 * 
	 * @return void
	 */
	public function rejectChanges()
	{
		$this->_itemChanges = null;
	}

	/**
	 * Determines if there are any children under this item 
	 * 
	 * @return boolean
	 */
	public function hasChildren()
	{
		if ($this->_children) {
			if (count($this->_children)) {
				return true;
			} else {
				return false;
			}
		} else {
			return Cream_Content_Managers_ItemProvider::hasChildren($this);
		}
	}
	
	/**
	 * Gets the collection of child items.
	 * 
	 * @return Cream_Content_ItemCollection
	 */
	public function getChildren()
	{
		if (!$this->_children) {
			$this->_children = Cream_Content_Managers_ItemProvider::getChildren($this);
		}
		
		return $this->_children;
	}

	public function getLinks()
	{
		if (!$this->_links) {
			$this->_links = Cream_Content_ItemLinks::instance($this);
		}
		
		return $this->_links; 
	}
	
	/**
	 * Returns the item locking object
	 * 
	 * @return Cream_Content_ItemLocking
	 */
	public function getLocking()
	{
		if (!$this->_locking) {
			$this->_locking = Cream_Content_ItemLocking::instance($this);
		}
		
		return $this->_locking; 
	}
	
	/**
	 * Returns the item name
	 * 
	 * @return string
	 */
	public function getName()
	{
		if ($this->getChanges()->getPropertyValue('name')) {
			return $this->getChanges()->getPropertyValue('name');
		} else {
			return $this->_itemData->getItemDefinition()->getName();
		}
	}
	
	/**
	 * Create a new item under this content item, the new item will be
	 * saved when the save function is called on the item object.
	 * 
	 * @param Cream_Guid $templateId
	 * @return Cream_Content_Item
	 */
	public function add(Cream_Guid $templateId)
	{
		return Cream_Content_Managers_ItemProvider::createItem($templateId, $this);
	}

	/**
	 * Copies the item and all it's children to another location in
	 * the content tree.
	 * 
	 * @param Cream_Content_Item $destination
	 */
	public function copyTo(Cream_Content_Item $destination)
	{
		if ($this->getAccess()->canCopyTo($destination)) {
			Cream_Content_Managers_ItemProvider::copyItem($this, $destination);
		}
	}
	
	/**
	 * Moves the item and all it's children to another location in 
	 * the tree. Returns true if the item has been moved, otherwise
	 * false.
	 * 
	 * @param Cream_Content_Item $destination
	 * @return boolean
	 */
	public function moveTo(Cream_Content_Item $destination)
	{
		if ($this->getAccess()->canMoveTo($destination)) {
			return Cream_Content_Managers_ItemProvider::moveItem($this, $destination);
		}
	}
	
	/**
	 * Returns the item editing object.
	 * 
	 * @return Cream_Content_ItemEditing
	 */
	public function getEditing()
	{
		if (!$this->_editing) {
			$this->_editing = Cream_Content_ItemEditing::instance($this);
		}
		
		return $this->_editing;
	}

	/**
	 * Returns the fields of this content item
	 * 
	 * @return Cream_Content_FieldCollection
	 */
	public function getFields()
	{
		if (!$this->_fields) {
			$this->_fields = Cream_Content_FieldCollection::instance($this);
		}
		
		return $this->_fields;
	}
	
	/**
	 * Returns the culture of this content item
	 * 
	 * @return Cream_Globalization_Culture
	 */
	public function getCulture()
	{
		return $this->getItemData()->getCulture();
	}
	
	/**
	 * Gets a list of cultures that the item has content in. 
	 * 
	 * @return Cream_Globalization_CultureCollection
	 */
	public function getCultures()
	{
		return Cream_Content_Managers_ItemProvider::getItemCultures($this);
	}
	
	/**
	 * Returns the parent content item of this item
	 * 
	 * @return Cream_Content_Item
	 */
	public function getParent()
	{
		if (!$this->getParentId()) {
			throw new Cream_Content_Exception('The content item with ID "'. $this->contentId .'" does not have a parent');
		}
		
		return Cream_Content_Managers_ItemProvider::getParent($this);
	}
	
	/**
	 * Returns the GUID of the parent of this content item
	 * 
	 * @return string
	 */
	public function getParentId()
	{
		return $this->_itemData->getItemDefinition()->getParentId();
	}
	
	/**
	 * Get path info of the item
	 * 
	 * @return Cream_Content_ItemPath
	 */
	public function getPaths()
	{
		if (!$this->_paths) {
			$this->_paths = Cream_Content_ItemPath::instance($this);
		}
		
		return $this->_paths;
	}
	
	/**
	 * Retrieves information abount the publishing of the item.
	 * 
	 * @return unknown_type
	 */
	public function getPublishing()
	{
		if (!$this->_publishing) {
			$this->_publishing = Cream_Content_ItemPublishing::instance($this);
		}
		
		return $this->_publishing;
	}
	
	/**
	 * Returns the template item of the current content item.
	 * 
	 * @return Cream_Content_Template_Item
	 */
	public function getTemplate()
	{
		if (!$this->_template) {
			$this->_template = Cream_Content_Managers_TemplateProvider::getTemplate($this);
		}
		
		return $this->_template;
	}
	
	/**
	 * Returns the GUID of the view ID used for this content item.
	 * 
	 * @return string
	 */
	public function getTemplateId()
	{
		if ($this->getChanges()->getPropertyValue('templateId')) {
			return $this->getChanges()->getPropertyValue('templateId');
		} else {
			return $this->getItemData()->getItemDefinition()->getTemplateId();
		}
	}
	
	/**
	 * Returns a unique string to identify the item. The string is 
	 * the name of the content repository and the id of the item.
	 * 
	 * @return string
	 */
	public function getUniqueId()
	{
		return $this->getRepository()->getName() .'.'. $this->getItemId()->toString();
	}
	
	/**
	 * Gets the value of an attribute
	 * 
	 * @param mixed $fieldName
	 * @return mixed
	 */
	public function get($fieldName)
	{
		return $this->getFields()->getField($fieldName);
	}
	
	/**
	 * Gets the value of an attribute
	 * 
	 * @param string $fieldName
	 * @return mixed
	 */
	public function __get($fieldName)
	{
		return $this->get($fieldName);		
	}
	
	/**
	 * Sets the value of a field
	 *  
	 * @param string $fieldName
	 * @param mixed $value
	 * @return void
	 */
	public function set($fieldName, $value)
	{
		$this->getFields()->getField($fieldName)->setValue($value);
	}
	
	/**
	 * Sets the value of a field
	 * 
	 * @param string $fieldName
	 * @param mixed $value
	 * @return void
	 */
	public function __set($fieldName, $value)
	{
		$this->set($fieldName, $value);
	}
	
	/**
	 * Check to see if an attribute is available for this content
	 * item. Returns true if it is, otherwise returns false.
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function __isset($name) 
	{
		return $this->getFields()->exists($name);
	}
	
	/**
	 * Returns true if the item is modified, otherwise false.
	 * 
	 * @return boolean
	 */
	public function isModified()
	{
		if ($this->getRuntimeSettings()->getSaveAll()) {
			return true;
		}
		
		if ($this->_itemChanges) {
			return true;
		} else {
			return false;
		}
	}
	
	public function isValid()
	{
		return true;
	}
	
	/**
	 * Deletes the item
	 * 
	 * @return void
	 */
	public function delete()
	{
		foreach($this->getChildren() as $child) {
			$child->delete();
		}
		
		Cream_Content_Managers_ItemProvider::deleteItem($this);
	}
	
	/**
	 * Returns the runtime settings object
	 * 
	 * @return Cream_Content_ItemRuntimeSettings
	 */
	public function getRuntimeSettings()
	{
		if (!$this->_runtimeSettings) {
			$this->_runtimeSettings = Cream_Content_ItemRuntimeSettings::instance($this);
		}
		
		return $this->_runtimeSettings;
	}
	
	/**
	 * Returns the repository
	 * 
	 * @return Cream_Content_Repository
	 */
	public function getRepository()
	{
		return $this->_repository;
	}
	
	/**
	 * Returns the workflow state of the item
	 * 
	 * @return Cream_Content_ItemState
	 */
	public function getState()
	{
		if (!$this->_state) {
			$this->_state = Cream_Content_ItemState::instance($this);
		}
		
		return $this->_state;
	}
	
	/**
	 * Returns the statistics of the item
	 * 
	 * @return Cream_Content_ItemStatistics
	 */
	public function getStatistics()
	{
		if (!$this->statistics) {
			$this->statistics = Cream_Content_ItemStatistics::instance($this);
		}
		
		return $this->statistics;
	}	
	
	/**
	 * Returns the version number of the item
	 * 
	 * @return Cream_Content_Version
	 */
	public function getVersion()
	{
		return $this->_itemData->getVersion();
	}
	
	/**
	 * Provides access to different versions of the item. 
	 * 
	 * @return Cream_Content_ItemVersions
	 */
	public function getVersions()
	{
		if (!$this->_versions) {
			$this->_versions = Cream_Content_ItemVersions::instance($this);
		}
		
		return $this->_versions;
	}
	
	/**
	 * Sets the name of the item.
	 * 
	 * @param string $name
	 * @return void
	 */
	public function setName($name) 
	{
		$this->getEditing()->assertEditing();
		$this->getChanges()->setPropertyValue('name', $name);
	}
	
	/**
	 * Sets the template id of the item.
	 * 
	 * @param Cream_Guid $templateId
	 * @return void
	 */
	public function setTemplateId(Cream_Guid $templateId)
	{
		$this->getEditing()->assertEditing();
		$this->getChanges()->setPropertyValue('templateId', $templateId);
	}
}