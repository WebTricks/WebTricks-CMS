
WebTricks.Shell.Applications.ContentManager.Manager = Ext.extend(WebTricks.Shell.Module,
{
	parameters: new Array(),
		
	createWindow : function()
    {
	    var desktop = this.app.getDesktop();
	    var win = desktop.getWindow(this.id);

	    if(!win) {
	    	
	    	this.tree = new WebTricks.Shell.Applications.ContentManager.Tree({
	    		region: 'west',
	    		split: true,
	    		width: 250
        	});
	    	
	    	this.tree.on('click', this.loadItem, this);
	    	
	    	this.workspace = new Ext.TabPanel({
	    		region : 'center'
	    	}),	  
	    	
	    	this.workspace.addListener('tabchange', function(tabpanel, tab) {
	    		var items = tabpanel.items;
	    		for(i = 0; i < items.length; i++) {    			
	    			if (tab.id == items.itemAt(i).id) {
	    				this.parameters['__workspaceTab'] = i;
	    			}
	    		}
	    	}, this);
	    	
	    	this.toolbar = new Ext.Panel({bodyCssClass: 'webtricks-toolbar-body', 'border': false, 'region': 'north', 'height': 115, 'items': this.toolbar});

	    	var config = {
	    		id: this.id,
	    		layout: 'border',
	    		items: [this.toolbar, this.tree, this.workspace]
	    	};

	        win = desktop.createWindow(Ext.apply(config, this.windowConfig.initialConfig));
	    }
	    
	    win.show();
	},
	
	loadItem : function(node)
	{		
		this.workspace.removeAll();
		this.parameters['__itemId'] = node.attributes.id;
		this.parameters['__repository'] = 'core';
		this.parameters['__culture'] = 'en';
		this.parameters['__version'] = 1;
		this.invokeCommand('item:load');
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
    		url: '/index.php/webtricks/applications_contentManager_manager/dispatch',
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
		    		this.workspace.setActiveTab(this.parameters['__workspaceTab']);		    		
		    		this.workspace.render();
		    	} else if (command.name == 'toolbar') {
			    	this.toolbar.removeAll();
			    	this.toolbar.add(command.value);
			    	this.toolbar.render();
			    	this.toolbar.doLayout();
		    	}
		    	break;
		    case 'runApplication':
		    	this.app.getDesktop().launchWindow(command.value);
		    	break;
		    case 'showModalDialog':
				var dialogClass = this.stringToFunction(command.name);
				var dialog = new dialogClass({
					sender: this
				}); 

				dialog.show();
		    	break;
		    case 'refresh':
		    	Ext.each(command.value, function(item, index, allItems) {
		    		this.tree.getLoader().load(this.tree.getNodeById(item));
		    	}, this); 
		}
	},
	
	postResult: function(result, value)
	{
		var params = {
			__result: result,
			__value: value
		};
		
		this.invokeCommand(this.command, params);
	},
	
	stringToFunction: function(str) 
	{
		var arr = str.split(".");
		
		var fn = (window || this);
		for (var i = 0, len = arr.length; i < len; i++) {
			fn = fn[arr[i]];
		}
		
		if (typeof fn !== "function") {
			throw new Error("function not found");
		}

		return fn;
	}
});