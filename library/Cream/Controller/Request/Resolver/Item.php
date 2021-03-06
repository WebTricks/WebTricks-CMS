<?php

class Cream_Controller_Request_Resolver_Item extends Cream_Controller_Request_Resolver_Abstract
{
	public function process()
	{
		$site = $this->_getApplication()->getContext()->getSite();
		$repository = $this->_getApplication()->getContext()->getRepository();

		if ($repository && $site) {
			$item =	$this->_resolveItem($this->_getItemPath());
			
			if ($item) {
				//$itemId = Cream_Application_ItemIds::getRootId(); 
				//$item = $this->_getApplication()->getContext()->getRepository()->getItem($itemId);
				
				$this->_getApplication()->getContext()->setItem($item);
			} 			
		}
	}
	
	protected function _getItemPath()
	{
		$fullPath = $this->_getApplication()->getRequest()->getPathInfo();
		$site = $this->_getApplication()->getContext()->getSite();
		
		if (substr($fullPath, 0, strlen($site->getPath())) == $site->getPath()) {
			$path = substr($fullPath, strlen($site->getPath()));
		} else {
			$path = $fullPath;
		}
		
		return $path;
	}
	
	protected function _resolveItem($path)
	{
		$site = $this->_getApplication()->getContext()->getSite();
		$repository = $this->_getApplication()->getContext()->getRepository();
		$culture = $this->_getApplication()->getContext()->getCulture();
		
		$item = $repository->getItemByPath($site->getRootPath(), $culture);
		$child = $item;
		
		if ($item) {
			$paths = explode('/', $path);
			
			foreach($paths as $name) {
				if (!$name) {
					continue;
				}
							
				$child = $this->_getSubItem($child, $name);

				if (!$child) {
					return null;
				}
			}			
		}
		
		return $child;
	}
	
	protected function _getSubItem(Cream_Content_Item $item, $name)
	{
		foreach($item->getChildren() as $childItem) {
			if (strtolower($childItem->getName()) == $name) {
				return $childItem;
			}
		}
	}
	
}