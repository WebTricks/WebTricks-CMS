<?php

class WebTricks_Shell_Applications_Security_DomainManager extends WebTricks_Shell_Applications_ContentManager_Abstract
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
		$gridPanel->setView($this->_getGridView());
		
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
		$reader->setFields(array('name', 'description'));
		$reader->setRoot('data');
		$reader->setIdProperty('name');
		$reader->setSuccessProperty('success');
		
		$store = Cream_Web_UI_ExtControls_Data_Store::instance();
		$store->setUrl($url->getUrl('*/applications_security_domainmanager/data'));
		$store->setReader($reader);
		$store->setAutoLoad(true);
		$store->setRemoteSort(false);
		
		return $store;
	}
	
	protected function _getGridColumns()
	{
		$selection = Cream_Web_UI_ExtControls_Grid_CheckboxSelectionModel::instance();
		
		$name = Cream_Web_UI_ExtControls_Grid_Column::instance();
		$name->setHeader(Cream_Globalization_Translate::text('Domain'));
		$name->setDataIndex('name');
		$name->setSortable(true);
		$name->setWidth('35');
		
		$description = Cream_Web_UI_ExtControls_Grid_Column::instance();
		$description ->setHeader(Cream_Globalization_Translate::text('Description'));
		$description ->setDataIndex('description');
		$description ->setSortable(true);
		$description ->setWidth('65');
								
		$columns = Cream_Web_UI_ExtControls_Grid_ColumnModel::instance();
		$columns->setColumns(array($selection, $name, $description));
				
		return $columns;
	}
	
	protected function _getGridSelectionModel()
	{
		$selection = Cream_Web_UI_ExtControls_Grid_CheckboxSelectionModel::instance();

		return $selection;
	}
}