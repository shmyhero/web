// JavaScript Document
var xmlHttp
function get_Edit(int,checkid)
{

//alert(int);
//alert(checkid);

xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
	var url="img_vote_edit.php"
	url=url+"?action=vote&id="+int+"&eid="+checkid
	url=url+"&sid="+Math.random()
	//alert(url);
	xmlHttp.onreadystatechange=function(){stateChanged(int,checkid)};
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

function stateChanged(pid,checkid)
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		var msg = xmlHttp.responseText;
		if(msg=="-1")
		{
			alert("错误1");
			return false; 
		}
		else if(msg=="-2")
		{
			alert("错误,请填写数字!");
			return false;	
		}
		else if(msg=="-3")
		{
			alert("修改错误");
			return false;	
		}else{
			document.getElementById("pp_"+pid).innerHTML = xmlHttp.responseText;
		}
	
	} 
} 

function GetXmlHttpObject()
{ 
	var objXMLHttp=null
	if (window.XMLHttpRequest)
	{
		objXMLHttp=new XMLHttpRequest()
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
	}
	return objXMLHttp
}