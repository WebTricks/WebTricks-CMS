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
 * Base webtricks shell controller
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class WebTricks_Shell_Controller_CommandAction extends WebTricks_Shell_Controller_Action
{
	public function dispatchAction()
	{
		$params = Cream_Json::decode($this->getRequest()->get('params'));
		
		try {
			$command = $params['__command'];
			$dispatchCommand = WebTricks_Shell_Commands_CommandProvider::getDispatchCommand($this, $command);
			if ($dispatchCommand) {
				$commandContext = $this->_getCommandContext();
				$commandContext->setMessage($dispatchCommand->getMessage());
				
				$dispatchCommand->execute($commandContext);
			}
		} catch (Exception $e) {
			WebTricks_Shell_Client_Response::alert($e->getMessage());
		}
		
		$this->getResponse()->setBody(Cream_Json::encode(WebTricks_Shell_Client_Response::toJson()));
	}	
	
	protected function _dispatchCommand(WebTricks_Shell_Commands_CommandContext $context)
	{	
		$commandName = $context->getMessage()->getMessage();
		$command = WebTricks_Shell_Commands_CommandProvider::getCommand($commandName);
		
		if ($command) {
			$command->execute($context);
		}
	}
	
	protected function _getCommandContext()
	{
		$commandContext = WebTricks_Shell_Commands_CommandContext::instance();
		$params = Cream_Json::decode($this->getRequest()->get('params'));
		
		if (isset($params['__result'])) {
			$commandContext->setResult($params['__result']);
		}
		
		if (isset($params['__value'])) {
			$commandContext->setValue($params['__value']);
		}		
		
		if (isset($params['__itemId'])) {
			$itemIds = $params['__itemId'];
			if (!is_array($itemIds)) {
				$itemIds = array($itemIds);
			}
					
			foreach($itemIds as $itemId) {
				$itemId = Cream_Guid::parseGuid($itemId);
				$item = $this->_getApplication()->getContext()->getContentRepository()->getItem($itemId);
				$commandContext->addItem($item);
			}
		}
		
		return $commandContext;
	}
}