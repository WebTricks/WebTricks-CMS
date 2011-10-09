
WebTricks.Shell.Applications.Media.ImageEditor = Ext.extend(WebTricks.Shell.Module,
{
	createWindow: function()
    {
	    var desktop = this.app.getDesktop();
	    var win = desktop.getWindow(this.id);

	    if(!win) {
	    		    	
	    	this.toolbar = new Ext.Panel({bodyCssClass: 'webtricks-toolbar-body', 'border': false, 'region': 'north', 'height': 115, 'items': this.toolbar});
	    	
			var imgView_Template = new Ext.XTemplate(
					'<tpl for=".">',
					'<div class="pref-view-thumb-wrap" id="{id}">',
					'<div class="pref-view-thumb"><img src="{pathtothumbnail}" title="{name}" /></div>',
					'<span>{shortName}</span></div>',
					'</tpl>',
					'<div class="x-clear"></div>'
				);
	    	
	    	
	        win = desktop.createWindow({
	            id: this.id,
	            title: 'Image Editor',
	            width: 740,
	            height: 480,
	            iconCls: 'icon-palette2',
	            layout: 'border',	            
	            items: [this.toolbar, new WebTricks.Shell.Applications.Media.ImageEditor.Container({owner: this})]
	        });
	    } 
	    
	    win.show();
	},

	processImage: function(params)
	{
		var aURL = "";
		
		if (params.aURL != "") {
			aURL = params.aURL;
			params.aURL = "";
			delete params.aURL;
		}
		
		params.imageName = rich_ImageEditor.imgName;
		params.Hindex = rich_ImageEditor.historyIndex;
		
		this.sendAjaxRequest(
			params,
			function(result, request) {
				var response = Ext.util.JSON.decode(result.responseText);
				if (response.error) {
					this.showErrorMsg(response.error);
				} else { 
					imageData=new Ext.data.Store({
							lastFtnCall: params,
							name: response.imageName,
							w: response.w,
							h: response.h,
							imgMAXh : response.maxHeight,
							imgMAXw : response.maxWidth,
							imgWH_tolerance: response.tolerance,
							imgSize_orig: response.imgSize_orig,
							imgSize_edit: response.imgSize_edit,
							size: true,
							imgW_orig: response.ow,
							imgH_orig: response.oh,
							lastmod: new Date(response.lastmod).format("n/d/Y g:i a"),
							url: response.url,
							imgZoom: 100 * response.zoomRatio,
							imgAspectRatio: response.imgAspectRatio,
							imgRez: response.imgRez,
							imgEXIF: response.exif,
					});
					
					if(params.action != "cleanUp" && params.action!="save") {
						this.displayImage(imageData);
					}
				}
			},
			function(result, request) {
				this.showErrorMsg(rich_ImageEditor.connErrMsg);
			},
			aURL
		);
	},
	
	displayImage: function(imageData)
	{
    	var thisApp = rich_ImageEditor.getDesktop.getWindow(rich_ImageEditor.winId);
		var actionFlag=false;
		try{
			actionFlag=true; //when not performed by upload/open command
			sb_text=imageData.lastFtnCall.action+" done. "+sb_text;
		}catch(e){}//escape err
		
		if(actionFlag) {
		try{
			if(imageData.lastFtnCall.action!="undo" &&
			   imageData.lastFtnCall.action!="redo" &&
			   imageData.lastFtnCall.action!="cleanUp" &&
			   imageData.lastFtnCall.action!="restoreIMG" &&
			   imageData.lastFtnCall.action!="viewActive" &&
			   imageData.lastFtnCall.action!="save" &&
			   imageData.lastFtnCall.action!="" &&
			   imageData.lastFtnCall.redoFlag!=true) {
				
				rich_ImageEditor.historyIndex++;
				var tempHist=new Array();
				for(x=0; x<rich_ImageEditor.historyIndex;x++){
					//rebuild history
					tempHist[x]=rich_ImageEditor.historyAction[x];
				}//end for x
				rich_ImageEditor.historyAction=null;//empty it out
				delete rich_ImageEditor.historyAction;
				rich_ImageEditor.historyAction=tempHist;
				delete tempHist; //clear mem
				rich_ImageEditor.historyAction[rich_ImageEditor.historyIndex]=imageData.lastFtnCall;
			}//end if recordable history
			if(imageData.lastFtnCall.action=="restoreIMG"){
				rich_ImageEditor.historyIndex=0;
				delete rich_ImageEditor.historyAction;
				rich_ImageEditor.historyAction=new Array();
			}//reset undo/redo upon restore
		}catch(e){}//escape err
		}//end if actionFlag
		if(imageData.size===true){
			//an action was performed
			rich_ImageEditor.imgSize_orig= imageData.imgSize_orig;// in KB
			rich_ImageEditor.imgSize_edit= imageData.imgSize_edit;
			rich_ImageEditor.imgW_orig= imageData.imgW_orig;
			rich_ImageEditor.imgH_orig=imageData.imgH_orig;
			rich_ImageEditor.imgMAXw=imageData.imgMAXw;
			rich_ImageEditor.imgMAXh=imageData.imgMAXh;
			rich_ImageEditor.imgWH_tolerance=imageData.imgWH_tolerance;
			rich_ImageEditor.imgZoom=imageData.imgZoom;
			rich_ImageEditor.imgAspectRatio=imageData.imgAspectRatio;
			rich_ImageEditor.imgEXIF=imageData.imgEXIF;
		}else{//loaded by open cmd
			rich_ImageEditor.imgSize_orig= imageData.size/1000;
			rich_ImageEditor.imgSize_edit= imageData.size/1000;
			rich_ImageEditor.imgW_orig= imageData.w;
			rich_ImageEditor.imgH_orig=imageData.h;
			rich_ImageEditor.imgEXIF="< Please \"Reload Current\" image to load EXIF data >";
		}//end if imageData.size
		rich_ImageEditor.imgRez=imageData.imgRez;
		rich_ImageEditor.imgW_edit= imageData.w;
		rich_ImageEditor.imgH_edit= imageData.h;
		rich_ImageEditor.imgDATE= imageData.lastmod;
		if(rich_ImageEditor.w<=0) rich_ImageEditor.w=imageData.w;
		if(rich_ImageEditor.h<=0) rich_ImageEditor.h=imageData.h;
		if(rich_ImageEditor.imgName!= imageData.name && rich_ImageEditor.imgName!= ""){
			//remove previous image from edit dir
			this.processImage({'action': "cleanUp"});
			rich_ImageEditor.w= imageData.w; //canvas matches image
			rich_ImageEditor.h= imageData.h;
			rich_ImageEditor.cursorStyle="default";
			rich_ImageEditor.historyIndex=0;
			rich_ImageEditor.historyAction= new Array("");
		}//end if imgName
		rich_ImageEditor.imgName= imageData.name;
		rich_ImageEditor.imgURL= imageData.url;
		Ext.DomHelper.overwrite('ImageEditorCanvas', {
			tag: 'img',
			src: rich_ImageEditor.getImgUrl+"?imageName="+rich_ImageEditor.imgName+"&Hindex="+rich_ImageEditor.historyIndex+"&_dc="+(new Date).getTime(),
			style:'margin:0px;',
			id: "CanvasPIC",
			name: "CanvasPIC",
		}, true).show(true).frame();

		var IEc= Ext.get("ImageEditorCanvas");//init the eventManager
		IEc.on('click', function(e){this.mouseManager("click",e)},this);
		IEc.on('dblclick', function(e){this.mouseManager("dblclick",e)},this);
		if(Ext.isIE) IEc.on('drag', function(e){this.mouseManager("drag",e)},this);//,{delay:20}
		IEc.on('keydown', function(e){this.mouseManager("keydown",e)},this);
		IEc.on('keyup', function(e){this.mouseManager("keyup",e)},this);
		IEc.on('keypress', function(e){this.mouseManager("keypress",e)},this);
		IEc.on('mousedown', function(e){this.mouseManager("mousedown",e)},this);
		IEc.on('mouseup', function(e){this.mouseManager("mouseup",e)},this);
		IEc.on('mousemove', function(e){this.mouseManager("mousemove",e)},this);
		IEc.on('mouseover', function(e){this.mouseManager("mouseover",e)},this);
		IEc.on('mouseout', function(e){this.mouseManager("mouseout",e)},this);
		IEc.on('scroll', function(e){this.mouseManager("scroll",e)},this);

		this.updateCanvas();
	}	
});

WebTricks.Shell.Applications.Media.ImageEditor.Container = function(config){
	this.owner = config.owner;
	
	WebTricks.Shell.Applications.Media.ImageEditor.Container.superclass.constructor.call(this, {
		autoScroll: false,
		bodyStyle: 'padding:0px',
		border: true,
		region: 'center',
		html: '<div name="ImageEditorWindow" id="ImageEditorWindow" ><table id="IEW_canvasContainer" border="0" cellpadding="0" cellspacing="0"><tr><td align="right" valign="bottom"><img id="rulerZ" name="rulerZ" src="/media/shell/base/default/images/imageeditor/rule.jpg" width="15" height="15" alt="Ruler" galleryimg="no"></td><td align="left" valign="bottom"><div id="edRuleX" name="edRuleX"><img id="rulerX" name="rulerX" src="/media/shell/base/default/images/imageeditor/ruler_vertical.jpg" width="699" height="15" alt="Ruler: Pixels" galleryimg="no"></div></td></tr><tr><td align="right" valign="top"><div id="edRuleY" name="edRuleY"><img id="rulerY" name="rulerY" src="/media/shell/base/default/images/imageeditor/ruler_horizontal.jpg" width="15" height="699" alt="Ruler: Pixels" galleryimg="no"></div></td><td width="100%" height="100%" align="left" valign="top" background="/media/shell/base/default/images/imageeditor/canvas.jpg"><div name="ImageEditorCanvas" id="ImageEditorCanvas"></div></td></tr></table></div>',
		id: config.id
	});
};
Ext.extend(WebTricks.Shell.Applications.Media.ImageEditor.Container, Ext.Panel);
