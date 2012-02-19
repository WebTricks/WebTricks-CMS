WebTricks.Shell.Controls.Form.ComboTree = Ext.extend(Ext.form.TriggerField, {

    triggerClass: 'x-form-tree-trigger',

    initComponent : function()
    {
		this.readOnly = false;
        this.isExpanded = false;
                
        if (!this.sepperator) {
        	this.sepperator=','
        }
        
        WebTricks.Shell.Controls.Form.ComboTree.superclass.initComponent.call(this);
        
        this.on('specialkey', function(f, e){
            if(e.getKey() == e.ENTER){
                this.onTriggerClick();
            }
        }, this);
        
        this.on('show',function() {
            this.getTree();
		});
    },
        
	onTriggerClick: function() 
	{
    	if (this.isExpanded) {
    		this.collapse();
		} else {
        	this.expand();
		}
    } ,
        
    collapse: function() 
    {
    	this.isExpanded=false;
        this.getTree().hide();
        if (this.resizer) {
        	this.resizer.resizeTo(this.treeWidth, this.treeHeight);
        }
    },
        
	expand: function () 
	{
    	this.isExpanded=true;
		this.getTree().show();
    	this.getTree().getEl().alignTo(this.wrap, 'tl-bl?');
    	
    	this.getTree().expandPath(this.value, 'text', function(succes, node) {
    		node.select();
    	});
	},                
       
	validateBlur : function()
	{
        return !this.treePanel || !this.treePanel.isVisible();
    },
    
    getValue: function()
    {
    	return this.nodeId;
    },
       
    getTree: function() 
    {
        if (!this.treePanel) {
            if (!this.treeWidth) {
                this.treeWidth = Math.max(200, this.width || 200);
            }
            if (!this.treeHeight) {
                this.treeHeight = 200;
            }
            this.treePanel = new WebTricks.Shell.Controls.ContentTree({
                renderTo: Ext.getBody(),
                floating: true,
                autoScroll: true,
                minWidth: 200,
                minHeight: 200,
                width: this.treeWidth,
                height: this.treeHeight,
                listeners: {
                    hide: this.onTreeHide,
                    show: this.onTreeShow,
                    click: this.onTreeNodeClick,
                    expandnode: this.onExpandOrCollapseNode,
                    collapsenode: this.onExpandOrCollapseNode,
                    resize: this.onTreeResize,
                    scope: this
                }
            });
            this.treePanel.show();
            this.treePanel.hide();
            this.relayEvents(this.treePanel.loader, ['beforeload', 'load', 'loadexception']);
            if(this.resizable){
                this.resizer = new Ext.Resizable(this.treePanel.getEl(),  {
                   pinned:true, handles:'se'
                });
                this.mon(this.resizer, 'resize', function(r, w, h){
                    this.treePanel.setSize(w, h);
                }, this);
            }
        }
        return this.treePanel;
    },

    onExpandOrCollapseNode: function() 
    {
        if (!this.maxHeight || this.resizable)
            return;  // -----------------------------> RETURN
        var treeEl = this.treePanel.getTreeEl();
        var heightPadding = treeEl.getHeight() - treeEl.dom.clientHeight;
        var ulEl = treeEl.child('ul');  // Get the underlying tree element
        var heightRequired = ulEl.getHeight() + heightPadding;
        if (heightRequired > this.maxHeight)
            heightRequired = this.maxHeight;
        this.treePanel.setHeight(heightRequired);
    },

    onTreeResize: function() 
    {
        if (this.treePanel)
            this.treePanel.getEl().alignTo(this.wrap, 'tl-bl?');
    },

    onTreeShow: function() 
    {
        Ext.getDoc().on('mousewheel', this.collapseIf, this);
        Ext.getDoc().on('mousedown', this.collapseIf, this);
    },

    onTreeHide: function() 
    {
        Ext.getDoc().un('mousewheel', this.collapseIf, this);
        Ext.getDoc().un('mousedown', this.collapseIf, this);
    },

    collapseIf : function(e)
    {
        if(!e.within(this.wrap) && !e.within(this.getTree().getEl())){
            this.collapse();
        }
    },

    onTreeNodeClick: function(node, e) 
    {
        this.setValue(node.getPath('text'));
        this.nodeId = node.id;
        this.collapse();
    }
});

Ext.reg('combotree', WebTricks.Shell.Controls.Form.ComboTree);