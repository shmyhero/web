function displaySubMenu(li) {
		var subMenu = li.getElementsByTagName("ul")[0];
		subMenu.style.display = "block";
	}
function hideSubMenu(li) {
	var subMenu = li.getElementsByTagName("ul")[0];
	subMenu.style.display = "none";
}

function scrollbarEvent (o, type) {
	if (type == "mousedown") {
		if (o.className == "Scrollbar-Track") o.style.backgroundColor = "";
		else o.style.backgroundColor = "";
	} else {
		if (o.className == "Scrollbar-Track") o.style.backgroundColor = "";
		else o.style.backgroundColor = "";
	}
}

function swapIt(o) {
	o.blur();
	if (o.className == "current") return false;
  
	var list = document.getElementById("Navigation").getElementsByTagName("a");
	for (var i = 0; i < list.length; i++) {
		if (list[i].className == "current") {
			list[i].className = "";
			document.getElementById(list[i].title).y = -scroller._y;
		}
		if (list[i].title == o.title) o.className = "current";
	}
  
	list = document.getElementById("Container").childNodes;
	for (var i = 0; i < list.length; i++) {
		if (list[i].tagName == "DIV") list[i].style.display = "none";
	}
  
	var top = document.getElementById(o.title);
	top.style.display = "block";
	scrollbar.swapContent(top);
	if (top.y) scrollbar.scrollTo(0, top.y);
  
	return false;
}

//搜索方法
function changSearch(content, sel,url)
{
	var urlEnd = url+"&" + sel + "=" + encodeURI(content);
	document.location.href = urlEnd;
}

//选择省份
function changURL(id, url)
{
	if(id > 0)
	{
		var urlEnd = url+"_" + id + ".html";
		document.location.href = urlEnd;
	}
}




function changSel(id, type)
{
	var url = document.location.href;
    var start = url.indexOf("?")+1;
    if (start==0) {
        return "";
    }
    var value = "";
	var existType = false;
    var queryString = url.substring(start);
    var paraNames = queryString.split("&");
	queryString = url.substring(0, start);
    for (var i=0; i<paraNames.length; i++) {
		if (type==getParameterName(paraNames[i]))
		{
			existType = true;
			queryString += getParameterName(paraNames[i]) + "=" + id + "&";
		}else{
			queryString += getParameterName(paraNames[i]) + "=" + getParameterValue(paraNames[i]) + "&";
		}
    }
	if (!existType)
	{
			queryString += type + "=" + id + "&";
	}
	document.location.href = (queryString.substring(0, queryString.length-1));
}


/**
**　JS getParameter 方法
**/
function getParameter(name) {
    var url = document.location.href;
    var start = url.indexOf("?")+1;
    if (start==0) {
        return "";
    }
    var value = "";
    var queryString = url.substring(start);
    var paraNames = queryString.split("&");
    for (var i=0; i<paraNames.length; i++) {
        if (name==getParameterName(paraNames[i])) {
            value = getParameterValue(paraNames[i])
        }
    }
    return value;
}

function getParameterName(str) {
    var start = str.indexOf("=");
    if (start==-1) {
        return str;
    }
    return str.substring(0,start);
}

function getParameterValue(str) {
    var start = str.indexOf("=");
    if (start==-1) {
        return "";
    }
    return str.substring(start+1);
}

// JavaScript Document
//选择、取消选择要删除的记录
var checkflag = "false";
function check(field) {
if(document.getElementById("cblist")==null)
{
	alert("您还未添加任何记录！");
	return "false";
}
if (checkflag == "false") 
{
	if (field.length == undefined)
	{
		field.checked = true;
	}
	else
	{
		for (i = 0; i < field.length; i++) 
		{
			field[i].checked = true;
		}
	}
	checkflag = "true";
	return "false"; 
}
else 
{
	if (field.length == undefined)
	{
		field.checked = false;
	}	
	else
	{
		for (i = 0; i < field.length; i++) 
		{
			field[i].checked = false; 
		}
	}
	checkflag = "false";
	return "true"; 
}
}

//删除选中的记录
function delEvent(ckfield,url) 
{ 
	selNone = true;
	if(document.getElementById("cblist")==null)
	{
		alert("您还未添加任何记录！");
		return;
	}
	idArr = "";

	if (ckfield.length == undefined)
	{
		if(ckfield.checked == true)
		{
			idArr =  ckfield.value;
			selNone = false;
		}
	}
	else
	{
		for (i = 0; i < ckfield.length; i++) 
		{
			if(ckfield[i].checked == true)
			{
				if(idArr != "")
					idArr += ",";
				idArr += ckfield[i].value;
				selNone = false;
			}
		}
	}
	if(selNone)
	{
		alert("请选中您要删除的记录！");
		return;
	}
	if(!confirm("确认删除！"))
		return "false";
	url += idArr;
	location.href=url;
}

//编辑选中的记录
function editEvent(ckfield,url) 
{
	selOne = true;
	if(document.getElementById("cblist")==null)
	{
		alert("您还未添加任何记录！");
		return;
	}
	if (ckfield.length == undefined)
	{
		if(ckfield.checked == true)
		{
			id =  ckfield.value;
		}
		else
		{
			alert("请选择您要编辑的记录！");
			return;
		}
	}
	else
	{
		for (i = 0; i < ckfield.length; i++) 
		{
			if(ckfield[i].checked == true)
			{
				if(!selOne)
				{
					alert("不能同时编辑多条记录！");
					return;
				}
				selOne = false;
				id = ckfield[i].value;
			}
		}
		if(selOne)
		{
			alert("请选择您要编辑的记录！");
			return;
		}
	}
	url += id;

	location.href=url;
}


//操作选中的记录
function optEvent(ckfield,url) 
{ 
	selNone = true;
	if(document.getElementById("cblist")==null)
	{
		alert("您还未添加任何记录！");
		return;
	}
	idArr = "";

	if (ckfield.length == undefined)
	{
		if(ckfield.checked == true)
		{
			idArr =  ckfield.value;
			selNone = false;
		}
	}
	else
	{
		for (i = 0; i < ckfield.length; i++) 
		{
			if(ckfield[i].checked == true)
			{
				if(idArr != "")
					idArr += ",";
				idArr += ckfield[i].value;
				selNone = false;
			}
		}
	}
	if(selNone)
	{
		alert("请选中您要操作的记录！");
		return;
	}
//	if(!confirm("确认删除！"))
//		return "false";
	url += idArr;
	location.href=url;
}


function popWin(strUrl, w, h )
{
	window.open (strUrl, 'popWin', 'height='+h+', width='+w+', left=250, top=250, toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=no, status=no');
}

// compatible firefox outerHTML attribute
if(typeof(HTMLElement)!="undefined" && !window.opera) 
{ 
    HTMLElement.prototype.__defineGetter__("outerHTML",function() 
    { 
        var a=this.attributes, str="<"+this.tagName, i=0;for(;i<a.length;i++) 
        if(a[i].specified) 
            str+=" "+a[i].name+'="'+a[i].value+'"'; 
        if(!this.canHaveChildren) 
            return str+" />"; 
        return str+">"+this.innerHTML+"</"+this.tagName+">"; 
    }); 
    HTMLElement.prototype.__defineSetter__("outerHTML",function(s) 
    { 
        var r = this.ownerDocument.createRange(); 
        r.setStartBefore(this); 
        var df = r.createContextualFragment(s); 
        this.parentNode.replaceChild(df, this); 
        return s; 
    }); 
    HTMLElement.prototype.__defineGetter__("canHaveChildren",function() 
    { 
        return !/^(area|base|basefont|col|frame|hr|img|br|input|isindex|link|meta|param)$/.test(this.tagName.toLowerCase()); 
    }); 
}

var callbackid = "data";
function ajaxLoad(sUrl, id) {
 if (window.XMLHttpRequest)
 {
  xmlObj = new XMLHttpRequest();
 }else if (window.ActiveXObject){
  xmlObj = new ActiveXObject("Microsoft.XMLHTTP");
 }else{
  return;
 }
 callbackid = id;
 xmlObj.onreadystatechange = handleResponse;
 xmlObj.open("GET",sUrl,true);
 xmlObj.send("");
}

function handleResponse()
{
 if (xmlObj.readyState == 4){
 //xmlObj loaded
  if (xmlObj.status == 200)
  {
   var data = xmlObj.responseText;
   var obj = document.getElementById(callbackid);
   obj.outerHTML = data;
  }
 }
}
