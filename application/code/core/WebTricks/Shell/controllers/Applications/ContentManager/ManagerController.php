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
 * Controller handeling the content manager
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_ContentManager_ManagerController extends WebTricks_Shell_Controller_CommandAction implements WebTricks_Shell_Commands_MessageHandlerInterface
{
	public function loadItem($message)
	{	
		$disableHistory = $message->getDisableHistory();

		$item = $this->_getItem($message);
		
		if (!$disableHistory) {
			$session = WebTricks_Shell_Session::singleton();
			$session->getHistory()->add($item->getItemUri());
		}		

		$template = $item->getTemplate();

		$folder = Cream_Web_UI_ExtControls_Panel::instance();
		$folder->setIconCls('icon-folder');
		$folder->setTitle('Folder');
		
		$panels = array();
		
		$editor = WebTricks_Shell_Applications_ContentManager_Editor::instance($this);
		$editor->setItem($item);

		$builder = Cream_Web_UI_ExtControls_Panel::instance();
		$builder->setIconCls('icon-component');
		$builder->setTitle('Builder');

		$inherentence = Cream_Web_UI_ExtControls_Panel::instance();
		$inherentence->setIconCls('icon-components');
		$inherentence->setTitle('Inheritence');
		
		//$items[] = $folder;
		$items['editor'][] = $editor->getEditor();
		$items['editor'][] = $builder;
		$items['editor'][] = $inherentence;
		
		$ribbonItemId = $this->_getApplication()->getContext()->getRepository()->getDataManager()->resolvePath('WebTricks/content/Applications/Content Editor/Ribbons/Ribbons/Default');
		$ribbonItem = $this->_getApplication()->getContext()->getRepository()->getItem($ribbonItemId);
		
		$context = $this->_getCommandContext();
		$context->clearItems();
		$context->addItem($item);
		
		$ribbon = WebTricks_Shell_Toolbar_Ribbon::instance();
		$ribbon->setCommandContext($context);
		
		WebTricks_Shell_Client_Response::setControl('toolbar', $ribbon->getExtControl($ribbonItem));
		WebTricks_Shell_Client_Response::setControl('workspace', $items['editor']);
	}
	
	public function saveItem(WebTricks_Shell_Commands_Message $message)
	{
		
		$item = $this->_getItem($message);
		$item->getEditing()->startEdit();
		$item->getFields()->readAll();
		
		$fields = $item->getFields()->getFields();
		
		foreach($fields as $field) {
			$field->setValue($message['values']['editor_'. $field->getFieldId()]);
		}
				
		$item->getEditing()->endEdit();
	}
	
	public function handleMessage(WebTricks_Shell_Commands_CommandContext $context)
	{	
		switch ($context->getMessage()->getMessage()) {
			case 'item:load':
				$this->loadItem($context->getMessage());
				break;
			case 'item:save':
				$this->saveItem($context->getMessage());
				break;
		}
						
		$this->_dispatchCommand($context);
	}
	
	/**
	 * Gets the item from the message
	 * 
	 * @param WebTricks_Shell_Commands_Message $message
	 * @throws Cream_Exceptions_ItemNotFoundException
	 * @return Cream_Content_Item
	 */
	protected function _getItem(WebTricks_Shell_Commands_Message $message)
	{
		$itemId = Cream_Guid::parseGuid($message->getItemId());
		$culture = Cream_Globalization_Culture::instance($message->getCulture());
		$version = Cream_Content_Version::instance($message->getVersion());

		$repository = $this->_getApplication()->getContext()->getContentRepository();
		$item = $repository->getItem($itemId, $culture, $version);
		
		if (!$item) {
			throw new Cream_Exceptions_ItemNotFoundException();		
		}
		
		WebTricks_Shell_Client_Response::setParameter('__itemId', (string) $itemId);
		WebTricks_Shell_Client_Response::setParameter('__culture', (string) $item->getCulture()); 
		WebTricks_Shell_Client_Response::setParameter('__version', (string) $item->getVersion());
		
		return $item;
	}
}