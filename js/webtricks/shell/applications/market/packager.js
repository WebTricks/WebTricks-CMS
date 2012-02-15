WebTricks.Shell.Applications.Market.Packager = Ext.extend(WebTricks.Shell.Module,
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
	    	
			this.toolbar = new Ext.Panel({bodyCssClass: 'webtricks-toolbar-body', 'border': false, 'region': 'north', 'height': 115, 'items': this.toolbar});    	
	    	
	    	config = {
	    		id: this.id,
		        shim: false,
		        animCollapse: false,
		        constrainHeader: true,
		        border: false,
		        items: [this.toolbar, this.getContentPanel()],
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
	input : new Ext.form.TextField({
		fieldLabel: 'Open',
		width: 281
	}),
	
	/**
	 * Content panel
	 * 
	 */
	getContentPanel: function() {
		if (!this.contentPanel) {
			this.contentPanel = new Ext.Panel({
				items: [this.getHeaderPanel(), this.getFormPanel()],
				padding: 5
			});			
		}
		
		return this.contentPanel;		
	}, 	

	/**
	 * Header panel
	 * 
	 */
	getHeaderPanel: function() {
		if (!this.headerPanel) {
			this.headerPanel = new Ext.Panel({
				border: false,
				html: '<div class="header-panel-icon icon-large-application-run"></div>Type the name of an application or click the browse button to select one.'
			});			
		}
		
		return this.headerPanel;		
	}, 	
	
	getFormPanel: function ()
	{
		if (!this.formPanel) {
			this.formPanel = new Ext.form.FormPanel({
				items: [this.input],
				border: false,
				labelWidth: 40,
				style: 'margin-top: 5px;'
			});		
		} 
		
		return this.formPanel;
	},

	getCloseButton: function() 
	{	
		if (!this.closeButton) {
			this.closeButton = new Ext.Button({
				text: 'Close'
			});
			
			this.closeButton.on('click', function(node) {
				this.app.getDesktop().getWindow(this.id).close();
			}, this);
		}
		
		return this.closeButton;
	}
});