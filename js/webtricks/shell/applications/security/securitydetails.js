WebTricks.Shell.Applications.Security.SecurityDetails = function(config)
{	
    this.okButton = new Ext.Button({
    	text: 'Ok'
    });
    
    this.okButton.on('click', function() {
		if (this.sender) {
			this.sender.setValue(this.input.getValue());
		}
    	this.close();    		
    }, this);
    
    	
    this.cancelButton = new Ext.Button({
    	text: 'Cancel'
    });
    
    this.cancelButton.on('click', function() {
    	this.close();
    }, this);
    
    this.addButton = new Ext.Button({
    	text: 'Add'
    });
    
    this.addButton.on('click', function() {
    	var dialog = new WebTricks.Shell.Applications.Security.SelectAccount();
    	dialog.show();
    }, this);	

    this.deleteButton = new Ext.Button({
    	text: 'Delete'
    });
    
    this.deleteButton.on('click', function() {
    	this.close();
    }, this);	    
	
	this.accountsStore = new Ext.data.Store({
	    url: '/index.php/webtricks/applications_security_securitydetails/accounts',
	    reader: new Ext.data.JsonReader({
		    root: 'data',
		    successProperty: 'success',
		    idProperty: 'name',
		    fields: ['name', 'icon']   	
	    }),
	    autoLoad: true
	});
	
    this.accounts = new Ext.grid.GridPanel({
    	title: 'Accounts',
    	hideHeaders: true,
    	flex: 1,
    	store: this.accountsStore,
    	viewConfig: {
    		forceFit: true
    	},
    	columns: [{
    		'header': 'Name',
    		'dataIndex': 'name',
    		'tpl': '<img src="'+ Ext.BLANK_IMAGE_URL +'" class="{icon}" height="16" width="16" />  {name}'
    	}],
    	sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
    	buttons: [this.addButton, this.deleteButton]
    });
    
    this.accounts.on('rowclick', function(grid, rowNumber) {
    	var record = this.accounts.getSelectionModel().getSelected();
    	alert(record.data.name);
    	
    	this.rightsStore.load();
    }, this);
    
	this.rightsStore = new Ext.data.Store({
	    url: '/index.php/webtricks/applications_security_securitydetails/rights',
	    reader: new Ext.data.JsonReader({
		    root: 'data',
		    successProperty: 'success',
		    idProperty: 'name',
		    fields: ['name', 'icon']   	
	    })   
	});   
	
	this.rightsStore.on('load', function(store, records, options){
		if (this.rights) {
			this.rights.setSource(store.getAt(0).data);
		} 
	}, this);
    
    this.rights = new Ext.grid.PropertyGrid({
    	title: 'Access rights',
    	flex: 1,
    	store: this.rightsStore
    });
    
    this.panel = new Ext.Panel({
    	layout: 'vbox', 
    	layoutConfig: {
    		align:'stretch'
        },
        border: false,
    	items: [this.accounts, this.rights]
    });
  
    this.items = [this.panel];
    this.layout = 'fit';
    this.buttons = [this.cancelButton, this.okButton];
    
    WebTricks.Shell.Applications.Security.SecurityDetails.superclass.constructor.call(this, config);    
};

Ext.extend(WebTricks.Shell.Applications.Security.SecurityDetails, WebTricks.Shell.Applications.Dialogs.Dialog,
{
	
});