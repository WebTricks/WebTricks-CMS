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
 * Base class for all link data adapters.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
abstract class Cream_Content_Links_Data_Adapter_Abstract extends Cream_ApplicationComponent
{
	/**
	 * Adds a link to the link database.
	 * 
	 * @param Cream_Content_Links_ItemLink $link
	 * @return void
	 */
    abstract public function addLink(Cream_Content_Links_ItemLink $link);
    
    /**
     * Gets the broken links of the specified repository.
     * 
     * @param Cream_Content_Repository $repository
     * @return array
     */    
    abstract public function getBrokenLinks(Cream_Content_Repository $repository);
    
    /**
     * Gets the reference count
     * 
     * @param Cream_Content_Item $item
     * @return integer
     */    
    abstract public function getReferenceCount(Cream_Content_Item $item);
    
    /**
     * Gets the references the given item has to other items. 
     * 
     * @param Cream_Content_Item $item
     * @return array
     */    
    abstract public function getReferences(Cream_Content_Item $item);
    
    /**
     * Gets the referrer count
     * 
     * @param Cream_Content_Item $item
     * @return integer
     */    
    abstract public function getReferrerCount(Cream_Content_Item $item);
    
    /**
     * Gets the referrers of item pointing to the given item.
     * 
     * @param Cream_Content_Item $item
     * @return array
     */    
    abstract public function getReferrers(Cream_Content_Item $item);
    
    /**
     * Remove the references the given item has.
     * 
     * @param Cream_Content_Item $item
     * @return void
     */    
    abstract public function removeReferences(Cream_Content_Item $item);
    
    /**
     * Updates all the references a particular item has.
     * 
     * @param Cream_Content_Item $item
     * @param array $links
     * @return void
     */    
    abstract protected function updateLinks(Cream_Content_Item $item, $links);
    
    /**
     * Rebuilds the links datbase for a complete repository
     * 
     * @param Cream_Content_Repository $repository
     * @return void
     */
    public function rebuild(Cream_Content_Repository $repository)
    {
    	$rootItem = $repository->getRootItem();
    	$this->rebuildItem($rootItem);
    }

    /**
     * Rebuilds the link database for the specified item and it's children.
     * 
     * @param Cream_Content_Item $item
     * @return void
     */
    protected function rebuildItem(Cream_Content_Item $item)
    {
        $this->updateReferences($item);
        foreach ($item->getChildren() as $childItem) {
            $this->rebuildItem($childItem);
        }
    }

    /**
     * Updates the references of the given item in the link database.
     * 
     * @param Cream_Content_Item $item
     * @return void
     */
    public function updateReferences(Cream_Content_Item $item)
    {
        $links = $item->getLinks()->getAllLinks();
        $this->updateLinks($item, $allLinks);
    }	
}