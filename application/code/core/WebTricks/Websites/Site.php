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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Site class
 *
 * @package		WebTricks_Websites
 * @author		Danny Verkade
 */
class WebTricks_Websites_Site extends Cream_ApplicationComponent
{
	/**
	 * Title to display in the browser
	 * 
	 * @var string
	 */
	protected $_browserTitle;
	
	protected $_contentCulture;
	
	/**
	 * Name of the content repository.
	 *  
	 * @var string
	 */
	protected $_contentRepositoryName;
	
	protected $_cultureName;
	
	protected $_host;
	
	protected $_name;
	
	protected $_path;
	
	protected $_port;
	
	protected $_repositoryName;
	
	protected $_rootPath;
	
	protected $_routerName;
	
	protected $_domain;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return WebTricks_Websites_Site
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Returns the domain of the site.
	 * 
	 * @return Cream_Security_Domains_Domain
	 */
	public function getDomain()
	{
		return $this->_domain;
	}
	
	/**
	 * Sets the domain of the site.
	 * 
	 * @param Cream_Security_Domains_Domain $domain
	 */
	public function setDomain(Cream_Security_Domains_Domain $domain)
	{
		$this->_domain = $domain;
	}
	
	public function getContentRepositoryName()
	{
		return $this->_contentRepositoryName;
	}
	
	public function setContentRepositoryName($contentRepositoryName)
	{
		$this->_contentRepositoryName = $contentRepositoryName;
	}
	
	public function getCultureName()
	{
		return $this->_cultureName;
	}
	
	public function setCultureName($cultureName)
	{
		$this->_cultureName = $cultureName;
	}
	
	public function getHost()
	{
		return $this->_host;
	}
	
	public function setHost($host)
	{
		$this->_host = $host;
	}
	
		
	public function getName()
	{
		return $this->_name;
	}
	
	public function setName($name)
	{
		$this->_name = $name;
	}
	
	public function getPath()
	{
		return $this->_path;
	}
	
	public function setPath($path)
	{
		$this->_path = $path;
	}		
	
	public function getPort()
	{
		return $this->_port;
	}
	
	public function setPort($port)
	{
		$this->_port = $port;
	}

	/**
	 * Returns the repository
	 *
	 * @return Cream_Content_Repository
	 */
	public function getRepository()
	{
		return Cream_Content_Managers_RepositoryProvider::getRepository($this->_repositoryName);
	}
	
	public function getRepositoryName()
	{
		return $this->_repositoryName;
	}
	
	public function setRepositoryName($repositoryName)
	{
		$this->_repositoryName = $repositoryName;
	}
	
	public function getRootPath()
	{
		if ($this->_rootPath) {
			return $this->_rootPath;
		} else {
			return 'webtricks';
		}
	}
	
	public function setRootPath($rootPath)
	{
		$this->_rootPath = $rootPath;
	}

	public function getRouterName()
	{
		return $this->_routerName;
	}
	
	public function setRouterName($routerName)
	{
		$this->_routerName = $routerName;
	}
	
	
	public function matches($host, $port, $path)
	{
		if (!$this->_matchesHost($host)) {
			return false;
		}
		
		if (!$this->_matchesPort($port)) {
			return false;
		}
		
		if (!$this->_matchesPath($path)) {
			return false;
		}	
		
		return true;
	}
	
	protected function _matchesHost($host)
	{
		if (!$this->_host) {
			return true;
		}
		
		$hostnames = explode('|', $this->_host);

		foreach ($hostnames as $hostname) {
			if ($hostname == $host) {
				return true;
			}	
		}
		
		return false;
	}
	
	protected function _matchesPort($port)
	{
		if ($this->_port) {
			if ($this->_port == $port) {
				return true;
			} else {
				return false;
			}
		}
		
		return true;
	}
	
	protected function _matchesPath($path)
	{
		if (!$this->getPath()) {
			return true;	
		}
		
		$length = strlen($this->getPath());
		$substr = substr($path, 0, $length);
		
		if ($substr == $this->getPath()) {
			return true;
		}
		
		return false;
	}
}