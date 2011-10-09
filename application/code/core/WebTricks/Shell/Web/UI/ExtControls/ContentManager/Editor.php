<?php

class WebTricks_Shell_Web_UI_ExtControls_ContentManager_Editor extends Cream_Web_UI_ExtControls_Form_FormPanel
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Web_UI_ExtControls_ContentManager_Editor
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);		
	}
	
	/**
	 * Initialize function
	 * 
	 */
	public function __init()
	{
		$this->setControl('WebTricks.Application.ContentManager.Editor');
	}
	
	public function setContentId(Cream_Guid $contentId)
	{
		$this->setAttribute('contentId', $contentId);
	}
	
	public function setTemplateId(Cream_Guid $templateId)
	{
		$this->setAttribute('templateId', $templateId);
	}
	
	public function setHasChildren($hasChildren)
	{
		$this->setAttribute('hasChildren', $hasChildren);
	}
}