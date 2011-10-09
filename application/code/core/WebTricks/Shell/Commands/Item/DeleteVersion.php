<?php

class WebTricks_Shell_Commands_Item_DeleteVersion extends WebTricks_Shell_Commands_Command
{	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		
	} 
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{				
		if (!$context->hasItems()) {
			return WebTricks_Shell_Commands_CommandState::HIDDEN;
		}
		
		$item = $context->getItem();
		
		if ($item->getTemplateId() == Cream_Application_TemplateIds::getTemplateId() || 
			$item->getTemplateId() == Cream_Application_TemplateIds::getTemplateSectionId() || 
			$item->getTemplateId() == Cream_Application_TemplateIds::getTemplateFieldId()) {
		
			return WebTricks_Shell_Commands_CommandState::HIDDEN;
		}
		
		$versions = $item->getVersions()->getVersionNumbers();
		
		if (!count($versions)) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;			
		}
		
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