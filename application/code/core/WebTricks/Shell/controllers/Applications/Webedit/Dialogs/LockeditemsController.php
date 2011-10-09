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

class WebTricks_Shell_Applications_Webedit_Dialogs_LockeditemsController extends WebTricks_Shell_Controller_CommandAction
{
	/**
	 * Retrieves the data of the locked items.
	 *
	 * @return void
	 */
	public function dataAction()
	{
		$data = array();
		$itemsData = array();
		$items = array();

		/* @var $item Cream_Content_Item */
		foreach ($items as $item) {
			$itemData = array(
				'name' => $item->getName(),
				'path' => $item->getPaths()->getPath(),
				'culture' => $item->getCulture(),
				'version' => $item->getVersion()
			);
			
			$itemsData[] = $itemData;
		}
		
		$data['data'] = $itemsData;
		$data['success'] = true;
		
		$this->getResponse()->setBody(Cream_Json::encode($data));		
	}
}