
WebTricks.Shell.Applications.Workbox = Ext.extend(WebTricks.Shell.Module,
{
	createWindow : function()
    {
	    var desktop = this.app.getDesktop();
	    var win = desktop.getWindow(this.id);

	    if(!win) {
	    		    	
	    	this.workspace = new Ext.TabPanel({
	    		region : 'center'
	    	});	  
	    	
	    	//this.toolbar = new Ext.Panel({'border': false});
	    	//this.toolbar
	    	//this.toolbar = this.toolbar.cloneConfig();
	    	
	    	var config = {
	    		id: this.id,
	    		tbar: this.toolbar,
	    		layout: 'border',
	    		items: [this.tree, this.workspace]
	    	}
	    	
	        win = desktop.createWindow(Ext.apply(config, this.windowConfig.initialConfig));
	    }
	    
	    win.show();
	},
		
	/**
	 * Invokes a command.
	 * 
	 */
	invokeCommand: function(command, result)
	{
		this.command = command;
		
    	Ext.Ajax.request({
    		url: '/index.php/webtricks/application_contentManager_manager/dispatch',
    		params: {
    			__command: command,
    			__result: result
    		},
    		success: this.process,
    		scope: this
    	});		
	},
	
	/**
	 * Processes the result of an ajax request.
	 * 
	 */
	process: function(result)
	{
		if(result.responseText !== ''){
			response = Ext.decode(result.responseText);
			Ext.each(response.commands, this.processCommand, this);
		}
	},
	
	/**
	 * Processes a ajax request command.
	 * 
	 */
	processCommand: function(command)
	{
		switch(command.command) {
			case "alert":
				if (command.response) {
					Ext.Msg.alert('', command.value, function () { this.postResult(command.response); }, this);					
				} else {
					Ext.Msg.alert('', command.value);
				}
				break;
		    case "confirm":
				Ext.Msg.confirm('', command.value, this.postResult, this);		    	
		        break;		
		}
	},
	
	postResult: function(result)
	{
		this.invokeCommand(this.command, result);
	}
});