<?php
header("Content-type: text/html; charset=utf-8");
session_start();
	require_once('./auth.php');
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');
	/* 权限读取 Star */
	$Admin_Channe_Arr 	= explode(",", $_SESSION["Admin_Channe"]);
	$Admin_Info_Arr 	= explode(",", $_SESSION["Admin_Info"]);
	if(!in_array("1", $Admin_Channe_Arr)){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo "<script type='text/javascript'> alert('无权限访问!');location.href='admin_index_body.php';</script>";
		exit;
	}
	/* 权限读取 End */

	unset($onlineip);
	if($_SERVER['HTTP_CLIENT_IP']){
		$onlineip=$_SERVER['HTTP_CLIENT_IP'];
	}elseif($_SERVER['HTTP_X_FORWARDED_FOR']){
		$onlineip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$onlineip=$_SERVER['REMOTE_ADDR'];
	}
	$adddate = date("Y-m-d");
	$addtime = mktime();


	if($_GET["module"]=="update"){
		$GetID	 	= intval($_GET["id"]);
		if(empty($GetID)){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo "<script type='text/javascript'> location.href='sysconfig.php';<\/script>";
			exit();
		}
		$GetPublish 	= intval($_GET["publish"]);
		if($GetPublish > 1){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo "<script type='text/javascript'> location.href='sysconfig.php';<\/script>";
			exit();
		}
		$sql_shen = "update sysconfig set publish = '$GetPublish' where id=".$GetID;
		$comments_shen = $wpdb->query($sql_shen);
		if($comments_shen > 0){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo "<script type='text/javascript'> location.href='sysconfig.php?cid=".$GetCID."&page=".$GetPage."';</script>";
			exit();
		}else{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo "<script type='text/javascript'> location.href='sysconfig.php?cid=".$GetCID."&page=".$GetPage."';<\/script>";
			exit();
		}
		
	}

	$module = $_GET["module"];
	if($module == "style_index"){
		$vname = "style_index";
	}elseif($module == "style_login"){
		$vname = "style_login";
	}else{
		$vname = "list";
	}

	$Action = $_POST["action"];
	if($Action == "edit"){
//exit("123456");
		$EditID = $_POST["EditID"];
		if(empty($EditID)){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo ("<script type='text/javascript'> alert('ID参数错误!');location.href='sysconfig.php';</script>");
			exit;
		}
		$E_small_pic	= csubstr(trim(strip_tags($_POST["small_pic"])),0,255);
		if(empty($E_small_pic)){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo ("<script type='text/javascript'> alert('图片不能为空!');location.href='sysconfig.php?module=".$EditID."';</script>");
			exit;
		}
		$E_IsPublish		= intval($_POST["IsPublish"]);
		
		$query = "update sysconfig set value = '".$E_small_pic."',publish = '".$E_IsPublish."' where varname = '".$EditID."'";
		$comments = $wpdb->query($query);
		if($comments > 0){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo "<script type='text/javascript'> alert('保存成功！');location.href='sysconfig.php';</script>";
			exit();
		}else{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo "<script type='text/javascript'> alert('保存失败！');location.href='sysconfig.php?module=".$EditID."';<\/script>";
			exit();
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>风格管理</title>
<link href="css/2.css" rel="stylesheet" type="text/css">
<script language=javascript src="js/arclist.js"></script>
</head>
<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="table">
  <tr class="hback">
    <td class="xingmu"><strong>网站风格样式管理</strong></td>
  </tr>
  <tr class="hback">
    <td class="hback">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <form action="" method="get" id="sForm" name="sForm" >
            <tr class="hback">
              <td>&nbsp;<a href="?module=list">内容列表</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="?module=style_index">首页背景图</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="?module=style_login">登录页背景图</a></td>
              <td style="text-align:right; padding-right:30px;">&nbsp;</td>
            </tr>
          </form>
        </table>
    </td>
  </tr>
</table>
<?php
	if($module == "style_index" || $module == "style_login"){
		
		$results = $wpdb->get_row("select * from sysconfig where varname = '".$module."'");
		if($results != null){
			$Str_id 		= stripslashes($results->id);
			$Str_varname 	= stripslashes($results->varname);
			$Str_info 		= stripslashes($results->info);
			$Str_value 		= stripslashes($results->value);
			$Str_publish 	= stripslashes($results->publish);
		}
?>
<table width="98%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
    <form name="phpform" id="phpform" method="post" action="" onsubmit="return Chk(this);">
    <input name="action" type="hidden" id="action" value="edit" />
    <input name="EditID" type="hidden" id="EditID" value="<?php echo $module;?>" />
    <tr class="hback">
        <td width="104">标题：</td>
        <td width="1109" height="24"><?php echo $Str_info;?></td>
    </tr>
  <tr class="hback">
    <td width="104">背景图：</td>
    <td width="1109"><?php if(!empty($Str_value)){?><img src="<?php echo $Str_value ?>" style="height:300px; padding-bottom:10px;"/><br><?php }?><input name="small_pic" type="text" class="flat" id="small_pic" style="width:350px;" value="<?php echo $Str_value;?>"/>
      &nbsp;<img src="images/upfile.gif" alt="" width="44" height="22" / align="absmiddle" style="cursor:pointer;" onclick="javascript:wallpaper(7);" />&nbsp;&nbsp;</td>
  </tr>
    <tr class="hback">
        <td width="104"> 是否发布：</td>
        <td width="1109">
        <label><input type="radio" name="IsPublish" id="IsPublish1" value="1" <?php if($Str_publish == "1"){?>checked="checked" <?php }?>/> 发布</label>
        <label><input type="radio" name="IsPublish" id="IsPublish0" value="0" <?php if($Str_publish == "0"){?>checked="checked" <?php }?>/> 不发布</label>
        </td>
    </tr>
    <tr class="hback">
        <td height="40" colspan="2" style="padding-left:180px;">
            <input type="submit" name="button" id="submitInner" value=" 修改内容 " style="cursor:pointer" />
            <input type="reset" name="button2" id="button2" value=" 重新填写 " style="cursor:pointer" />
        </td>
    </tr>
    </form>
</table>

<?php
	}
	if($module == "list" || $module == ""){
?>
<table width="98%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#E2F5BC" style="margin-top:5px;" class="table">
	<form name="form2" id="form2" method="post" action="">
    <tr class="xingmu">
      <td width="50" colspan="2" class="xingmu"><div align="center">编号</div></td>
      <td class="xingmu"><div align="center">标题</div></td>
      <td class="xingmu" width="120"><div align="center">图片</div></td>
      <td class="xingmu" width="40"><div align="center">发布</div></td>
      <td width="131" class="xingmu"><div align="center">管理操作</div></td>
    </tr>

<?php
	$query = "SELECT * FROM sysconfig order by id asc";
	$comments = $wpdb->get_results($query);
	if ($comments != null){
		foreach ($comments as $v){
			$id 		= $v->id;
			$varname 	= $v->varname;
			$info 		= $v->info;
			$value 		= $v->value;
			$publish 	= $v->publish;
?>

    <tr onMouseOver="overColor(this)" onMouseOut="outColor(this)">
      <td height="18" width="20" align="center" class="hback"><input id="arcID" type="checkbox" value="<?php echo $id; ?>" name="arcID"/></td>
      <td width="30" height="18" class="hback" align="center"><?php echo $id ?></td>
      <td class="hback"><?php echo $info ?></td>
      <td class="hback"><img src="<?php echo $value ?>" style="height:300px;"/></td>
      <td class="hback" align="center"><a href="?module=update&id=<?php echo $id;?>&publish=<?php echo ($publish == "1")?"0":"1";?>"><img height=12 alt="Published" src="<?php echo ($publish == "1")?"images/publish_g.png":"images/publish_r.png"?>" width=12 border=0>
        </a>
      </td>
      <td class="hback">
          <div align="center">
            <input type="button" name="Submit42" style="cursor:pointer; color:Green" value=" 修改 " onclick="location='sysconfig.php?module=<?php echo $varname ?>'" />
          </div>
      </td>
    </tr>

<?php
		}
	}
?>
<tr>
  </tr>
  </form>
</table>
<?php
	}
?>
<?php
	include("name.php");
?>
<script language="JavaScript" type="text/JavaScript">
function Chk(theForm)
{
	if (document.getElementById("title").value == ""){
		alert("标题内容不能为空!");
		document.getElementById("title").focus();
		return (false);
    }
	if (document.getElementById("typeid").value == ""){
		alert("请选择所属分类!");
		document.getElementById("typeid").focus();
		return (false);
    }else{
	        content.style.display = "none";
	        updated.style.display = "";
	}
}
function wallpaper(id){ 
	window.open("pic_up.php?id="+id,"","height=120,width=350,left=300,top=150,resizable=yes,scrollbars=yes,status=yes,toolbar=no,menubar=no,location=no");
}
</script>
</body>
</html>