
WebTricks.Shell.Applications.Reports.LogViewer = Ext.extend(WebTricks.Shell.Module,
{
	parameters: new Array(),
		
	createWindow : function()
    {
	    var desktop = this.app.getDesktop();
	    var win = desktop.getWindow(this.id);

	    if(!win) {
	    		    		    	
	    	var config = {
	    		id: this.id,
	    		items: [this.workspace]
	    	};

	        win = desktop.createWindow(Ext.apply(config, this.windowConfig.initialConfig));
	    }
	    
	    win.show();
	},
	
	/**
	 * Invokes a command.
	 * 
	 */
	invokeCommand: function(command, resultParams)
	{
		var valueParams = {};
		
		forms = this.workspace.findByType('form');
		Ext.each(forms, function(form) { Ext.applyIf(valueParams, form.getForm().getFieldValues()); }, this);
		
		this.command = command;
		var params = {
			__command: command,
			__values: valueParams
		};

		Ext.applyIf(params, resultParams);
		Ext.applyIf(params, this.parameters);

		
		value = Ext.encode(params);
		
    	Ext.Ajax.request({
    		url: '/index.php/webtricks/application_contentManager_manager/dispatch',
    		params: {params: value},
    		success: this.process,
    		scope: this
    	});		
	}
});