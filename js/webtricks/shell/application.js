WebTricks.Shell.Application = function(config)
{
	Ext.apply(this, config);

	this.addEvents({
		'ready': true,
		'beforeunload': true,
		'moduleactioncomplete': true
	});
	
	this.heartbeat = ({
		run: function() {
			Ext.Ajax.request({
				url: '/index.php/webtricks/application/heartbeat'
			});
		},
		interval: 300000 // 5 minutes
	});
	
	Ext.TaskMgr.start(this.heartbeat);
	Ext.onReady(this.initApp, this);
};

Ext.extend(WebTricks.Shell.Application, Ext.util.Observable, 
{
   /**
    * @cfg {Object} A config object to be applied to Ext.Desktop.
    */
   desktopConfig: null,
   
   /**
    * @cfg {Object} The member info.
    * Example: { group: 'demo', name: 'Todd Murdock' }
    */
   memberInfo: null,
   
   /**
    * @cfg {Array} An array of the module definitions.
    * The definitions are used until the module is loaded on demand.
    * * Example:
    * [
    *    {
    *       "id": "demo-accordion",
    *       "type": "demo/accordion",
    *       "className": "QoDesk.AccordionWindow",
    *       "launcher": {
    *          "iconCls":"acc-icon",
    *          "shortcutIconCls":"demo-acc-shortcut",
    *          "text":"Accordion Window",
    *          "tooltip":"A window with an accordion layout"
    *       },
    *       "launcherPaths": {
    *          "StartMenu": "/"
    *       }
    *    },
    *	   ...
    */
   modules: null,
   
   /**
    * @cfg {Object/Array}
    */
   plugins: null,
   
   /**
    * @cfg {Object} The members privileges.
    * * Example:
    * {
    *    "qo-preferences": { "viewThemes": 1, "viewWallpapers": 1 },
    *    "demo-layout":1,
    *    "demo-grid":1,
    *    "demo-bogus":1,
    *    "demo-tabs":1,
    *    "demo-accordion":1
    * }
    */
   privileges: null,
   
   /**
    * Read-only. This app's ready state
    * @type boolean
    */
   isReady: false,
   
   /**
    * Read-only. The url of this app's server connection
    *
    * Allows a module to connect to its server script without knowing the path.
    * Example ajax call:
    *
    * Ext.Ajax.request({
    *    url: this.app.connection,
    *    // Could also pass the module id in the querystring like this.
    *    // url: this.app.connection+'?id='+this.id,
    *    params: {
    *	      id: this.id
    *	      ...
    *	   },
    *	   success: function(){
    *	      ...
    *	   },
    *	   failure: function(){
    *       ...
    *    },
    *	   scope: this
    *	});
    */
   connection: '',
   
   /**
    * Read-only. The queue of requests to run once a module is loaded
    */
   requestQueue: [],

   init: Ext.emptyFn,

   initApp : function()
   {
		this.init();
		this.preventBackspace();

		// the user interface
		this.desktop = new Ext.Desktop(Ext.applyIf({
			app: this
		}, this.desktopConfig));

		Ext.EventManager.on(window, 'beforeunload', this.onBeforeUnload, this);
		this.fireEvent('ready', this);
		this.isReady = true;
	},

	/**
	 * @param {string} v The id or moduleType you want returned
	 * @param {Function} cb The Function to call when the module is ready/loaded
	 * @param {object} scope The scope in which to execute the function
	 */
	requestModule: function(v, cb, scope)
	{
		var m = this.getModule(v);
		if (m) {
			if (m.loaded === true) {
				cb.call(scope, m);
			} else {
				if (cb && scope) {
					this.requestQueue.push({ id: m.id, callback: cb, scope: scope });
					this.loadModule(m);
				}
			}
		}
	},
    
   /**
    * @param {Ext.app.Module} m The module
    */
   loadModule : function(m)
   {
	   if(m.isLoading){
		   return false; 
	   }

    	var id = m.id;
    	var moduleName = m.launcher.text;
		
		m.isLoading = true;
    	
    	Ext.Ajax.request({
    		url: this.connection,
    		params: {
    			itemId: id
    		},
    		success: function(o) {	
    			if (o.responseText !== '') {
    				config = Ext.decode(o.responseText);
    				this.loadModuleComplete(true, id, config);
    			} else {
    				Ext.MessageBox.alert('Error', 'An error occured on the server.');    				
    			}
    		},
    		failure: function() {
				Ext.MessageBox.alert('Error', 'Connection to the server failed!');    				    			
    		},
    		scope: this
    	});

      return true;
    },
    
    /**
     * @param {boolean} success
     * @param {string} id
     * 
     * Will be called when a module is loaded.
     * If a request for this module is waiting in the
     * queue, it as executed and removed from the queue.
     */
    loadModuleComplete : function(success, id, config)
    {   	
		if(success === true && id) {
			var m = this.instantiateModule(id, config);
			if (m) {
				m.isLoading = false;
				m.loaded = true;
				m.init();
				m.on('actioncomplete', this.onModuleActionComplete, this);
		
		        var q = this.requestQueue;
		        var nq = [];
		        var found = false;
		
		        for(var i = 0, len = q.length; i < len; i++){
		           if(found === false && q[i].id === id){
		              found = q[i];
		           }else{
		              nq.push(q[i]);
		           }
		        }
		
		        this.requestQueue = nq;
		
		        if (found) {
		           found.callback.call(found.scope, m);
		        }
			}
		}
   },

   /**
    * Private
    * @param {string} id
    */
   instantiateModule : function(id, config)
   {
      var p = this.getModule(id); // get the placeholder

      if(p && p.loaded === false){
    	  if( eval('typeof ' + p.className) === 'function') {
    		  var m = eval('new ' + p.className + '()');
    		  m = Ext.apply(m, config);
    		  m.app = this;

    		  var ms = this.modules;
    		  for(var i = 0, len = ms.length; i < len; i++){ // replace the placeholder with the module
    			  if(ms[i].id === m.id){
    				  Ext.apply(m, ms[i]); // transfer launcher properties
    				  ms[i] = m;
    			  }
    		  }
    		  return m;
    	  }
      }
      return null;
   },

   /**
    * @param {string} v The id or moduleType you want returned
    */
   getModule : function(v)
   {
      var ms = this.modules;

      for(var i = 0, len = ms.length; i < len; i++){
         if(ms[i].id == v || ms[i].moduleType == v){
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
		m.launcher.handler = this.desktop.launchWindow.createDelegate(this.desktop, [m.id]);
		m.app = this;
      return true;
   },

   /**
    * @param {string} id or moduleType
    * @param {array} requests An array of request objects
    * 
    * Example:
    * this.app.makeRequest('module-id', {
    *    requests: [
    *       {
    *          method: 'createWindow',
    *          params: '',
    *          callback: this.myCallbackFunction,
    *          scope: this
    *       },
    *       { ... }
    *    ]
    * });
    */
   makeRequest : function(id, requests){
      if(id !== '' && requests){
         var m = this.requestModule(id, function(m){
            if(m){
               m.handleRequest(requests);
            }
         }, this);
      }
   },

   /**
    * @param {string} method The module method
    * @param {string} id The module id property
    */
   isAllowedTo : function(method, id){
      if(method !== '' && id != ''){
         var p = this.privileges;
         if(p[id] && Ext.isArray(p[id]) && p[id].indexOf(method) !== -1){
            return true;
         }
      }
      return false;
   },

   getDesktop : function(){
      return this.desktop;
   },

   /**
    * @param {Function} fn The function to call after the app is ready
    * @param {object} scope The scope in which to execute the function
    */
   onReady : function(fn, scope){
      if(!this.isReady){
         this.on('ready', fn, scope);
      }else{
         fn.call(scope, this);
      }
   },

   onBeforeUnload : function(e){
      if(this.fireEvent('beforeunload', this) === false){
         e.stopEvent();
      }
   },

   /**
    * Prevent the backspace (history -1) shortcut
    */
   preventBackspace : function(){
      var map = new Ext.KeyMap(document, [{
         key: Ext.EventObject.BACKSPACE,
         stopEvent: false,
         fn: function(key, e){
            var t = e.target.tagName;
            if(t != "INPUT" && t != "TEXTAREA"){
               e.stopEvent();
            }
         }
      }]);
   },
    
   /**
    * @param {Ext.app.Module} module
    * @param {object} data
    * @param {object} options
    * 
    * It may be benificial for a system module to register all (or some) module
    * activity in the database.
    * 
    * Example usage:
    * 
    * this.app.on('moduleactioncomplete', this.onModuleActionComplete, this);
    * 
    * onModuleActionComplete : function(app, module, params, options){
    *    	if(module && params){
    *    	
    *    		if(typeof options === 'object'){
    *    			var keepExisting = options.keepExisting || false;
    *    		}
    *    		
    *    		Ext.Ajax.request({
    *				url: this.app.connection
    *				, params: { 
    *					action: 'registerModuleAction'
    *					, id: this.id
    *					, actionModuleId: module.id
    *					, actionData: typeof params.data == 'object' ? Ext.encode(params.data) : params.data
    *					, actionDesc: params.description
    *					, keepExisting: keepExisting || false
    *				}
    *				, failure: function(response,options){
    *					// failed
    *				}                                      
    *				, success: function(o){
    *					// success
    *				}
    *				, scope: this
    *			});
    * 		}
    * }
    */
   onModuleActionComplete : function(module, data, options){
      this.fireEvent('moduleactioncomplete', this, module, data, options);
   }
});