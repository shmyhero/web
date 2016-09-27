<?php
define('ISBASE', 9);
//网站base url
switch (ISBASE) {
	case 0:
		//上海迈和
		define('BASE_URL',  'http://myherochina.com/TH_CFD_WEB/');
		define('appid', 'wxf12393f33e05b9a3');
		define('secret', '0072c4a9765506236168e330a20207c9');
	case 1:
		//迈和信息科技 //被封域名
		define('BASE_URL',  'http://amazingsh.com/TH_CFD_WEB/');
		define('appid', 'wx5ab9ebf8fa013fa7');
		define('secret', 'a10d9b29cd1651ac272ff8652d9701fc');
		break;
	case 2:
		//上海迈和信息科技有限公司
		define('BASE_URL',  'http://fajiangpin.com/TH_CFD_WEB/');
		define('appid', 'wx6e976ef797645ec6');
		define('secret', '01d710c6d5c737bdc09e7d2594e3fbfa');
		break;
	case 3:
		//迈和信息
		define('BASE_URL',  'http://myherosh.com/TH_CFD_WEB/');
		define('appid', 'wx0de638cecd3d1af0');
		define('secret', 'e08d24b42f6295b0b82a2e5f38d1b9ad');
		break;
	case 4:
		//迈和科技 404
		define('BASE_URL',  'http://tradingsh.com/TH_CFD_WEB/');
		define('appid', 'wxb9271ad84fa589ca');
		define('secret', '11b4c4e809f7cb2c51142e0afa2d49d5');
		break;
	case 5:
		//模拟炒股
		define('BASE_URL',  'http://buyingspan.com/TH_CFD_WEB/');
		define('appid', 'wx74f2832d5a074a82');
		define('secret', '198481a9623696423327d5f1cc31b531');
		break;
	case 6:
		//全民股神的小伙伴
		define('BASE_URL',  'http://myheroweb.com/TH_CFD_WEB/');
		define('appid', 'wx7a5c26b43552c0f8');
		define('secret', 'e90914dfcb8886d8a047c193c94dfcce');
		break;
	case 7:
		//tradehero
		define('BASE_URL',  'http://cashkindom.com/TH_CFD_WEB/');
		define('appid', 'wx2abb9cdb99453eb6');
		define('secret', 'e3cb79d413edbded54470363c27c480e');
		break;
	case 8:
		//TradeHero
		define('BASE_URL',  'http://gateofmarket.com/TH_CFD_WEB/');
		define('appid', 'wx2e893e78830ceb6a');
		define('secret', 'e468854bf311d9a8a8b0f461872c9e91');
		break;
	case 9:
		//全民股神 大号
		define('BASE_URL',  'http://cn.tradehero.mobi/TH_CFD_WEB/');
		define('appid', 'wx992a0a8ce6ec3d2b');
		define('secret', 'c10b4b200d1f375ccb494339440332da');
		break;
};

define ('HTTP_HOST', 'myherochina.com');
define ('PORT', 80);


//数据库
/**
 * 本机测试
 */
define('DB_USER', 'root');
define('DB_PASSWORD', '9k2rfIg2');
define('DB_NAME', 'caizd');
define('DB_HOST', 'localhost');

/**
 *正式服务器
 */
// define ( 'DB_USER', 'root');
// define ( 'DB_PASSWORD', 'root');
// define ( 'DB_NAME', 'hb618');
// define ( 'DB_HOST', 'localhost');

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

define('LAUNCH_START',time() >= strtotime('2015-05-07 00:00:00'));

define('paomadeng', '4月14日三甲：@edithcat @不亦乐乎 @蛋蛋de忧桑 ，每人100元奖金');
