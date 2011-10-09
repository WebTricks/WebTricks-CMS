WebTricks.Shell.Applications.ContentManager.Dialogs.ShowValidationResult = function(config)
{	    
    this.editor = new Ext.ux.TinyMCE({
    	xtype: 'tinymce',
    	tinymceSettings: config.htmlEditor
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
  
    this.items = [this.editor];
    this.buttons = [this.cancelButton, this.okButton];
    
    WebTricks.Shell.Applications.ContentManager.Dialogs.ShowValidationResult.superclass.constructor.call(this, config);    
};

Ext.extend(WebTricks.Shell.Applications.ContentManager.Dialogs.ShowValidationResult, WebTricks.Shell.Applications.Dialogs.Dialog,
{
	
});