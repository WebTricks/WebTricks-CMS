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
 * Controller handeling the run tool
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_Tool_RunController extends WebTricks_Shell_Controller_Action
{
	/**
	 * Root path where to find the applications

	 * @var string
	 */
	const REPOSITORY_PATH_APPLICATION_ROOT = "webtricks/content/Applications";

	/**
	 * Fetches the item id of the application to run. Returns the id
	 * of the application if it is found, otherwise returns null.
	 * 
	 */
	public function runAction()
	{
		$input = $this->getRequest()->getParam('application');
		$repository = $this->_getApplication()->getRepository('core');
		$itemId = $repository->getDataManager()->resolvePath(self::REPOSITORY_PATH_APPLICATION_ROOT .'/'. $input);
		
		if ($itemId) {
			$this->getResponse()->setBody(Cream_Json::encode(array('itemId' => $itemId->toString())));	
		}
	}
}