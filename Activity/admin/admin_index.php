<?php
	require_once('./auth.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Manage</title>
</head>
	<frameset rows="40,*,32" cols="*" frameborder="no" border="0" framespacing="0" >
		<frame src="admin_index_top.php" name="topFrame" id="topFrame" scrolling="no" noresize>
		<frameset cols="100,*" name="bodyFrame" id="bodyFrame" frameborder="no" border="0" framespacing="0"  >
			<frame src="admin_index_menu.php" name="menu" id="menu" scrolling="auto" noresize>
			<frame src="admin_index_body.php" name="main" id="main" scrolling="auto" noresize>
		</frameset>
		<frame src="admin_index_foot.php" name="footFrame" id="footFrame" scrolling="no" noresize>
	</frameset>
	<noframes>
		<body>你的浏览器不支持框架！</body>
	</noframes>
</html>

