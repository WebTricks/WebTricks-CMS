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
 * Controller handeling the content manager editor.
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_ContentManager_FolderController extends WebTricks_Shell_Controller_Action
{
	/**
	 * Folder object
	 * 
	 * @var WebTricks_Shell_Application_ContentManager_Folder
	 */
	protected $_folder;
		
	/**
	 * 
	 * 
	 */
	public function contextMenuAction()
	{
		$contextMenu = $this->getFolder()->getContextMenu();
		
        $this->getResponse()->setBody(Cream_Json::encode($contextMenu));		
	}
	
	public function dataAction()
	{
		$data = array();
		$items = $this->getFolder()->getItems();
		
		foreach($items as $item) {
			array_push($data, array(
				'id' => $item->getItemId()->toString(),
				'text' => $item->getName(),
				'iconCls' => 'icon-'. $item->getAppearance()->getIcon(),
			));						
		}
		
        $this->getResponse()->setBody(Cream_Json::encode($data));		
	}

	/**
	 * Returns the folder object 
	 * 
	 * @return WebTricks_Shell_Application_ContentManager_Folder
	 */
	protected function getFolder()
	{
		if (!$this->_folder) {
			$this->_folder = WebTricks_Shell_Applications_ContentManager_Folder::instance();
		}
		
		return $this->_folder;
	}
}