<?php
	include("auth.php");
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');
	require_once('inc/class_page.php');
	
	if($TypeID != "999"){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo ("<script type='text/javascript'> alert('您无权访问该区域!');location.href='admin_index_body.php';</script>");
		exit();
	}

	$key = @$_REQUEST["start_time"];
	$key1 = @$_REQUEST["class_id"];
	$pxxx = @$_REQUEST["type"];
	$px='';
	if($pxxx=="date"){
		if($key!=""){
			$px = "where AddDate like '%$key%' ";
		}
	} 
	if($pxxx=="dengji"){
		$px = "where dengji = $key1";
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>会员管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/2.css" rel="stylesheet" type="text/css">
<LINK href="css/page.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript" src="js/PublicJS.js" charset="utf-8"></script>
<SCRIPT language=javascript src="js/arclist.js"></SCRIPT>
</HEAD>
<BODY>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="table">
    <tr class="hback">
        <td class="xingmu">系统管理</td>
    </tr>
    <tr class="hback">
        <td class="hback"><a href="user_index.php">管理员列表</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="user_add.php">添加管理员</a></td>
    </tr>
</table>

<table class="table" cellspacing=1 cellpadding=1 width="98%" align=center border=0>
  <tbody>
  <form name="form2" id="form2">
    <tr align="middle" class="xingmu">
      <td class="xingmu" width="4%">ID</td>
      <td class="xingmu" width="4%">选择</td>
      <td class="xingmu" align="left">&nbsp;登录名</td>
      <td class="xingmu" align="left">&nbsp;昵称</td>
      <td class="xingmu" align="left">&nbsp;邮件</td>
      <td class="xingmu" align="left">&nbsp;管理权限</td>
      <td class="xingmu" align="left">&nbsp;最后登陆</td>
      <td class="xingmu" align="left">&nbsp;登陆IP</td>
    </tr>
<?php	
	$page = @$_REQUEST["page"];
	$perPage = 20;
	$startnum = ((($page > 1)?$page:1)-1) * $perPage;
	$endnum = $perPage;
	
	$totalnum = $wpdb->get_var("SELECT count(*) FROM admin $px order by userid asc");
	$pages = ceil($totalnum/$perPage);
	$R_sql = "SELECT * FROM admin $px order by userid asc limit $startnum,$endnum";
	$comments = $wpdb->get_results($R_sql);
	//print_r($comments);
	$alternate='0';
	if ($comments != null){
		foreach ($comments as $comment){
			$id			= $comment->id;
			$userid		= $comment->userid;
			$uname 		= $comment->uname;
			$email 		= $comment->email;
			$typeid 	= $comment->typeid;
			if($typeid == "999"){
				$usertype = "超级管理员";
			}else{
				$usertype = "普通管理员";
			}
			$logintime 	= $comment->logintime;
			$ip 		= $comment->loginip;
			$addtime 	= $comment->addtime;	
		
			//颜色循环代码__________________
			if ($alternate == "1"){
				$color = "#F6F6F6"; $alternate = "2"; 
			}else{
				$color = "#ffffff"; $alternate = "1"; 
			}
?>
    <tr onMouseOver="overColor(this)" onMouseOut="outColor(this)" style="cursor:pointer;">
        <td class="hback" align="center"><?php echo $id ?></td>
        <td class="hback" align="center"><input id="arcID" type="checkbox" value="<?php echo $id ?>" name="arcID"></td>
        <td class="hback" align=left>&nbsp;<a href="user_edit.php?id=<?php echo $id ?>"><?php echo $userid; ?></a></td>
        <td class="hback" align=left>&nbsp;<?php echo $uname; ?></td>
        <td class="hback" align="left">&nbsp;<?php echo $email; ?></td>
        <td class="hback" align="left">&nbsp;<?php echo $usertype; ?></td>
        <td class="hback" align="left">&nbsp;<?php echo $logintime; ?></td>
        <td class="hback"  align="left">&nbsp;<?php echo $ip; ?></td>
    </tr>
<?php
	}
?>
    <tr class="hback">
        <td class="hback" colspan="8" height="30">
            &nbsp;&nbsp;<a class=inputbutx href="javascript:selAll()">全选</a>
            &nbsp;&nbsp;<a class=inputbutx href="javascript:noSelAll()">取消</a>
            &nbsp;&nbsp;<a class=inputbutx href="javascript:delAdmin(0)" onClick="{if(confirm('确定删除所选数据吗?\n\n如果删除将不可还原!')){document.getElementById('form2').submit();javascript:delAdmin(0);return true;}return false;};">删除</a>
        </td>
    </tr>
  </form>
    <tr class="hback">
        <td class="hback" colspan="8">
            <span class="mainbox notice">
				<?php echo paging($pages, "page"); ?>&nbsp;&nbsp;<font class='page'>共<?php echo $totalnum; ?>&nbsp;&nbsp;每页<?php echo $perPage; ?>条信息</font>
            </span>
        </td>
    </tr>
  <?php 
	}else{
?>
  <tr>
    <td height="50" colspan="8">&nbsp;暂无内容</td>
  </tr>
  <?php	
	}
?>
</table>
<?php
	include("name.php");
?>
</BODY>
</HTML>