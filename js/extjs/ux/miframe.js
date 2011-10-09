Ext.ux.IFrameComponent = Ext.extend(Ext.BoxComponent, {
	initComponent: function(e){
        Ext.ux.IFrameComponent.superclass.initComponent.call(this);
        this.on('beforerender', this.onBeforeRender, this);
    },
    onBeforeRender: function(box) {

    },
	onRender: function(ct, position) {
    	this.el = ct.createChild({
        	tag: 'iframe', 
            id: 'iframe-' + this.id, 
            frameBorder: 0, 
            src: this.url
       	});
		Ext.ux.IFrameComponent.superclass.onRender.apply(this, arguments);
		this.el.on('load', this.onLoad, this);

    },
    
	onLoad: function() {
        this.fireEvent('load', this);
    },
    
	setSrc: function (src) {	
		if(this.el){
			this.el.dom.src = 'about:blank';
        	this.el.dom.src = src;
		}else{
			this.src='about:blank';
			this.src=src;
		}
	}
});
Ext.reg('IFrameComponent', Ext.ux.IFrameComponent);