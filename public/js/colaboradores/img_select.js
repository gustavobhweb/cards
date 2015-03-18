function callbackPhoto()
{

	var $userPhoto = $('.userPhoto');

	var usuarioId = $userPhoto.data('id');


    $('.modal-photo').fadeOut('slow', function(){
        $('.loading').hide();
    });

    var src = '/imagens/colaboradores/'+usuarioId+'/temp.png' + '?' + $.now();

    $('.return-modal-menu').click();

    $userPhoto.data('selected', true).attr('src', src);
}
function onLoadwebcam()
{
    $('#avisopermitir').fadeOut();
    $('#waitcam').fadeOut(0, function(){
        $('#imgselect_container').fadeIn();
    });
}

function ImgSelect(e,t){var n={url:"/home/snapwebcam",crop:{aspectRatio:null,minSize:null,maxSize:null,setSelect:null},flash:{swf:"/static/webcam.swf",width:400,height:300},messages:{invalidJson:"Invalid JSON response.",uploadError:"Ajax upload error.",webcam:"Webcam Error: ",flashwebcam:"Webcam Error. Please try again.",uploading:"Uploading...",saving:"Saving...",loading:"Loading...",jcrop:"jQuery Jcrop not loaded",minCropWidth:"Crop selection requires a minimum width of ",maxCropWidth:"Crop selection exceeds maximum width of ",minCropHeight:"Crop selection requires a height of ",maxCropHeight:"Crop selection exceeds maximum height of "}};this.options=$.extend(true,n,t||{});this._container=e;this._alert=e.find(".imgs-alert");this._crop=e.find(".imgs-crop-container");this._webcam=e.find(".imgs-webcam-container");this._saveBtn=e.find(".imgs-save");this._cancelBtn=e.find(".imgs-cancel");this._captureBtn=e.find(".imgs-capture");this.init()}(function(e){e.support.getUserMedia=!!(navigator.getUserMedia||navigator.webkitGetUserMedia||navigator.mozGetUserMedia||navigator.msGetUserMedia);var t=0,n;ImgSelect.prototype={init:function(){t+=1;this._container.find(".imgs-upload").append('<input type="file" name="file">').on("change",e.proxy(this.upload,this));this._container.find(".imgs-webcam").on("click",e.proxy(this.webcam,this))},upload:function(n){var r,i,s=this,o=e(n.target),u=o.clone();this.removeCrop();this.removeWebcam();this.alert(this.i18n("uploading"),2);r=e('<iframe name="iframe-transport-'+t+'" style="display:none;"></iframe>');r.appendTo("body");r.on("load",function(){var t=null;try{t=r.contents().find("body").html();t=e.parseJSON(t)}catch(o){}if(t)s.uploadDone(t);else s.alert(s.i18n("invalidJson"),3);window.setTimeout(function(){r.remove();i.remove();e(n.currentTarget).append(u)},100)});i=e('<form style="display:none;"><form/>');i.prop("method","POST");i.prop("action",this.options.url);i.prop("target",r.prop("name"));i.prop("enctype","multipart/form-data");i.prop("encoding","multipart/form-data");i.append(o);i.append('<input type="hidden" name="action" value="upload"/>');if(this.options.data){e.each(this.options.data,function(t,n){e('<input type="hidden"/>').prop("name","data["+t+"]").val(n).appendTo(i)})}i.appendTo("body");i.submit()},webcam:function(){var t=this,r,i=function(n,r){t.alert(t.i18n("uploading"),2);e.ajax({url:t.options.url,type:"POST",dataType:"json",data:{action:"upload",file:n,data:t.options.data||0,flashwebcam:r}}).done(function(e){t.uploadDone(e)}).fail(function(){t.alert(t.i18n("invalidJson"),3)})};this.removeWebcam();this.removeCrop();this._webcam.show();this.alert(0);t._cancelBtn.on("click",e.proxy(t.removeWebcam,t));if(e.support.getUserMedia){var s=e('<video autoplay style="display:none" width="400"></video>');this._webcam.html(s);navigator.getUserMedia=navigator.getUserMedia||navigator.webkitGetUserMedia||navigator.mozGetUserMedia||navigator.msGetUserMedia;navigator.getUserMedia({video:true},function(e){onLoadwebcam();n=e;s.attr("src",window.URL.createObjectURL(e));s.show();t._captureBtn.show();t._cancelBtn.show();t._captureBtn.on("click",function(){var e=document.createElement("canvas"),n=e.getContext("2d");e.width=s[0].videoWidth;e.height=s[0].videoHeight;n.drawImage(s[0],0,0);t.removeWebcam();i(e.toDataURL("image/png").replace("data:image/png;base64,",""))})},function(e){t.alert(t.i18n("webcam")+e.name,3)})}else{this._webcam.html(webcam.getHtml(this.options.flash));webcam.loaded=function(){t._captureBtn.show();t._cancelBtn.show()};webcam.complete=function(e){if(e){t.removeWebcam();i(e,true)}else t.alert(t.i18n("flashwebcam"),3)};t._captureBtn.on("click",function(){webcam.snap();})}},uploadDone:function(e){callbackPhoto();if(e.success){this.alert(0);if(this.options.uploadComplete)this.options.uploadComplete(e.data);if(this.options.crop)this.crop(e.data.url)}else this.alert(this.i18n(e.data||"uploadError"),3)},crop:function(t){if(!e.Jcrop)return this.alert(this.i18n("jcrop"),3);this.removeCrop();this._cancelBtn.on("click",e.proxy(this.removeCrop,this));var n=this,r=new Image,i=this.options.crop,s,o=function(e){s=e},u={onChange:o,onRelease:o};if(i.aspectRatio)u.aspectRatio=i.aspectRatio;if(i.setSelect)u.setSelect=i.setSelect;if(i.minSize)u.minSize=i.minSize;if(i.maxSize)u.maxSize=i.maxSize;n.alert(n.i18n("loading"),2);r.onload=function(){n.alert(0);n._cancelBtn.show();u.trueSize=[r.width,r.height];var i=e('<img src="'+t+'">').appendTo(n._crop);window.setTimeout(function(){i.Jcrop(u)},100);n._crop.show();n._saveBtn.on("click",function(){if(!n.validateCrop(s||{}))return;n._saveBtn.prop("disabled",true);n.alert(n.i18n("saving"),2);e.ajax({url:n.options.url,type:"POST",dataType:"json",data:{action:"crop",image:t,coords:s,data:n.options.data||0}}).done(function(e){if(e.success){n.alert(0);n.removeCrop();if(n.options.cropComplete)n.options.cropComplete(e.data)}else n.alert(n.i18n(e.data||"uploadError"),3)}).fail(function(){n.alert(n.i18n("invalidJson"),3)}).always(function(){n._saveBtn.prop("disabled",false)})}).show()};r.src=t},validateCrop:function(e){var t=this.options.crop;if(t.minSize){if(t.minSize[0]&&(e.w||0)<t.minSize[0])return this.alert(this.i18n("minCropWidth")+t.minSize[0]+"px",3);if(t.maxSize[0]&&(e.w||0)>t.maxSize[0])return this.alert(this.i18n("maxCropWidth")+t.maxSize[0]+"px",3);if(t.minSize[1]&&(e.h||0)<t.minSize[1])return this.alert(this.i18n("minCropHeight")+t.minSize[1]+"px",3);if(t.maxSize[1]&&(e.h||0)>t.maxSize[1])return this.alert(this.i18n("maxCropHeight")+t.maxSize[1]+"px",3)}return true},removeWebcam:function(){if(n)n.stop();this._webcam.html("");this._captureBtn.off("click").hide();this._cancelBtn.off("click").hide()},removeCrop:function(){e(this._crop).html("");this._saveBtn.off("click").hide();this._cancelBtn.off("click").hide()},alert:function(t,n){if(this.options.alert)return this.options.alert(t,n);if(!t)return e(this._alert).hide();e(this._alert).html(t).removeClass(n==1?"alert-danger alert-warning":n==2?"alert-danger alert-success":"alert-warning alert-danger").addClass("alert-"+(n==1?"success":n==2?"warning":"danger")).show()},i18n:function(e){e=this.options.messages[e]||e.toString();return e}}})(jQuery);window.webcam={isLoaded:false,loaded:null,complete:null,error:null,getHtml:function(e){return'<object id="webcam_movie" type="application/x-shockwave-flash" data="'+e.swf+'" width="'+e.width+'" height="'+e.height+'">'+'<param name="wmode" value="transparent">'+'<param name="movie" value="'+e.swf+'">'+'<param name="FlashVars" value="width='+e.width+"&height="+e.height+"&server_width="+e.width*1.5+"&server_height="+e.height*1.5+'">'+'<param name="allowScriptAccess" value="always">'+"</object>"},snap:function(){if(!this.isLoaded)return alert("ERROR: Movie is not loaded yet");var e=document.getElementById("webcam_movie");if(!e)alert("ERROR: Cannot locate movie #webcam_movie in DOM");try{e._snap()}catch(t){}},notify:function(e,t){switch(e){case"loaded":this.isLoaded=true;this.loaded();break;case"error":this.error(t);break;case"success":this.complete(t);break}}}