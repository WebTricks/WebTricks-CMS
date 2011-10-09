<?php

class Cream_Controller_Request_Resolver_Website extends Cream_Controller_Request_Resolver_Abstract
{
	public function process()
	{
		$site = $this->_resolveSite();

		if ($site) {
			$this->getApplication()->getContext()->setSite($site);
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
		$siteName = $this->getApplication()->getRequest()->getParam('__site');
		
		if ($siteName) {
			$website = Cream_Websites_SiteProvider::getSite($siteName);
		}
		
		return $website;
	}
	
	protected function _resolveFromHost()
	{
		$host = $this->getApplication()->getRequest()->getHttpHost();
		$port = $this->getApplication()->getRequest()->getHttpPort();
		$path = $this->getApplication()->getRequest()->getPathInfo();
		
		$website = Cream_Websites_SiteProvider::getSiteFromHost($host, $port, $path);
		
		return $website;		
	}
}