<?php

class Cream_Controller_Request_Resolver_Culture extends Cream_Controller_Request_Resolver_Abstract
{
	const CONFIG_DEFAULT_CULTURE_PATH = 'global/globalization/default_culture';
	
	public function process()
	{
		if ($this->_setFromUrlPath()) {
			return;
		}
		
		if ($this->_setFromQueryString()) {
			return;
		}
		
		if ($this->_setFromQueryString()) {
			return;
		}
		
		if ($this->_setFromBrowser()) {
			return;
		}
		
		if ($this->_setFromSite()) {
			return;
		}
		
		if ($this->_setFromDefaultSetting()) {
			return;
		}

		throw new Cream_Controller_Exception('Culture could not be set.');
	}
	
	protected function _setFromUrlPath()
	{
		
	}
	
	/**
	 * Set the culture context from the query string.
	 * 
	 * @return boolean
	 */
	protected function _setFromQueryString()
	{
		$culture = $this->getApplication()->getRequest()->getParam('__culture');
		
		if ($culture) {
			return $this->_setCulture($culture, true);	
		}
		
		return false;
	}

	/**
	 * Set the culture context from the browser.
	 * 
	 * @return boolean
	 */
	protected function _setFromBrowser()
	{
		$cultures = $this->getApplication()->getRequest()->getServer('HTTP_ACCEPT_LANGUAGE');
		$cultures = explode(',', $cultures);
		
	    foreach ($cultures as $culture) {
			$cultureName = $culture;

			if (strstr($culture, ';')) {
				$cultureName = substr($culture, 0, strpos($culture, ';'));
			}
			
			if ($this->_setCulture($cultureName)) {
				return true;
			}
        }
		return false;
	}
	
	/**
	 * Set the culture context from the site context.
	 * 
	 * @return boolean
	 */	
	protected function _setFromSite()
	{
		return $this->_setCulture($this->getApplication()->getContext()->getSite()->getCultureName());
	}
	
	/**
	 * Set the culture context from the config.
	 * 
	 * @return boolean
	 */
	protected function _setFromDefaultSetting()
	{
		$culture = $this->getApplication()->getConfig()->getNode(self::CONFIG_DEFAULT_CULTURE_PATH);

		return $this->_setCulture((string) $culture);
	}
	
	/**
	 * Set the culture.
	 * 
	 * @return boolean
	 */
	protected function _setCulture($cultureName, $persistent = false)
	{			
		if ($cultureName) {

			
			$cultures = $this->getApplication()->getContext()->getRepository()->getCultures();

			foreach($cultures as $culture) {
				if ($culture->getCulture() == $cultureName) {
					$contextItem = $this->getApplication()->getContext()->getItem();
					
					if ($this->_hasVersionInLanguage($contextItem, $culture)) {
						$this->_setContextCulture($culture, $persistent);
						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Set the culture context.
	 * 
	 * @return void
	 */
	protected function _setContextCulture(Cream_Globalization_Culture $culture, $persistent = false)
	{
		$this->getApplication()->getContext()->setCulture($culture);
		
		if ($persistent) {
			
		}
	}
	
	protected function _hasVersionInLanguage(Cream_Content_Item $item, Cream_Globalization_Culture $culture)
	{	
		$repository = $item->getRepository();
		$languageItem = $repository->getItem($item->getItemId(), $culture);
		
		if ($languageItem) {
			return true;
		}

		return false;
	}
}