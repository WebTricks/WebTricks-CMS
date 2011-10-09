WebTricks.Application = function(cfg)
{
    Ext.apply(this, cfg);
    this.addEvents({
        'ready' : true,
        'beforeunload' : true
    });

    Ext.onReady(this.initApp, this);
};

Ext.extend(WebTricks.Application, Ext.util.Observable, 
{
    isReady: false,
    startMenu: null,
    modules: null,
    
    /**
     * Read-only. The queue of requests to run once a module is loaded
     */
    requestQueue : [],   

    getStartConfig : function()
	{

    },

    initApp : function() 
	{
    	this.startConfig = this.startConfig || this.getStartConfig();
        this.desktop = new WebTricks.Controls.Desktop(this);
		this.launcher = this.desktop.taskbar.startMenu;
		this.modules = this.getModules();

		if(this.modules){
            this.initModules(this.modules);
        }

        this.init();

        Ext.EventManager.on(window, 'beforeunload', this.onUnload, this);
		this.fireEvent('ready', this);
        this.isReady = true;
        this.removeLoadMask();
    },

    getModules : Ext.emptyFn,
    init : Ext.emptyFn,

    initModules : function(ms)
	{
		for(var i = 0, len = ms.length; i < len; i++) {
			if(ms[i].loaded === false){
    			ms[i].launcher.handler = this.createWindow.createDelegate(this, [ms[i].moduleId]);
    			this.launcher.add(ms[i].launcher);
    		}
    		ms[i].app = this;
    		ms[i].on('actioncomplete', this.onModuleActionComplete, this);
        }
        
        return true;    		
    },

    getModule : function(name)
	{
    	var ms = this.modules;
    	for(var i = 0, len = ms.length; i < len; i++){
    		if(ms[i].id == name || ms[i].appType == name){
    			return ms[i];
			}
        }
        return '';
    },

    onReady : function(fn, scope)
	{
        if(!this.isReady){
            this.on('ready', fn, scope);
        }else{
            fn.call(scope, this);
        }
    },

    getDesktop : function()
	{
        return this.desktop;
    },

    onUnload : function(e)
	{
        if(this.fireEvent('beforeunload', this) === false){
            e.stopEvent();
        }
    },
    
	// Remove the loading layer
	removeLoadMask : function()
	{
		var loading = Ext.get('loading');
		var mask = Ext.get('loading-mask');
		mask.setOpacity(.8);
		mask.shift({
			xy: loading.getXY(),
			width: loading.getWidth(),
			height: loading.getHeight(),
			remove: true,
			duration: 1,
			opacity: .3,
			easing: 'easeOut',
			callback : function(){
				loading.fadeOut({duration:.2,remove:true});
			}
		});
	},  
	
    /**
     * @param {string} moduleId
     * 
     * Provides the handler to the module launcher.
     * Requests the module, which will load the module if needed.
     * Passes in the callback and scope as params.
     */
    createWindow : function(moduleId){
    	var m = this.requestModule(moduleId, function(m){
    		if(m){
	    		m.createWindow();
	    	}
    	}, this);
    },
    
    /** 
     * @param {string} v The moduleId or moduleType you want returned
     * @param {Function} cb The Function to call when the module is ready/loaded
     * @param {object} scope The scope in which to execute the function
     */
	requestModule : function(v, cb, scope){
    	var m = this.getModule(v);
        
        if(m){
	        if(m.loaded === true){
	        	cb.call(scope, m);
	        }else{
	        	if(cb && scope){
		        	this.requestQueue.push({
			        	moduleId: m.moduleId,
			        	callback: cb,
			        	scope: scope
			        });
			        this.loadModule(m);
	        	}
	        }
        }
    },
    
    /**
     * @param {Ext.app.Module} m
     */
    loadModule : function(m)
    {
    	if (m.isLoading) { 
    		return false; 
    	}
    	
    	var moduleId = m.moduleId;
    	var moduleName = m.launcher.text;
    	//var notifyWin = this.desktop.showNotification({
		//	html: 'Loading ' + moduleName + '...'
		//	, title: 'Please wait'
		//});
		
		m.isLoading = true;
    	
		for(var i = 0, len = m.url.length; i < len; i++) {
	    	Ext.Ajax.request({
	    		url: m.url[i],
	    		success: function(o){	
	    			if(o.responseText !== ''){
	    				eval(o.responseText);
	    				this.loadModuleComplete(true, m);
	    			}else{
	    				alert('An error occured on the server.');
	    			}
	    		},
	    		failure: function(){
	    			alert('Connection to the server failed!');
	    		},
	    		scope: this
	    	});
		}
    },
    
    /**
     * @param {boolean} success
     * @param {Ext.app.Module} m
     * 
     * Will be called when a module is loaded.
     * If a request for this module is waiting in the
     * queue, it as executed and removed from the queue.
     */
    loadModuleComplete : function(success, m){    	
    	if(success === true){
    		m.isLoading = false;
    		m.loaded = true;
    		m.init();
    		
    		var moduleId = m.moduleId;
	    	var q = this.requestQueue;
	    	var nq = [];
	    	var found = false;
	    	
	    	for(var i = 0, len = q.length; i < len; i++){
	    		if(found === false && q[i].moduleId === moduleId){
	    			found = q[i];
	    		}else{
	    			nq.push(q[i]);
	    		}
	    	}
	    	
	    	this.requestQueue = nq;
	    	
	    	if(found){
	    		found.callback.call(found.scope, m);
	    	}
    	}
    },

    /**
     * @param {string} v The moduleId or moduleType you want returned
     */
    getModule : function(v){
    	var ms = this.modules;
    	
        for(var i = 0, len = ms.length; i < len; i++){
    		if(ms[i].moduleId == v || ms[i].moduleType == v){
    			return ms[i];
			}
        }
        
        return null;
    },
    
    
    /**
     * @param {Ext.app.Module} m The module to register
     */
    registerModule: function(m){
    	if(!m){ return false; }
		this.modules.push(m);
		m.launcher.handler = this.createWindow.createDelegate(this, [m.moduleId]);
		m.app = this;
	},

    /**
     * @param {string} moduleId or moduleType 
     * @param {array} requests An array of request objects
     * 
     * Example:
     * this.app.makeRequest('module-id', {
	 *    requests: [
	 *       {
	 *          action: 'createWindow',
	 *          params: '',
	 *          callback: this.myCallbackFunction,
	 *          scope: this
	 *       },
	 *       { ... }
	 *    ]
	 * });
     */
    makeRequest : function(moduleId, requests){
    	if(moduleId !== '' && Ext.isArray(requests)){
	    	var m = this.requestModule(moduleId, function(m){
	    		if(m){
		    		m.handleRequest(requests);
		    	}
	    	}, this);
    	}
    }
});