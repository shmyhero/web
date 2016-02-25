<?php
///**
// * 0  服务器myherochina.com
// * 1  服务器godstock.com
// * 2  服务器fajiangpin.com
// */
define('ISBASE', 0);

//网站base url
switch (ISBASE) {
	case 0:
		define('BASE_URL',  'http://myherochina.com/backstagemian/');
		define('appid', 'wxf12393f33e05b9a3');
		define('secret', '0072c4a9765506236168e330a20207c9');
	case 1:
		define('BASE_URL',  'http://amazingsh.com/backstagemian/');
		define('appid', 'wx5ab9ebf8fa013fa7');
		define('secret', 'a10d9b29cd1651ac272ff8652d9701fc');
		break;
	case 2:
		define('BASE_URL',  'http://fajiangpin.com/backstagemian/');
		define('appid', 'wx6e976ef797645ec6');
		define('secret', '01d710c6d5c737bdc09e7d2594e3fbfa');
		break;
	case 3:
		define('BASE_URL',  'http://myherosh.com/backstagemian/');
		define('appid', 'wx0de638cecd3d1af0');
		define('secret', 'e08d24b42f6295b0b82a2e5f38d1b9ad');
		break;
	case 4:
		define('BASE_URL',  'http://tradingsh.com/backstagemian/');
		define('appid', 'wxb9271ad84fa589ca');
		define('secret', '11b4c4e809f7cb2c51142e0afa2d49d5');
		break;
	case 5:
		define('BASE_URL',  'http://buyingspan.com/backstagemian/');
		define('appid', 'wx74f2832d5a074a82');
		define('secret', '1987deee7b4c5dc68270d61d23c4b3f5');
		break;
};

define ( 'HTTP_HOST', 'myherochina.com');
define ( 'PORT', 80);


//数据库
/**
 * 本机测试
 */
//define('DB_USER', 'root');
//define('DB_PASSWORD', 'gGZkSbEs');
//define('DB_NAME', 'backstagemian');
//define('DB_HOST', '121.42.49.77');

/**
 *正式服务器
 */
define ( 'DB_USER', 'root');
define ( 'DB_PASSWORD', 'root');
define ( 'DB_NAME', 'hongbaotest');
define ( 'DB_HOST', 'localhost');

//表名前缀
define('DB_TABLE_PREFIX', 'qia_');

//缓存文件夹
define('CACHE_FOLDER', 'cache/');

//缓存目录
define('CACHE_PATH', dirname(dirname(dirname(__FILE__))) . '/' . CACHE_FOLDER);

//cache时间
define('CACHE_TIME', 3600);

//上传文件文件夹
define('UPLOAD_FILE_FOLDER', 'upfolder/');

//上传文件目录
define('UPLOAD_FILE_PATH',
		dirname(dirname(dirname(__FILE__))) . '/' . UPLOAD_FILE_FOLDER);


//错误信息
define('NO_RIGHT_TO_DO_THIS', '你没有权限操作该项目');

define('INVALIDATION_VISIT', '非正常访问');

define('DOUBLE_POST_ALERT', '请不要重复提交数据');

//时区
if (date_default_timezone_get() !== 'PRC') {
	date_default_timezone_set('PRC');
}
define('hongbao', 5);

//第一阶段 0-1/3	20%	80%
define('D1JD_amount', 500);

define('D2JD_amount', 1000);

define('D3JD_amount',  1500);

define('D4JD_amount', 2000);

define('D5JD_amount', 2500);

define('D6JD_amount',  3000);

define('D7JD_amount',  3500);

define('GJ_amount', 4000);

define('DJ_amount', 10000);

define('LAUNCH_START',time() >= strtotime('2015-04-01 00:00:00'));

define('paomadeng', '4月14日三甲：@edithcat @不亦乐乎 @蛋蛋de忧桑 ，每人100元奖金');

