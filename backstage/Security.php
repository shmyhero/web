<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$api = new API();
$search=Security_Util::my_get('search');
$report=Security_Util::my_get('report');
//if($search!=''){
	//热门持有
	$trendingHold=json_decode($api->trendingHold(),true);
	//print_r($trendingHold);
	//涨幅榜单
	$trendingRisePercent=json_decode($api->trendingRisePercent(),true);
	//中国概念
	$trendingMarketCap=json_decode($api->trendingMarketCap(),true);
	
//}
//else{
//	if($report=='0'){
//	$StockpickHistory=json_decode($api->report(),true);
//	}
//}
$count1=count($trendingHold);
$count2=count($trendingRisePercent);
$count3=count($trendingMarketCap);

function TO_date($strALL)
{
	$arr= explode('T',$strALL);
	$str=$arr[0];
	return $arr[0].' '. $arr[1];
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
    <!-- STYLESHEETS --><!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
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
    <!-- FONTS
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'> -->
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

                                <ul class="breadcrumb">
                                    <li>
                                        <i class="fa fa-home"></i>
                                        <a href="Security.php">个股讨论</a>
                                    </li>
                                    <li>
                                        <a href="Security.php">个股讨论</a>
                                    </li>
                                    <!--<li>概览</li>-->
                                </ul>
                                <!-- /BREADCRUMBS -->
                                <div class="clearfix">
                                    <h3 class="content-title pull-left">个股讨论</h3>
                                </div>
                                <!--<div class="description">Email Inbox</div>-->
                            </div>
                        </div>
                    </div>
<!--<div class="emailHeader row">-->
<!--                                        <div class="emailTitle">-->
<!--                                            <div class="col-md-2">-->
<!--                                               -->
<!--                                            </div>-->
<!--                                            <div class="col-md-10">-->
<!--                                              -->
<!--                                                    <div class="input-group input-medium">-->
<!--                                                        <input type="text"  class="form-control" placeholder="查询 用户" >-->
<!--														<span class="input-group-btn">                   -->
<!--														<button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>-->
<!--														</span>-->
<!--                                                    </div>-->
<!--                                               -->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
                    <div class="row">
                        
                        
                        <div class="container main-content">
				<div class="row">
					<div id="content" class="col-lg-12">

						<!-- PAGE MAIN CONTENT -->
						<div class="row">
							<div class="col-md-3 box-container">
								<!-- BOX BORDER SLIMSCROLL -->
								<div class="box border orange">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i>热门持有</h4>
										
									</div>
									<div class="box-body">
										<div class="scroller" data-height="735px">
										<table class="table table-hover">
											<thead>
												
											</thead>
											<tbody>
											<?php
											if($count1>0){
											foreach($trendingHold as $k=>$val){  ?>
												<tr class="new">
													<td class="viewEmail sname"><?php echo $val["security"]["name"] ;   ?></td>
													<td class="viewEmail idtype"><?php echo  $val["security"]["symbol"].'|'.$val["security"]["exchange"].'|'.$val["security"]["id"] ;   ?></td>
													<?php
											if(intval($val["security"]["previousClose"]) !=0){  ?>
													<td class="viewEmail "><?php echo round( ($val["security"]["lastPrice"]-$val["security"]["previousClose"]) / $val["security"]["previousClose"] * 100,2) ;   ?>%</td>
												<?php }else{ ?>
													<td class="viewEmail ">0%</td>
												<?php } ?>
												</tr>
												<?php
												}}?>
											</tbody>
										
										</table>
										</div>
									</div>
								</div>
								<!-- /BOX BORDER SLIMSCROLL -->
							</div>
							<div class="col-md-3 box-container">
								<!-- BOX BORDER SLIMSCROLL -->
								<div class="box border orange">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i>涨幅榜单</h4>
										
									</div>
									<div class="box-body">
										<div class="scroller" data-height="735px">
										<table class="table table-hover">
											<thead>
												
											</thead>
											<tbody>
											<?php
											if($count2>0){
											foreach($trendingRisePercent as $k=>$val){  ?>
												<tr class="new">
													<td class="viewEmail sname"><?php echo $val["security"]["name"] ;   ?></td>
													<td class="viewEmail idtype"><?php echo  $val["security"]["symbol"].'|'.$val["security"]["exchange"].'|'.$val["security"]["id"] ;   ?></td>
													<td class="viewEmail "><?php echo round( ($val["security"]["lastPrice"]-$val["security"]["previousClose"]) / $val["security"]["previousClose"] *100,2) ;   ?>%</td>
													
												</tr>
												<?php
												}}?>
											</tbody>
										
										</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 box-container">
								<!-- BOX BORDER SLIMSCROLL -->
								<div class="box border orange">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i>中国概念</h4>
										
									</div>
									<div class="box-body">
										<div class="scroller" data-height="735px">
										<table class="table table-hover">
											<thead>
												
											</thead>
											<tbody>
											<?php
											if($count3>0){
											foreach($trendingMarketCap as $k=>$val){  ?>
												<tr class="new">
													<td class="viewEmail sname"><?php echo $val["security"]["name"] ;   ?></td>
													<td class="viewEmail idtype"><?php echo  $val["security"]["symbol"].'|'.$val["security"]["exchange"].'|'.$val["security"]["id"] ;   ?></td>
													<td class="viewEmail "><?php echo round( ($val["security"]["lastPrice"]-$val["security"]["previousClose"]) / $val["security"]["previousClose"] *100,2) ;   ?>%</td>
													
												</tr>
												<?php
												}}?>
											</tbody>
										
										</table>
										</div>
									</div>
								</div>
							</div>
								<!-- /BOX BORDER SLIMSCROLL -->
							</div>
					
						</div>
						
						<!-- BOX TABS -->
						
					</div><!-- /CONTENT-->
				</div>
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
<script src="js/lesscss/less-1.4.1.min.js" type="text/javascript"></script>-->
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
<script src="js/Security.js"></script>
<script>
    jQuery(document).ready(function() {
        App.setPage("elements");  //Set current page
        App.init(); //Initialise plugins and elements
        Security.init();
    });
</script>
<!-- /JAVASCRIPTS -->
</body>
</html>