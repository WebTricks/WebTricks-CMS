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
 * Data manager for the content repository, this manager stores the 
 * data in a database.
 *
 * @package		Cream_Content_Data_Manager
 * @author		Danny Verkade
 */
class Cream_Content_Data_Manager_Database extends Cream_Content_Data_Manager_Abstract
{
	/**
	 * Name of the read connection to use
	 * 
	 * @var string
	 */
	protected $_readConnection;
	
	/**
	 * Name of the write connection to use
	 * 
	 * @var string
	 */
	protected $_writeConnection;
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Config_Xml_Element $config
	 */
	public function __init(Cream_Content_Repository $repository, Cream_Config_Xml_Element $config)
	{
		parent::__init($repository, $config);
		
		$this->_readConnection = (string) $config->connection->read;
		$this->_writeConnection = (string) $config->connection->write;
	}

	/**
	 * Deletes an item
	 * 
	 * @param Cream_Guid $itemId
	 * @return void
	 */
	public function deleteItem(Cream_Guid $itemId)
	{
		// Delete shared fields
		$delete = Cream_Data_Statement_Delete::instance();
		$delete->from($this->_getTableName('item_shared_field'));
		$delete->where('itemId = ?', $itemId);
		$this->_getWriteConnection()->query($delete);
		
		// Delete culture fields
		$delete = Cream_Data_Statement_Delete::instance();
		$delete->from($this->_getTableName('item_versioned_field'));
		$delete->where('itemId = ?', $itemId);
		$this->_getWriteConnection()->query($delete);

		// Delete unversioned fields
		$delete = Cream_Data_Statement_Delete::instance();
		$delete->from($this->_getTableName('item_unversioned_field'));
		$delete->where('itemId = ?', $itemId);
		$this->_getWriteConnection()->query($delete);
		
		// Delete item
		$delete = Cream_Data_Statement_Delete::instance();
		$delete->from($this->_getTableName('item'));
		$delete->where('itemId = ?', $itemId);	
		$this->_getWriteConnection()->query($delete);			
	}
		
	/**
	 * Checks if a given item exists, returns true if it is, otherwise
	 * returns false.
	 * 
	 * @param Cream_Guid $itemId
	 * @return boolean
	 */
	public function itemExists(Cream_Guid $itemId)
	{
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item'), 'itemId');
		$select->where('itemId = ?', $itemId);
		
		$result = $this->_getReadConnection()->query($select);
		
		if ($result->getNumRows()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Gets a list of all versions that have been defined in the 
	 * entire database. 
	 * 
	 * @return array
	 */
	public function getVersions()
	{
		$versions = array();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item_versioned_field'), 'version');
		$select->orderBy('version', 'DESC');
		$select->distinct(true);

		$result = $this->_getReadConnection()->query($select);
		
		foreach($result->getRows() as $row) {
			$version = Cream_Content_Version::instance($row->version);
			$versions[] = $version;
		}
		
		return $versions;
	}
	
	/**
	 * Gets the cultures of the database.
	 * 
	 * @return Cream_Globalization_CultureCollection
	 */
	public function getCultures()
	{
		$cultureCollection = Cream_Globalization_CultureCollection::instance();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->distinct(true);
		$select->from($this->_getTableName('item'), array('itemId', 'name'));
		$select->where('templateId = ?', Cream_Application_TemplateIds::getCulture());
		
		$result = $this->_getReadConnection()->query($select);
		
		foreach ($result->getRows() as $row) {
			$culture = Cream_Globalization_Culture::instance($row->name);
			$cultureCollection->add($culture);
		}
		
		return $cultureCollection;
	}
	
	/**
	 * Returns an item collection containing all cultures for the
	 * specified item.
	 * 
	 * @param Cream_Guid $itemId
	 * @return Cream_Globalization_CultureCollection
	 */
	public function getItemCultures(Cream_Guid $itemId)
	{
		$cultures = Cream_Globalization_CultureCollection::instance();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item_versioned_field'), 'culture');
		$select->where('itemId = ?', $itemId);
		$select->groupBy('culture');
		
		$result = $this->_getReadConnection()->query($select);
		
		foreach ($result->getRows() as $row) {
			$culture = Cream_Globalization_Culture::instance($row->culture);
			$cultures->add($culture);
		}
		
		return $cultures;
	}
	
	/**
	 * Gets all items that are in a specific workflow state. 
	 * 
	 * @param Cream_Guid $stateId
	 * @return Cream_Content_ItemCollection
	 */
	public function getItemsInWorkflowState(Cream_Guid $stateId)
	{
		$itemCollection = Cream_Content_ItemCollection::instance();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item_versioned_field') .' AS item', array('item.itemId', 'item_versioned_field.culture', 'item_versioned_field.version'));
		$select->innerJoin($this->_getTableName('item_versioned_field') .' AS item_versioned_field', array('item_versioned_field.itemId', 'item.itemId'));
		$select->where('item_versioned_field.field = ?', Cream_Application_FieldIds::workflowStateId);
		$select->where('item_versioned_field.value = ?', $stateId);
		$select->orderBy('item.name');
		$select->orderBy('item_versioned_field.culture');
		$select->orderBy('item_versioned_field.version');
		
		$result = $this->_getReadConnection()->query($select);
		
		foreach ($result->getRows() as $row) {
			
			$itemId = Cream_Guid::parseGuid($row->itemId);
			$culture = Cream_Globalization_Culture::instance($row->culture);
			$version = Cream_Content_Version::instance($row->version);
			
			$item = Cream_Content_Managers_ItemProvider::getItem($itemId, $culture, $version);
			$itemCollection->add($item);
		}
		
		return $itemCollection;
	}

	/**
	 * Check if the given version exists
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_Version $version
	 * @param Cream_Globalization_Culture $culture
	 * @return boolean
	 */
	protected function _versionExists(Cream_Guid $itemId, Cream_Content_Version $version, Cream_Globalization_Culture $culture)
	{
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item_versioned_field'), 'version');
		$select->where('itemId = ?', $itemId);
		$select->where('culture = ?', $culture);
		$select->where('version = ?', $version);
		
		$result = $this->_getReadConnection()->query($select);
		
		if ($result->getNumRows()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Adds an version to the item. Returns the version number of the
	 * new version.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_Version $version
	 * @param Cream_Globalization_Culture $culture
	 * @return integer
	 */
	public function addVersion(Cream_Guid $itemId, Cream_Content_Version $version, Cream_Globalization_Culture $culture)
	{
		$newVersion = Cream_Content_Version::INVALID;
		
		if ($version > 0) {
			$newVersion = $this->_copyVersion($itemId, $version, $culture);	
		}
		
		if ($newVersion == Cream_Content_Version::INVALID) {
			$newVersion = $this->_addBlankVersion();
		}
		
		return $newVersion;
	}
	
	/**
	 * Adds a blank version to the item. Returns the version number
	 * of the new version.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @return integer
	 */
	protected function _addBlankVersion(Cream_Guid $itemId, Cream_Globalization_Culture $culture)
	{
		print "INSERT INTO {0}VersionedFields{1}(   {0}ItemId{1}, {0}Culture{1}, {0}Version{1}, {0}FieldId{1}, {0}Value{1}, {0}Created{1}, {0}Updated{1} ) VALUES(   {2}itemId{3}, {2}Culture{3}, {2}newVersion{3}, {2}fieldId{3}, {2}value{3}, {2}now{3}, {2}now{3} )";
	}
	
	/**
	 * Copies a version to a new version. Returns the version number
	 * of the new version.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_Version $version
	 * @param Cream_Globalization_Culture $culture
	 * @return integer
	 */
	protected function _copyVersion(Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version)
	{
		if (!$this->_versionExists($itemId, $version, $culture)) {
			return Cream_Content_Version::INVALID();
		}
		
		$newVersion = $this->getLatestVersion($itemId, $culture) + 1;
		
		print "INSERT INTO {0}VersionedFields{1}(   {0}ItemId{1}, {0}Culture{1}, {0}Version{1}, {0}FieldId{1}, {0}Value{1}, {0}Created{1}, {0}Updated{1} ) SELECT {0}ItemId{1}, {0}Culture{1}, {2}newVersion{3}, {0}FieldId{1}, {0}Value{1}, {2}now{3}, {0}Updated{1} FROM {0}VersionedFields{1} WHERE {0}ItemId{1} = {2}itemId{3} AND {0}Culture{1} = {2}culture{3} AND {0}Version{1} = {2}version{3";
		
		return $newVersion;
	}	
	
	/**
	 * Gets the latest version number for a specific culture. 
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @return integer
	 */
	public function getLatestVersion(Cream_Guid $itemId, Cream_Globalization_Culture $culture)
	{
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item_versioned_field'), Cream_Expression::instance('MAX(version) AS version'));
		$select->where('itemId = ?', $itemId);
		$select->where('culture = ?', $culture);

		$result = $this->_getReadConnection()->query($select);
		
		if ($result->getNumRows()) {
			$version = $result->getRow()->version;
			return Cream_Content_Version::instance($version);
		} else {
			return Cream_Content_Version::getFirst();
		}
	}
	
	/**
	 * Loads the childs ids of the specified item ID into an array.
	 * Returns an empty array if there are no child items present.
	 * 
	 * @param Cream_Guid $itemId
	 * @return array
	 */
	public function loadChildIds(Cream_Guid $itemId)
	{
		$childIds = array();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item') .' AS item', 'item.itemId');
		$select->where('parentId = ?', $itemId);
		
		$result = $this->_getReadConnection()->query($select);

		foreach($result->getRows() as $row) {
			$childIds[] = Cream_Guid::parseGuid($row->itemId);
		}
		
		return $childIds;
	}

	/**
	 * Loads the item definition, throws an exception when the given
	 * item ID is not found.
	 * 
	 * @param Cream_Guid $itemId
	 * @return Cream_Content_ItemDefinition
	 * @throws Cream_Content_Data_Provider_Exception when the item ID
	 * is not found
	 */
	public function loadItemDefinition(Cream_Guid $itemId)
	{
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item'));
		$select->where('itemId = ?', $itemId);
		
		$result = $this->_getReadConnection()->query($select);
		
		if ($result->getNumRows()) {
			$itemId = Cream_Guid::parseGuid($result->getRow()->itemId); 
			$templateId = Cream_Guid::parseGuid($result->getRow()->templateId);
			$parentId = Cream_Guid::parseGuid($result->getRow()->parentId);
			$name = $result->getRow()->name;
			
			return Cream_Content_ItemDefinition::instance($itemId, $templateId, $parentId, $name); 
		} else {
			return null;
			//throw new Cream_Content_Data_Exception('Item with ID "'. $itemId .'" not found.');
		}
	}

	/**
	 * Loads all the field data
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @param Cream_Content_Version $version
	 * @return Cream_Content_ItemFieldData
	 */
	public function loadItemFields(Cream_Guid $itemId, Cream_Globalization_Culture $culture, Cream_Content_Version $version)
	{
		$itemFieldData = Cream_Content_ItemFieldData::instance();
		
		$sharedQuery = Cream_Data_Statement_Select::instance();
		$sharedQuery->from($this->_getTableName('item_shared_field'), array('itemId', Cream_Expression::instance("'". $culture ."' AS culture"), Cream_Expression::instance("'". $version ."' AS version"), 'fieldId', 'value'));
		$sharedQuery->where('itemId = ?', $itemId);
		
		$versionedQuery = Cream_Data_Statement_Select::instance();
		$versionedQuery->from($this->_getTableName('item_versioned_field'), array('itemId', 'culture', 'version', 'fieldId', 'value'));
		$versionedQuery->where('itemId = ?', $itemId);
		$versionedQuery->where('culture = ?', $culture);
		$versionedQuery->where('version = ?', $version);

		$unversionedQuery = Cream_Data_Statement_Select::instance();
		$unversionedQuery->from($this->_getTableName('item_unversioned_field'), array('itemId', 'culture', Cream_Expression::instance("'". $version ."' AS version"), 'fieldId', 'value'));
		$unversionedQuery->where('itemId = ?', $itemId);
		$unversionedQuery->where('culture = ?', $culture);		
		
		$select = "	SELECT itemId, culture, version, fieldId, value 
					FROM ( ". $sharedQuery ." UNION ALL ". $versionedQuery ." UNION ALL ". $unversionedQuery ." ) AS temp 
					ORDER BY itemId, culture DESC, version DESC";
		
		$result = $this->_getReadConnection()->query($select);
		
		foreach($result->getRows() as $row) {
			$fieldName = Cream_Guid::parseGuid($row->fieldId);
			$value = $row->value;
			$itemFieldData->add($fieldName, $value);
		}
		
		return $itemFieldData;
	}		
	
	/**
	 * Saves an item
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public function saveItem(Cream_Content_Item $item)
	{			
		if ($item->getRuntimeSettings()->getSaveAll()) {
			$changes = $item->getFullChanges();
		} else {
			$changes = $item->getChanges();
		}

		$this->_saveItemDefinition($item->getItemData()->getItemDefinition());
		$this->_saveItemFields($item->getItemId(), $item->getChanges());			
	}
	
	/**
	 * Saves the item definition to the database
	 * 
	 * @param Cream_Content_ItemDefinition $itemDefinition
	 * @return void
	 */
	protected function _saveItemDefinition(Cream_Content_ItemDefinition $itemDefinition)
	{
		if ($this->itemExists($itemDefinition->getItemId())) {
			$query = Cream_Data_Statement_Update::instance();
			$query->from($this->_getTableName('item'));
			$query->set('templateId', $itemDefinition->getTemplateId());
			$query->set('parentId', $itemDefinition->getParentId());
			$query->set('name', $itemDefinition->getName());
			$query->set('updated', Cream_Expression::instance('NOW()'));
			$query->where('itemId = ?', $itemDefinition->getItemId());
		} else {
			$query = Cream_Data_Statement_Insert::instance();
			$query->into($this->_getTableName('item'));
			$query->values(array(
				'itemId' => $itemDefinition->getItemId(),
				'templateId' => $itemDefinition->getTemplateId(),
				'parentId' => $itemDefinition->getParentId(),
				'name' => $itemDefinition->getName(),
				'created' => Cream_Expression::instance('NOW()'),
				'updated' => Cream_Expression::instance('NOW()')
			));
		}
		
		$this->_getWriteConnection()->query($query);		
	}
	
	/**
	 * Saves the item fields
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Data_ItemChanges $itemChanges
	 */
	protected function _saveItemFields(Cream_Guid $itemId, Cream_Content_ItemChanges $itemChanges)
	{
		/* @var $change Cream_Content_FieldChange */
		foreach($itemChanges->getFields() as $change) {
			if ($change->getTemplateField()->isShared()) {
				$this->_saveSharedField($itemId, $change);
			} elseif ($change->getTemplateField()->isUnversioned()) {
				$this->_saveUnversionedField($itemId, $change);
			} elseif ($change->getTemplateField()->isVersioned()) {
				$this->_saveVersionedField($itemId, $change);
			}
		}
	}
	
	/**
	 * Saves a shared field to the database
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_FieldChange $fieldChange
	 * @return void
	 */
	protected function _saveSharedField(Cream_Guid $itemId, Cream_Content_FieldChange $fieldChange)
	{
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item_shared_field'), 'id');
		$select->where('itemId = ?', $itemId);
		$select->where('fieldId = ?', $fieldChange->getFieldId());
		
		$result = $this->_getReadConnection()->query($select);
		
		if ($result->getNumRows()) {
			$query = Cream_Data_Statement_Update::instance();
			$query->from($this->_getTableName('item_shared_field'));
			$query->set('value', $fieldChange->getValue());
			$query->set('updated', Cream_Expression::instance('NOW()'));
			$query->where('id = ?', $result->getRow()->id);
		} else {
			$query = Cream_Data_Statement_Insert::instance();
			$query->into($this->_getTableName('item_shared_field'));
			$query->values(array(
				'id' => Cream_Guid::generateGuid(),
				'itemId' => $itemId,
				'fieldId' => $fieldChange->getFieldId(),
				'value' => $fieldChange->getValue(),
				'created' => Cream_Expression::instance('NOW()'),
				'updated' => Cream_Expression::instance('NOW()')
			));
		}		
				
		$this->_getWriteConnection()->query($query);
	}
	
	/**
	 * Saves a versioned field to the database.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_FieldChange $fieldChange
	 * @return void
	 */
	protected function _saveVersionedField(Cream_Guid $itemId, Cream_Content_FieldChange $fieldChange)
	{
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item_versioned_field'), 'id');
		$select->where('itemId = ?', $itemId);
		$select->where('fieldId = ?', $fieldChange->getFieldId());
		$select->where('culture = ?', $fieldChange->getCulture());
		$select->where('version = ?', $fieldChange->getVersion());
		
		$result = $this->_getReadConnection()->query($select);
		
		if ($result->getNumRows()) {
			$query = Cream_Data_Statement_Update::instance();
			$query->from($this->_getTableName('item_versioned_field'));
			$query->set('value', $fieldChange->getValue());
			$query->set('updated', Cream_Expression::instance('NOW()'));
			$query->where('id = ?', $result->getRow()->id);
		} else {
			$query = Cream_Data_Statement_Insert::instance();
			$query->into($this->_getTableName('item_versioned_field'));
			$query->values(array(
				'id' => Cream_Guid::generateGuid(),
				'itemId' => $itemId,
				'culture' => $fieldChange->getCulture(),
				'version' => $fieldChange->getVersion(), 
				'value' => $fieldChange->getValue(),
				'created' => Cream_Expression::instance('NOW()'),
				'updated' => Cream_Expression::instance('NOW()')
			));
		}
		
		$this->_getWriteConnection()->query($query);		
	}

	/**
	 * Saves a unversioned field to the database.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_FieldChange $fieldChange
	 * @return void
	 */
	protected function _saveUnversionedField(Cream_Guid $itemId, Cream_Content_FieldChange $fieldChange)
	{
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item_unversioned_field'), 'id');
		$select->where('itemId = ?', $itemId);
		$select->where('fieldId = ?', $fieldChange->getFieldId());
		$select->where('culture = ?', $fieldChange->getCulture());
		
		$result = $this->_getReadConnection()->query($select);
		
		if ($result->getNumRows()) {
			$query = Cream_Data_Statement_Update::instance();
			$query->from($this->_getTableName('item_unversioned_field'));
			$query->set('value', $fieldChange->getValue());
			$query->set('updated', Cream_Expression::instance('NOW()'));
			$query->where('id = ?', $result->getRow()->id);
		} else {
			$query = Cream_Data_Statement_Insert::instance();
			$query->into($this->_getTableName('item_unversioned_field'));
			$query->values(array(
				'id' => Cream_Guid::generateGuid(),
				'itemId' => $itemId,
				'culture' => $fieldChange->getCulture(),
				'value' => $fieldChange->getValue(),
				'created' => Cream_Expression::instance('NOW()'),
				'updated' => Cream_Expression::instance('NOW()')
			));
		}
		
		$this->_getWriteConnection()->query($query);		
	}
	
	public function copyItem(Cream_Guid $itemId, Cream_Guid $destinationId, Cream_Guid $newId, $newName)
	{	
		$query = "INSERT INTO ". $this->_getTableName('items') ." (itemId, name, templateId, parentId, created, updated) SELECT '". $newId ."', '". $newName ."', TemplateId, {0}MasterID{1}, {2}destinationId{3}, {2}now{3}, {0}Updated{1}\r\n                   FROM ". $this->_getTableName('items') ." WHERE ItemId = {2}itemId{3}";
		$query = "INSERT INTO {0}SharedFields{1}(\r\n                     {0}ItemId{1}, {0}FieldId{1}, {0}Value{1}, {0}Created{1}, {0}Updated{1}\r\n                   )\r\n                   SELECT {2}copyId{3}, {0}FieldId{1}, {0}Value{1}, {2}now{3}, {0}Updated{1}\r\n                   FROM {0}SharedFields{1}\r\n                   WHERE {0}ItemId{1} = {2}itemId{3}";
		$query = "INSERT INTO {0}UnversionedFields{1}(\r\n                     {0}ItemId{1}, {0}Language{1}, {0}FieldId{1}, {0}Value{1}, {0}Created{1}, {0}Updated{1}\r\n                   )\r\n                   SELECT {2}copyId{3}, {0}Language{1}, {0}FieldId{1}, {0}Value{1}, {2}now{3}, {0}Updated{1}\r\n                   FROM {0}UnversionedFields{1}\r\n                   WHERE {0}ItemId{1} = {2}itemId{3}";
		$query = "INSERT INTO {0}VersionedFields{1}(\r\n                     {0}ItemId{1}, {0}Language{1}, {0}Version{1}, {0}FieldId{1}, {0}Value{1}, {0}Created{1}, {0}Updated{1}\r\n                   )\r\n                   SELECT {2}copyId{3}, {0}Language{1}, {0}Version{1}, {0}FieldId{1}, {0}Value{1}, {2}now{3}, {0}Updated{1}\r\n                   FROM {0}VersionedFields{1}\r\n                   WHERE {0}ItemId{1} = {2}itemId{3}";

		$this->_getWriteConnection()->query($query);
	}
	
	/**
	 * Moves an item, returns true of the item is moved, otherwise
	 * false.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Guid $destinationId
	 * @return boolean
	 */
	public function moveItem(Cream_Guid $itemId, Cream_Guid $destinationId)
	{
		$update = Cream_Data_Statement_Update::instance();
		$update->from($this->_getTableName('item'));
		$update->set('parentId', $destinationId);
		$update->where('itemId = ?', $itemId);

		$result = $this->_getWriteConnection()->query($update);
		
		if ($result->getAffectedRows()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Removes a version from an item. 
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Content_Version $version
	 * @return void
	 */
	public function removeVersion(Cream_Guid $itemId, Cream_Content_Version $version)
	{
		$delete = Cream_Data_Statement_Delete::instance();
		$delete->from($this->_getTableName('item_shared_field'));
		$delete->where('itemId = ?', $itemId);
		$delete->where('version = ?', $version);
		$this->_getWriteConnection()->query($delete);
		
		$delete = Cream_Data_Statement_Delete::instance();
		$delete->from($this->_getTableName('item_versioned_field'));
		$delete->where('itemId = ?', $itemId);
		$delete->where('version = ?', $version);
		$this->_getWriteConnection()->query($delete);
	}
	
	/**
	 * Removes a culture of the specified item.
	 * 
	 * @param Cream_Guid $itemId
	 * @param Cream_Globalization_Culture $culture
	 * @return void
	 */
	public function removeCulture(Cream_Guid $itemId, Cream_Globalization_Culture $culture)
	{
		$delete = Cream_Data_Statement_Delete::instance();
		$delete->from($this->_getTableName('item_versioned_field'));
		$delete->where('itemId = ?', $itemId);
		$delete->where('culture = ?', $culture);
		$this->_getWriteConnection()->query($delete);		
	}
	
	/**
	 * Resolves a path to a item GUID. Returns the guid when an item found,
	 * otherwise returns null.
	 * 
	 * @param string $path
	 * @return Cream_Guid
	 */
	public function resolvePath($path)
	{
		$i = 0;
		$parts = array_reverse(explode('/', $path));
		$first = array_shift($parts);
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from($this->_getTableName('item') .' AS i'. $i, 'i'. $i .'.itemId');
		$select->where('i'. $i .'.name = ?', $first);
		
		foreach($parts as $part) {
			$select->innerJoin($this->_getTableName('item') .' AS i'. ($i+1), array('i'. ($i+1) .'.itemId', 'i'. $i .'.parentId'), 'i'. ($i+1) .'.name = ?', $part);
			$i++;
		}
		
		$result = $this->_getReadConnection()->query($select);

		if ($result->getNumRows()) {
			return Cream_Guid::parseGuid($result->getRow()->itemId);
		} else {
			return null;
		}
	}

	/**
	 * Returns the name of the table to use.
	 * 
	 * @param string $table
	 * @return string
	 */
	protected function _getTableName($table)
	{
		return $this->repository->getName() .'_'. $table;
	}
	
	/**
	 * Returns the read connection
	 *
	 * @return Cream_Data_Connection
	 */
	protected function _getReadConnection()
	{
		return $this->getApplication()->getConnection($this->_readConnection);
	}

	/**
	 * Returns the write connection
	 *
	 * @return Cream_Data_Connection
	 */	
	protected function _getWriteConnection()
	{
		return $this->getApplication()->getConnection($this->_writeConnection);
	}
}