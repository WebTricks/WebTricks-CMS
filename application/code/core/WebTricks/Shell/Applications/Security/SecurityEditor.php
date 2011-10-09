<?php

class WebTricks_Shell_Applications_Security_SecurityEditor extends WebTricks_Shell_Applications_ContentManager_Abstract
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Applications_Security_SecurityEditor
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

	public function getConfig()
	{
		return array(
			'id' => (string) $this->getApplicationItem()->getItemId(),
			'toolbar' => $this->_getToolbar(),
			'workspace' => $this->_getTreeGridPanel(),
			'windowConfig' => $this->_getWindowConfig()
		);
	}
	
	protected function _getTreeGridPanel()
	{
		$gridPanel = WebTricks_Shell_Web_UI_ExtControls_Tree_TreeGridPanel::instance();
		$gridPanel->setRegion('center');
		$gridPanel->setStore($this->_getStore());
		$gridPanel->setColumns($this->_getGridColumns());
		$gridPanel->setWidth('100%');
		$gridPanel->setRootVisible(true);
		$gridPanel->setView($this->_getGridView());
		$gridPanel->setDataUrl('/index.php/webtricks/applications_contentManager_tree/children');

		return $gridPanel;
	}
	
	protected function _getGridView()
	{
		$view = Cream_Web_UI_ExtControls_Grid_GridView::instance();
		$view->setForceFit(true);
		
		return $view;
	}
	
	protected function _getStore()
	{
		$url = Cream_Url::instance();	
		
		$reader = Cream_Web_UI_ExtControls_Data_JsonReader::instance();
		$reader->setFields(array('userId', 'domain', 'email', 'isApproved', 'isLocked', 'createDate'));
		$reader->setRoot('data');
		$reader->setIdProperty('email');
		$reader->setSuccessProperty('success');
		
		$store = Cream_Web_UI_ExtControls_Data_Store::instance();
		$store->setUrl($url->getUrl('*/applications_security_usermanager/data'));
		$store->setReader($reader);
		$store->setAutoLoad(true);
		
		return $store;
	}
	
	protected function _getGridColumns()
	{
		$email = WebTricks_Shell_Web_UI_ExtControls_Tree_Column::instance();
		$email->setHeader(Cream_Globalization_Translate::text('E-mail'));
		$email->setDataIndex('email');
		$email->setSortable(true);
		$email->setWidth('35%');
		
		$domain = WebTricks_Shell_Web_UI_ExtControls_Tree_Column::instance();
		$domain->setHeader(Cream_Globalization_Translate::text('Domain'));
		$domain->setDataIndex('domain');
		$domain->setSortable(true);
		$domain->setWidth('25%');
				
		$isApproved = WebTricks_Shell_Web_UI_ExtControls_Tree_Column::instance();
		$isApproved->setHeader(Cream_Globalization_Translate::text('Is approved'));
		$isApproved->setDataIndex('isApproved');
		$isApproved->setSortable(true);
		$isApproved->setWidth('20%');		
		
		$isLocked = WebTricks_Shell_Web_UI_ExtControls_Tree_Column::instance();
		$isLocked->setHeader(Cream_Globalization_Translate::text('Is locked'));
		$isLocked->setDataIndex('isLocked');
		$isLocked->setSortable(true);
		$isLocked->setWidth('20%');		
		
		$createDate = WebTricks_Shell_Web_UI_ExtControls_Tree_Column::instance();
		$createDate->setHeader(Cream_Globalization_Translate::text('Create date'));
		$createDate->setDataIndex('createDate');
		$createDate->setSortable(true);
		$createDate->setWidth('20%');		
				
		//$columns = Cream_Web_UI_ExtControls_Grid_ColumnModel::instance();
		//$columns->setColumns(array($selection, $email, $domain, $isApproved, $isLocked, $createDate));
				
		return array($email, $domain, $isApproved, $isLocked, $createDate);
	}
}