WebTricks.Applications.ContentManager.Folder = function(config)
{
    this.useArrows = true;
    this.autoScroll = true;
    this.animate = true;
    this.enableDD = true;
    this.containerScroll = true;
    this.border = false;

    this.dataUrl = '/json/content/tree/getChildren/';

    this.root = new Ext.tree.AsyncTreeNode({
        nodeType: 'async',
        text: 'WebTricks',
        draggable: false,
        id: '11111111-1111-1111-1111-111111111111'
    });
    
    WebTricks.Applications.ContentManager.Folder.superclass.constructor.call(this, config);
	
    this.on('click', function(node)	{
		Application.addTab(node.attributes.id, node.attributes.text, node.attributes.iconCls, '/json/content/editor/?itemId='+ node.attributes.id);
	}, this);	
}

Ext.extend(WebTricks.Applications.ContentManager.Folder, Ext.tree.TreePanel,
{
	
});