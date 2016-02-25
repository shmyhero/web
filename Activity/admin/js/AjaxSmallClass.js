// JavaScript Document
function CreateXHR(){
var request;
//返回浏览器的名称
var browser = navigator.appName;
//使用IE，则使用XMLHttp对象
	if(browser == "Microsoft Internet Explorer"){
		var arrVersions=["Microsoft.XMLHttp", "MSXML2.XMLHttp.4.0","MSXML2.XMLHttp.3.0","MSXML2.XMLHttp","MSXML2.XMLHttp.5.0"];
		for (var i=0;i<arrVersions.length;i++){
			try{
			//从中找到一个支持的版本并建立XMLHttp对象
			request=new ActiveXObject(arrVersions[i]);
			return request;
			}
			catch(exception){
			//忽略，继续
			}
		}
	}else{
		//否则返回一个XMLHttpRequest对象
		request = new XMLHttpRequest();
		if(request.overrideMimeType){
			request.overrideMimeType('text/xml;charset=utf-8');
		} 
		return request;
	}  
}
//实例化
var Request=new CreateXHR();
function showsecond(x){
	var URL = "stores_AjaxSmallClass.php?value="+x;
	Request.open("GET",URL,true);
	Request.onreadystatechange = Show_Second;
	Request.send(null);
}

function Show_Second(){
	if(Request.readyState==4 &&Request.status==200){
	//显示二级框
	document.getElementById("smallclass").style.display ='';
	//读取返回的xml数据
	var myData=Request.responseXML.getElementsByTagName("row");
	//如果数据长度为0，则表示没有取到数据，则不显示二级菜单
	if(myData.length == 0){
		document.getElementById("smallclass").style.display = 'none';   
	}
	//alert(myData.length);
	var myStr=new Array();
	var myValue=new Array();
	for(var i = 0;i<myData.length;i++){
		myStr[i]=myData[i].firstChild.data;
		myValue[i]=myData[i].getAttribute("value");
		}
		document.getElementById("smallclass").options.length =0;   
		for(var j=0;j<myStr.length;j++){
			document.getElementById("smallclass").options[document.getElementById("smallclass").options.length] =new Option(myStr[j],myValue[j]);
		}
	}
	//document.getElementById("second").options.length =0;
	//document.getElementById("second").options[document.getElementById("second").options.length] =	new Option('请选择市（县/地区）1...','0');
	//document.getElementById("second3").options.length =0;
	//document.getElementById("second3").options[document.getElementById("second3").options.length] =	new Option('请选择三级分类...','0');
}
