WebTricks.Shell.Applications.WebEdit.Dialogs.LockedItems = function(config)
{	    
    this.grid = new Ext.grid.GridPanel({
    	columns: {
    		
    	}
    });
    
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
  
    this.items = [this.grid];
    this.buttons = [this.cancelButton, this.okButton];
    
    WebTricks.Shell.Applications.WebEdit.Dialogs.LockedItems.superclass.constructor.call(this, config);    
};

Ext.extend(WebTricks.Shell.Applications.WebEdit.Dialogs.LockedItems, WebTricks.Shell.Applications.Dialogs.Dialog,
{
	
});