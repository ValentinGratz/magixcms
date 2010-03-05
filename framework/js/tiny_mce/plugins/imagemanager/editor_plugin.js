(function(){window.mcImageManager={settings:{document_base_url:"",relative_urls:false,remove_script_host:false,use_url_path:true,remember_last_path:"auto",target_elements:"",target_form:"",handle:"image,media"},setup:function(){var e=this,h,g=document,f=[];h=g.location.href;if(h.indexOf("?")!=-1){h=h.substring(0,h.indexOf("?"))}h=h.substring(0,h.lastIndexOf("/")+1);e.settings.default_base_url=unescape(h);function c(d){var j,k;for(j=0;j<d.length;j++){k=d[j];f.push(k);if(k.src&&/mcimagemanager\.js/g.test(k.src)){return k.src.substring(0,k.src.lastIndexOf("/"))}}}h=g.documentElement;if(h&&(h=c(h.getElementsByTagName("script")))){return e.baseURL=h}h=g.getElementsByTagName("script");if(h&&(h=c(h))){return e.baseURL=h}h=g.getElementsByTagName("head")[0];if(h&&(h=c(h.getElementsByTagName("script")))){return e.baseURL=h}},relaxDomain:function(){var c=this,d=/(http|https):\/\/([^\/:]+)\/?/.exec(c.baseURL);if(window.tinymce&&tinymce.relaxedDomain){c.relaxedDomain=tinymce.relaxedDomain;return}if(d&&d[2]!=document.location.hostname){document.domain=c.relaxedDomain=d[2].replace(/.*\.(.+\..+)$/,"$1")}},init:function(c){this.extend(this.settings,c)},browse:function(d){var c=this;d=d||{};if(d.fields){d.oninsert=function(e){c.each(d.fields.replace(/\s+/g,"").split(/,/),function(f){var g;if(g=document.getElementById(f)){c._setVal(g,e.focusedFile.url)}})}}this.openWin({page:"index.html",scrollbars:"yes"},d)},edit:function(c){this.openWin({page:"edit.html",width:800,height:500},c)},upload:function(c){this.openWin({page:"upload.html",width:550,height:350},c)},view:function(c){this.openWin({page:"view.html",width:800,height:500},c)},createDir:function(c){this.openWin({page:"createdir.html",width:450,height:280},c)},openWin:function(i,d){var h=this,c,e;h.windowArgs=d=h.extend({},h.settings,d);i=h.extend({x:-1,y:-1,width:810,height:500,inline:1},i);if(i.x==-1){i.x=parseInt(screen.width/2)-(i.width/2)}if(i.y==-1){i.y=parseInt(screen.height/2)-(i.height/2)}if(i.page){i.url=h.baseURL+"/../index.php?type=im&page="+i.page}if(d.session_id){i.url+="&sessionid="+d.session_id}if(d.custom_data){i.url+="&custom_data="+escape(d.custom_data)}if(h.relaxedDomain){i.url+="&domain="+escape(h.relaxedDomain)}if(d.custom_query){i.url+=d.custom_query}if(d.target_frame){if(e=frames[d.target_frame]){e.document.location=i.url}if(e=document.getElementById(d.target_frame)){e.src=i.url}return}if(window.tinymce&&tinyMCE.activeEditor){return tinyMCE.activeEditor.windowManager.open(i,d)}if(window.jQuery&&jQuery.WindowManager){return jQuery.WindowManager.open(i,d)}c=window.open(i.url,"mcImageManagerWin","left="+i.x+",top="+i.y+",width="+i.width+",height="+i.height+",scrollbars="+(i.scrollbars?"yes":"no")+",resizable="+(i.resizable?"yes":"no")+",statusbar="+(i.statusbar?"yes":"no"));try{c.focus()}catch(g){}},each:function(g,e,d){var h,c;if(g){d=d||g;if(g.length!==undefined){for(h=0,c=g.length;h<c;h++){e.call(d,g[h],h,g)}}else{for(h in g){if(g.hasOwnProperty(h)){e.call(d,g[h],h,g)}}}}},extend:function(){var e,c=arguments,g=c[0],f,d;for(f=1;f<c.length;f++){if(d=c[f]){for(e in d){g[e]=d[e]}}}return g},open:function(i,e,d,c,h){var f=this,g;h=h||{};if(!h.url&&document.forms[i]&&(g=document.forms[i].elements[e.split(",")[0]])){h.url=g.value}if(!c){h.oninsert=function(n){var m,k,j,l=n.focusedFile;j=e.replace(/\s+/g,"").split(",");for(k=0;k<j.length;k++){if(m=document.forms[i][j[k]]){f._setVal(m,l.url)}}}}else{if(typeof(c)=="string"){c=window[c]}h.oninsert=function(j){c(j.focusedFile.url,j)}}f.browse(h)},filebrowserCallBack:function(h,k,d,j,e){var l=mcImageManager,f,c,g,m={};if(window.mcFileManager&&!e){c=mcFileManager.settings.handle;c=c.split(",");for(f=0;f<c.length;f++){if(d==c[f]){g=1}}if(g&&mcFileManager.filebrowserCallBack(h,k,d,j,1)){return}}l.each(tinyMCE.activeEditor?tinyMCE.activeEditor.settings:tinyMCE.settings,function(n,i){if(i.indexOf("imagemanager_")===0){m[i.substring(13)]=n}});l.browse(l.extend(m,{url:j.document.forms[0][h].value,relative_urls:0,oninsert:function(q){var p,n,i;p=j.document.forms[0];n=q.focusedFile.url;inf=q.focusedFile.custom;if(typeof(TinyMCE_convertURL)!="undefined"){n=TinyMCE_convertURL(n,null,true)}else{if(tinyMCE.convertURL){n=tinyMCE.convertURL(n,null,true)}else{n=tinyMCE.activeEditor.convertURL(n,null,true)}}if(inf.custom&&inf.custom.description){i=["alt","title","linktitle"];for(f=0;f<i.length;f++){if(p.elements[i[f]]){p.elements[i[f]].value=inf.custom.description}}}l._setVal(p[h],n);j=null}}));return true},_setVal:function(f,c){f.value=c;try{f.onchange()}catch(d){}}};mcImageManager.setup();mcImageManager.relaxDomain();var a={getInfo:function(){return{longname:"MCImageManager PHP",author:"Moxiecode Systems AB",authorurl:"http://tinymce.moxiecode.com",infourl:"http://tinymce.moxiecode.com/plugins_filemanager.php",version:"3.1.2"}},convertURL:function(c){if(window.TinyMCE_convertURL){return TinyMCE_convertURL(c,null,true)}if(tinyMCE.convertURL){return tinyMCE.convertURL(c,null,true)}return tinyMCE.activeEditor.convertURL(c,null,true)},replace:function(g,k,j){var f,h;if(typeof(g)!="string"){return g(k,j)}function c(i,e){for(f=0,h=i,e=e.split(".");f<e.length;f++){h=h[e[f]]}return h}g=""+g.replace(/\{\$([^\}]+)\}/g,function(i,d){var e=d.split("|"),m=c(k,e[0]);if(e.length==1&&j&&j.xmlEncode){m=j.xmlEncode(m)}for(f=1;f<e.length;f++){m=j[e[f]](m,k,d)}return m});g=g.replace(/\{\=([\w]+)([^\}]+)\}/g,function(e,d,i){return c(j,d)(k,d,i)});return g}};if(window.tinymce){tinymce.create("tinymce.plugins.ImageManagerPlugin",{init:function(c,d){var e=this;e.editor=c;e.url=d;mcImageManager.baseURL=d+"/js";c.settings.file_browser_callback=mcImageManager.filebrowserCallBack;mcImageManager.settings.handle=c.getParam("imagemanager_handle",mcImageManager.settings.handle);c.onInit.add(function(){if(c&&c.plugins.contextmenu&&c.getParam("imagemanager_contextmenu",true)){c.plugins.contextmenu.onContextMenu.add(function(h,f,i){var g=c.selection.getNode();if(g&&g.nodeName=="IMG"){f.addSeparator();sm=f.addMenu({title:"ImageManager"});sm.add({title:"imagemanager_replaceimage_desc",icon_src:d+"/pages/im/img/insertimage.gif",onclick:function(){mcImageManager.browse({path:c.getParam("imagemanager_path"),rootpath:c.getParam("imagemanager_rootpath"),remember_last_path:c.getParam("imagemanager_remember_last_path"),custom_data:c.getParam("imagemanager_custom_data"),insert_filter:c.getParam("imagemanager_insert_filter"),oninsert:function(j){c.dom.setAttribs(g,{width:"",height:"",style:{width:"",height:""}});c.dom.setAttrib(g,"src",j.focusedFile.url)}})}});sm.add({title:"imagemanager_editimage_desc",icon_src:d+"/pages/im/img/editimage.gif",onclick:function(){mcImageManager.edit({insert_filter:c.getParam("imagemanager_insert_filter"),url:c.documentBaseURI.toAbsolute(c.dom.getAttrib(g,"src",c.dom.getAttrib(g,"src"))),onsave:function(j){c.dom.setAttribs(g,{width:"",height:"",style:{width:"",height:""}});c.dom.setAttrib(g,"src",j.file.url)}})}})}})}});c.addCommand("mceInsertImage",function(g,f){var h={};tinymce.each(tinyMCE.activeEditor.settings,function(j,i){if(i.indexOf("imagemanager_")===0){h[i.substring(13)]=j}});mcImageManager.browse(tinymce.extend(h,{oninsert:function(j){var i=j.focusedFile.custom;if(!i.thumbnail_url){i.thumbnail_url=d;i.twidth=i.width;i.theight=i.height}c.execCommand("mceInsertContent",false,a.replace(c.getParam("imagemanager_insert_template",'<img src="{$url}" width="{$custom.width}" height="{$custom.height}" />'),j.focusedFile,{urlencode:function(k){return escape(k)},xmlEncode:function(k){return tinymce.DOM.encode(k)}}))}},f))})},getInfo:function(){return a.getInfo()},createControl:function(i,d){var g=this,h,f=g.editor,e;switch(i){case"insertimage":e=f.getParam("imagemanager_insert_template");if(e instanceof Array){h=d.createMenuButton("insertimage",{title:"imagemanager_insertimage_desc",image:g.url+"/pages/im/img/insertimage.gif",icons:false});h.onRenderMenu.add(function(k,j){tinymce.each(e,function(c){j.add({title:c.title,onclick:function(){f.execCommand("mceInsertImage",false,c)}})})})}else{h=d.createButton("insertimage",{title:"imagemanager_insertimage_desc",image:g.url+"/pages/im/img/insertimage.gif",onclick:function(){f.execCommand("mceInsertImage",false,{template:e})}})}return h}return null}});tinymce.PluginManager.add("imagemanager",tinymce.plugins.ImageManagerPlugin);tinymce.ScriptLoader.load((tinymce.PluginManager.urls.imagemanager||tinymce.baseURL+"/plugins/imagemanager")+"/language/index.php?type=im&format=tinymce_3_x&group=tinymce&prefix=imagemanager_")}if(window.TinyMCE_Engine){var b={setup:function(){var c=(window.realTinyMCE||tinyMCE).baseURL;mcImageManager.baseURL=c+"/plugins/imagemanager/js";document.write('<script type="text/javascript" src="'+c+'/plugins/imagemanager/language/index.php?type=im&format=tinymce&group=tinymce&prefix=imagemanager_"><\/script>')},initInstance:function(c){c.settings.file_browser_callback="mcImageManager.filebrowserCallBack";mcImageManager.settings.handle=tinyMCE.getParam("imagemanager_handle",mcImageManager.settings.handle)},getControlHTML:function(c){switch(c){case"insertimage":return tinyMCE.getButtonHTML(c,"lang_imagemanager_insertimage_desc","{$pluginurl}/pages/im/img/insertimage.gif","mceInsertImage",false)}return""},getInfo:function(){return a.getInfo()},execCommand:function(h,e,g,f,d){var c=tinyMCE.getInstanceById(h);if(g=="mceInsertImage"){mcImageManager.browse(tinyMCE.extend({path:tinyMCE.getParam("imagemanager_path"),rootpath:tinyMCE.getParam("imagemanager_rootpath"),remember_last_path:tinyMCE.getParam("imagemanager_remember_last_path"),custom_data:tinyMCE.getParam("imagemanager_custom_data"),insert_filter:tinyMCE.getParam("imagemanager_insert_filter"),oninsert:function(j){var i=j.focusedFile.custom;if(!i.thumbnail_url){i.thumbnail_url=url;i.twidth=i.width;i.theight=i.height}c.execCommand("mceInsertContent",false,a.replace(tinyMCE.getParam("imagemanager_insert_template",'<a href="{$url}" rel="lightbox"><img src="{$custom.thumbnail_url}" width="{$custom.twidth}" height="{$custom.theight}" /></a>'),j.focusedFile,{urlencode:function(k){return escape(k)},xmlEncode:function(k){return tinyMCE.xmlEncode(k)}}))}},d));return true}return false}};b.setup();tinyMCE.addPlugin("imagemanager",b)}})();