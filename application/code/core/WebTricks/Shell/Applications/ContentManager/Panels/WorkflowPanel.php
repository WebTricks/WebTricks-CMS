<?php

class WebTricks_Shell_Applications_ContentManager_Panels_WorkflowPanel
{
	public function getExtControl()
	{
		$control = Cream_Web_UI_ExtControls_Form_ComboBox::instance();
		
		return $control;
	}	
}
