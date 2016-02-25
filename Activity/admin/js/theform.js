function propic(id){ 
	window.open("file_pic.php?id="+id,"","height=100,width=300,left=300,top=150,resizable=no,scrollbars=no,status=no,toolbar=no,menubar=no,location=no");
}
function wallpaper(id){ 
	window.open("wallpaper_up.php?id="+id,"","height=100,width=300,left=300,top=150,resizable=no,scrollbars=no,status=no,toolbar=no,menubar=no,location=no");
}
function Chk(theForm)
{
	//产品名称
	if(document.getElementById("Name").value==""){
		alert("请填写产品名称!");
		document.getElementById("Name").focus();
		return false;
	}
	//产品型号
	if(document.getElementById("Model").value==""){
		alert("请填写产品型号!");
		document.getElementById("Model").focus();
		return false;
	}
	//产品类型
	var j = 0;
	for (var i=0; i<document.getElementsByName("Top_type").length; i++) {
		if (document.getElementsByName("Top_type")[i].checked) j = 1;
	}
	if (j==0) {
		alert("请选择产品类型!");
		document.getElementsByName("Top_type").checked="checked" ;
		document.getElementById("Top_type").focus();
		return false;
	}
	//适用性别
	//var jj = 0;
	//for (var ii=0; ii<document.getElementsByName("Sex").length; ii++) {
		//if (document.getElementsByName("Sex")[ii].checked) jj = 1;
	//}
	//if (jj==0) {
		//alert("请选择适用性别!");
		//document.getElementsByName("Sex").checked="checked" ;
		//document.getElementById("Sex").focus();
		//return false;
	//}
	//产品材质
	//if(document.getElementById("Material").value==""){
		//alert("请填写产品材质!");
		//document.getElementById("Material").focus();
		//return false;
	//}
	//产品尺寸
	//if(document.getElementById("Size").value==""){
		//alert("请填写产品尺寸!");
		//document.getElementById("Size").focus();
		//return false;
	//}
	//上市时间
	if(document.getElementById("up_time").value==""){
		alert("请选择上市时间!");
		document.getElementById("up_time").focus();
		return false;
	}
	//科 技 点
	var jjj = 0;
	for (var iii=0; iii<document.getElementsByName("Tech").length; iii++) {
		if (document.getElementsByName("Tech")[iii].checked) jjj = 1;
	}
	//if (jjj==0) {
	//	alert("请选择科技点!");
	//	document.getElementsByName("Tech").checked="checked" ;
	//	document.getElementById("Tech").focus();
	//	return false;
	//}
	//运动类型
	var jjjj = 0;
	for (var iiii=0; iiii<document.getElementsByName("Exercise").length; iiii++) {
		if (document.getElementsByName("Exercise")[iiii].checked) jjjj = 1;
	}
	if (jjjj==0) {
		alert("请选择运动类型!");
		document.getElementsByName("Exercise").checked="checked" ;
		document.getElementById("Exercise").focus();
		return false;
	}
	//产品类型
	var jjjjj = 0;
	for (var iiiii=0; iiiii<document.getElementsByName("Pro_type").length; iiiii++) {
		if (document.getElementsByName("Pro_type")[iiiii].checked) jjjjj = 1;
	}
	if (jjjjj==0) {
		alert("请选择产品类型!");
		document.getElementsByName("Pro_type").checked="checked" ;
		document.getElementById("Pro_type").focus();
		return false;
	}
	//产品颜色
	var jjjjjj = 0;
	for (var iiiiii=0; iiiiii<document.getElementsByName("Color").length; iiiiii++) {
		if (document.getElementsByName("Color")[iiiiii].checked) jjjjjj = 1;
	}
	if (jjjjjj==0) {
		alert("请选择产品颜色!");
		document.getElementsByName("Color").checked="checked" ;
		document.getElementById("Color").focus();
		return false;
	}
	//缩 略 图
	if(document.getElementById("Small_pic").value==""){
		alert("请填写缩略图!");
		document.getElementById("Small_pic").focus();
		return false;
	}
	//原始图片
	if(document.getElementById("Big_pic").value==""){
		alert("请填写原始图片!");
		document.getElementById("Big_pic").focus();
		return false;
	}
	else
	{
		updated.style.display = '';
	}
}
function ShowColor(){
	var fcolor=showModalDialog("size.htm?ok",false,"dialogWidth:107px;dialogHeight:237px;status:0;dialogTop:"+(window.event.clientY+120)+";dialogLeft:"+(window.event.clientX));
	if(fcolor!=null && fcolor!="undefined") document.phpform.Size.value = fcolor;
}
function pronews(id){ 
	window.open("size.php?id="+id,"","height=180,width=400,left=400,top=100,resizable=no,scrollbars=no,status=no,toolbar=no,menubar=no,location=no");
}
