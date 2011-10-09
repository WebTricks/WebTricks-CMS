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
 * Controller handeling the task manager
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_System_TaskmanagerController extends WebTricks_Shell_Controller_Action
{
	/**
	 * Fetches the data to display in the task manager
	 * 
	 */
	public function dataAction()
	{
		//$input = $this->getRequest()->getParam('application');
		//$repository = $this->getApplication()->getRepository('core');
		//$itemId = $repository->getDataManager()->resolvePath(self::REPOSITORY_PATH_APPLICATION_ROOT .'/'. $input);
		//
		//if ($itemId) {
		//	$this->getResponse()->setBody(Cream_Json::encode(array('itemId' => $itemId->toString())));	
		//}
	}
}