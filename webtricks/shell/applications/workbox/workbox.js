WebTricks.Applications.Workbox.Workbox = function(config) {
	
	if(!config) {
		config = {};
	}
	
	this.workFlowStateId = config.workFlowStateId;
	this.workFlowStateName = config.workFlowStateName;
	this.workFlowStateIcon = config.workFlowStateIcon;
	this.pageSize = config.pageSize;
		
	this.publish = new Ext.Button ({
		iconCls: 'icon-earth',
		text: 'Publiceren'		
	});
	
	this.actionButtonGroup = new Ext.ButtonGroup ({
		items: [this.publish]
	});
	
	this.buttonToolbar = new Ext.Toolbar ({
		items: [this.actionButtonGroup]
	});
	
	this.selectionModel = new Ext.grid.CheckboxSelectionModel();
	
	this.gridView =	new Ext.grid.GridView({
		forceFit: true,
		emptyText: "Geen rijen gevonden."
	});
	
	this.reader = new Ext.data.JsonReader({
		totalProperty: 'totalcount',
		root: 'items'
	});

	this.store = new Ext.data.Store({
		url: '/json/content/workbox/getStateItems/?stateId='+ this.workFlowStateId,
		autoload: true,
		reader: this.reader,
		remoteSort: true
	});
	
	this.pagingToolbar = new Ext.PagingToolbar({
		store: this.store,
		pageSize: this.pageSize,
		displayInfo: true,
		displayMsg: 'Displaying {0} - {1} of {2}',
		emptyMsg: 'Geen resultaten gevonden.'
	});
	
	this.pageName = new Ext.grid.Column ({
		header: 'Naam',
		dataIndex: 'name',
		sortable: true
	});
	
	this.editText = new Ext.grid.Column ({
		header: 'Commentaar',
		dataIndex: 'comment',
		sortable: true
	});
	
	this.language = new Ext.grid.Column ({
		header: 'Taal',
		dataIndex: 'language',
		sortable: true
	});

	this.title = this.workFlowStateName;
	this.iconCls = this.workFlowStateIcon;
	this.border = false;
	this.columns = [this.selectionModel,this.pageName,this.editText,this.language];
	this.selModel = this.selectionModel;
	this.loadMask = true;
	this.view = this.gridView;
	this.store = this.store;
	this.tbar = this.buttonToolbar;
	this.bbar = this.pagingToolbar;
	this.layout = 'fit';
	
	this.store.load();
	
	Framework.Ext.Content.Workbox.superclass.constructor.call(this, config);
		
}

Ext.extend(Framework.Ext.Content.Workbox, Ext.grid.GridPanel,{

		
});