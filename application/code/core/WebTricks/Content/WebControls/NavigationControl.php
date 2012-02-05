<?php 

class WebTricks_Content_WebControls_NavigationControl extends Cream_Web_UI_WebControls_TemplateControl
{
	public function getRootItem()
	{
		$siteRoot = $this->_getApplication()->getContext()->getSite()->getRootPath();
		
		$rootItem = $this->_getApplication()->getContext()->getRepository()->getItemByPath($siteRoot);
		
		return $rootItem;
	}
}