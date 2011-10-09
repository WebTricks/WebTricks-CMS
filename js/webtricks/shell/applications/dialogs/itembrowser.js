
WebTricks.Shell.Applications.Dialogs.ItemBrowser = function(config)
{	
    this.input = new Ext.form.TextField({
		readOnly: true,
		fieldLabel: 'Name',
		width: 331
	});
    
    this.tree = new WebTricks.Shell.Applications.ContentManager.Tree({
		rootVisible: false,
		contextmenu: false,
		height: 210,
	    rootId: config.rootId,
    	typeIds: config.typeIds		
	});			
	
	this.tree.on('click', function(node) {
		this.input.setValue(node.getPath('text'));
	}, this);
	
	this.headerPanel = new Ext.Panel({
		border: false,
		html: '<div class="header-panel-icon icon-large-folder-out"></div><b>Item Browser</b><br/>Select an item'
	});	
	
	this.formPanel = new Ext.form.FormPanel({
		items: [this.input],
		border: false,
		labelWidth: 40,
		style: 'margin-top: 5px;'
	});
	
	this.contentPanel = new Ext.Panel({
		items: [this.headerPanel, this.tree, this.formPanel],
		padding: 5
	});			
    
    this.okButton = new Ext.Button({
    	text: 'Ok'
    });
    
    this.okButton.on('click', function() {
    	if (this.input.getValue()) {
    		if (this.sender) {
    			this.sender.setValue(this.input.getValue());
    		}
        	this.close();    		
    	} else {
			Ext.Msg.alert('No item selected', 'No item selected, please select an item.');
    	}
    }, this);
    
    	
    this.cancelButton = new Ext.Button({
    	text: 'Cancel'
    });
    
    this.cancelButton.on('click', function() {
    	this.close();
    }, this);
  
    this.title = 'Item Browser',
    this.items = [this.contentPanel];
    this.buttons = [this.cancelButton, this.okButton];

    WebTricks.Shell.Applications.Dialogs.ItemBrowser.superclass.constructor.call(this, config);
    
    
};

Ext.extend(WebTricks.Shell.Applications.Dialogs.ItemBrowser, WebTricks.Shell.Applications.Dialogs.Dialog,
{
	
});