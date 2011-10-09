WebTricks.Module = function(config)
{
    Ext.apply(this, config);
    WebTricks.Module.superclass.constructor.call(this);
    this.init();
}

Ext.extend(WebTricks.Module, Ext.util.Observable, 
{
	constructor : function(config)
	{
		this.addEvents({
			'actioncomplete':true
		});

		config = config || {};
		Ext.apply(this, config);
		Ext.app.Module.superclass.constructor.call(this);	
	},

	/**
	 * The unique id of the module
	 */
	id : null,
	
	/**
	 * The title of the module
	 */
	title : null,
	
	/**
	 * The icon class for this application
	 */
	iconCls : null,
	
	/**
	 * Read only. {object}
	 * Override this with the launcher for your module.
	 * 
	 * Example:
	 * 
	 * {
	 *    iconCls: 'pref-icon',
	 *    handler: this.createWindow,
	 *    scope: this,
	 *    shortcutIconCls: 'pref-shortcut-icon',
	 *    text: 'Preferences',
	 *    tooltip: '<b>Preferences</b><br />Allows you to modify your desktop'
	 * }
	 */
	launcher : null,
	
	/**
	 * Read only. {boolean}
	 * Ext.app.App uses this property to determine if the module has been loaded.
	 */
	loaded : false,
	
	/**
	 * Read only. {boolean}
	 * Ext.app.App uses this property to determine if the module is currently being loaded.
	 */
	isLoading : false,
	
	/**
	 * Read only. {string}
	 * Override this with the menu path for your module.
	 * Ext.app.App uses this property to add this module to the Start Menu.
	 * 
	 * Case sensitive options are:
	 * 
	 * 1. StartMenu
	 * 2. ToolMenu
	 * 
	 * Example:
	 * 
	 * menuPath: 'StartMenu/Bogus Menu'
	 * 
	 * To prevent a module from being listed in the StartMenu or ToolMenu, do this:
	 * 
	 * menuPath: null
	 */	
	menuPath : 'StartMenu',
	
	/**
	 * Read only. {string}
	 * Override this with the type of your module.
	 * Example: 'system/preferences'
	 */
	moduleType : null,
	
	/**
	 * Read only. {string}
	 * Override this with the unique id of your module.
	 */
	moduleId : null,
	
	/**
	 * Override this to initialize your module.
	 * Is called by the loadModuleComplete() of the Ext.app.App class
	 */
	init : Ext.emptyFn,
	
	/**
	 * Override this function to create your module's window.
	 */
	createWindow : Ext.emptyFn,
	
	/**
	 * @param {array} An array of request objects
	 *
	 * Override this function to handle requests from other modules.
	 * Expect the passed in param to look like the following.
	 * 
	 * {
	 *    requests: [
	 *       {
	 *          action: 'createWindow',
	 *          params: '',
	 *          callback: this.myCallbackFunction,
	 *          scope: this
	 *       },
	 *       { ... }
	 *    ]
	 * }
	 *
	 * View makeRequest() in App.js for more details.
	 */
	handleRequest : Ext.emptyFn
});