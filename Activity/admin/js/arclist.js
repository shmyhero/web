function delArcPhoto(aid){
	var qstr=getCheckboxItem();
	if(aid==0) aid = getOneItem();
	location="photo_del.php?qstr="+qstr+"&aid="+aid+"&dopost=delArchives";
}

function ShenArc(aid){
	var qstr=getCheckboxItem();
	if(aid==0) aid = getOneItem();
	location="photo_del.php?qstr="+qstr+"&aid="+aid+"&dopost=shenlArchives";
}

function NoShenArc(aid){
	var qstr=getCheckboxItem();
	if(aid==0) aid = getOneItem();
	location="photo_del.php?qstr="+qstr+"&aid="+aid+"&dopost=noshenArchives";
}

function ShiftPhoto(aid){
	var qstr=getCheckboxItem();
	var cid = getCheckboxCid();
	if(aid==0) aid = getOneItem();
	location="photo_del.php?qstr="+qstr+"&cid="+cid+"&dopost=ShiftArchives";
}

function delMember(aid){
	var qstr=getCheckboxItem();
	if(aid==0) aid = getOneItem();
	location="members_del.php?qstr="+qstr+"&aid="+aid+"&dopost=delArchives";
}
//上下文菜单
function ShowMenu(obj,aid,atitle)
{
  var eobj,popupoptions
  popupoptions = [
    new ContextItem("浏览文档",function(){ viewArc(aid); }),
    new ContextItem("编辑文档",function(){ editArc(aid); }),
    new ContextSeperator(),
    new ContextItem("更新HTML",function(){ updateArc(aid); }),
    new ContextItem("审核文档",function(){ checkArc(aid); }),
    new ContextItem("推荐文档",function(){ adArc(aid); }),
    new ContextSeperator(),
    new ContextItem("删除文档",function(){ delArc(aid); }),
    new ContextSeperator(),
    new ContextItem("全部选择",function(){ selAll(); }),
    new ContextItem("取消选择",function(){ noSelAll(); }),
    new ContextSeperator(),
    new ContextItem("频道管理",function(){ location="catalog_main.php"; })
  ]
  ContextMenu.display(popupoptions)
}

//获得选中分类ID
function getCheckboxCid()
{
	var allSel="";
	if(document.form2.classid.value) return document.form2.classid.value;
	for(i=0;i<document.form2.classid.length;i++)
	{
		if(document.form2.classid[i].checked)
		{
			if(allSel=="")
				allSel=document.form2.classid[i].value;
			else
				allSel=allSel+","+document.form2.classid[i].value;
		}
	}
	return allSel;	
}

//获得选中文件的文件名
function getCheckboxItem()
{
	var allSel="";
	if(document.form2.arcID.value) return document.form2.arcID.value;
	for(i=0;i<document.form2.arcID.length;i++)
	{
		if(document.form2.arcID[i].checked)
		{
			if(allSel=="")
				allSel=document.form2.arcID[i].value;
			else
				allSel=allSel+","+document.form2.arcID[i].value;
		}
	}
	return allSel;	
}

//获得选中其中一个的id
function getOneItem()
{
	var allSel="";
	if(document.form2.arcID.value) return document.form2.arcID.value;
	for(i=0;i<document.form2.arcID.length;i++)
	{
		if(document.form2.arcID[i].checked)
		{
				allSel = document.form2.arcID[i].value;
				break;
		}
	}
	return allSel;	
}

function selAll()
{
	for(i=0;i<document.form2.arcID.length;i++)
	{
		if(!document.form2.arcID[i].checked)
		{
			document.form2.arcID[i].checked=true;
		}
	}
}
function noSelAll()
{
	for(i=0;i<document.form2.arcID.length;i++)
	{
		if(document.form2.arcID[i].checked)
		{
			document.form2.arcID[i].checked=false;
		}
	}
}
