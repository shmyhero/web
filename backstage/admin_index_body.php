<?php
header("Content-type: text/html; charset=utf-8");
session_start();
//	require_once('./auth.php');
//	include("../inc/config.php");
//	include("../inc/class.db.php");
//	require_once('../inc/utils.php');
//	$count_article=0;
//	$count_english=0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Cloud Admin | Inbox</title>
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
    <link rel="stylesheet" type="text/css" href="js/uniform/css/uniform.default.min.css" />
    <!-- INBOX CSS -->
    <link rel="stylesheet" href="css/inbox.css">
    <!-- FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
</head>
<body>
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
                                        <a href="index.html">广场</a>
                                    </li>
                                    <li>
                                        <a href="index.html">讨论大厅</a>
                                    </li>
                                    <!--<li>概览</li>-->
                                </ul>
                                <!-- /BREADCRUMBS -->
                                <div class="clearfix">
                                    <h3 class="content-title pull-left">讨论大厅</h3>
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
                                    <h4><i class="fa fa-suitcase "></i>帖子</h4>
                                    <div class="tools">
                                        <a href="javascript:;" class="reload">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <!-- TOP ROW -->
                                    <div class="emailHeader row">
                                        <div class="emailTitle">
                                            <div class="col-md-2">
                                               
                                            </div>
                                            <div class="col-md-10">
                                                <form class="form-inline hidden-xs" action="index.html">
                                                    <div class="input-group input-medium">
                                                        <input type="text" class="form-control" placeholder="查询 帖子">
														<span class="input-group-btn">                   
														<button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
														</span>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /TOP ROW -->
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
                                                        <i class="fa fa-inbox fa-fw"></i> 讨论大厅
                                                    </a>
                                                </li>
                                                <li class="starred">
                                                    <a href="javascript:;" data-title="Starred">
                                                        <i class="fa fa-user fa-fw"></i> 新手学堂
                                                    </a>
                                                </li>
                                                <li class="sent">
                                                    <a href="javascript:;"  data-title="Sent">
                                                        <i class="fa fa-star fa-fw"></i> 精华帖
                                                    </a>
                                                </li>
                                                <li class="draft">
                                                    <a href="javascript:;" data-title="Draft">
                                                        <i class="fa fa-files-o fa-fw"></i> 悬赏贴
                                                    </a>
                                                </li>
                                                
                                                 <li class="otice">
                                                    <a href="javascript:;" data-title="Draft">
                                                        <i class="fa fa-files-o fa-fw"></i> 公告
                                                    </a>
                                                </li>
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


</body>
</html>