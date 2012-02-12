<?php

class Cream_Controller_Request_Resolver_Website extends Cream_Controller_Request_Resolver_Abstract
{
	public function process()
	{
		$site = $this->_resolveSite();

		if ($site) {
			$this->_getApplication()->getContext()->setSite($site);
		}
	}
	
	protected function _resolveSite()
	{
		$site = $this->_resolveFromQueryString();
		
		if ($site) {	
			return $site;
		}
		
		$site = $this->_resolveFromHost();
		
		if ($site) {
			return $site;
		}
	}
	
	protected function _resolveFromQueryString()
	{
		$website = null;
		$siteName = $this->_getApplication()->getRequest()->getParam('__site');
		
		if ($siteName) {
			$website = WebTricks_Websites_SiteProvider::getSite($siteName);
		}
		
		return $website;
	}
	
	protected function _resolveFromHost()
	{
		$host = $this->_getApplication()->getRequest()->getHttpHost();
		$port = $this->_getApplication()->getRequest()->getHttpPort();
		$path = $this->_getApplication()->getRequest()->getPathInfo();
		
		$website = WebTricks_Websites_SiteProvider::getSiteFromHost($host, $port, $path);
		
		return $website;		
	}
}