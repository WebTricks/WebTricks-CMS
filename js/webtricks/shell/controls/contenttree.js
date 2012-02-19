
WebTricks.Shell.Controls.ContentTree = function(config)
{
    this.useArrows = true;
    this.autoScroll = true;
    this.animate = true;
    this.enableDD = false;
    this.containerScroll = true;
    this.border = true;

    this.dataUrl = '/index.php/webtricks/applications_contentManager_tree/children';

    this.root = new Ext.tree.AsyncTreeNode({
        nodeType: 'async',
        text: 'WebTricks',
        draggable: false,
        id: '11111111-1111-1111-1111-111111111111'
    });
    
    if (config.contextmenu) {
		this.tree.on('contextmenu', function(node, e) {
			
			node.select();
			var location = e.getXY();
			
	    	Ext.Ajax.request({
	    		url: '/index.php/webtricks/applications_contentManager_tree/contextmenu',
	    		params: {
	    			itemId: node.attributes.id
	    		},
	    		success: function(o){	
	    			if(o.responseText !== ''){
	    				menu = Ext.decode(o.responseText);
	    	            menu.showAt(location);				
	    			}
	    		},
	    		scope: this
	    	});
		}, this);
    }
    
    WebTricks.Shell.Controls.ContentTree.superclass.constructor.call(this, config);	
}

Ext.extend(WebTricks.Shell.Controls.ContentTree, Ext.tree.TreePanel,
{
	
});