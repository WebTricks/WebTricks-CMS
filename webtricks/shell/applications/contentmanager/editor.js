WebTricks.Applications.ContentManager.Editor = function(config)
{
	this.contentId = config.contentId;
	this.templateId = config.templateId;
	this.culture = config.culture;
	this.version = config.version;
	
	this.hasChildren = config.hasChildren;


	this.saveButton = new Ext.Button({
        iconCls: 'icon-medium-disk-blue',
        iconAlign: 'top',
        scale: 'large',
        text: 'Bewaren',
        scope: this,
        handler: this.save
	});

	this.cancelButton = new Ext.Button({
		iconCls: 'icon-medium-exit',
		text: 'Sluiten',
		scale: 'large',
		iconAlign: 'top',
		handler: this.cancel,
		scope: this
	});

	this.deleteButton = new Ext.Button({
        iconCls: 'icon-medium-delete2',
        iconAlign: 'top',
        scale: 'large',
        text: 'Verwijderen',
        scope: this,
        handler: this.deleteItem
	});

	this.cutButton = new Ext.Button({
        iconCls: 'icon-cut',
        iconAlign: 'left',
        scale: 'small',
        text: 'Knippen',
        scope: this,
        handler: this.cutToClipboard
	});

	this.copyButton = new Ext.Button({
        iconCls: 'icon-copy',
        iconAlign: 'left',
        scale: 'small',
        text: 'Kopieren',
        scope: this,
        handler: this.copyToClipboard
	});

	this.pasteButton = new Ext.Button({
        iconCls: 'icon-medium-paste',
        iconAlign: 'top',
        scale: 'large',
        text: 'Plakken',
        rowspan: 2,
        scope: this
	});

	this.languageMenu = new Ext.menu.Menu({
        items: [this.deleteButton, this.deleteButton]
    });

	this.languageButton = new Ext.Button({
        iconCls: 'icon-medium-flag-netherlands',
        iconAlign: 'top',
        scale: 'large',
        text: 'Nederlands',
        scope: this,
        handler: this.changeLanguage,
        menu: this.languageMenu
	});

	this.translateButton = new Ext.Button({
        iconCls: 'icon-medium-earth-location',
        iconAlign: 'top',
        scale: 'large',
        text: 'Vertalen',
        scope: this,
        handler: this.toggleTranslation,
        enableToggle: true
	});

	this.fileGroup = new Ext.ButtonGroup({
		title: 'Bestand',
		items: [this.saveButton, this.cancelButton]
	});

	this.actionsGroup = new Ext.ButtonGroup({
		title: 'Acties',
		items: [this.deleteButton]
	});

	this.languageGroup = new Ext.ButtonGroup({
		title: 'Internationalisering',
		items: [this.languageButton, this.translateButton]

	});

	this.clipboardGroup = new Ext.ButtonGroup({
		columns: 2,
		title: 'Clipboard',
		items: [this.pasteButton, this.cutButton, this.copyButton]
	});

	this.toolbar = new Ext.Toolbar({
	});

	this.toolbar.add(this.fileGroup);
	if (this.contentId) {
		this.toolbar.add(this.actionsGroup);
	}
	this.toolbar.add(this.languageGroup);

	this.tbar = this.toolbar;
	this.border = false;
	this.autoScroll = true;
	this.labelAlign = 'top';

	if (this.hasChildren) {
		this.items = [this.tabPanel];
	} else {
		this.items = [this.view];
	}

	WebTricks.Applications.ContentManager.Editor.superclass.constructor.call(this, config);

	this.getForm().addListener('actioncomplete', function() {
		Ext.example.msg('Opgeslagen','');

		// Close tabpanel
		var tabpanel = Ext.getCmp('tabpanel');
		tabpanel.remove(tabpanel.getActiveTab());
	});

	this.getForm().addListener('actionfailed', function() {
		alert('asdf2');
	});
}

Ext.extend(WebTricks.Applications.ContentManager.Editor, Ext.form.FormPanel,
{
	/**
	 * Saves the content items
	 */
    save: function()
    {
		// Sync de HTML Editors
		HtmlEditors = this.findByType('tinymce');

		for (i=0;i<HtmlEditors.length;i++) {
			HtmlEditors[i].syncValue();
		}

		this.getForm().submit({
			url: '/json/content/editor/save/?contentId='+this.contentId,
			waitMsg:'Bewaren...'
		});

    },

    /**
     * Deletes the content item
     */
	deleteItem: function()
	{
    	alert('hier');
	},

	/**
	 * Cancels current edit operations and closes the tab / window
	 */
	cancel: function()
	{
		if (this.getForm().isDirty()) {
			Ext.MessageBox.confirm('Confirm', 'Niet alle wijzigingen zijn opgeslagen. Wilt u doorgaan?', function(btn) {
				if (btn == 'yes') {
					this.close();
				}
			},this);
		} else {
			this.close();
		}
	},

	/**
	 * Closes the tab or window
	 */
	close: function()
	{
		if (this.isPopupWindow) {
			var editorWindow = Ext.getCmp('popupWindow');
			editorWindow.close();
		} else {
			var tabpanel = Ext.getCmp('tabpanel');
			tabpanel.remove(tabpanel.getActiveTab());
		}
	},

    cutToClipboard: function()
    {
       CutTxt = document.selection.createRange();
       CutTxt.execCommand("Cut");
    },

    copyToClipboard: function()
    {
       CopiedTxt = document.selection.createRange();
       CopiedTxt.execCommand("Copy");
    },

    pasteFromClipboard: function()
    {
        Paste.execCommand("Copy");
    },

    changeLanguage: function()
    {
    	this.getForm().load({url: 'test.php'});
    }
});