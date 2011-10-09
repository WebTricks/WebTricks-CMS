<?php

class WebTricks_Shell_Applications_Security_RoleManager extends WebTricks_Shell_Applications_ContentManager_Abstract
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Applications_ContentManager_Folder
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
			'workspace' => $this->_getGridPanel(),
			'windowConfig' => $this->_getWindowConfig()
		);
	}
	
	protected function _getGridPanel()
	{
		$gridPanel = Cream_Web_UI_ExtControls_Grid_GridPanel::instance();
		$gridPanel->setRegion('center');
		$gridPanel->setStore($this->_getStore());
		$gridPanel->setColModel($this->_getGridColumns());
		$gridPanel->setWidth('100%');
		$gridPanel->setSelModel($this->_getGridSelectionModel());
		
		return $gridPanel;
	}
	
	protected function _getStore()
	{
		$url = Cream_Url::instance();	
		
		$reader = Cream_Web_UI_ExtControls_Data_JsonReader::instance();
		$reader->setFields(array('userId', 'domain', 'email', 'isApproved', 'isLocked', 'createDate'));
		$reader->setRoot('data');
		$reader->setIdProperty('email');
		$reader->setSuccessProperty('success');
		
		$store = Cream_Web_UI_ExtControls_Data_JsonStore::instance();
		$store->setUrl($url->getUrl('*/applications_security_rolemanager/data'));
		$store->setReader($reader);
		$store->setAutoLoad(true);
		
		return $store;
	}
	
	protected function _getGridColumns()
	{		
		$email = Cream_Web_UI_ExtControls_Grid_Column::instance();
		$email->setHeader(Cream_Globalization_Translate::text('E-mail'));
		$email->setDataIndex('email');
		$email->setSortable(true);
		$email->setWidth('35%');
		
		$domain = Cream_Web_UI_ExtControls_Grid_Column::instance();
		$domain->setHeader(Cream_Globalization_Translate::text('Domain'));
		$domain->setDataIndex('domain');
		$domain->setSortable(true);
		$domain->setWidth('25%');
				
		$isApproved = Cream_Web_UI_ExtControls_Grid_BooleanColumn::instance();
		$isApproved->setHeader(Cream_Globalization_Translate::text('Is approved'));
		$isApproved->setDataIndex('isApproved');
		$isApproved->setSortable(true);
		$isApproved->setWidth('20%');		
		
		$isLocked = Cream_Web_UI_ExtControls_Grid_BooleanColumn::instance();
		$isLocked->setHeader(Cream_Globalization_Translate::text('Is locked'));
		$isLocked->setDataIndex('isLocked');
		$isLocked->setSortable(true);
		$isLocked->setWidth('20%');		
		
		$createDate = Cream_Web_UI_ExtControls_Grid_DateColumn::instance();
		$createDate->setHeader(Cream_Globalization_Translate::text('Create date'));
		$createDate->setDataIndex('createDate');
		$createDate->setSortable(true);
		$createDate->setWidth('20%');		
				
		$columns = Cream_Web_UI_ExtControls_Grid_ColumnModel::instance();
		$columns->setColumns(array($email, $domain, $isApproved, $isLocked, $createDate));
				
		return $columns;
	}
	
	protected function _getGridSelectionModel()
	{
		$selection = Cream_Web_UI_ExtControls_Grid_CheckboxSelectionModel::instance();

		return $selection;
	}
}