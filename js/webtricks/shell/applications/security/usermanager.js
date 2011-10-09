
WebTricks.Shell.Applications.Security.UserManager = Ext.extend(WebTricks.Shell.Module,
{
	parameters: new Array(),
		
	createWindow : function()
    {
	    var desktop = this.app.getDesktop();
	    var win = desktop.getWindow(this.id);

	    if(!win) {
	    		    		    	
	    	this.toolbar = new Ext.Panel({bodyCssClass: 'webtricks-toolbar-body', 'border': false, 'region': 'north', 'height': 115, 'items': this.toolbar});

	    	var config = {
	    		id: this.id,
	    		layout: 'border',
	    		items: [this.toolbar, this.workspace]
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
			case 'alert':
				if (command.response) {
					Ext.Msg.alert('', command.value, function () { this.postResult(command.response); }, this);					
				} else {
					Ext.Msg.alert('', command.value);
				}
				break;
		    case 'confirm':
				Ext.Msg.confirm('', command.value, this.postResult, this);		    	
		        break;	
		    case 'prompt':
				Ext.Msg.prompt('', command.value, this.postResult, this);		    	
		        break;	
		    case 'setParameter':
		    	this.parameters[command.name] = command.value;

		    	if (command.name == '__itemId') {
		    		this.tree.getNodeById(command.value).select();
		    		this.tree.expandPath(this.tree.getNodeById(command.value).getPath());		    		
		    	}
		    	break;
		    case 'setControl':
		    	if (command.name == 'workspace') {
		    		this.workspace.removeAll();
		    		this.workspace.add(command.value);
		    		this.workspace.render();
		    	} else if (command.name == 'toolbar') {
			    	this.toolbar.removeAll();
			    	this.toolbar.add(command.value);
			    	this.toolbar.render();
			    	this.toolbar.doLayout();
		    	}
		    	break;
		}
	},
	
	postResult: function(result, value)
	{
		var params = {
			__result: result,
			__value: value
		};
		
		this.invokeCommand(this.command, params);
	}
});