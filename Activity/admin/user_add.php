<?php
	require_once('./auth.php');
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');
	if($TypeID != "999"){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo ("<script type='text/javascript'> alert('您无权访问该区域!');location.href='admin_index_body.php';</script>");
		exit();
	}

	if($_POST["Action"]=="edit"){
		$user_name		= trim($_POST["user_name"]);
		
		$totalnum = $wpdb->get_var("SELECT count(*) FROM admin where userid = '".$user_name."' ");
		if($totalnum > 0){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo ("<script type='text/javascript'> alert('登陆账号存在!');location.href='user_index.php';</script>");
			exit();
		}
		$edit_uname		= trim($_POST["uname"]);
		$e_pwd			= trim($_POST["pwd"]);
		if(!empty($e_pwd)){
			$e_pwd = md5($e_pwd);
		}
		$edit_email		= trim($_POST["email"]);
		$typeid			= intval(trim($_POST["typeid"]));
		if($typeid == "999"){
			$channelid 		= "1,2,3,4";
			$infoid 		= "1,2,3";
		}elseif($typeid == "1"){
			$channel_arr	= $_POST["channelid"];
			$channelid 		= implode(",", $channel_arr);
			$infoid_arr		= $_POST["infoid"];
			$infoid 		= implode(",", $infoid_arr);
		}


//	print_r($channel_arr);
//	print_r($infoid_arr);

		$ipaddress 	= ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"]; 			//IP地址
		$ipaddress 	= ($ipaddress) ? $ipaddress : $_SERVER["REMOTE_ADDR"];
		$addtime 	= mktime();
		
		$sql="insert into admin(userid,pwd,uname,email,typeid,channelid,infoid,addtime,ipaddress)values('$user_name','$e_pwd','$edit_uname','$edit_email','$typeid','$channelid','$infoid',$addtime,'$ipaddress') ";
//		echo $sql;
		$curID = $wpdb->query($sql);
		if($curID == 1){
			echo ("<script type='text/javascript'> alert('添加成功!');location.href='user_index.php';</script>");
			exit();
		}else{
			exit();
			echo "<script type='text/javascript'> alert('添加失败!');location.href='user_add.php';</script>";
			exit();
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加管理员</title>
<link href="css/2.css" rel="stylesheet" type="text/css">
<script type="text/javascript"> 
function checkSubmit()
{
	//登录名
	if(document.getElementById("user_name").value==""){
		alert("登录名不能为空!");
		document.getElementById("user_name").focus();
		return false;
	}else{
		var js_name=document.getElementById("nickname").value;
		if(js_name.length<4||js_name.length>18)
		{
			alert("账号最少4个字符!");
			document.getElementById("nickname").focus();
			return false;
		}
	}
	if(document.getElementById("pwd").value==""){
		alert("密码不能为空");
		document.getElementById("pwd").focus();
		return false;
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
			document.getElementById('checkokpwd').innerHTML = "<font color='green'>密码正确！</font>";
		}
	}
}
</script>
</head>
<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="table">
  <form action="" method="post" id="form1" name="form1" onsubmit="return checkSubmit();">
    <tr class="xingmu">
        <td height="24" colspan="3" class="xingmu">&nbsp;添加管理员</td>
    </tr>
  <tr>
      <td height="28" bgcolor="#F9F9F9"><div align="right">登录ID：</div></td>
      <td align="left" bgcolor="#FFFFFF" colspan="2"><input name="user_name" type="text" class="flat" id="user_name" style="width:150px" value="" size="16" maxlength="12"/>
      &nbsp;登陆ID提交后不可修改</td>
    </tr>
    <tr>
      <td height="24" bgcolor="#F9F9F9"><div align="right">管理昵称：</div></td>
      <td align="left" bgcolor="#FFFFFF" colspan="2"><input name="uname" type="text" class="flat" id="uname" style="width:150px" size="16" maxlength="16" />
        &nbsp;可修改</td>
    </tr>
    <tr>
      <td height="24" bgcolor="#F9F9F9"><div align="right">电子邮件：</div></td>
      <td align="left" bgcolor="#FFFFFF" colspan="2"><input name="email" type="text" class="flat" id="email" style="width:150px" size="16" maxlength="16" />
        &nbsp;可修改</td>
    </tr>
    <tr>
      <td height="24" bgcolor="#F9F9F9"><div align="right">新密码：</div></td>
      <td align="left" bgcolor="#FFFFFF" colspan="2"><input name="pwd" type="text" class="flat" id="pwd" style="width:150px" onchange="checkPwd()" size="16" maxlength="16" />
        &nbsp;（只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'、'!'以内范围的字符）</td>
    </tr>
    <tr>
      <td height="24" bgcolor="#F9F9F9"><div align="right">确认新密码：</div></td>
      <td align="left" bgcolor="#FFFFFF" colspan="2"><input name="pwd2" type="text" class="flat" id="pwd2" style="width:150px" onchange="checkPwd()" size="16" maxlength="16" />
          <span id='checkokpwd'></span></td>
    </tr>
<?php
	if($TypeID == "999"){
?>
    <tr>
        <td height="24" class="xingmu">&nbsp;管理权限：
      </td>
        <td height="24" colspan="2" class="xingmu">
<label><input type="radio" name="typeid" id="typeid" value="999" onClick="SwitchNewsType('notitle');" <?php if($str_typeid=="999"){ echo "checked='checked'";}?>/>超级管理员</label>
&nbsp;<label><input name="typeid" type="radio" id="typeid" value="1" onClick="SwitchNewsType('yestitle');" <?php if($str_typeid!="999"){ echo "checked='checked'";}?>/>普通管理员</label>
      </td>
    </tr>
    <tr id="001">
        <td height="24" bgcolor="#F9F9F9">
            <div align="right">频道权限：</div>
        </td>
        <td height="24" colspan="2" bgcolor="#FFFFFF">
<?php
	eval('$typeid = array('.$typeid.');');

	$query = "select * from channel order by id asc";
	$results = $wpdb->get_results($query);
	if($results != null){
		foreach($results as $result){
			$channel_id		= $result->id;
			$channel_name 	= $result->title;
?>
		<label>
        <input type="checkbox" name="channelid[]" id="channelid" value="<?php echo $channel_id ?>" <?php if(in_array("$calss_id", $typeid)){echo "checked='checked'";} ?>/>
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
            <label>
            <input type="checkbox" name="infoid[]" id="infoid" value="1" <?php if(in_array("$calss_id", $typeid)){echo "checked='checked'";} ?>/>
            添加
            </label>
            <label>
            <input type="checkbox" name="infoid[]" id="infoid" value="2" <?php if(in_array("$calss_id", $typeid)){echo "checked='checked'";} ?>/>
            修改
            </label>
            <label>
            <input type="checkbox" name="infoid[]" id="infoid" value="3" <?php if(in_array("$calss_id", $typeid)){echo "checked='checked'";} ?>/>
            删除
            </label>
        </td>
    </tr>
<?php
	}
?>
    <tr>
      <td height="30" colspan="2" class="hback" style="padding-left:30px;">
        <input type="hidden" name="Edit_ID" id="Edit_ID" value="<?php echo $u_id; ?>" />
        <input type='hidden' name='Action' value='edit' />
        <input type="submit" name="Submit" value=" 添 加 " class="flat" style="cursor:pointer;"/>
      </td>
    </tr>
  </form>
</table>
<?php
	include("name.php");
?>
<script language="JavaScript" type="text/JavaScript">
function selectit(){
	//设置变量form的值为name等于select的表单
	var form=document.form1
	//取得触发事件的按钮的name属性值
	var action=event.srcElement.name
	for (var i=0;i<form.elements.length;i++){//遍历表单项
	//将当前表单项form.elements[i]对象简写为e
	var e = form.elements[i]
	//如果当前表单项的name属性值为iTo，
	//执行下一行代码。限定脚本处理的表单项范围。
	if (e.name == "typeid[]")
	/*如果单击事件发生在name为selectall的按钮上，就将当前表单项的checked属性设为true(即选中)，否则设置为当前设置的相反值(反选)*/
	e.checked =(action=="selectall")?(form.selectall.checked):(!e.checked) 
	}
}
</script>

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
