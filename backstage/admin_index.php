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
		<frameset cols="176,*" name="bodyFrame" id="bodyFrame" frameborder="no" border="0" framespacing="0"  >
		<section id="page">
			<frame src="admin_index_menu.php" name="menu" id="menu" scrolling="auto" noresize>
			<frame src="admin_index_body.php" name="main" id="main" scrolling="auto" noresize>
	    </section>
		</frameset>
		
	</frameset>
	<noframes>
		<body>你的浏览器不支持框架！</body>
	</noframes>
	<!--/PAGE -->
<!-- JAVASCRIPTS -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- JQUERY -->
<script src="js/jquery/jquery-2.0.3.min.js"></script>
<!-- JQUERY UI-->
<script src="js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- BOOTSTRAP -->
<script src="bootstrap-dist/js/bootstrap.min.js"></script>
<!-- LESS CSS -->
<script src="js/lesscss/less-1.4.1.min.js" type="text/javascript"></script>
<!-- DATE RANGE PICKER -->
<script src="js/bootstrap-daterangepicker/moment.min.js"></script>
<script src="js/bootstrap-daterangepicker/daterangepicker.min.js"></script>
<!-- SLIMSCROLL -->
<script type="text/javascript" src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script><script type="text/javascript" src="js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
<!-- BLOCK UI -->
<script type="text/javascript" src="js/jQuery-BlockUI/jquery.blockUI.min.js"></script>
<!-- UNIFORM -->
<script type="text/javascript" src="js/uniform/jquery.uniform.min.js"></script>
<!-- BOOTSTRAP WYSIWYG -->
<script type="text/javascript" src="js/bootstrap-wysiwyg/jquery.hotkeys.min.js"></script>
<script type="text/javascript" src="js/bootstrap-wysiwyg/bootstrap-wysiwyg.min.js"></script>
<!-- COOKIE -->
<script type="text/javascript" src="js/jQuery-Cookie/jquery.cookie.min.js"></script>
<!-- CUSTOM SCRIPT -->
<script src="js/script.js"></script>
<script src="js/inbox.js"></script>
<script>
    jQuery(document).ready(function() {
        App.setPage("inbox");  //Set current page
        App.init(); //Initialise plugins and elements
        Inbox.init();
    });
</script>
<!-- /JAVASCRIPTS -->
</html>
