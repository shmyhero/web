<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$participant = Session_Util::my_session_get('participant');
if ($participant !== NULL) {
	$participant = json_decode($participant);
}else{
	$url = BASE_URL.'login.php';
	header("Location:".$url);
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>全民股神</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="css/cloud-admin.css" >
    <link rel="stylesheet" type="text/css"  href="css/themes/default.css" id="skin-switcher" >
    <link rel="stylesheet" type="text/css"  href="css/responsive.css" >
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <!-- UNIFORM -->
    <link rel="stylesheet" type="text/css"ref="js/uniform/css/uniform.default.min.css" />

    <link rel="stylesheet" href="css/jquery.atwho.css" />

    <!-- INBOX CSS -->
    <link rel="stylesheet" href="css/inbox.css">
	<style>
		.note-alarm {
		float: right;
		margin-top: 10px;
		margin-right: 10px;
		}
	</style>
</head>
<body>
<!-- HEADER -->
<header class="navbar clearfix" id="header">
    <div class="container headercontainer">
        
    </div>

</header>
<!--/HEADER -->

<!-- PAGE -->
<section id="page">
    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar">
        <div class="sidebar-menu nav-collapse">
            <div class="divide-20"></div>
            <ul>
                <li class="has-sub">
                    <a  class="" href="index.html">
                        <i class="fa fa-bookmark-o fa-fw"></i> <span class="menu-text">广场</span>
                        
                    </a>
                    <!-- 
                    <ul class="sub">
                        <li><a class="" href="index.html"><span class="sub-menu-text">讨论大厅</span></a></li>
                        <li><a class="" href="notifications.html"><span class="sub-menu-text">新手学堂</span></a></li>
                        <li><a class="" href="buttons_icons.html"><span class="sub-menu-text">精华帖</span></a></li>
                        <li><a class="" href="sliders_progress.html"><span class="sub-menu-text">悬赏帖</span></a></li>

                        
                    </ul>-->
                </li>
                <li>
                    <a href="Security.php" class="">
                        <i class="fa fa-comments fa-fw"></i> <span class="menu-text">个股讨论</span>
                       
                    </a>
                </li>

                <li>
                    <a href="stockrecommend.php" class="">
                        <i class="fa fa-table fa-fw"></i> <span class="menu-text">股神荐股</span>
                        <span class="arrow"></span>
                    </a>
                </li>
                
            </ul>
            <!-- /SIDEBAR MENU -->
        </div>
    </div>
    <!-- /SIDEBAR -->
    
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div id="content" class="col-lg-12">
                    <!-- PAGE HEADER-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-header">
                                <!-- STYLER -->

                                <!-- /STYLER -->
                                <!-- BREADCRUMBS -->
                                <ul class="breadcrumb">
                                    <li>
                                        <i class="fa fa-home"></i>
                                        <a href="stockrecommend.php">股神荐股</a>
                                    </li>
                                    <li>
                                        <a href="stockrecommend.php" class="daohang">荐股帖子</a>
                                    </li>
                                    <!--<li>概览</li>-->
                                </ul> 
                                <!-- /BREADCRUMBS -->
                                <div class="clearfix">
                                    <h3 class="content-title pull-left daohang">我的帖子</h3>
                                </div>
                                <!--<div class="description">Email Inbox</div>-->
                            </div>
                        </div>
                    </div>
                    <!-- /PAGE HEADER -->
                    <!-- INBOX -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BOX -->
                            <div class="box border">
                                <div class="box-title">
                                    <h4><i class="fa fa-suitcase "></i>我的帖子</h4>
                                    <div class="tools">
                                        <a href="javascript:;" class="reload">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body">
                                   
                                    <hr>
                                    <!-- INBOX -->
                                    <div class="row email">
                                        <div id="list-toggle" class="col-md-2">
                                            <ul class="list-unstyled">
                                                <li class="composeBtn">
                                                    <a href="javascript:;" data-title="Compose" class="btn btn-danger">  撰写新文章  </a>
                                                </li>
                                            </ul>
                                            <ul class="emailNav nav nav-pills nav-stacked margin-bottom-10">
                                                <li class="inbox " >
                                                    <a href="javascript:;" data-title="Inbox">
                                                        <i class="fa fa-inbox fa-fw"></i> 我的帖子
                                                    </a>
                                                </li>
<!--                                                <li class="starred">-->
<!--                                                    <a href="javascript:;" data-title="Starred">-->
<!--                                                        <i class="fa fa-user fa-fw"></i> 我的回复-->
<!--                                                    </a>
                                                </li>-->
                                                
                                            </ul>
                                        </div>
                                        
                                        <div class="col-md-10">
                                            <div class="emailContent"></div>
                                        </div>
                                    </div>
                                    <!-- /INBOX -->
                                </div>
                            </div>
                            <!-- /BOX -->
                        </div>
                    </div>
                    <!-- /INBOX -->
                    <div class="footer-tools">
							<span class="go-top">
								<i class="fa fa-chevron-up"></i> Top
							</span>
                    </div>
                    
                </div>
                <!-- /CONTENT-->
            </div>
        </div>
    </div>
</section>
<!--/PAGE -->
<!-- JAVASCRIPTS -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- JQUERY -->
<script src="js/jquery/jquery-2.0.3.min.js"></script>
<!-- JQUERY UI-->
<script src="js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- BOOTSTRAP -->
<script src="bootstrap-dist/js/bootstrap.min.js"></script>
<!-- LESS CSS
<script src="js/lesscss/less-1.4.1.min.js" type="text/javascript"></script> -->

<!-- DATE RANGE PICKER 日期选择
<script src="js/bootstrap-daterangepicker/moment.min.js"></script>
<script src="js/bootstrap-daterangepicker/daterangepicker.min.js"></script>
-->
<!-- SLIMSCROLL 滚动条
<script type="text/javascript" src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
-->
<!-- BLOCK UI 弹窗
<script type="text/javascript" src="js/jQuery-BlockUI/jquery.blockUI.min.js"></script>
-->
<!-- UNIFORM -->
<script type="text/javascript" src="js/uniform/jquery.uniform.min.js"></script>
<!-- BOOTSTRAP WYSIWYG -->

<!-- <script  src="js/summernote-master/dist/summernote.js"></script>
<script  src="js/summernote-master/lang/summernote-zh-CN.js"></script>
必须-->

<script  src="js/ajaxfileupload.js"></script>

           <script type="text/javascript" src="js/jquery.caret.js"></script>
    <script type="text/javascript" src="js/jquery.atwho.js"></script>
<!-- COOKIE -->
<script type="text/javascript" src="js/jQuery-Cookie/jquery.cookie.min.js"></script>
<!-- CUSTOM SCRIPT -->
<script src="js/script.js"></script>
<script src="js/commend.js"></script>
<script>
    jQuery(document).ready(function() {
        App.setPage("commend");  //Set current page
        App.init(); //Initialise plugins and elements
        Commend.init();

        
    });
</script>
<!-- /JAVASCRIPTS -->
</body>
</html>
