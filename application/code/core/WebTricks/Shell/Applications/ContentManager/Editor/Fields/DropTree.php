<?php

class WebTricks_Shell_Applications_ContentManager_Editor_Fields_DropTree extends WebTricks_Shell_Applications_ContentManager_Editor_Fields_Abstract
{
	/**
	 * Returns the Ext JS control for this field
	 * 
	 * @return Cream_Web_UI_ExtControl
	 */
	protected function _getExtControl()
	{
		$control = WebTricks_Shell_Web_UI_ExtControls_Form_ComboTree::instance();
		if ($this->_getFieldValue()) {
			
			$itemId = Cream_Guid::parseGuid($this->_getFieldValue());
	
			if ($itemId) {
				$linkedItem = $this->_item->getRepository()->getItem($itemId);
				
				if ($linkedItem) {
					$path = $linkedItem->getPaths()->getPath();
			
					$control->setValue($path);
					$control->setNodeId($this->_getFieldValue());
				}
			}
		}
		return $control;		
	}
}