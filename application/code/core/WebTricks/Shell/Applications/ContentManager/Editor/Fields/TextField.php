<?php

class WebTricks_Shell_Applications_ContentManager_Editor_Fields_TextField extends WebTricks_Shell_Applications_ContentManager_Editor_Fields_Abstract
{
	protected function _getExtControl()
	{
		$control = Cream_Web_UI_ExtControls_Form_TextField::instance();
		$control->setValue($this->_getFieldValue());
		return $control;
	}
}