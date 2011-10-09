
WebTricks.Shell.Applications.Dialogs.Dialog = function(config)
{	
    this.modal = true;
    this.height = 350;
    this.width = 450;
    this.bodyBorder = false;
    this.border = false;
    this.layout = 'fit';    
    this.resizable = false;
    this.closable = true;

    WebTricks.Shell.Applications.Dialogs.Dialog.superclass.constructor.call(this, config);
    
    
};

Ext.extend(WebTricks.Shell.Applications.Dialogs.Dialog, Ext.Window,
{
	
});