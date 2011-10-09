
WebTricks.Shell.Applications.ContentManager.Dialogs.EditHtml = function(config)
{	
    WebTricks.Shell.Applications.ContentManager.Dialogs.EditHtml.superclass.constructor.call(this, config);
    
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
};

Ext.extend(WebTricks.Shell.Applications.ContentManager.Dialogs.EditHtml, WebTricks.Shell.Applications.Dialogs.Dialog,
{
	
});