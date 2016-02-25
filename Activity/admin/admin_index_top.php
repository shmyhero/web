<?php
	include("auth.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Top</title>
<link href="css/admin_top.css" rel="stylesheet" type="text/css" />
<script language='javascript'>

function $Nav(){
	if(window.navigator.userAgent.indexOf("MSIE")>=1) return 'IE';
  else if(window.navigator.userAgent.indexOf("Firefox")>=1) return 'FF';
  else return "OT";
}

var preID = 0;

function OpenMenu(cid,lurl,rurl,bid){
   if($Nav()=='IE'){
     if(rurl!='') top.document.frames.main.location = rurl;
     if(cid > -1) top.document.frames.menu.location = 'admin_index_menu.php?c='+cid;
     else if(lurl!='') top.document.frames.menu.location = lurl;
     if(bid>0) document.getElementById("d"+bid).className = 'thisclass';
     if(preID>0 && preID!=bid) document.getElementById("d"+preID).className = '';
     preID = bid;
   }else{
     if(rurl!='') top.document.getElementById("main").src = rurl;
     if(cid > -1) top.document.getElementById("menu").src = 'admin_index_menu.php?c='+cid;
     else if(lurl!='') top.document.getElementById("menu").src = lurl;
     if(bid>0) document.getElementById("d"+bid).className = 'thisclass';
     if(preID>0 && preID!=bid) document.getElementById("d"+preID).className = '';
     preID = bid;
   }
}

var preFrameW = '160,*';
var FrameHide = 0;
function ChangeMenu(way){
	var addwidth = 10;
	var fcol = top.document.all.bodyFrame.cols;
	if(way==1) addwidth = 10;
	else if(way==-1) addwidth = -10;
	else if(way==0){
		if(FrameHide == 0){
			preFrameW = top.document.all.bodyFrame.cols;
			top.document.all.bodyFrame.cols = '0,*';
			FrameHide = 1;
			return;
		}else{
			top.document.all.bodyFrame.cols = preFrameW;
			FrameHide = 0;
			return;
		}
	}
	fcols = fcol.split(',');
	fcols[0] = parseInt(fcols[0]) + addwidth;
	top.document.all.bodyFrame.cols = fcols[0]+',*';
}

function resetBT(){
	if(preID>0) document.getElementById("d"+preID).className = 'bdd';
	preID = 0;
}

</script>
</head>
<body>
<div class="topnav">
	<div class="sitenav">
		<div class="welcome">
			你好：<span class="username"><?php echo $_SESSION['Admin_Name']; ?> </span>，欢迎使用！
		</div>
		<div class="welcome">
		<a href="javascript:ChangeMenu(-1)"><img src='images/frame-l.gif' border='0' alt="减小左框架"></a>
    <a href="javascript:ChangeMenu(0)"><img src='images/frame_on.gif' border='0' alt="隐藏/显示左框架"></a>
    <a href="javascript:ChangeMenu(1)" title="增大左框架"><img src='images/frame-r.gif' border='0' alt="增大左框架"></a>
    </div>
		<div class="sitelink">
			<a href="../" target="_blank">网站主页</a> | 
			<a href="javascript:OpenMenu(0,'','admin_index_body.php',0)">管理主页</a> | 
			<a href="logout.php" target="_parent">注销登录</a>
		</div>
	</div>
</div>
</body>
</html>
