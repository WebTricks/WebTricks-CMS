<?php

class WebTricks_Shell_Commands_Item_CompareVersions extends WebTricks_Shell_Commands_Command
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
		
		if (count($versions)) {
			return parent::queryState($context);
		}
		
		return WebTricks_Shell_Commands_CommandState::DISABLED;
	}
}