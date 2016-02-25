<?php 
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

$participant = Session_Util::my_session_get('participant');
if ($participant !== NULL) {
	
	$participant = json_decode($participant);
	$name=$participant->name;
	$password = $participant->password;
	$remember = $participant->remember;
	//echo  $_COOKIE['name'];
//	$url = BASE_URL.'fn_system.php';
//	header("Location:".$url);
//	exit();
	
    }else {
     	//echo "session为空  ";
     }  

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>全民股神 | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link rel="stylesheet" type="text/css" href="css/cloud-admin.css" >
	
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- DATE RANGE PICKER -->
	<link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
	<!-- UNIFORM -->
	<link rel="stylesheet" type="text/css" href="js/uniform/css/uniform.default.min.css" />
	<!-- ANIMATE -->
	<link rel="stylesheet" type="text/css" href="css/animatecss/animate.min.css" />
	<!-- FONTS -->
		<link rel="stylesheet" type="text/css" href="css/fonts.googleapis.com.css" />

</head>
<body class="login">	
	<!-- PAGE -->
	<section id="page">
			<!-- HEADER -->
			<header>
				<!-- NAV-BAR -->
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div id="logo">
								<a ><img src="img/logo/logo-alt.png" height="40" alt="logo name" /></a>
							</div>
						</div>
					</div>
				</div>
				<!--/NAV-BAR -->
			</header>
			<!--/HEADER -->
			<!-- LOGIN -->
			<section id="login" class="visible">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box-plain">
								<h2 class="bigintro">Sign In</h2>
								<div class="divide-40"></div>
								
								  <div class="form-group">
									<label for="exampleInputEmail1">邮箱地址</label>
									<i class="fa fa-envelope"></i>
									<input type="email" class="form-control" id="exampleInputEmail1" value="<?php echo $_COOKIE['name'];?>" >
								  </div>
								  <div class="form-group"> 
									<label for="exampleInputPassword1">密码</label>
									<i class="fa fa-lock"></i>
									<input type="password" class="form-control" id="exampleInputPassword1" value="<?php echo $_COOKIE['password'] ?>">
								  </div>
								  <div class="form-actions">
									<label class="checkbox">
									<?php if($remember == "1"){?>
									<input type="checkbox" class="uniform" id="exampleInputcheck" checked>记住我
									<?php }else{($remember == "0")?>
									<input type="checkbox" class="uniform" id="exampleInputcheck" >记住我
									<?php }?></label>
									<button type="button" class="btn btn-danger">登录</button>
								  </div>
								
								<!-- SOCIAL LOGIN -->
								
								<div class="divide-20"></div>
								<div class="center">
									<strong></strong>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--/LOGIN -->
			
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
	
	
	<!-- UNIFORM -->
	<script type="text/javascript" src="js/uniform/jquery.uniform.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="js/script.js"></script>
	<script>
		jQuery(document).ready(function() {		
			App.setPage("login");  //Set current page
			App.init(); //Initialise plugins and elements
			
			$('.btn-danger').on('click', function () {
			
			var email    =	$('#exampleInputEmail1').val();
			var password =	$('#exampleInputPassword1').val();
			var remember = "0";
			$("[type='checkbox'][id='exampleInputcheck']:checked").each(function(){  
				remember="1";
			});
			//console.log( remember);
				if(email!=''&&password!='')
				{
					var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					 if (filter.test(email))
					 { 
						$.ajax({
							type : 'post',
				            cache: false,
				            url: "action.php",
				            dataType: "html",
				            data : {
								action : 'login',email: email,password: password,remember: remember
							},
				            success: function(obj) 
				            {
								//console.log(obj);
								var data = eval('(' + obj+ ')');
								if(data.status=="success")
								{
									window.location.href="index.html"
								}
								else{
									$('.center > strong').html('邮箱或密码错误'+data.status);
								}
				            },
				            error: function(xhr, ajaxOptions, thrownError)
				            {
				                toggleButton(el);
				            },
				            async: false
				        });
					 }
				 else {
					 $('.center > strong').html('请在电子邮箱地址中包含"@"。"'+email+'" 中缺少"@" ');
					 }
				}
				else
				{
					$('.center > strong').html('邮箱或密码不能为空');
				}
				
            });

			
		});
	</script>
	<script type="text/javascript">
		function swapScreen(id) {
			jQuery('.visible').removeClass('visible animated fadeInUp');
			jQuery('#'+id).addClass('visible animated fadeInUp');
		}
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>