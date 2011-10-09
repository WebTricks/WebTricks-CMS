Ext.override(WebTricks.Application.ContentManager.Manager, 
{
    createWindow : function()
    {
	    var desktop = this.app.getDesktop();
	    var win = desktop.getWindow(this.id);
	    if(!win){
	        win = desktop.createWindow({
	            id: this.id,
	            title: this.title,
	            width: 740,
	            height: 480,
	            iconCls: this.iconCls,
	            shim: false,
	            animCollapse: false,
	            constrainHeader: true,
	            border: false,
	            layout: 'border',
	            items: [this.getTree(), this.getWorkspace()]	            
	        });
	    }
    
	    win.show();
	},
	
	getTree : function()
	{
		if (!this.tree) {
			
			this.tree = new WebTricks.Applications.ContentManager.Tree({
				region : 'west',
				width: 200,
				split: true
			});			
			
			this.tree.on('click', function(node)	{
				this.addTab(node.attributes.id, node.attributes.text, node.attributes.iconCls, '/json/content/editor/?itemId='+ node.attributes.id);
			}, this);			
			
			this.tree.on('contextmenu', function(node, e) {
				node.select();
				menu = new Ext.menu.Menu({
					plugins: [new WebTricks.Shell.Controls.RemoteComponent({
						url: '/index.php/webtricks/application_contentmanager_tree/contextmenu/?itemId='+ node.attributes.id
					})]
				});
	            menu.showAt(e.getXY());				
			}, this);			
		}
		
		return this.tree;
	},
		
	getWorkspace : function()
	{
		if (!this.workspace) {
			this.workspace = new Ext.TabPanel({
				region : 'center'
			});
		}
		
		return this.workspace;
	},
	
	addTab : function(id, title, icon, url)
	{
		if (!icon) {
			icon = 'icon-document-plain';
		}

		var tab = this.getWorkspace().getComponent(id);

	    if (tab){
	    	this.getWorkspace().setActiveTab(tab);
	    } else {
	        var tab = this.getWorkspace().add(new Ext.Panel({
				style: 'background-color: #F0F5FA;',
				border: false,
				closable: true,
				layout: 'fit',
				title: title,
				id: id,
				iconCls: icon,
				plugins: [new WebTricks.Shell.Controls.RemoteComponent({
					url: url
				})],
				//listeners: {activate: function(t) {
				//	Application.reload(t);
				//}}
	        }));
	        this.getWorkspace().setActiveTab(tab);
	    }	
	}
});