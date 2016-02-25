<?php
session_start();
	require_once('./auth.php');
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');

	if($TypeID != "999"){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo ("<script type='text/javascript'> alert('您无权访问该区域!');location.href='admin_index_body.php';</script>");
		exit();
	}

	$qstr 	= $_GET["qstr"];
	$aid 	= $_GET["aid"];
	$dopost = $_GET["dopost"];

	if(empty($dopost)||empty($aid)){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo "<script type='text/javascript'> alert('对不起，没有选择所要操作的运行参数！');location.href='user_index.php';</script>";
		exit();
	}else{

	if($dopost=="delArchives")
		$arr = explode(",",$qstr);
		$scount = count($arr);
		$people= $arr;
		for ($i=0;$i<$scount;$i++){
			/*--------------------------
			//删除文档
			function delArchives();
			---------------------------*/
			if($people[$i] == "1"){
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
				echo ("<script type='text/javascript'> alert('该账号禁止删除!');location.href='user_index.php';</script>");
				exit();
			}
			$sql="delete from admin where id = $people[$i]";
			$curID = $wpdb->query($sql);
			//确定刪除操作完成
			//include("replace_list.php");
		}
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo "<script type='text/javascript'> alert('ID({$qstr})管理删除成功');location.href='user_index.php';</script>";
		exit();
	}
?>