<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * The context class represents the context of the current request.
 * 
 * @package		Cream_Application
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Application_Context extends Cream_ApplicationComponent
{
	/**
	 * 
	 * @var Cream_Content_Repository
	 */
	protected $_contentRepository;
	
	/**
	 * Context culture
	 *  
	 * @var Cream_Globalization_Culture
	 */
	protected $_culture;
	
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_device;
	
	/**
	 * 
	 * 
	 * @var Cream_Security_Domains_Domain
	 */
	protected $_domain;
	
	/**
	 * 
	 * 
	 * @var Cream_Content_Item
	 */
	protected $_item;
	
	/**
	 * 
	 * 
	 * @var Cream_Content_Repository
	 */
	protected $_repository;	
	
	/**
	 * 
	 * 
	 * @var WebTricks_Websites_Site
	 */
	protected $_site;
	
	/**
	 *
	 * 
	 * @var Cream_Security_Accounts_User
	 */
	protected $_user;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Application_Context
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Returns the content repository.
	 * 
	 * @return Cream_Content_Repository
	 */
	public function getContentRepository()
	{
		return $this->_contentRepository;
	}
	
	/**
	 * Sets the content repository.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @return void
	 */
	public function setContentRepository(Cream_Content_Repository $repository)
	{
		$this->_contentRepository = $repository;
	}
	
	/**
	 * Returns the context culture.
	 * 
	 * @return Cream_Globalization_Culture
	 */
	public function getCulture()
	{
		if (!$this->_culture) {
			$culture = $this->_getApplication()->getConfig()->getNode(Cream_Controller_Request_Resolver_Culture::CONFIG_DEFAULT_CULTURE_PATH);
			return Cream_Globalization_Culture::instance((string) $culture);			
		}
		
		return $this->_culture;
	}
	
	/**
	 * Set the context culture.
	 *  
	 * @param Cream_Globalization_Culture $culture
	 * @return void
	 */
	public function setCulture(Cream_Globalization_Culture $culture)
	{
		$this->_culture = $culture;
	}
	
	public function getDevice()
	{
		return $this->_device;
	}
	
	public function setDevice($device)
	{
		$this->_device = $device;
	}
	
	public function getDomain()
	{
		if ($this->_domain) {
			return $this->_domain;
		} else {
			return $this->getSite()->getDomain();
		}
	}
	
	public function setDomain(Cream_Security_Domains_Domain $domain)
	{
		$this->_domain = $domain;
	}
	
	/**
	 * Returns the context item.
	 * 
	 * @return Cream_Content_Item
	 */
	public function getItem()
	{
		return $this->_item;
	}
	
	/**
	 * Sets the context item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return void
	 */
	public function setItem(Cream_Content_Item $item)
	{	
		$this->_item = $item;
	}
	
	/**
	 * Returns the current repository to use for fetching content
	 * items. 
	 * 
	 * @return Cream_Content_Repository
	 */
	public function getRepository()
	{
		if ($this->_repository) {
			return $this->_repository;
		} else {
			return $this->getSite()->getRepository();
		}
	}
	
	/**
	 * Set the repository context.
	 * 
	 * @param Cream_Content_Repository $repository
	 */
	public function setRepository(Cream_Content_Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	/**
	 * Returns the website context.
	 * 
	 * @return WebTricks_Websites_Site
	 */
	public function getSite()
	{
		return $this->_site;
	}
	
	/**
	 * Sets the website context.
	 * 
	 * @param WebTricks_Websites_Site $site
	 */
	public function setSite(WebTricks_Websites_Site $site)
	{
		$this->_site = $site;
	}
	
	/**
	 * Returns the current user.
	 * 
	 * @return Cream_Security_Accounts_User
	 */
	public function getUser()
	{
		if ($this->_user) {
			return $this->_user;
		} else {
			return $this->getDomain()->getAnonymousUser();
		}
	}
	
	/**
	 * Sets the current user.
	 * 
	 * @param Cream_Security_Accounts_User $user
	 */
	public function setUser(Cream_Security_Accounts_User $user)
	{
		$this->_user = $user;
	}
}