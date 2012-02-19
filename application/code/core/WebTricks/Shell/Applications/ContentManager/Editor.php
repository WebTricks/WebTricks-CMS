<?php

class WebTricks_Shell_Applications_ContentManager_Editor extends WebTricks_Shell_Applications_ContentManager_Abstract
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Applications_ContentManager_Editor
	 */
	public static function instance($controller)
	{
		return Cream::instance(__CLASS__, $controller);
	}
	
	public function getConfig()
	{
		
	}
	
	public function getEditor()
	{
		$editor = Cream_Web_UI_ExtControls_Form_FormPanel::instance();
		$editor->setIconCls('icon-cube-blue');
		$editor->setTitle('Editor');
		$editor->setAutoScroll(true);
		
		$editor->addItem($this->getHeader());
		$editor->addItem($this->getQuickInfo());
		$editor->addItems($this->getSections());
		
		return $editor;
	}
	
	public function getHeader()
	{
		$template = $this->_controller->getLayout()->createBlock('webcontrol/template');
		$template->setTemplate('shell/applications/contentmanager/editor/header.phtml');
		$template->assign('item', $this->getItem());
		
		$panel = Cream_Web_UI_ExtControls_Panel::instance();
		$panel->setBorder(false);
		$panel->setHtml($template->toHtml());
		
		return $panel;
	}
	
	public function getHeaderWarnings()
	{
		
	}

	public function getQuickInfo()
	{
		$panel = Cream_Web_UI_ExtControls_Panel::instance();
		$panel->setTitle('Quick Info');
		$panel->setIconCls('icon-information');
		$panel->setCollapsible(true);
		$panel->setBorder(false);
		
		$itemId = Cream_Web_UI_ExtControls_Form_DisplayField::instance();
		$itemId->setFieldLabel('Item Id');
		$itemId->setValue((string) $this->getItem()->getItemId());

		$itemName = Cream_Web_UI_ExtControls_Form_DisplayField::instance();
		$itemName->setFieldLabel('Item Id');
		$itemName->setValue($this->getItem()->getItemData()->getItemDefinition()->getName());
		
		$itemPath = Cream_Web_UI_ExtControls_Form_DisplayField::instance();
		$itemPath->setFieldLabel('Item path');
		$itemPath->setValue($this->getItem()->getPaths()->getPath());
		
		$templateItem = $this->getItem()->getRepository()->getItem($this->getItem()->getTemplateId());
		
		$templateId = Cream_Web_UI_ExtControls_Form_DisplayField::instance();
		$templateId->setFieldLabel('Template Id');
		$templateId->setValue($templateItem->getPaths()->getPath() .' - '. $this->getItem()->getTemplateId()->toString());
		
		$panel->setItems(array($itemId, $itemName, $itemPath, $templateId));
		
		return $panel;
	}
	
	
	public function getSections()
	{
		$sections = array();
		
		foreach($this->getItem()->getTemplate()->getSections() as $section) {
			$sections[] = $this->getSection($section);
		}
		
		return $sections;
	}
	
	public function getSection(Cream_Content_Template_Section $section)
	{
		$panel = Cream_Web_UI_ExtControls_Panel::instance();
		$panel->setBorder(false);
		$panel->setIconCls('icon-'. $section->getIcon());
		$panel->setTitle($section->getName());
		$panel->setCollapsible(true);
		$panel->setItems($this->getFields($section));	
		$panel->setLayout('form');

		return $panel;
	}
	
	public function getFields(Cream_Content_Template_Section $section)
	{
		$fields = array();
		
		foreach($section->getFields() as $field) {
			$fields[] = $this->getField($field);
		}
		
		return $fields;
	}
	
	public function getField(Cream_Content_Template_Field $field)
	{
		if ($field->isShared()) {
			$type = '[shared]';
		} elseif ($field->isUnversioned()) {
			$type = '[unversioned]';
		} else {
			$type = '';
		}
		
		$title = $field->getName() .' '. $type .' '. $field->getId();
		
		$fieldControl = WebTricks_Shell_Applications_ContentManager_Editor_Fields_FieldTypeManager::getField($field, $this->getItem());
		$control = $fieldControl->getExtControl();
		
		$container = WebTricks_Shell_Web_UI_ExtControls_ContentManager_Fields_FieldContainer::instance();
		$container->setItems($control);
		$container->setTitle($title);
		
		$item = WebTricks_Shell_Applications_ContentManager_Editor_Fields_FieldTypeManager::getFieldTypeItem($field->getType());
		if ($item && $menuItem = $item->getChildren()->getByName('menu')) {
			$container->setTbar($this->_getMenuButtons($menuItem));	
		}
				
		return $container;
	}
	
	protected function _getMenuButtons(Cream_Content_Item $item)
	{
		$buttons = array();
		
		foreach($item->getChildren() as $child) {
			
			$button = $button = $this->_getMenuButton($child);
			
			if ($button) {
				$buttons[] = $button;
			}
		}
		
		return $buttons;
	}
	
	protected function _getMenuButton(Cream_Content_Item $button)
	{
		$enabled = WebTricks_Shell_Commands_CommandState::ENABLED;
		$click = (string) $button->get('Message');
		
		$command = WebTricks_Shell_Commands_CommandProvider::getCommand($click);
		
		if ($command) {
			$enabled = $command->queryState($this->_commandContext);
		}
		
		if ($enabled != WebTricks_Shell_Commands_CommandState::HIDDEN) {
		
			$buttonControl = Cream_Web_UI_ExtControls_Button::instance();
			$buttonControl->setScale('small');
			$buttonControl->setText((string) $button->get('Display name'));
			$buttonControl->setHandler(Cream_Expression::instance('function() { alert(this.application.getModule(\'16192c38-8337-4895-9364-4d29e78b7b40\').invokeCommand(\''. $click .'\')); }'));
			$buttonControl->setScope(Cream_Expression::instance('this'));
			
			if ($enabled == WebTricks_Shell_Commands_CommandState::DISABLED) {
				$buttonControl->setDisabled(true);
			}
			
			if ($enabled == WebTricks_Shell_Commands_CommandState::DOWN) {
				$buttonControl->setPressed(true);
			}
		
			return $buttonControl;
		}
		
	}
}