<?php
//HTTPOnly设置
if ('1' !== ini_get('session.cookie_httponly')) {
	ini_set('session.cookie_httponly', '1');
}
//只使用cookie
if ('1' !== ini_get('session.use_only_cookies')) {
	ini_set('session.use_only_cookies', '1');
}
//不使用URL传递session_id
if ('0' !== ini_get('session.use_trans_sid')) {
	ini_set('session.use_trans_sid', '0');
}
session_start();
if (!defined('ua_seed')) {
	define('ua_seed', '@ranranba');
}
if (!isset($_SESSION['user_agent'])) {
	$_SESSION['user_agent'] = md5(
			$_SERVER['HTTP_USER_AGENT'] . ua_seed . session_id());
} else {
	if ($_SESSION['user_agent']
			!== md5($_SERVER['HTTP_USER_AGENT'] . ua_seed . session_id())) {
		exit();
	}
}

//anti cc
//include(dirname(__FILE__) . '/anti_cc.php');