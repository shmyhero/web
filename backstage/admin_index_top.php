<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$participant = Session_Util::my_session_get('participant');
$participant = json_decode($participant);

	//echo $participant->name;
	//echo $participant->password;
	
	$arruser1='[{"userid" : "112@qq.com"}, 
				{"userid" : "1123@qq.com"},    
				{"userid" : "11234@qq.com"},  
				{"userid" : "112345@qq.com"},
				{"userid" : "1123456@qq.com"},
				{"userid" : "1112@qq.com"},    
				{"userid" : "11123@qq.com"},  
				{"userid" : "111234@qq.com"},
				{"userid" : "1112345@qq.com"},
				{"userid" : "11123456@qq.com"},
				{"userid" : "212@qq.com"},    
				{"userid" : "2123@qq.com"},
				{"userid" : "21234@qq.com"},  
				{"userid" : "212345@qq.com"},  
				{"userid" : "2123456@qq.com"},
				{"userid" : "2212@qq.com"},
				{"userid" : "22123@qq.com"},  
				{"userid" : "221234@qq.com"},  
				{"userid" : "2212345@qq.com"},
				{"userid" : "22123456@qq.com"}]';

	$arruser2='[{"userid" : "p12345@qq.com"},
				{"userid" : "p13456@qq.com"},
				{"userid" : "p14567@qq.com"},
				{"userid" : "p23456@qq.com"},
				{"userid" : "p24567@qq.com"},
				{"userid" : "p21234@qq.com"},
				{"userid" : "p22345@qq.com"},
				{"userid" : "p25678@qq.com"},
				{"userid" : "p41234@qq.com"},
				{"userid" : "p42234@qq.com"},
				{"userid" : "p43234@qq.com"},
				{"userid" : "p44234@qq.com"},
				{"userid" : "p512345@qq.com"},
				{"userid" : "p522345@qq.com"},
				{"userid" : "p532345@qq.com"},
				{"userid" : "p552345@qq.com"},
				{"userid" : "p31234@qq.com"},
				{"userid" : "p32234@qq.com"},
				{"userid" : "p33234@qq.com"},
				{"userid" : "p34234@qq.com"},
				{"userid" : "p61234@qq.com"},
				{"userid" : "p62234@qq.com"},
				{"userid" : "p63234@qq.com"},
				{"userid" : "p64234@qq.com"},
				{"userid" : "p65234@qq.com"},
				{"userid" : "p66234@qq.com"}]';
	
	$arruser3='[{"userid" : "officialcn@tradehero.mobi"},{"userid" : "managercn@tradehero.mobi"},{"userid" : "mastercn@tradehero.mobi"},{"userid" : "Celia@tradehero.mobi"}]';
	
	$arruser4='[{"userid" : "gs001@qq.com"},{"userid    " : "gs002@qq.com"},{"userid" : "gs003@qq.com"},{"userid" : "gs004@qq.com"},{"userid" : "gs005@qq.com"},{"userid" : "gs006@qq.com"},{"userid" : "gs007@qq.com"}]';
	
	$arruser5='[{"userid" : "jg001@qq.com"},{"userid" : "jg002@qq.com"},{"userid" : " jg003@qq.com"},{"userid" : " jg004@qq.com"},{"userid" : " jg005@qq.com"}]';
	
	switch ($participant->password) {
	case '123456':
		$userswitchingarr=json_decode($arruser1,true);
		break;
	case '1003110762':
		$userswitchingarr=json_decode($arruser2,true);
		break;
	case 'trader111':
		$userswitchingarr=json_decode($arruser3,true);   
		break;
	case '012345':
		$userswitchingarr=json_decode($arruser4,true);
		break;
	case '111111':
		$userswitchingarr=json_decode($arruser5,true);
		break;
	};
	
?>
<!DOCTYPE html>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
		<div class="navbar-brand">
            <!-- COMPANY LOGO -->
            <a >
                <img src="img/logo/logo.png" alt="Logo" class="img-responsive">
            </a>
            <!-- /COMPANY LOGO -->
            <!-- TEAM STATUS FOR MOBILE -->
            <div class="visible-xs">
                <a href="#" class="team-status-toggle switcher btn dropdown-toggle">
                    <i class="fa fa-users"></i>
                </a>
            </div>
            <!-- /TEAM STATUS FOR MOBILE -->
            <!-- SIDEBAR COLLAPSE -->
            <div id="sidebar-collapse" class="sidebar-collapse btn">
                <i class="fa fa-bars"
                   data-icon1="fa fa-bars"
                   data-icon2="fa fa-bars" ></i>
            </div>
            <!-- /SIDEBAR COLLAPSE -->
        </div>
        <!-- NAVBAR LEFT -->
        <ul class="nav navbar-nav pull-left hidden-xs" id="navbar-left">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-cog"></i>
                    <span class="name">样式设置</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu skins">
                    <li class="dropdown-title">
                     	<span><i class="fa fa-leaf"></i> 选择皮肤</span>
                    </li>
                    <li><a  data-skin="default">白天</a></li>
                    <li><a  data-skin="night">夜间</a></li>
                    <li><a  data-skin="nature">护眼</a></li>
                </ul>
            </li>
        </ul>
        <!-- /NAVBAR LEFT -->

        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user" id="header-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img alt="" src="<?php echo $participant->picUrl ;   ?>" />
                    <span class="username"><?php echo $participant->nickname ;   ?></span>
                    <i class="fa fa-angle-down"></i>  
                </a>
                <ul class="dropdown-menu">
                    <?php
	foreach($userswitchingarr as $k=>$val){  ?>
	
	<li ><a ><i class="fa fa-male"><?php echo $val["userid"] ;   ?></i></a></li>
	
	 <?php
		}
		?>
                    <li><a href="login.php"><i class="fa fa-power-off"></i>切换用户</a></li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
</body>
</html>

