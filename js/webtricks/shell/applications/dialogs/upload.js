Ext.namespace("WebTricks");
Ext.namespace("WebTricks.Shell");
Ext.namespace("WebTricks.Shell.Applications");
Ext.namespace("WebTricks.Shell.Applications.Dialogs");

WebTricks.Shell.Applications.Dialogs.Upload = function(config)
{	
	var statusIconRenderer = function(value){
		switch(value){
			default:
				return value;
			case 'Pending':
				return '<img src="/inc/img/hourglass.png" width=16 height=16>';
			case 'Sending':
				return '<img src="/inc/img/loading.gif" width=16 height=16>';
			case 'Error':
				return '<img src="/inc/img/cross.png" width=16 height=16>';
			case 'Cancelled':
			case 'Aborted':
				return '<img src="/inc/img/cancel.png" width=16 height=16>';
			case 'Uploaded':
				return '<img src="/inc/img/tick.png" width=16 height=16>';
		}
	}
	
	progressBarColumnTemplate = new Ext.XTemplate(
		'<div class="ux-progress-cell-inner ux-progress-cell-inner-center ux-progress-cell-foreground">',
			'<div>{value} %</div>',
		'</div>',
		'<div class="ux-progress-cell-inner ux-progress-cell-inner-center ux-progress-cell-background" style="left:{value}%">',
			'<div style="left:-{value}%">{value} %</div>',
		'</div>'
    )
    
	progressBarColumnRenderer = function(value, meta, record, rowIndex, colIndex, store){
        meta.css += ' x-grid3-td-progress-cell';
		return progressBarColumnTemplate.apply({
			value: value
		});
	}
	
	this.updateFileUploadRecord = function(id, column, value) {
		var rec = this.gridPanel.store.getById(id);
		rec.set(column, value);
		rec.commit();
	}
	
	this.selectFilesButton = new Ext.Button({
		iconCls: 'icon-large-folder-up',
		iconAlign: 'top',
		scale: 'large',
		text: 'Select files'
	});
	
	this.uploadButton = new Ext.Button({
		text:'Start Upload',
		iconAlign: 'top',
		scale: 'large',		
		iconCls: 'icon-large-upload',		
		scope: this,
		handler: function() {
			this.uploader.startUpload();
		}		
	})
	
	this.abortButton = new Ext.SplitButton({
		minWidth: 50,
		text:'Abort',
		iconAlign: 'top',
		scale: 'large',		
		iconCls: 'icon-large-earth-delete',		
		scope: this,
		handler: function() {
			this.uploader.startUpload();
		},
		menu: {
			items: [{
				text: 'Abort All',
				scope: this,
				handler: function() {
					this.uploader.abortAllUploads();
				}
			}]
		}
	})
		
	this.deleteButton = new Ext.Button({
		minWidth: 50,
		text:'Delete',
		iconAlign: 'top',
		scale: 'large',		
		iconCls: 'icon-large-delete2',		
		scope: this,
		handler: function() {
			this.uploader.startUpload();
		}		
	})
	
	this.filesButtonGroup = new Ext.ButtonGroup({
		title: 'Files',
		items: [this.selectFilesButton]
	});
	
	this.actionsButtonGroup = new Ext.ButtonGroup({
		title: 'Actions',
		items: [this.uploadButton, this.abortButton, this.deleteButton]
	});

	
	this.placeholderId = Ext.id(); 

	this.uploader = new Ext.ux.AwesomeUploader({
		placeholderId: this.placeholderId,
			awesomeUploaderRoot: '/js/awesomeuploader/',
			height: 40,
			allowDragAndDropAnywhere: true,
			autoStartUpload: false,
			maxFileSizeBytes: 15 * 1024 * 1024, // 15 MiB
			listeners: {
				scope:this,
				fileselected: function(awesomeUploader, file)
				{
					this.gridPanel.store.loadData({
						id:file.id,
						name:file.name,
						size:file.size,
						status:'Pending',
						progress:0
					}, true);
				},
				uploadstart:function(awesomeUploader, file)
				{				
					this.updateFileUploadRecord(file.id, 'status', 'Sending');
				},
				uploadprogress:function(awesomeUploader, fileId, bytesComplete, bytesTotal)
				{
					this.updateFileUploadRecord(fileId, 'progress', Math.round((bytesComplete / bytesTotal)*100) );
				},
				uploadcomplete:function(awesomeUploader, file, serverData, resultObject){
					try {
						var result = Ext.util.JSON.decode(serverData);//throws a SyntaxError.
					} catch(e) {
						resultObject.error = 'Invalid JSON data returned';
						//Invalid json data. Return false here and "uploaderror" event will be called for this file. Show error message there.
						return false;
					}
					
					resultObject = result;
					
					if(result.success){
						this.updateFileUploadRecord(file.id, 'progress', 100 );
						this.updateFileUploadRecord(file.id, 'status', 'Uploaded' );
					} else {
						return false;
					}
				}
				,uploadaborted:function(awesomeUploader, file ){
					this.updateFileUploadRecord(file.id, 'status', 'Aborted' );
				}
				,uploadremoved:function(awesomeUploader, file ){
					
					this.gridPanel.store.remove(this.gridPanel.store.getById(file.id) );
				}
				,uploaderror:function(awesomeUploader, file, serverData, resultObject){
					resultObject = resultObject || {};
					
					var error = 'Error! ';
					if(resultObject.error){
						error += resultObject.error;
					}
					
					this.updateFileUploadRecord(file.id, 'progress', 0 );
					this.updateFileUploadRecord(file.id, 'status', 'Error' );
					
				}
			}
	});
	
	this.gridPanel = new Ext.grid.GridPanel({
			enableHdMenu: false,
			tbar:[
			      this.filesButtonGroup, 
			      this.actionsButtonGroup,
			{
				text:'Abort'
				,icon:'/inc/img/cancel.png'
				,scope:this
				,handler:function(){
					var selModel = this.gridPanel.getSelectionModel();
					if(!selModel.hasSelection()){
						Ext.Msg.alert('','Please select an upload to cancel');
						return true;
					}
					var rec = selModel.getSelected();
					this.uploader.abortUpload(rec.data.id);
				}
			},{
				text:'Abort All'
				,icon:'/inc/img/cancel.png'
				,scope:this
				,handler:function(){
					this.uploader.abortAllUploads();
				}
			},{
				text:'Remove'
				,icon:'/inc/img/cross.png'
				,scope:this
				,handler:function(){
					var selModel = this.gridPanel.getSelectionModel();
					if(!selModel.hasSelection()){
						Ext.Msg.alert('','Please select an upload to cancel');
						return true;
					}
					var rec = selModel.getSelected();
					this.uploader.removeUpload(rec.data.id);
				}
			},{
				text:'Remove All'
				,icon:'/inc/img/cross.png'
				,scope:this
				,handler:function(){
					this.uploader.removeAllUploads();
				}
			}],
			store:new Ext.data.JsonStore({
				fields: ['id','name','size','status','progress'],
    			idProperty: 'id'
			}),
			columns:[
				{header:'File Name', dataIndex:'name', width: '25%'},
				{header:'Size', dataIndex:'size', width: '25%', renderer:Ext.util.Format.fileSize},
				{header:'&nbsp;', dataIndex:'status', width: '20%', renderer:statusIconRenderer},
				{header:'Status', dataIndex:'status', width: '20%'},
				{header:'Progress', dataIndex:'progress', width: '20%', renderer:progressBarColumnRenderer}
			]
	});

    this.modal = true;
    this.height = 400;
    this.width = 400;
    this.bodyBorder = false;
    this.border = false;
    this.title = 'Upload';
    this.layout = 'fit';
    this.items = [this.gridPanel]
        
    this.selectFilesButton.on('afterrender', function() {
        var em = this.selectFilesButton.el.child('em');

        em.setStyle({
            position: 'relative',
            display: 'block'
        });
        em.createChild({
            tag: 'div',
            id: this.placeholderId
        });
                
        this.add(this.uploader);
        
    }, this);
        
    WebTricks.Shell.Applications.Dialogs.Upload.superclass.constructor.call(this, config);
}

Ext.extend(WebTricks.Shell.Applications.Dialogs.Upload, Ext.Window,
{

});