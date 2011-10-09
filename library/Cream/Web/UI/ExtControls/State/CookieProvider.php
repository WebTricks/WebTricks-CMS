<?php
/**
 * WebTricks - PHP Framework
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
 * The default Provider implementation which saves state via cookies. 
 * 
 * @package		Cream_Web_UI_ExtControls_State
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_State_CookieProvider extends Cream_Web_UI_ExtControls_State_Provider 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_State_CookieProvider
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
		
	/**
	 * Initialize function
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.state.CookieProvider');
	}
	
	/**
	 * The path for which the cookie is active (defaults to root '/' which 
	 * makes it active for all pages in the site)
	 *
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->setAttribute('path', $path);
	}

	/**
	 * The cookie expiration date (defaults to 7 days from now)
	 *
	 * @param date $expires
	 */
	public function setExpires($expires)
	{
		$this->setAttribute('expires', $expires);
	}

	/**
	 * The domain to save the cookie for. Note that you cannot specify a 
	 * different domain than your page is on, but you can specify a sub-domain,
	 * or simply the domain itself like 'extjs.com' to include all sub-domains 
	 * if you need to access cookies across different sub-domains (defaults to 
	 * null which uses the same domain the page is running on including the 
	 * 'www' like 'www.extjs.com')
	 *
	 * @param string $domain
	 */
	public function setDomain($domain)
	{
		$this->setAttribute('domain', $domain);
	}

	/**
	 * True if the site is using SSL (defaults to false)
	 *
	 * @param boolean $secure
	 */
	public function setSecure($secure)
	{
		$this->setAttribute('secure', $secure);
	}
}