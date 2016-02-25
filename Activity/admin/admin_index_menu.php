<?php
header("Content-type: text/html; charset=utf-8");
session_start();
	require_once('./auth.php');
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');
	$ChanneID_Arr = explode(",", $_SESSION["Admin_Channe"]);
	$Admin_Channe_Arr 	= explode(",", $_SESSION["Admin_Channe"]);
	$Admin_Info_Arr 	= explode(",", $_SESSION["Admin_Info"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>menu</title>
<link href="css/admin_menu.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<script language="javascript">
function getObject(objectId) {
	if(document.getElementById && document.getElementById(objectId)) {
		// W3C DOM
		return document.getElementById(objectId);
	}else if(document.all && document.all(objectId)) {
		// MSIE 4 DOM
		return document.all(objectId);
	}else if (document.layers && document.layers[objectId]) {
		// NN 4 DOM.. note: this won't find nested layers
		return document.layers[objectId];
	}else{
		return false;
	}
}

function showHide(objname){
    var obj = getObject(objname);
    if(obj.style.display == "none"){
		obj.style.display = "block";
	}else{
		obj.style.display = "none";
	}
}
</script>
<base target="main">
<body>
<div class="menu">

<!-- Item 1 Strat -->
<dl>
    <dt><a href="javascript:void(0);" onclick="showHide('items1');" target="_self">内容列表管理</a></dt>
    <dd id="items1" style="display:;">
        <ul>
            <li><a href='egg_user_index.php' target='main'>涨跌信息列表</a></li>
    
        </ul>
    </dd>
</dl>
<!-- Item 1 End -->

<dl>
    <dt><a href="javascript:void(0);" onclick="showHide('items50');" target="_self">系统管理</a></dt>
    <dd id="items50" style="display:;">
		<ul>
<?php
	if($TypeID == "999"){
?>
			<li><a href='user_index.php' target='main'>管理员列表</a></li>
<?php
	}
?>
			<li><a href='user_pass.php' target='main'>管理密码修改</a></li>
		</ul>
	</dd>
</dl>
<!-- Item 4 End -->

<?php
/*
	echo "<pre>";
	print_r($Admin_Channe_Arr);
	print_r($Admin_Info_Arr);
	echo "</pre>";
*/
?>
</div>
</body>
</html>
