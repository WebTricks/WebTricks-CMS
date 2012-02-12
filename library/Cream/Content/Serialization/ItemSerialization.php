<?php

class Cream_Content_Serialization_ItemSerialization
{
	const FORMAT_VERSION = 1;
	
	public static function serialize(Cream_Content_Item $item)
	{
		
	}	
	
	public static function unserialize(Cream_Content_Serialization_Tokenizer $tokenizer)
	{
		$syncItem = self::_readItem($tokenizer);
		self::_pasteItem($syncItem);
		
		//print_r($syncItem);
	}
	
	protected static function _readItem(Cream_Content_Serialization_Tokenizer $tokenizer)
	{
	    $item = Cream_Content_Serialization_SyncItem::instance();
		
		while (($tokenizer->getLine() != null) && (strlen($tokenizer->getLine()) == 0)) {
	        $tokenizer->nextLine();
	    }
	    
	    if (($tokenizer->getLine() == null) || ($tokenizer->getLine() !== "----item----")) {
	        throw new Exception("Format error: serialized stream does not start with ----item----");
	    }

		$tokenizer->nextLine();
	    $values = Cream_Content_Serialization_Util::readHeaders($tokenizer);
	    
	    if ((!$values["version"]) || (self::FORMAT_VERSION < $values["version"])) {
	        throw new Exception("The file was generated using a newer version of Serialization.");
	    }

	    $item->setId($values["id"]);
	    $item->setItemPath($values["path"]);
	    
	    try {
	        $item->setRepositoryName($values["database"]);
	        $item->setParentId($values["parent"]);
	        $item->setName($values["name"]);
	        $item->setBranchId($values["master"]);
	        $item->setTemplateId($values["template"]);
	        $item->setTemplateName($values["templatekey"]);
	        
	        $tokenizer->nextLine();
	        
	        while ($tokenizer->getLine() == "----field----") {
				$tokenizer->nextLine();	        	
	            $field = self::_readField($tokenizer);
	            
	            if ($field != null) {
	                $item->addSharedField($field);
	            }
	            
	            while ($tokenizer->getLine() === '') {
	            	$tokenizer->nextLine();
	            }
	        }
	        
	        while ($tokenizer->getLine() == "----version----") {
				$tokenizer->nextLine();	        	
	            $version = self::_readVersion($tokenizer);
	            
	            if ($version != null) {
	                $item->addVersion($version);
	            }
	            
	        	while ($tokenizer->getLine() === '') {
	        		$tokenizer->nextLine();
				}
	        }
	    } catch (Exception $exception) {
	        throw new Exception("Error reading item: " + item.ItemPath, exception);
	    }
	    
	    return $item;		
	}
	
	protected static function _readField(Cream_Content_Serialization_Tokenizer $tokenizer)
	{	
		$values = Cream_Content_Serialization_Util::readHeaders($tokenizer);
		
		$field = Cream_Content_Serialization_SyncField::instance();
		$field->setFieldId($values['field']);
		$field->setFieldName($values['name']);
		$field->setFieldKey($values['key']);
		
		$tokenizer->nextLine();
		$content = '';
		
		while(strlen($content) < $values['content-length']) {
			$content .= $tokenizer->getLine();
			$tokenizer->nextLine();
		}	
		
		$field->setFieldValue($content);
		
		return $field;
	}
	
	protected static function _readVersion(Cream_Content_Serialization_Tokenizer $tokenizer)
	{
		$values = Cream_Content_Serialization_Util::readHeaders($tokenizer);
		
		while (!$tokenizer->getLine()) {
	    	$tokenizer->nextLine();
		}		
		
		$version = Cream_Content_Serialization_SyncVersion::instance();
		$version->setCulture($values['language']);
		$version->setVersion($values['version']);
		$version->setRevision($values['revision']);

		while ($tokenizer->getLine() == "----field----") {
			$tokenizer->nextLine();	        	
	        $field = self::_readField($tokenizer);
	            
	        if ($field != null) {
	        	$version->addField($field);
			}
	            
			while ($tokenizer->getLine() === '') {
	        	$tokenizer->nextLine();
			}
		}
		
		return $version;
	}
	
	protected static function _pasteItem(Cream_Content_Serialization_SyncItem $syncItem)
	{
		$repository = Cream_Content_Managers_RepositoryProvider::getRepository($syncItem->getRepositoryName());

		$itemId = Cream_Guid::parseGuid($syncItem->getId());
		$templateId = Cream_Guid::parseGuid($syncItem->getTemplateId());
		$parentId = Cream_Guid::parseGuid($syncItem->getParentId());
		$name = $syncItem->getName();
		
		//$destination = $repository->getItem($destinationId);
		
		//$item = $repository->getItem($itemId);
		
		//if (!$item) {
			
		//	if (!$destination && ((string) $itemId !== (string) Cream_Application_ItemIds::getRootId())) {
		//		return;
		//	}
			
		//	$item = Cream_Content_Managers_ItemProvider::createItem($templateId, $destination);
		//} else {
		//	if (!$destinationId && $destinationId != $item->getParentId()) {
		//		$item->moveTo($destination);
		//	}
		//}
		
		//if ((string) $item->getTemplateId() !== (string) $templateId) {
		//	$item->changeTemplate($repository, $templateId);
		//}
		
		//if ($item->getName() !== $syncItem->getName()) {
		//	$item->setName($syncItem->getName());			
		//}
		
		$fieldList = Cream_Content_ItemFieldData::instance();
		
		foreach($syncItem->getSharedFields() as $syncField) {
			$fieldId = Cream_Guid::parseGuid($syncField->getFieldId());
			$fieldList->add($fieldId, $syncField->getFieldValue());
		}
		
		foreach($syncItem->getVersions() as $syncVersion) {
			
			$versionFieldList = clone $fieldList;
			$culture = Cream_Globalization_Culture::instance($syncVersion->getCulture());
			$version = Cream_Content_Version::instance($syncVersion->getVersion());
			
			foreach($syncVersion->getFields() as $syncField) {
				$fieldId = Cream_Guid::parseGuid($syncField->getFieldId());
				$versionFieldList->add($fieldId, $syncField->getFieldValue());
			}
			
			$itemDefinition = Cream_Content_ItemDefinition::instance($itemId, $templateId, $parentId, $name);
			$data = Cream_Content_ItemData::instance($itemDefinition, $culture, $version, $versionFieldList);
			$item = Cream_Content_Item::instance($itemId, $data, $repository);

			$item->getEditing()->startEdit();
			$item->getRuntimeSettings()->setSaveAll(true);
			$item->getEditing()->acceptChanges();
			
		}	

	}
	
	protected static function _pasteField(Cream_Content_ItemFieldData $fieldList, Cream_Content_Serialization_SyncField $syncField)
	{
		
		
	}
	
	protected static function _pasteVersion(Cream_Content_ItemFieldData $fieldList, Cream_Content_Serialization_SyncVersion $syncVersion)
	{
		
		

		
	}
}