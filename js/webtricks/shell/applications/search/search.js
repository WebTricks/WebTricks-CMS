WebTricks.Shell.Applications.Search.Search = Ext.extend(WebTricks.Shell.Module,
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
		        buttons: [this.getCloseButton()],
		        layout: 'fit'
	    	};
	    	
	        win = desktop.createWindow(Ext.apply(config, this.windowConfig.initialConfig));
	    }
    
	    win.show();
	},
	
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
	getHeaderPanel: function() {
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

	getCloseButton: function() 
	{	
		this.closeButton = new Ext.Button({
			text: 'Close'
		});
		
		this.closeButton.on('click', function(node) {
			this.app.getDesktop().getWindow(this.id).close();
		}, this);
		
		return this.closeButton;
	}
});