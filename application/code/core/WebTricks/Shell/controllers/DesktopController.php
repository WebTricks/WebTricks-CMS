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
 * Controller for the WebTricks Desktop
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_DesktopController extends WebTricks_Shell_Controller_Action
{
	/**
	 * Runs an application given by the item id submitted.
	 * 
	 */
	public function runAction()
	{
		$itemId = Cream_Guid::parseGuid($this->getRequest()->getParam('itemId'));
		$item = $this->getApplication()->getRepository('core')->getItem($itemId);
		$class = $item->get('Application');
		
		$application = Cream::instance((string) $class);
		$application->setApplicationItem($item);
		
		$config = $application->getConfig();
        $this->getResponse()->setBody(Cream_Json::encode($config));
	}

	/**
	 * Retrieves the shell application config
	 * 
	 */
	public function applicationAction()
	{
		$desktop = WebTricks_Shell_Applications_Desktop::instance();

        $this->getResponse()->setBody('var application = '. Cream_Json::encode($desktop->getDesktop()));				
	}
}