(function(g){"function"===typeof define&&define.amd?define(["jquery","datatables.net","datatables.net-buttons"],function(k){return g(k,window,document)}):"object"===typeof exports?module.exports=function(k,l){k||(k=window);if(!l||!l.fn.dataTable)l=require("datatables.net")(k,l).$;l.fn.dataTable.Buttons||require("datatables.net-buttons")(k,l);return g(l,k,k.document)}:g(jQuery,window,document)})(function(g,k,l,q){function v(a){for(var b="";0<=a;)b=String.fromCharCode(a%26+65)+b,a=Math.floor(a/26)-
    1;return b}function n(a,b,d){var c=a.createElement(b);d&&(d.attr&&g(c).attr(d.attr),d.children&&g.each(d.children,function(a,b){c.appendChild(b)}),null!==d.text&&d.text!==q&&c.appendChild(a.createTextNode(d.text)));return c}function B(a,b){var d=a.header[b].length,c;a.footer&&a.footer[b].length>d&&(d=a.footer[b].length);for(var e=0,f=a.body.length;e<f;e++)if(c=a.body[e][b],c=null!==c&&c!==q?c.toString():"",-1!==c.indexOf("\n")?(c=c.split("\n"),c.sort(function(a,b){return b.length-a.length}),c=c[0].length):
        c=c.length,c>d&&(d=c),40<d)return 52;d*=1.3;return 6<d?d:6}function w(a){o===q&&(o=-1===u.serializeToString(g.parseXML(p["xl/worksheets/sheet1.xml"])).indexOf("xmlns:r"));g.each(a,function(b,d){if(g.isPlainObject(d))w(d);else{if(o){var c=d.childNodes[0],e,f,i=[];for(e=c.attributes.length-1;0<=e;e--){f=c.attributes[e].nodeName;var j=c.attributes[e].nodeValue;-1!==f.indexOf(":")&&(i.push({name:f,value:j}),c.removeAttribute(f))}e=0;for(f=i.length;e<f;e++)j=d.createAttribute(i[e].name.replace(":","_dt_b_namespace_token_")),
    j.value=i[e].value,c.setAttributeNode(j)}c=u.serializeToString(d);o&&(-1===c.indexOf("<?xml")&&(c='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'+c),c=c.replace(/_dt_b_namespace_token_/g,":"));c=c.replace(/<([^<>]*?) xmlns=""([^<>]*?)>/g,"<$1 $2>");a[b]=c}})}var h=g.fn.dataTable,i={version:"1.0.4-TableTools2",clients:{},moviePath:"",nextId:1,$:function(a){"string"==typeof a&&(a=l.getElementById(a));a.addClass||(a.hide=function(){this.style.display="none"},a.show=function(){this.style.display=
    ""},a.addClass=function(a){this.removeClass(a);this.className+=" "+a},a.removeClass=function(a){this.className=this.className.replace(RegExp("\\s*"+a+"\\s*")," ").replace(/^\s+/,"").replace(/\s+$/,"")},a.hasClass=function(a){return!!this.className.match(RegExp("\\s*"+a+"\\s*"))});return a},setMoviePath:function(a){this.moviePath=a},dispatch:function(a,b,d){(a=this.clients[a])&&a.receiveEvent(b,d)},log:function(a){console.log("Flash: "+a)},register:function(a,b){this.clients[a]=b},getDOMObjectPosition:function(a){var b=
    {left:0,top:0,width:a.width?a.width:a.offsetWidth,height:a.height?a.height:a.offsetHeight};""!==a.style.width&&(b.width=a.style.width.replace("px",""));""!==a.style.height&&(b.height=a.style.height.replace("px",""));for(;a;)b.left+=a.offsetLeft,b.top+=a.offsetTop,a=a.offsetParent;return b},Client:function(a){this.handlers={};this.id=i.nextId++;this.movieId="ZeroClipboard_TableToolsMovie_"+this.id;i.register(this.id,this);a&&this.glue(a)}};i.Client.prototype={id:0,ready:!1,movie:null,clipText:"",fileName:"",
    action:"copy",handCursorEnabled:!0,cssEffects:!0,handlers:null,sized:!1,sheetName:"",glue:function(a,b){this.domElement=i.$(a);var d=99;this.domElement.style.zIndex&&(d=parseInt(this.domElement.style.zIndex,10)+1);var c=i.getDOMObjectPosition(this.domElement);this.div=l.createElement("div");var e=this.div.style;e.position="absolute";e.left="0px";e.top="0px";e.width=c.width+"px";e.height=c.height+"px";e.zIndex=d;"undefined"!=typeof b&&""!==b&&(this.div.title=b);0!==c.width&&0!==c.height&&(this.sized=
        !0);this.domElement&&(this.domElement.appendChild(this.div),this.div.innerHTML=this.getHTML(c.width,c.height).replace(/&/g,"&amp;"))},positionElement:function(){var a=i.getDOMObjectPosition(this.domElement),b=this.div.style;b.position="absolute";b.width=a.width+"px";b.height=a.height+"px";0!==a.width&&0!==a.height&&(this.sized=!0,b=this.div.childNodes[0],b.width=a.width,b.height=a.height)},getHTML:function(a,b){var d="",c="id="+this.id+"&width="+a+"&height="+b;if(navigator.userAgent.match(/MSIE/))var e=
        location.href.match(/^https/i)?"https://":"http://",d=d+('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="'+e+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="'+a+'" height="'+b+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+i.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+
        c+'"/><param name="wmode" value="transparent"/></object>');else d+='<embed id="'+this.movieId+'" src="'+i.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+a+'" height="'+b+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+c+'" wmode="transparent" />';return d},hide:function(){this.div&&(this.div.style.left="-2000px")},
    show:function(){this.reposition()},destroy:function(){var a=this;this.domElement&&this.div&&(g(this.div).remove(),this.div=this.domElement=null,g.each(i.clients,function(b,d){d===a&&delete i.clients[b]}))},reposition:function(a){a&&((this.domElement=i.$(a))||this.hide());if(this.domElement&&this.div){var a=i.getDOMObjectPosition(this.domElement),b=this.div.style;b.left=""+a.left+"px";b.top=""+a.top+"px"}},clearText:function(){this.clipText="";this.ready&&this.movie.clearText()},appendText:function(a){this.clipText+=
        a;this.ready&&this.movie.appendText(a)},setText:function(a){this.clipText=a;this.ready&&this.movie.setText(a)},setFileName:function(a){this.fileName=a;this.ready&&this.movie.setFileName(a)},setSheetData:function(a){this.ready&&this.movie.setSheetData(JSON.stringify(a))},setAction:function(a){this.action=a;this.ready&&this.movie.setAction(a)},addEventListener:function(a,b){a=a.toString().toLowerCase().replace(/^on/,"");this.handlers[a]||(this.handlers[a]=[]);this.handlers[a].push(b)},setHandCursor:function(a){this.handCursorEnabled=
        a;this.ready&&this.movie.setHandCursor(a)},setCSSEffects:function(a){this.cssEffects=!!a},receiveEvent:function(a,b){var d,a=a.toString().toLowerCase().replace(/^on/,"");switch(a){case "load":this.movie=l.getElementById(this.movieId);if(!this.movie){d=this;setTimeout(function(){d.receiveEvent("load",null)},1);return}if(!this.ready&&navigator.userAgent.match(/Firefox/)&&navigator.userAgent.match(/Windows/)){d=this;setTimeout(function(){d.receiveEvent("load",null)},100);this.ready=!0;return}this.ready=
        !0;this.movie.clearText();this.movie.appendText(this.clipText);this.movie.setFileName(this.fileName);this.movie.setAction(this.action);this.movie.setHandCursor(this.handCursorEnabled);break;case "mouseover":this.domElement&&this.cssEffects&&this.recoverActive&&this.domElement.addClass("active");break;case "mouseout":this.domElement&&this.cssEffects&&(this.recoverActive=!1,this.domElement.hasClass("active")&&(this.domElement.removeClass("active"),this.recoverActive=!0));break;case "mousedown":this.domElement&&
    this.cssEffects&&this.domElement.addClass("active");break;case "mouseup":this.domElement&&this.cssEffects&&(this.domElement.removeClass("active"),this.recoverActive=!1)}if(this.handlers[a])for(var c=0,e=this.handlers[a].length;c<e;c++){var f=this.handlers[a][c];if("function"==typeof f)f(this,b);else if("object"==typeof f&&2==f.length)f[0][f[1]](this,b);else if("string"==typeof f)k[f](this,b)}}};i.hasFlash=function(){try{if(new ActiveXObject("ShockwaveFlash.ShockwaveFlash"))return!0}catch(a){if(navigator.mimeTypes&&
    navigator.mimeTypes["application/x-shockwave-flash"]!==q&&navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin)return!0}return!1};k.ZeroClipboard_TableTools=i;var x=function(a,b){b.attr("id");b.parents("html").length?a.glue(b[0],""):setTimeout(function(){x(a,b)},500)},C=function(a){var b="Sheet1";a.sheetName&&(b=a.sheetName.replace(/[\[\]\*\/\\\?\:]/g,""));return b},s=function(a,b){var d=b.match(/[\s\S]{1,8192}/g)||[];a.clearText();for(var c=0,e=d.length;c<e;c++)a.appendText(d[c])},
    y=function(a){return a.newline?a.newline:navigator.userAgent.match(/Windows/)?"\r\n":"\n"},z=function(a,b){for(var d=y(b),c=a.buttons.exportData(b.exportOptions),e=b.fieldBoundary,f=b.fieldSeparator,g=RegExp(e,"g"),i=b.escapeChar!==q?b.escapeChar:"\\",k=function(a){for(var b="",c=0,d=a.length;c<d;c++)0<c&&(b+=f),b+=e?e+(""+a[c]).replace(g,i+e)+e:a[c];return b},l=b.header?k(c.header)+d:"",n=b.footer&&c.footer?d+k(c.footer):"",m=[],h=0,p=c.body.length;h<p;h++)m.push(k(c.body[h]));return{str:l+m.join(d)+
    n,rows:m.length}},t={available:function(){return i.hasFlash()},init:function(a,b,d){i.moviePath=h.Buttons.swfPath;var c=new i.Client;c.setHandCursor(!0);c.addEventListener("mouseDown",function(){d._fromFlash=!0;a.button(b[0]).trigger();d._fromFlash=!1});x(c,b);d._flash=c},destroy:function(a,b,d){d._flash.destroy()},fieldSeparator:",",fieldBoundary:'"',exportOptions:{},title:"*",messageTop:"*",messageBottom:"*",filename:"*",extension:".csv",header:!0,footer:!1},u="",u="undefined"===typeof k.XMLSerializer?
        new function(){this.serializeToString=function(a){return a.xml}}:new XMLSerializer,o,p={"_rels/.rels":'<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>',"xl/_rels/workbook.xml.rels":'<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>',
        "[Content_Types].xml":'<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="xml" ContentType="application/xml" /><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml" /><Default Extension="jpeg" ContentType="image/jpeg" /><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml" /><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml" /><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml" /></Types>',
        "xl/workbook.xml":'<?xml version="1.0" encoding="UTF-8" standalone="yes"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><fileVersion appName="xl" lastEdited="5" lowestEdited="5" rupBuild="24816"/><workbookPr showInkAnnotation="0" autoCompressPictures="0"/><bookViews><workbookView xWindow="0" yWindow="0" windowWidth="25600" windowHeight="19020" tabRatio="500"/></bookViews><sheets><sheet name="" sheetId="1" r:id="rId1"/></sheets></workbook>',
        "xl/worksheets/sheet1.xml":'<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" mc:Ignorable="x14ac" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac"><sheetData/><mergeCells count="0"/></worksheet>',"xl/styles.xml":'<?xml version="1.0" encoding="UTF-8"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" mc:Ignorable="x14ac" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac"><numFmts count="6"><numFmt numFmtId="164" formatCode="#,##0.00_- [$$-45C]"/><numFmt numFmtId="165" formatCode="&quot;£&quot;#,##0.00"/><numFmt numFmtId="166" formatCode="[$€-2] #,##0.00"/><numFmt numFmtId="167" formatCode="0.0%"/><numFmt numFmtId="168" formatCode="#,##0;(#,##0)"/><numFmt numFmtId="169" formatCode="#,##0.00;(#,##0.00)"/></numFmts><fonts count="5" x14ac:knownFonts="1"><font><sz val="11" /><name val="Calibri" /></font><font><sz val="11" /><name val="Calibri" /><color rgb="FFFFFFFF" /></font><font><sz val="11" /><name val="Calibri" /><b /></font><font><sz val="11" /><name val="Calibri" /><i /></font><font><sz val="11" /><name val="Calibri" /><u /></font></fonts><fills count="6"><fill><patternFill patternType="none" /></fill><fill><patternFill patternType="none" /></fill><fill><patternFill patternType="solid"><fgColor rgb="FFD9D9D9" /><bgColor indexed="64" /></patternFill></fill><fill><patternFill patternType="solid"><fgColor rgb="FFD99795" /><bgColor indexed="64" /></patternFill></fill><fill><patternFill patternType="solid"><fgColor rgb="ffc6efce" /><bgColor indexed="64" /></patternFill></fill><fill><patternFill patternType="solid"><fgColor rgb="ffc6cfef" /><bgColor indexed="64" /></patternFill></fill></fills><borders count="2"><border><left /><right /><top /><bottom /><diagonal /></border><border diagonalUp="false" diagonalDown="false"><left style="thin"><color auto="1" /></left><right style="thin"><color auto="1" /></right><top style="thin"><color auto="1" /></top><bottom style="thin"><color auto="1" /></bottom><diagonal /></border></borders><cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" /></cellStyleXfs><cellXfs count="61"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="1" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="2" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="3" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="4" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/><xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1"><alignment horizontal="left"/></xf><xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1"><alignment horizontal="center"/></xf><xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1"><alignment horizontal="right"/></xf><xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1"><alignment horizontal="fill"/></xf><xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1"><alignment textRotation="90"/></xf><xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1"><alignment wrapText="1"/></xf><xf numFmtId="9"   fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/><xf numFmtId="164" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/><xf numFmtId="165" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/><xf numFmtId="166" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/><xf numFmtId="167" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/><xf numFmtId="168" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/><xf numFmtId="169" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/><xf numFmtId="3" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/><xf numFmtId="4" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/></cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0" /></cellStyles><dxfs count="0" /><tableStyles count="0" defaultTableStyle="TableStyleMedium9" defaultPivotStyle="PivotStyleMedium4" /></styleSheet>'},
    A=[{match:/^\-?\d+\.\d%$/,style:60,fmt:function(a){return a/100}},{match:/^\-?\d+\.?\d*%$/,style:56,fmt:function(a){return a/100}},{match:/^\-?\$[\d,]+.?\d*$/,style:57},{match:/^\-?£[\d,]+.?\d*$/,style:58},{match:/^\-?€[\d,]+.?\d*$/,style:59},{match:/^\([\d,]+\)$/,style:61,fmt:function(a){return-1*a.replace(/[\(\)]/g,"")}},{match:/^\([\d,]+\.\d{2}\)$/,style:62,fmt:function(a){return-1*a.replace(/[\(\)]/g,"")}},{match:/^[\d,]+$/,style:63},{match:/^[\d,]+\.\d{2}$/,style:64}];h.Buttons.swfPath="//cdn.datatables.net/buttons/"+
    h.Buttons.version+"/swf/flashExport.swf";h.Api.register("buttons.resize()",function(){g.each(i.clients,function(a,b){b.domElement!==q&&b.domElement.parentNode&&b.positionElement()})});h.ext.buttons.copyFlash=g.extend({},t,{className:"buttons-copy buttons-flash",text:function(a){return a.i18n("buttons.copy","Copy")},action:function(a,b,d,c){if(c._fromFlash){this.processing(!0);var a=c._flash,e=z(b,c),d=b.buttons.exportInfo(c),f=y(c),e=e.str;d.title&&(e=d.title+f+f+e);d.messageTop&&(e=d.messageTop+
    f+f+e);d.messageBottom&&(e=e+f+f+d.messageBottom);c.customize&&(e=c.customize(e,c));a.setAction("copy");s(a,e);this.processing(!1);b.buttons.info(b.i18n("buttons.copyTitle","Copy to clipboard"),b.i18n("buttons.copySuccess",{_:"Copied %d rows to clipboard",1:"Copied 1 row to clipboard"},data.rows),3E3)}},fieldSeparator:"\t",fieldBoundary:""});h.ext.buttons.csvFlash=g.extend({},t,{className:"buttons-csv buttons-flash",text:function(a){return a.i18n("buttons.csv","CSV")},action:function(a,b,d,c){a=c._flash;
    b=z(b,c);b=c.customize?c.customize(b.str,c):b.str;a.setAction("csv");a.setFileName(_filename(c));s(a,b)},escapeChar:'"'});h.ext.buttons.excelFlash=g.extend({},t,{className:"buttons-excel buttons-flash",text:function(a){return a.i18n("buttons.excel","Excel")},action:function(a,b,d,c){this.processing(!0);var a=c._flash,e=0,f=g.parseXML(p["xl/worksheets/sheet1.xml"]),i=f.getElementsByTagName("sheetData")[0],d={_rels:{".rels":g.parseXML(p["_rels/.rels"])},xl:{_rels:{"workbook.xml.rels":g.parseXML(p["xl/_rels/workbook.xml.rels"])},
    "workbook.xml":g.parseXML(p["xl/workbook.xml"]),"styles.xml":g.parseXML(p["xl/styles.xml"]),worksheets:{"sheet1.xml":f}},"[Content_Types].xml":g.parseXML(p["[Content_Types].xml"])},j=b.buttons.exportData(c.exportOptions),k,l,h=function(a){k=e+1;l=n(f,"row",{attr:{r:k}});for(var b=0,d=a.length;b<d;b++){var h=v(b)+""+k,j=null;if(null===a[b]||a[b]===q||""===a[b])if(!0===c.createEmptyCells)a[b]="";else continue;a[b]=g.trim(a[b]);for(var m=0,p=A.length;m<p;m++){var o=A[m];if(a[b].match&&!a[b].match(/^0\d+/)&&
    a[b].match(o.match)){j=a[b].replace(/[^\d\.\-]/g,"");o.fmt&&(j=o.fmt(j));j=n(f,"c",{attr:{r:h,s:o.style},children:[n(f,"v",{text:j})]});break}}j||("number"===typeof a[b]||a[b].match&&a[b].match(/^-?\d+(\.\d+)?$/)&&!a[b].match(/^0\d+/)?j=n(f,"c",{attr:{t:"n",r:h},children:[n(f,"v",{text:a[b]})]}):(o=!a[b].replace?a[b]:a[b].replace(/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F-\x9F]/g,""),j=n(f,"c",{attr:{t:"inlineStr",r:h},children:{row:n(f,"is",{children:{row:n(f,"t",{text:o})}})}})));l.appendChild(j)}i.appendChild(l);
    e++};g("sheets sheet",d.xl["workbook.xml"]).attr("name",C(c));c.customizeData&&c.customizeData(j);var m=function(a,b){var c=g("mergeCells",f);c[0].appendChild(n(f,"mergeCell",{attr:{ref:"A"+a+":"+v(b)+a}}));c.attr("count",c.attr("count")+1);g("row:eq("+(a-1)+") c",f).attr("s","51")},b=b.buttons.exportInfo(c);b.title&&(h([b.title],e),m(e,j.header.length-1));b.messageTop&&(h([b.messageTop],e),m(e,j.header.length-1));c.header&&(h(j.header,e),g("row:last c",f).attr("s","2"));for(var r=0,o=j.body.length;r<
o;r++)h(j.body[r],e);c.footer&&j.footer&&(h(j.footer,e),g("row:last c",f).attr("s","2"));b.messageBottom&&(h([b.messageBottom],e),m(e,j.header.length-1));h=n(f,"cols");g("worksheet",f).prepend(h);m=0;for(r=j.header.length;m<r;m++)h.appendChild(n(f,"col",{attr:{min:m+1,max:m+1,width:B(j,m),customWidth:1}}));c.customize&&c.customize(d);w(d);a.setAction("excel");a.setFileName(b.filename);a.setSheetData(d);s(a,"");this.processing(!1)},extension:".xlsx",createEmptyCells:!1});h.ext.buttons.pdfFlash=g.extend({},
    t,{className:"buttons-pdf buttons-flash",text:function(a){return a.i18n("buttons.pdf","PDF")},action:function(a,b,d,c){this.processing(!0);var a=c._flash,d=b.buttons.exportData(c.exportOptions),e=b.buttons.exportInfo(c),f=b.table().node().offsetWidth,g=b.columns(c.columns).indexes().map(function(a){return b.column(a).header().offsetWidth/f});a.setAction("pdf");a.setFileName(e.filename);s(a,JSON.stringify({title:e.title||"",messageTop:e.messageTop||"",messageBottom:e.messageBottom||"",colWidth:g.toArray(),
        orientation:c.orientation,size:c.pageSize,header:c.header?d.header:null,footer:c.footer?d.footer:null,body:d.body}));this.processing(!1)},extension:".pdf",orientation:"portrait",pageSize:"A4",newline:"\n"});return h.Buttons});
