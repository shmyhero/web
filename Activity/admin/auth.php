<?php
	if (!session_id())  session_start();
	if (!$_SESSION["Admin_Name"]){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo ("<script type='text/javascript'> alert('请先登录');location.href='admin_login.php';</script>");
	}else{
		$Admin_Name = $_SESSION["Admin_Name"];
		$Admin_Nick = $_SESSION["Admin_Nick"];
		$TypeID = $_SESSION['Admin_Permissions'];//权限999为超级管理
	}
	//print_r($_SESSION);
?>
