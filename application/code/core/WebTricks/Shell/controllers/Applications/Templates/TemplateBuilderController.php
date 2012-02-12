<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Controller handeling of the template builder
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_Templates_TemplateBuilderController extends WebTricks_Shell_Controller_Action
{
	public function indexAction()
	{
		$itemId = Cream_Guid::parseGuid($this->getRequest()->getParam('itemId'));
		
		if ($itemId) {
			$item = Cream_Content_Managers_TemplateProvider::getTemplateById($itemId, $this->_getApplication()->getContext()->getContentRepository()); 
		} else {
			$item = Cream_Content_Template_Item::instance(Cream_Guid::generateGuid());			
		}
	}
	
	public function saveAction()
	{
		
	}	
	
	protected function renderTemplate()
	{
		
	}
	
	protected function renderSection()
	{
		
	}
	
	protected function renderField()
	{
		
	}
		
	protected function saveTemplate()
	{
		
	}
	
	protected function saveSection()
	{
		
	}
	
	protected function saveField()
	{
		
	}
}