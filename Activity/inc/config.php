<?php
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'caizd');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'gGZkSbEs');
	//require_once('inc/class.db.php');
	$config['WebsiteTitle'] = "hongbao";											//网站标题
	$config['WebsiteUrl'] 	= "";					//网站地址
	$config['RewriteUrl'] 	= 0;													//静态化设置 0 or 1
	$config['Copyright'] 	= "&copy; 2001-2014 anta.com All Right Reserved";	//版权信息




/*
	unset($onlineip);
	if($_SERVER['HTTP_CLIENT_IP']){
		$onlineip=$_SERVER['HTTP_CLIENT_IP'];
	}elseif($_SERVER['HTTP_X_FORWARDED_FOR']){
		$onlineip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$onlineip=$_SERVER['REMOTE_ADDR'];
	}

	$file_name		= "http://".$_SERVER['HTTP_HOST']."/ipconfig.txt";
	//$file_name		= "http://worldcup.qiaqiafood.com/ipconfig.txt";
	$file_content 	= file_get_contents($file_name);
	$ALLOWED_IP 	= explode("\r\n", $file_content);
	foreach ($ALLOWED_IP as $val){
		if (in_array($onlineip, $ALLOWED_IP)) {
			break;
		}else{
			echo "<html>\r\n";
			echo "<head><title>404 Not Found</title></head>\r\n";
			echo "<body bgcolor=\"white\">\r\n";
			echo "<center><h1>404 Not Found</h1></center>\r\n";
			echo "<hr><center>nginx</center>\r\n";
			echo "</body>\r\n";
			echo "</html>";
			exit();
		}
	}
*/
?>