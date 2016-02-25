<?php
header("Content-type: text/html; charset=utf-8");
if (!session_id())  session_start();
	require_once('./auth.php');
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');
	
	$user_name = $_SESSION["Admin_Name"];
	$ErrCodes='';
	//开始查询
	$query = "select * from admin where userid='".addslashes($user_name)."'";
	//执行SQL
	$results = $wpdb->get_results($query);
	if($results != null)
	{
		//$usertype = $results[0]->usertype;
		$uname = $results[0]->uname;
		$email = $results[0]->email;
		$typeid = $results[0]->typeid;
		$logintime = $results[0]->logintime;
		$loginip = $results[0]->loginip;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更改个人资料</title>
<link href="css/2.css" rel="stylesheet" type="text/css">
<LINK href="css/page.css" type=text/css rel=stylesheet>
<script>
function checkSubmit()
{
	if (document.form1.pwd.value==''){
		alert("修改的密码不能为空!");
		form1.pwd.focus();
		return (false);
    }
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
			document.getElementById('checkokpwd').innerHTML = "<font color='green'>输入正确！</font>";
		}
	}
}
</script>
</head>
<body>
<?php

	if(@$_POST["Action"]=="edit"){
		$e_pwd= $_POST["pwd"];
		if(!empty($e_pwd)){
			$e_pwd = md5($e_pwd);
		}

		$ipaddress = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"]; 			//IP地址
		$ipaddress = ($ipaddress) ? $ipaddress : $_SERVER["REMOTE_ADDR"];
		$tim = date("Y-m-j H:i:s");
		
		$sql="update admin set pwd='$e_pwd',logintime='$tim',loginip='$ipaddress' where userid='".addslashes($user_name)."'";
		$curID = $wpdb->query($sql);
		if($curID==1){		
			if(isset($_SESSION["Admin_Name"]))
			unset($_SESSION["Admin_Name"]);
			unset($_SESSION["admin"]);
			session_destroy();
			echo ("<script type='text/javascript'> alert('修改成功,请重新登录本系统!');location.href='admin_login.php';</script>");
			
			//$ErrorUrl = "admin_login.php";
			//$ErrCodes = "资料修改成功!请重新登录";
			//exit();
		}else{
			$ErrorUrl = "user_pass.php";
			$ErrCodes = "资料修改失败!";
			echo ("<script type='text/javascript'>location.href='user_pass.php?ErrorUrl=$ErrorUrl&ErrCodes=$ErrCodes';</script>");
			exit();
		}
	}
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="table">
  <form action="" method="post" id="form1" name="form1" onsubmit="return checkSubmit();">
    <tr class="xingmu">
      <td colspan="2" class="xingmu">修改密码</td>
    </tr>
    <tr>
      <td height="28" class="hback"><div align="right">登录ID：</div></td>
      <td align="left" class="hback"><input name="uname" type="text" class="flat" id="uname" style="width:150px" value="<?php echo $user_name;?>" size="16" maxlength="12" disabled="disabled"/>
      &nbsp;登陆ID不可修改
            
      
      </td>
    </tr>
    <tr>
      <td height="24" class="hback"><div align="right">新密码：</div></td>
      <td align="left" class="hback"><input name="pwd" type="text" class="flat" id="pwd" style="width:150px" onchange="checkPwd()" size="16" maxlength="16" />
        &nbsp;（只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'、'!'以内范围的字符）</td>
    </tr>
    <tr>
      <td height="24" class="hback"><div align="right">确认新密码：</div></td>
      <td align="left" class="hback"><input name="pwd2" type="text" class="flat" id="pwd2" style="width:150px" onchange="checkPwd()" size="16" maxlength="16" />
          <span id='checkokpwd'></span></td>
    </tr>
    <tr>
      <td height="24" class="hback"><div align="right">记录：</div></td>
      <td align="left" class="hback">上次更新时间：<?php echo $logintime; ?>，上次更新IP：<?php echo $loginip; ?></td>
    </tr>
<?php
	if($TypeID == "999"){
?>
<?php
	}
?>
    <tr>
        <td height="30" colspan="2" align="left" style="padding-left:30px;" class="hback">
            <input type='hidden' name='Action' value='edit' />
            <input type="submit" name="Submit" value=" 保存修改 " class="flat" style="cursor:pointer;"/>
            <?php echo $ErrCodes; ?>
        </td>
    </tr>
  </form>
</table>
<?php
	include("name.php");
?>
</body>
</html>
