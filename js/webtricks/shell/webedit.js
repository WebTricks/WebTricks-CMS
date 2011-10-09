WebTricks.Shell.Webedit = function(config)
{
	Ext.apply(this, config);

	this.addEvents({
		'ready': true,
		'beforeunload': true,
		'moduleactioncomplete': true
	});
	
	this.heartbeat = {
		run: function() {
			Ext.Ajax.request({
				url: '/index.php/webtricks/application/heartbeat'
			});
		},
		interval: 300000 // 5 minutes
	}
	
	Ext.TaskMgr.start(this.heartbeat);
	Ext.onReady(this.initApp, this);
};

Ext.extend(WebTricks.Shell.Application, Ext.util.Observable, 
{
	init: Ext.emptyFn,

	initApp : function()
	{
		this.init();
		this.preventBackspace();

		// the user interface
		this.viewport = new Ext.Viewport(Ext.applyIf({
			app: this
		}, this.desktopConfig));

		Ext.EventManager.on(window, 'beforeunload', this.onBeforeUnload, this);
		this.fireEvent('ready', this);
		this.isReady = true;
	}
}