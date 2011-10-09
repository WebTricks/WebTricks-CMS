
WebTricks.Shell.Applications.ContentManager.Tree = function(config)
{
    this.useArrows = true;
    this.autoScroll = true;
    this.animate = true;
    this.enableDD = true;
    this.containerScroll = true;
    this.border = true;

    this.dataUrl = '/index.php/webtricks/applications_contentManager_tree/children';

    if (!config.rootId) {
    	config.rootId = '11111111-1111-1111-1111-111111111111';
    }
    	
    this.root = new Ext.tree.AsyncTreeNode({
    	nodeType: 'async',
    	text: 'WebTricks',
    	draggable: false,
    	id: config.rootId
    });
    
    WebTricks.Shell.Applications.ContentManager.Tree.superclass.constructor.call(this, config);
    
    if (config.contextmenu) {
		this.on('contextmenu', function(node, e) {
			
			node.select();
			var location = e.getXY();
			
	    	Ext.Ajax.request({
	    		url: '/index.php/webtricks/application_contentManager_tree/contextmenu',
	    		params: {
	    			itemId: node.attributes.id
	    		},
	    		success: function(o) {	
	    			if(o.responseText !== ''){
	    				menu = Ext.decode(o.responseText);
	    	            menu.showAt(location);				
	    			}
	    		},
	    		scope: this
	    	});
		}, this);
    } else {
    	this.on('contextmenu', function(node, e) {
    		return false;
		}, this);    	
    }    
    
    this.getLoader().on("beforeload", function(treeLoader, node) {
        treeLoader.baseParams = {
        	'rootId': config.rootId,
        	'typeIds[]': config.typeIds
        }
    }, this);        
}

Ext.extend(WebTricks.Shell.Applications.ContentManager.Tree, Ext.tree.TreePanel,
{
	
});