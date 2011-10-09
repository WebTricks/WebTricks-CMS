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
 * Webedit
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_Webedit extends Cream_ApplicationComponent
{
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function getWebedit()
	{
		return $this->_getViewport();
	}
	
	protected function _getViewport()
	{
		$viewport = Cream_Web_UI_ExtControls_Viewport::instance();
		$viewport->setItems($this->_getPanel());
		$viewport->setLayout('border');
		
		return $viewport;
	}
	
	protected function _getPanel()
	{
		$panel = Cream_Web_UI_ExtControls_Panel::instance();
		$panel->setItems($this->_getIframe());
		$panel->setMargins('5 5 5 5');
		$panel->setRegion('center');
		$panel->setLayout('fit');
		$panel->setBorder(false);
		$panel->setTbar($this->_getToolbar());
				
		return $panel;
	}
	
	protected function _getIframe()
	{
		$panel = WebTricks_Shell_Web_UI_ExtControls_Iframe::instance();
		$panel->setUrl('http://www.yahoo.com/');
		$panel->setLayout('fit');
		
		return $panel;
	}
	
	protected function _getToolbar()
	{
		$itemId = $this->getApplication()->getRepository('core')->getDataManager()->resolvePath('WebTricks/content/Applications/WebEdit/Ribbons/Preview');
		$item = $this->getApplication()->getRepository('core')->getItem($itemId);

		$ribbon = WebTricks_Shell_Toolbar_Ribbon::instance();
		return $ribbon->getExtControl($item);
	}
}