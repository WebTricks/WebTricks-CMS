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
 * @copyright Copyright (c) 2007-2012 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Command class for moving down an item.
 *
 * @package		WebTricks_Shell
 * @author		WebTicks Core Team <core@webtricksframework.com>
 */
class WebTricks_Shell_Commands_Item_MoveDown extends WebTricks_Shell_Commands_Command
{	
	/**
	 * Execute the command.
	 *
	 * @see WebTricks_Shell_Commands_Command::execute()
	 */	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		$sorting = WebTricks_Shell_Framework_Sorting::instance();
		
		if ($context->hasItems()) {
			foreach($context->getItems() as $item) {
				$sorting->moveDown($item);
				WebTricks_Shell_Client_Response::refresh((string) $item->getParent()->getItemId());
			}
		}
	}
	
	/**
	 * Determine the state of the command.
	 *
	 * @see WebTricks_Shell_Commands_Command::queryState()
	 */	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{		
		if (!$context->hasItems()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		$item = $context->getItem();
		
		if ($item->getAppearance()->isReadOnly()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if (!$item->getAccess()->canWrite()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if ($item->getLocking()->isLocked() && !$item->getLocking()->hasLock()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		return parent::queryState($context);
	}
}