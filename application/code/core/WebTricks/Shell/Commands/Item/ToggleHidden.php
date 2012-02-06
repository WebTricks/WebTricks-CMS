<?php

class WebTricks_Shell_Commands_Item_ToggleHidden extends WebTricks_Shell_Commands_Command
{	
	public function execute(WebTricks_Shell_Commands_CommandContext $context)
	{
		if ($context->hasItems()) {
			$item = $context->getItem();
			
			$item->getEditing()->startEdit();
			$item->getAppearance()->setHidden(!$item->getAppearance()->isHidden());
			$item->getEditing()->endEdit();
		}		
	} 
	
	public function getHeader(WebTricks_Shell_Commands_CommandContext $context, $header)
	{
		if ($context->hasItems()) {
			if ($context->getItem()->getAppearance()->isHidden()) {
				return Cream_Globalization_Translate::text('Make visible');
			} else {
				return Cream_Globalization_Translate::text('Hide item');
			}
		} else {
			return parent::getHeader($context, $header);
		}	
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
		
		if ($item->getAppearance()->isReadOnly()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if (!$item->getAccess()->canWrite()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		
		if (!$item->getLocking()->canLock() && !$item->getLocking()->hasLock()) {
			return WebTricks_Shell_Commands_CommandState::DISABLED;
		}
		return parent::queryState($context);
	}
}