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
 * Base class for all shell applications
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
abstract class WebTricks_Shell_Applications_Abstract extends Cream_ApplicationComponent
{
	protected $_applicationItem;
	
	public function getApplicationItem()
	{
		return $this->_applicationItem;
	}

	public function setApplicationItem(Cream_Content_Item $item)
	{
		$this->_applicationItem = $item;
	}
	
	abstract public function getConfig();
	
	protected function _getWindowConfig()
	{
		if ($this->getApplicationItem()->get('Disable close')->getValue()) {
			$closable = false;
		} else {
			$closable = true;
		}

		if ($this->getApplicationItem()->get('Disable maximize')->getValue()) {
			$maximizable = false;
		} else {
			$maximizable = true;
		}
		
		if ($this->getApplicationItem()->get('Disable minimize')->getValue()) {
			$minimizable = false;
		} else {
			$minimizable = true;
		}
		
		if ($this->getApplicationItem()->get('Disable resize')->getValue()) {
			$resizable = false;
		} else {
			$resizable = true;
		}
		
		if ($this->getApplicationItem()->get('Window Mode')->getValue() == 'Maximized') {
			$maximized = true;
		} else {
			$maximized = false;
		}
				
		$window = Cream_Web_UI_ExtControls_Window::instance();
		$window->setTitle((string) $this->getApplicationItem()->get('Display name'));
		$window->setIconCls('icon-'. $this->getApplicationItem()->get('Icon'));
		$window->setWidth((string) $this->getApplicationItem()->get('Width'));
		$window->setHeight((string) $this->getApplicationItem()->get('Height'));
		$window->setClosable($closable);
		$window->setResizable($resizable);
		$window->setMaximizable($maximizable);
		$window->setMinimizable($minimizable);
		$window->setMaximized($maximized);
		
		return $window;
	}
}