WebTricks.Shell.Applications.Tools.Run = Ext.extend(WebTricks.Shell.Module,
{	
	/**
	 * Creates the window
	 * 
	 */
    createWindow: function()
    {
	    var desktop = this.app.getDesktop();
	    var win = desktop.getWindow(this.id);
	    if(!win){
	    	var config = {
	    		id: this.id,
		        shim: false,
		        animCollapse: false,
		        constrainHeader: true,
		        border: false,
		        items: [this.getContentPanel()],
		        buttons: [this.getBrowseButton(), this.getCancelButton(), this.getOkButton()],
		        layout: 'fit'
	    	}
		            
	        win = desktop.createWindow(Ext.apply(config, this.windowConfig.initialConfig)); 		
	    }
    
	    win.show();
	},
	
	/**
	 * URL to use for determining the ID of the application
	 */
	url : '/index.php/webtricks/application_tool_run/run',
	
	/**
	 * Input textfield
	 * 
	 */
	getInput: function() 
	{
		this.input = new Ext.form.TextField({
			fieldLabel: 'Open',
			width: 281
		});
	
		return this.input;
	},	
	
	/**
	 * Content panel
	 * 
	 */
	getContentPanel: function() 
	{
		this.contentPanel = new Ext.Panel({
			items: [this.getHeaderPanel(), this.getFormPanel()],
			padding: 5
		});			
		
		return this.contentPanel;		
	}, 	

	/**
	 * Header panel
	 * 
	 */
	getHeaderPanel: function() 
	{
		this.headerPanel = new Ext.Panel({
			border: false,
			html: '<div class="header-panel-icon icon-large-application-run"></div>Type the name of an application or click the browse button to select one.'
		});			
		
		return this.headerPanel;		
	}, 	
	
	getFormPanel: function ()
	{
		this.formPanel = new Ext.form.FormPanel({
			items: [this.getInput()],
			border: false,
			labelWidth: 40,
			style: 'margin-top: 5px;'
		});		
		
		return this.formPanel;
	},
	
	/**
	 * Browse button
	 * 
	 */
	getBrowseButton: function() 
	{
		this.browseButton = new Ext.Button({
			text: 'Browse'
		});			
		
		this.browseButton.on('click', function(node) {
			this.showItemBrowser();
		}, this);
		
		return this.browseButton;		
	}, 
	
	getOkButton: function() 
	{	
		this.okButton = new Ext.Button({
			text: 'OK'
		});
		
		this.okButton.on('click', function(node) {
			this.run();
		}, this);
		
		return this.okButton;
	},
		
	getCancelButton: function() 
	{
		var desktop = this.app.getDesktop();
		var id = this.id;
			
		this.cancelButton = new Ext.Button({
			text: 'Cancel'
		});
		
		this.cancelButton.on('click', function(node) {
			desktop.getWindow(id).close();
		}, this);
		
		return this.cancelButton;
	}, 
	
	/**
	 * Tries to run the entered application.
	 * 
	 */
	run : function()
	{
		var desktop = this.app.getDesktop();
		var id = this.id;

		Ext.Ajax.request({
			url: this.url,
			success: function(o) {
				if (o.responseText) {
					run = Ext.decode(o.responseText);
					desktop.launchWindow(run.itemId);
					desktop.getWindow(id).close();
				} else {
					Ext.Msg.alert('Application not found.', 'The requested application can not be found.');
				}
			},
			params: { application: this.input.getValue() }
		}, this);		
	},
	
	showItemBrowser : function()
	{
		var itemBrowser = new WebTricks.Shell.Applications.Dialogs.ItemBrowser({
			sender: this.input,
			rootId: 'ed767e7d-42d1-4bec-92a2-f360107b717f',
			typeIds: ['7e0d2319-bf15-4e12-831e-322fafaaa981','e49d8005-0305-471a-898b-f82f579fc599']
		});
		
		itemBrowser.show();
	}
});