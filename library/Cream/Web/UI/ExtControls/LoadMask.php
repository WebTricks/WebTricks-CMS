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
 * A simple utility class for generically masking elements while loading data. 
 * If the store config option is specified, the masking will be automatically 
 * synchronized with the store's loading process and the mask element will be 
 * cached for reuse. For all other elements, this mask will replace the 
 * element's Updater load indicator and will be destroyed after the initial 
 * load. 
 * 
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_LoadMask extends Cream_Web_UI_ExtControl 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_LoadMask
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
		$this->setControl('Ext.LoadMask');
	}
		
	/**
	 * True to create a single-use mask that is automatically destroyed after
	 * loading (useful for page loads), False to persist the mask element 
	 * reference for multiple uses (e.g., for paged data widgets). Defaults to 
	 * false.
	 *
	 * @param boolean $removeMask
	 */
	public function setRemoveMask($removeMask) 
	{
		$this->setAttribute('removeMask', $removeMask);
	}

	/**
	 * The text to display in a centered loading message box (defaults to 
	 * 'Loading...')
	 *
	 * @param string $msg
	 */
	public function setMsg($msg) 
	{
		$this->setAttribute('msg', $msg);
	}

	/**
	 * The CSS class to apply to the loading message element (defaults to
	 * "x-mask-loading")
	 *
	 * @param string $msgCls
	 */
	public function setMsgCls($msgCls) 
	{
		$this->setAttribute('msgCls', $msgCls);
	}
	
	/**
	 * Store to which the mask is bound. The mask is displayed when a load 
	 * request is issued, and hidden on either load sucess, or load fail.
	 *
	 * @param string $store
	 */
	public function setStore($store) 
	{
		$this->setAttribute('store', $store);
	}	
}