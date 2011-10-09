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
 * Database adapter
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Links_Data_Adapter_Database extends Cream_Content_Links_Data_Adapter_Abstract
{
	/**
	 * Adds a link to the link database.
	 * 
	 * @param Cream_Content_Links_ItemLink $link
	 * @return void
	 */
    public function addLink(Cream_Content_Links_ItemLink $link)
    {
    	$insert = Cream_Data_Statement_Insert::instance();
    	$insert->into('Links');
    	$insert->values(array(
    		'sourceRepository' => $link->getSourceRepositoryName(),
    		'sourceItemId' => $link->getSourceItemId(),
    		'sourceFieldId' => $link->getSourceFieldId(),
    		'targetRepository' => $link->getTargetRepositoryName(),
    		'targetItemId' => $link->getTargetItemId()
    	));
    	
    	$this->getApplication()->getConnection()->query($insert);
    }

    /**
     * Gets the item links.
     * 
     * @param Cream_Data_Statement_Abstract $statement
     * @return array
     */
    protected function getLinks(Cream_Data_Statement_Abstract $statement)
    {
    	$links = array();
    	$result = $this->getApplication()->getConnection()->query($statement);

    	foreach ($result->getRows() as $row) {
			$sourceRepositoryName = $row->sourceRepository;
			$sourceItemId = Cream_Guid::parseGuid($row->sourceItemId);
			$sourceFieldId = Cream_Guid::parseGuid($row->sourceFieldId);
			$targetRepositoryName = $row->targetRepository;
			$targetItemId = Cream_Guid::parseGuid($row->targetItemId);						
			
			$link = Cream_Content_Links_ItemLink::instance($sourceRepository, $sourceItemId, $sourceFieldId, $targetRepository, $targetItemId);
			$links[] = $link;
        }
        
        return $links;
    }

    /**
     * Gets the reference count
     * 
     * @param Cream_Content_Item $item
     * @return integer
     */
    public function getReferenceCount(Cream_Content_Item $item)
    {
    	$select = Cream_Data_Statement_Select::instance();
    	$select->from('Links', Cream_Expression::instance('COUNT(*) AS count'));
    	$select->where('sourceItemId = ?', $item->getItemId());
    	$select->where('sourceRepository = ?', $item->getRepository()->getName());
    	
    	$result = $this->getApplication()->getConnection()->query($select);
    	
    	if ($result->getNumRows()) {
    		return $result->getRow()->count;
    	} else {
    		return 0;
    	}	
    }

    /**
     * Gets the references the given item has to other items. 
     * 
     * @param Cream_Content_Item $item
     * @return array
     */
    public function getReferences(Cream_Content_Item $item)
    {
    	$select = Cream_Data_Statement_Select::instance();
    	$select->from('Links');
    	$select->where('sourceItemId = ?', $item->getItemId());
    	$select->where('sourceRepository = ?', $item->getRepository()->getName());
    	
        return $this->getLinks($select, $item);
    }

    /**
     * Gets the referrer count
     * 
     * @param Cream_Content_Item $item
     * @return integer
     */
    public function getReferrerCount(Cream_Content_Item $item)
    {
    	$select = Cream_Data_Statement_Select::instance();
    	$select->from('Links', Cream_Expression::instance('COUNT(*) AS count'));
    	$select->where('targetItemId = ?', $item->getItemId());
    	$select->where('targetRepository = ?', $item->getRepository()->getName());
    	
    	$result = $this->getApplication()->getConnection()->query($select);
    	
    	if ($result->getNumRows()) {
    		return $result->getRow()->count;
    	} else {
    		return 0;
    	}
    }

    /**
     * Gets the referrers of item pointing to the given item.
     * 
     * @param Cream_Content_Item $item
     * @return array
     */
    public function getReferrers(Cream_Content_Item $item)
    {
    	$select = Cream_Data_Statement_Select::instance();
    	$select->from('Links');
    	$select->where('targetItemId = ?', $item->getItemId());
    	$select->where('targetRepository = ?', $item->getRepository()->getName());
    	
        return $this->getLinks($select);
    }

    /**
     * Remove the references the given item has.
     * 
     * @param Cream_Content_Item $item
     * @return void
     */
    public function removeReferences(Cream_Content_Item $item)
    {
    	$delete = Cream_Data_Statement_Delete::instance();
    	$delete->from('Links');
    	$delete->where('sourceItemId = ?', $item->getItemId());
    	$delete->where('sourceRepository = ?', $item->getRepository()->getName());

    	$this->getApplication()->getConnection()->query($delete);
    }

    /**
     * Updates all the references a particular item has.
     * 
     * @param Cream_Content_Item $item
     * @param array $links
     * @return void
     */
    protected function updateLinks(Cream_Content_Item $item, $links)
    {
		$this->removeReferences($item);
		
		foreach($links as $link) {
			$this->addLink($link);	
		}
    }	
    
    /**
     * Gets the broken links of the specified repository.
     * 
     * @param Cream_Content_Repository $repository
     * @return array
     */
    public function getBrokenLinks(Cream_Content_Repository $repository)
    {
    	$links = array();
    	
    	$delete = Cream_Data_Statement_Delete::instance();
    	$delete->from('Links');
    	$delete->where('sourceRepository = ?', $item->getRepository()->getName());
    	
    	$result = $this->getApplication()->getConnection()->query($select);
    	
    	foreach($result->getRows as $row) {
			$sourceRepositoryName = $row->sourceRepository;
			$sourceItemId = Cream_Guid::parseGuid($row->sourceItemId);
			$sourceFieldId = Cream_Guid::parseGuid($row->sourceFieldId);
			$targetRepositoryName = $row->targetRepository;
			$targetItemId = Cream_Guid::parseGuid($row->targetItemId);

			if ($targetRepository == null || $targetRepository->getItem($targetItemId) == null) {
				$link = Cream_Content_Links_ItemLink::instance($sourceRepository, $sourceItemId, $sourceFieldId, $targetRepository, $targetItemId);
				$links[] = $link;								
			}
    	}
    	
    	return $links;
    }
}