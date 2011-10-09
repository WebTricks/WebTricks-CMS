Ext.form.GroupComboBox = function(config)
{
    var cls = 'x-combo-list';
    this.tpl = '<div class="'+cls+'-item x-combo-list-group">{' + config.groupField + '}</div><div class="'+cls+'-item x-combo-list-groupitem">{' + config.displayField + '}</div>';
    
    Ext.form.GroupComboBox.superclass.constructor.call(this, config);
};

Ext.extend(Ext.form.GroupComboBox, Ext.form.ComboBox,
{
    groupField: undefined
});  
