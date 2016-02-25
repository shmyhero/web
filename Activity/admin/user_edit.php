<?php
session_start();
	require_once('./auth.php');
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');

	$u_id = intval($_GET["id"]);
	if(empty($u_id)){
		echo ("<script type='text/javascript'> alert('参数传递错误!');location.href='user_index.php';</script>");
	}
	if($u_id=="1"){
		echo ("<script type='text/javascript'> alert('该账号禁止在此修改!');location.href='user_index.php';</script>");
	}
	if($TypeID != "999"){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo ("<script type='text/javascript'> alert('您无权访问该区域!');location.href='admin_index_body.php';</script>");
		exit();
	}

	if($_POST["Action"]=="edit"){
		$Edit_ID= intval($_POST["Edit_ID"]);

		$e_uname		= trim($_POST["uname"]);
		$e_pwd			= trim($_POST["pwd"]);
		if(!empty($e_pwd)){
			$e_pwd = md5($e_pwd);
		}
		$e_email		= trim($_POST["email"]);
		$e_typeid		= intval(trim($_POST["typeid"]));
		if($e_typeid == "999"){
			$e_channelid 		= "1,2,3,4";
			$e_infoid 		= "1,2,3";
		}elseif($e_typeid == "1"){
			$e_channel_arr	= $_POST["channelid"];
			$e_channelid 		= implode(",", $e_channel_arr);
			$e_infoid_arr		= $_POST["infoid"];
			$e_infoid 		= implode(",", $e_infoid_arr);
		}

		$ipaddress = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"]; 			//IP地址
		$ipaddress = ($ipaddress) ? $ipaddress : $_SERVER["REMOTE_ADDR"];
		$tim = date("Y-m-j H:i:s");
		
		if(empty($e_pwd)){
			$sql="update admin set
				uname		= '".$e_uname."',
				email		= '".$e_email."',
				typeid		= '".$e_typeid."',
				channelid	= '".$e_channelid."',
				infoid		= '".$e_infoid."'
			where id='".$Edit_ID."'";
		}else{
			$sql="update admin set 
				pwd			= '".$e_pwd."',
				uname		= '".$e_uname."',
				email		= '".$e_email."',
				typeid		= '".$e_typeid."',
				channelid	= '".$e_channelid."',
				infoid		= '".$e_infoid."'
			where id='".$Edit_ID."'";
		}
		$curID = $wpdb->query($sql);
		if($curID==1){
			echo ("<script type='text/javascript'> alert('修改成功!');location.href='user_index.php';</script>");
			exit();
		}else{
			echo ("<script type='text/javascript'> alert('资料修改失败!');location.href='user_edit.php?id=$Edit_ID';</script>");
			exit();
		}
	}

	//开始查询
	$query = "select * from admin where id='".addslashes($u_id)."'";
	$results = $wpdb->get_results($query);
	if($results != null){
		$userid 	= $results[0]->userid;
		$usertype 	= $results[0]->usertype;
		$uname 		= $results[0]->uname;
		$email 		= $results[0]->email;
		$typeid 	= $results[0]->typeid;
		$str_typeid = $typeid;

		$channelid 	= $results[0]->channelid;
		$infoid 	= $results[0]->infoid;

		$logintime 	= $results[0]->logintime;
		$loginip 	= $results[0]->loginip;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更改管理员资料</title>
<link href="css/2.css" rel="stylesheet" type="text/css">
<script>
function checkSubmit()
{
   if(document.form1.pwd.value!=''){
	   if(document.form1.pwd.value!=document.form1.pwd2.value){
	     alert("两次输入密码不一致！");
	     return false;
	   }
  }
  return true;
}
function checkPwd(){
	if(document.form1.pwd.value!=''){
		pw1 = document.form1.pwd.value;
		pw2 = document.form1.pwd2.value;
		pw3 = pw1.replace(/[^0-9a-z_@!\.\-]/ig,'');
		if(pw1!=pw3){
			document.getElementById('checkokpwd').innerHTML = "<font color='red'>密码含有非法字符！</font>";
		}else if(pw1!=pw2){
			document.getElementById('checkokpwd').innerHTML = "<font color='red'>两次密码不一致！</font>";
		}else{
			document.getElementById('checkokpwd').innerHTML = "<font color='green'>密码正确！</font>";
		}
	}
}
</script>
</head>
<body>
<?php
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="table">
  <form action="" method="post" id="form1" name="form1" onsubmit="return checkSubmit();">
    <tr class="xingmu">
        <td height="24" colspan="3" class="xingmu">&nbsp;添加管理员</td>
    </tr>
    <tr>
      <td height="28" bgcolor="#F9F9F9"><div align="right">登录ID：</div></td>
      <td align="left" bgcolor="#FFFFFF"><input name="uname" type="text" class="flat" id="uname" style="width:150px" value="<?php echo $userid;?>" size="16" maxlength="12" disabled="disabled"/>
      &nbsp;登陆ID不可修改</td>
    </tr>
    <tr>
      <td height="24" bgcolor="#F9F9F9"><div align="right">管理昵称：</div></td>
      <td align="left" bgcolor="#FFFFFF"><input name="uname" type="text" class="flat" id="uname" style="width:150px" value="<?php echo $uname;?>" size="16" maxlength="16" />
        &nbsp;可修改</td>
    </tr>
    <tr>
      <td height="24" bgcolor="#F9F9F9"><div align="right">电子邮件：</div></td>
      <td align="left" bgcolor="#FFFFFF" colspan="2"><input name="email" type="text" class="flat" id="email" style="width:150px" size="16" maxlength="16" value="<?php echo $email;?>" />
        &nbsp;可修改</td>
    </tr>
    <tr>
      <td height="24" bgcolor="#F9F9F9"><div align="right">新密码：</div></td>
      <td align="left" bgcolor="#FFFFFF"><input name="pwd" type="text" class="flat" id="pwd" style="width:150px" onchange="checkPwd()" size="16" maxlength="16" />
        &nbsp;（只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'、'!'以内范围的字符）</td>
    </tr>
    <tr>
      <td height="24" bgcolor="#F9F9F9"><div align="right">确认新密码：</div></td>
      <td align="left" bgcolor="#FFFFFF"><input name="pwd2" type="text" class="flat" id="pwd2" style="width:150px" onchange="checkPwd()" size="16" maxlength="16" />
          <span id='checkokpwd'></span></td>
    </tr>
    <tr>
      <td height="24" bgcolor="#F9F9F9"><div align="right">记录：</div></td>
      <td align="left" bgcolor="#FFFFFF">上次更新时间：<?php echo $logintime; ?>，上次更新IP：<?php echo $loginip; ?></td>
    </tr>
<?php
	if($TypeID == "999"){
?>
    <tr>
        <td height="24"class="xingmu">&nbsp;管理权限：</td>
        <td class="xingmu">
<label><input type="radio" name="typeid" id="typeid" value="999" onClick="SwitchNewsType('notitle');" <?php if($str_typeid=="999"){ echo "checked='checked'";}?>/>超级管理员</label>
&nbsp;
<label><input name="typeid" type="radio" id="typeid" value="1" onClick="SwitchNewsType('yestitle');" <?php if($str_typeid=="1"){ echo "checked='checked'";}?>/>普通管理员</label>
      </td>
    </tr>

    <tr id="001">
        <td height="24" bgcolor="#F9F9F9">
            <div align="right">频道权限：</div>
        </td>
        <td height="24" colspan="2" bgcolor="#FFFFFF">
<?php
	eval('$Channel_Arr = array('.$channelid.');');
	$query = "select * from channel order by id asc";
	$results = $wpdb->get_results($query);
	if($results != null){
		foreach($results as $result){
			$channel_id		= $result->id;
			$channel_name 	= $result->title;
?>
		<label>
        <input type="checkbox" name="channelid[]" id="channelid" value="<?php echo $channel_id ?>" <?php if(in_array("$channel_id", $Channel_Arr)){echo "checked='checked'";} ?>/>
        <?php echo $channel_name ?>
        </label>
<?php
		}
	}
?>
        </td>
    </tr>
    <tr id="002">
        <td height="24" bgcolor="#FFFFFF"><div align="right">内容权限：</div></td>
        <td height="24" bgcolor="#FFFFFF" colspan="2">
<?php
	eval('$Infoid_Arr = array('.$infoid.');');
?>
<label><input type="checkbox" name="infoid[]" id="infoid" value="1" <?php if(in_array("1", $Infoid_Arr)){echo "checked='checked'";} ?>/> 添加</label>
<label><input type="checkbox" name="infoid[]" id="infoid" value="2" <?php if(in_array("2", $Infoid_Arr)){echo "checked='checked'";} ?>/> 修改</label>
<label><input type="checkbox" name="infoid[]" id="infoid" value="3" <?php if(in_array("3", $Infoid_Arr)){echo "checked='checked'";} ?>/> 删除</label>
        </td>
    </tr>
<?php
	}
?>
    <tr>

    <tr>
        <td height="30" colspan="2" class="hback" style="padding-left:30px;">
            <input type="hidden" name="Edit_ID" id="Edit_ID" value="<?php echo $u_id; ?>" />
            <input type='hidden' name='Action' value='edit' />
            <input type="submit" name="Submit" value=" 保存修改 " class="flat" style="cursor:pointer;"/>
        </td>
    </tr>
  </form>
</table>
<?php
	include("name.php");
?>
<script language="JavaScript" type="text/JavaScript">
<!--
<?php
	if($str_typeid=="999"){
?>
	SwitchNewsType('notitle');
<?php
	}
?>
function SwitchNewsType(IsUR)
{
	switch (IsUR)
	{
	case "notitle":
		document.getElementById('001').style.display='none';
		document.getElementById('002').style.display='none';
		break;
	case "yestitle":
		document.getElementById('001').style.display='';
		document.getElementById('002').style.display='';
		break;
	default :
		document.getElementById('001').style.display='none';
		document.getElementById('002').style.display='none';
	}
}
//-->
</script>

</body>
</html>
