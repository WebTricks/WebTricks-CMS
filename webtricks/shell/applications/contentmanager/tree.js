WebTricks.Applications.ContentManager.Tree = function(config)
{
    this.useArrows = true;
    this.autoScroll = true;
    this.animate = true;
    this.enableDD = true;
    this.containerScroll = true;
    this.border = true;

    this.dataUrl = '/json/content/tree/getChildren/';

    this.root = new Ext.tree.AsyncTreeNode({
        nodeType: 'async',
        text: 'WebTricks',
        draggable: false,
        id: '11111111-1111-1111-1111-111111111111'
    });
    
    WebTricks.Applications.ContentManager.Tree.superclass.constructor.call(this, config);	
}

Ext.extend(WebTricks.Applications.ContentManager.Tree, Ext.tree.TreePanel,
{
	
});