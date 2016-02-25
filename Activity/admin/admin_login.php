<?php
header("Content-type: text/html; charset=utf-8");

	if (!session_id())  session_start();

	require_once("../inc/config.php");
	require_once("../inc/class.db.php");
	require_once('../inc/utils.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理系统</title>
<style type="text/css">
<!--
*{
	padding:0px;
	margin:0px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
body {
	margin: 0px;
	background:#F7F7F7;
	font-size:12px;
}
input{
	vertical-align:middle;
}
img{
	border:none;
	vertical-align:middle;
}
a{
	color:#333333;
}
a:hover{
	color:#FF3300;
	text-decoration:none;
}
.main{
	width:640px;
	margin:140px auto 0px;
	border:4px solid #EEE;
	background:#FFF;
	padding-bottom:10px;
}

.main .title{
	width:600px;
	height:50px;
	margin:0px auto;
	background:url(images/login_toptitle.jpg) -10px 0px no-repeat;
	text-indent:30px;
	line-height:46px;
	font-size:14px;
	letter-spacing:2px;
	color:#F60;
	font-weight:bold;
}

.main .login{
	width:560px;
	margin:20px auto 0px;
	overflow:hidden;
}
.main .login .inputbox{
	width:260px;
	float:left;
	background:url(images/login_input_hr.gif) right center no-repeat;
}
.main .login .inputbox dl{
	width:230px;
	height:41px;
	clear:both;
}
.main .login .inputbox dl dt{
	float:left;
	width:60px;
	height:31px;
	line-height:31px;
	text-align:right;
	font-weight:bold;
}
.main .login .inputbox dl dd{
	width:160px;
	float:right;
	padding-top:1px;
}
.main .login .inputbox dl dd input{
	font-size:12px;
	font-weight:bold;
	border:1px solid #888;
	padding:4px;
}


.main .login .butbox{
	float:left;
	width:200px;
	margin-left:26px;
}
.main .login .butbox dl{
	width:200px;
}
.main .login .butbox dl dt{
	width:160px;
	height:41px;
	padding-top:5px;
}
.main .login .butbox dl dt input{
	width:98px;
	height:33px;
	background:url(images/login_submit.gif) no-repeat;
	border:none;
	cursor:pointer;
}
.main .login .butbox dl dd{
	height:21px;
	line-height:21px;
}
.main .login .butbox dl dd a{
	margin:5px;
}



.main .msg{
	width:560px;
	margin:10px auto;
	clear:both;
	line-height:17px;
	padding:6px;
	border:1px solid #FC9;
	background:#FFFFCC;
	color:#666;
}

.copyright{
	width:640px;
	text-align:right;
	margin:10px auto;
	font-size:10px;
	color:#999999;
}
.copyright a{
	font-weight:bold;
	color:#F63;
	text-decoration:none;
}
.copyright a:hover{
	color:#000;
}
-->
</style>
<script type="text/javascript" language="javascript">
<!--
	window.onload = function (){
		userid = document.getElementById("userid");
		userid.focus();
	}
-->
</script>
</head>
<body>
<?php
//--------------------------------
//登录检测
//--------------------------------
if(!empty($_POST["Action"])){
	$dopost = $_POST["Action"];
	if($dopost=="login"){
		
		if(empty($_POST["userid"])){
			echo ("<script type='text/javascript'> alert('用户名怎么能是空的呢！');location.href='admin_login.php';</script>");
			exit;
		}
		if(empty($_POST["pwd"])){
			echo ("<script type='text/javascript'> alert('密码也不能是空的！');location.href='admin_login.php';</script>");
			exit;
		}

		$user_name=csubstr(strip_tags(trim($_POST["userid"])),0,20); 	//用户名已经记录了
		$user_pws=csubstr(strip_tags(trim($_POST["pwd"])),0,20);		//密码已经记录了
		$user_pws = md5($user_pws);

		//echo $user_pws."<br>";
		//echo $servername."<br>".$sqlservername."<br>".$sqlserverpws;

		$comments = $wpdb->get_results("select * from admin where userid='$user_name' and pwd='$user_pws'");
		if ($comments == null){
			echo ("<script type='text/javascript'> alert('用户名或密码不正确！');location.href='admin_login.php';</script>");
			exit;
		}else{
			$ipaddress = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"]; 			//IP地址
			$ipaddress = ($ipaddress) ? $ipaddress : $_SERVER["REMOTE_ADDR"];
			$tim = date("Y-m-j H:i:s");
			$sql="update admin set logintime='$tim',loginip='$ipaddress' where userid='".addslashes($user_name)."'";
			$curID = $wpdb->query($sql);

			$query = "select * from admin where userid='$user_name'";	//开始查询
			$results = $wpdb->get_results($query);									//执行SQL		
			if($results != null){
				$id 		= stripslashes($results[0]->id);
				$uname 		= stripslashes($results[0]->uname);
				$typeid 	= stripslashes($results[0]->typeid);
				$channelid 	= stripslashes($results[0]->channelid);
				$infoid 	= stripslashes($results[0]->infoid);
			}
			$_SESSION["Admin_UserID"]		=$id;
			$_SESSION["Admin_Name"]			=$user_name;
			$_SESSION["Admin_Nick"] 		= $uname;
			$_SESSION["Admin_Permissions"] 	= $typeid;
			$_SESSION["Admin_Channe"] 		= $channelid;
			$_SESSION["Admin_Info"] 		= $infoid;
			
			echo "<script type='text/javascript'>top.location.href='admin_index.php';</script>";
			exit();
		}
	}
}
?>

	<div class="main">
		<div class="title">
			管理登陆
		</div>
		
		<div class="login">
		<form action="admin_login.php" method="post" onSubmit="return Chk(this);">
            <input type="hidden" name="Action" value="login">
            <div class="inputbox">
				<dl>
					<dt>用户名：</dt>
					<dd><input name="userid" type="text" id="userid" onfocus="this.style.borderColor='#F93'" onblur="this.style.borderColor='#888'" size="20" maxlength="20" />
					</dd>
				</dl>
			  <dl>
					<dt>密码：</dt>
					<dd><input name="pwd" type="password" onfocus="this.style.borderColor='#F93'" onblur="this.style.borderColor='#888'" size="20" maxlength="20" />
					</dd>
			  </dl>
            <div class="butbox">
            <dl>
			  <dt><input name="submit" type="submit" value="" /></dt>
			  </dl>
			</div>
		</form>
		</div>
</div>
<script type="text/javascript">
function Chk(theForm)
{
	if (theForm.userid.value == ""){
		alert("用户名不能为空!");
		theForm.userid.focus();
		return (false);
    }
	if (theForm.pwd.value == ""){
		alert("密码不能为空!");
		theForm.pwd.focus();
		return (false);
    }
}
</script>
</body>
</html>
