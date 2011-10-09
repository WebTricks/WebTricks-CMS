WebTricks.Shell.Applications.Security.SelectAccount = function(config)
{	    
	this.rolesStore = new Ext.data.Store({
	    url: '/index.php/webtricks/applications_security_selectaccount/roles',
	    reader: new Ext.data.JsonReader({
		    root: 'data',
		    successProperty: 'success',
		    idProperty: 'name',
		    fields: ['name', 'icon']   	
	    }),
	    autoLoad: true
	});
	
    this.roles = new Ext.list.ListView({
    	store: this.accountsStore,
    	multiSelect: false,
    	columns: [{
    		'header': 'Name',
    		'dataIndex': 'name',
    		'tpl': '<img src="'+ Ext.BLANK_IMAGE_URL +'" class="{icon}" height="16" width="16" />  {name}'
    	}],
    	border: true
    });
    
	this.usersStore = new Ext.data.Store({
	    url: '/index.php/webtricks/applications_security_selectaccount/users',
	    reader: new Ext.data.JsonReader({
		    root: 'data',
		    successProperty: 'success',
		    idProperty: 'name',
		    fields: ['name', 'icon']   	
	    }),
	    autoLoad: true
	});
	
    this.users = new Ext.list.ListView({
    	store: this.accountsStore,
    	multiSelect: false,
    	columns: [{
    		'header': 'Name',
    		'dataIndex': 'name',
    		'tpl': '<img src="'+ Ext.BLANK_IMAGE_URL +'" class="{icon}" height="16" width="16" />  {name}'
    	}],
    	border: true
    });    
    
    this.tabPanel = new Ext.TabPanel({
    	
    });
    
    this.tabPanel.add(this.users);
    this.tabPanel.add(this.roles);
    
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
  
    this.items = [this.tabPanel];
    this.buttons = [this.cancelButton, this.okButton];
    
    WebTricks.Shell.Applications.Security.SelectAccount.superclass.constructor.call(this, config);    
};

Ext.extend(WebTricks.Shell.Applications.Security.SelectAccount, WebTricks.Shell.Applications.Dialogs.Dialog,
{
	
});