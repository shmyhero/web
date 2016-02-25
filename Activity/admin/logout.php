<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>退出登录</title>
</head>

<body>
<?php
	if(isset($_SESSION["Admin_Name"]))
		unset($_SESSION["Admin_Name"]);
		unset($_SESSION["admin"]);
		session_destroy();
	//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo ("<script type='text/javascript'> alert('成功退出登录!');location.href='admin_login.php';</script>");

?></body>
</html>
