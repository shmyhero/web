<?php
// ----- HTTP 请求方法 ---------------------------------------------- //

/**
* 判断URL请求参数中是否包含非法字符
*
* @参数		string	字段名
* @返回		string
* 作者：Jovi Gu
* 日期：2008-7-21
*/
function steQForm($param)
{
	$arr_risk_char = array(";", "'", "&", "%20", "--", "==", "<", ">", "%", " ");

	for ($i=0; $i<count($arr_risk_char); $i++)
	{
		if (preg_match ("/".$arr_risk_char[$i]."/i", $_GET[$param])) 
		{
			throw new Exception("参数包含非法字符[ ".$arr_risk_char[$i]." ]!");
		}
	}

	return $_GET[$param];
}


function steForm($param, $method)
{
	global $config;
	$arr_risk_char = array(";", "'", "&", "%20", "--", "==", "<", ">", "%", " ");

	for ($i=0; $i<count($arr_risk_char); $i++)
	{
		eval('$tmp = $_'.$method.'['.$param.'];');
	
		if (preg_match ("/".$arr_risk_char[$i]."/i", $tmp)) 
		{
//			throw new Exception("参数包含非法字符[ ".$arr_risk_char[$i]." ]!");
			alerturl("参数包含非法字符[ ".$arr_risk_char[$i]." ]!", $_SERVER['REQUEST_URI']);
		}
	}

	return $tmp;
}
/**
* 判断URL请求参数是否整型
*
* @参数		string	字段名
* @返回		int
* 作者：Jovi Gu
* 日期：2008-7-21
*/
function steNForm($param)
{
	if (!is_numeric($_GET[$param]))
	{
		return 0;
//		throw new Exception("参数错误!");
	}
	return $_GET[$param];
}


// ----- 设置语言 ---------------------------------------------- //

/**
* 设置语言
*
* @参数		string	语言类型
* @参数		string	所处路径
* 作者：Jovi Gu
* 日期：2008-9-27
*/
function setLanguage($lang_type, $lang_path = 'language/') {
	if(file_exists($lang_path.'lang-'.$lang_type.'.php')) {
	  include($lang_path.'lang-'.$lang_type.'.php');
	} elseif (file_exists($lang_path.'lang-cn.php')) {
	  include($lang_path.'lang-cn.php');
	}
}


// ----- 数据采集 ---------------------------------------------- //

/**
* 取出自定义区域
*
* @参数		string	数据源
* @参数		string	开始字符串
* @参数		string	结束字符串
* @返回		string
* 作者：Jovi Gu
* 日期：2008-7-22
*/
function get_sub_content($str, $start, $end)
{
	if ( $start == '' || $end == '' )
	{
		   return;
	}
	$str = explode($start, $str);
	$str = explode($end, $str[1]);
	return $str[0]; 
}

/**
* 取出所有LINK数组
*
* @参数		string	数据源
* @返回		array	
* 作者：Jovi Gu
* 日期：2008-7-22
*/
function get_all_url($code)
{
	preg_match_all('/<a\s+href=["|\']?([^>"\' ]+)["|\']?\s*[^>]*>([^>]+)<\/a>/i',$code,$arr);
	return array('name'=>$arr[2],'url'=>$arr[1]); 
}


// ----- utf-8字符串处理 ---------------------------------------------- //

/**
* 计算UTF-8字符串长度
*
* @参数		string	数据源
* @返回		string
* 作者：Jovi Gu
* 日期：2008-7-22
*/
function strlen_utf8($str) {
	$i = 0;
	$count = 0;
	$len = strlen ($str);
	while ($i < $len)
	{
		$chr = ord ($str[$i]);
		$count++;
		$i++;
		if($i >= $len)
		break;
		if($chr & 0x80)
		{
			$chr <<= 1;
			while ($chr & 0x80)
			{
				$i++;
				$chr <<= 1;
			}
		}
	}
	return $count;
}

/**
* 截取utf8字符串
*
* @参数		string	数据源
* @参数		string	开始位置
* @参数		string	截取长度
* @返回		string
* 作者：Jovi Gu
* 日期：2008-7-22
*/
function utf8Substr($str, $from, $len)
{
    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
                       '$1',$str) . "...";
}
/**
* 返回执行结果
* @参数		$message	结果信息
* @参数		$url	跳转URL
* @返回		string
*/
function ExitMessage($message,$url='')
{
	echo '<p>'.$message.'<br>';
	if($url)
	{
		echo '<a href="'.$url.'">返回</a>';
	}else {
		echo '<a href="#" onClick="window.history.go(-1)">返回</a>';
	}
	echo '</p>';
	exit;
}
/**
* 获取新闻作者
* @参数		$selected_id	新闻种类ID
* @返回		string          新闻种类中文名称
*/
function OptionAuthors($selected_id=0)
{
	global $wpdb, $config;
	$sql = "SELECT * FROM ".$config['DBPrefix']."_admin ORDER BY ID";
	$results = $wpdb->get_results($sql);
	foreach($results as $result)
	{
		$ID			= $result->ID;
		$UserName	= $result->UserName;
		if($selected_id == $ID)
		{
			echo '<option value="'.$ID.'"selected>'.$UserName.'</option>';
		}else{
			echo '<option value="'.$ID.'">'.$UserName.'</option>';
		}
	}
}
/**
* 获取所有省份
* @参数		$selected_id	省份ID
* @返回		string          省份中文名称
*/
function OptionProvince($selected_id=0)
{
	$sql = "SELECT * FROM at_province ORDER BY ID desc";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result))
	{
		$province_id=$row["ID"];
		$CnName=$row["CnName"];
		if($selected_id ==$province_id)
		{
			echo '<option value="'.$province_id.'"selected>'.$CnName.'</option>';
		}else{
			echo '<option value="'.$province_id.'">'.$CnName.'</option>';
		}
	}
}


/**
* 获取模块模板
* @参数		string			模块名称
* @返回		string          省份中文名称
*/
function get_query_template($module, $section, $task) {
	$template = '';
	if ($task == '') $task = "list";
	if ($module != '') $module = $module . '/';
	if ($section != '') $section = $section . '/';
	if ( file_exists($module . $section . $task . '.php') )
		$template = $module . $section . $task . '.php';

	return $template;
}

function delhtml($document){   //清除HTML标签
	$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
				   '@<[\\/\\!]*?[^<>]*?>@si',            // Strip out HTML tags
				   '@[\t\n\r|&nbsp;]@si',            // Strip out \r\n\r &nbsp; tags
				   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
				   '@<![\\s\\S]*?--[ \\t\\n\\r]*>@'          // Strip multi-line comments including CDATA 
	);
	return preg_replace($search, '', $document);
}
function delhtmls($document){   //清除script标签
	$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
				   '@<[\\/\\!]*?[^<>]*?>@si',            // Strip out HTML tags
				   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
				   '@<![\\s\\S]*?--[ \\t\\n\\r]*>@'          // Strip multi-line comments including CDATA 
	);
	return preg_replace($search, '', $document);
}

/**
* 判断字符串末尾字符
*
* @参数		string	原字符串
* @参数		string	包含字符串
* @返回		bool
* 作者：Jovi Gu
* 日期：2008-10-27
*/
function endWith($instr, $sub_str)
{
	if(strstr($instr,$sub_str) != "" && strlen($sub_str) < strlen($instr)){
		return (substr($instr, -1, strlen($sub_str)) == $sub_str);
	}
   return false; 
}


/**
* 判断字符串开始字符
*
* @参数		string	原字符串
* @参数		string	包含字符串
* @返回		bool
* 作者：Jovi Gu
* 日期：2008-10-27
*/
function startWith($instr, $sub_str)
{
	if(strstr($instr,$sub_str) != "" && strlen($sub_str) < strlen($instr)){
		return (substr($instr, 0, strlen($sub_str)) == $sub_str);
	}
   return false; 
}

/**
* 去除文件扩展名
*
* @参数		string	文件名
* @返回		string	文件主名
* 作者：Jovi Gu
* 日期：2008-11-7
*/

function RemoveExtension( $fileName )
{
	return substr( $fileName, 0, strrpos( $fileName, '.' ) ) ;
}


/**
* 获取物理根目录
*
* @参数		
* @返回		string	物理根目录
* 作者：Jovi Gu
* 日期：2008-11-7
*/
function GetRootPath()
{
	$sRealPath = realpath( './' ) ;

	$sSelfPath = $_SERVER['PHP_SELF'] ;
	$sSelfPath = substr( $sSelfPath, 0, strrpos( $sSelfPath, '/' ) ) ;

	return substr( $sRealPath, 0, strlen( $sRealPath ) - strlen( $sSelfPath ) ) ;
}

/* 
* @todo 中文截取，支持gb2312,gbk,utf-8,big5 
* 
* @param string $str 要截取的字串 
* @param int $start 截取起始位置 
* @param int $length 截取长度 
* @param string $charset utf-8|gb2312|gbk|big5 编码 
* @param $suffix 是否加尾缀 
*/ 
function csubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) 
{ 
	if(function_exists("mb_substr")) 
	return mb_substr($str, $start, $length, $charset); 
	$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/"; 
	$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/"; 
	$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/"; 
	$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/"; 
	preg_match_all($re[$charset], $str, $match); 
	$slice = join("",array_slice($match[0], $start, $length)); 
	if($suffix) return $slice; 
	return $slice; 
} 

function replace_txt($str) 
{ 
	$str = str_replace("-", "0", $str);
	$str = str_replace("$", "", $str);
	return $str;
} 

function alertmessage($msg)
{
	echo "<script language='javascript'>";
	echo "alert('$msg');";
	echo " history.go(-1);";
	echo "</script>";
}

function alertcurrmsg($msg)
{
	echo "<script language='javascript'>";
	echo "alert('$msg');";
	echo "</script>";
}

function alerturl($msg, $backurl='')
{
	echo "<script language='javascript'>";
	echo "alert('$msg');";
	if (!empty($backurl))
	echo "location.href='$backurl';";
	echo "</script>";
}
/**
* 计算二个日期之间的月的跨度数（经历的月数）的函数 
*
* @参数		$d1,$d2
* @返回		string	数量
* 作者：Jesson Wu
* 日期：2011-08-16
*/
function dateMonthDiff($d1,$d2)
{
     $m1 = date("n",strtotime($d1));
     $m2 = date("n",strtotime($d2));

     $y1 = date("Y",strtotime($d1));
     $y2 = date("Y",strtotime($d2));

     $a = ($y2-$y1)*12+($m2-$m1)+1;
      return $a;
}

/**
* URL编码转换
*
* @返回		string	数量
* 作者：Jesson Wu
* 日期：2011-09-28
*/
function decode_unicode_url($str)
{
  $res = '';

  $i = 0;
  $max = strlen($str) - 6;
  while ($i <= $max)
  {
    $character = $str[$i];
    if ($character == '%' && $str[$i + 1] == 'u')
    {
      $value = hexdec(substr($str, $i + 2, 4));
      $i += 6;

      if ($value < 0x0080) // 1 byte: 0xxxxxxx
        $character = chr($value);
      else if ($value < 0x0800) // 2 bytes: 110xxxxx 10xxxxxx
        $character =
            chr((($value & 0x07c0) >> 6) | 0xc0)
          . chr(($value & 0x3f) | 0x80);
      else // 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx
        $character =
            chr((($value & 0xf000) >> 12) | 0xe0)
          . chr((($value & 0x0fc0) >> 6) | 0x80)
          . chr(($value & 0x3f) | 0x80);
    }
    else
      $i++;

    $res.= $character;
  }

  return $res.substr($str, $i);
}
//IP替换方法
function replace_ip($str)
{
	$reg = '/((?:\d+\.){3})\d+/';
	$str = preg_replace($reg, "\\1*", $str);
	return $str;
}
//用户发布的html,过滤危险代码
function replace_html($str)
{
    $farr = array(
        "/\s+/",                                                                                            //过滤多余的空白
        "/<(\/?)(scrīpt|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",  //过滤 <scrīpt 等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object的过滤
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",                                      //过滤javascrīpt的on事件
     
   );
   $tarr = array(
        " ",
        "＜\\1\\2\\3＞",           //如果要直接清除不安全的标签，这里可以留空
        "\\1\\2",
   );

  $str = preg_replace( $farr,$tarr,$str);
   return $str;
} 

function replace_date($str)
{
	list($year, $month, $day) = split ('[-.-]', $str);
	$str_date = intval($month)."月".intval($day)."日";
	return $str_date;
}

function tel($string){
	$tel_sum = strlen($string);
	$arr1 = str_split($string);
	if($tel_sum==11){
		for($i=0;$i<=$tel_sum;$i++){
			if($i==3||$i==4||$i==5||$i==6){
				$ddd = "*";
			}else{
				$ddd = $arr1[$i];
			}
			echo $ddd;
		}
	}elseif($tel_sum>11){
		for($i=0;$i<=$tel_sum;$i++){
			if($i==6||$i==7||$i==8){
				$ddd = "*";
			}else{
				$ddd = $arr1[$i];
			}
			echo $ddd;
		}
	}elseif($tel_sum<11){
		for($i=0;$i<=$tel_sum;$i++){
			if($i==6||$i==7||$i==8){
				$ddd = "*";
			}else{
				$ddd = $arr1[$i];
			}
			echo $ddd;
		}
	}
	return $ddd;
}
// 截取文字段落(超出长度用后缀表示)
// 设计思路按照排除法,排除字符段落中的英文字符
// 再按照英文字符为1个占位符,中文为2个占位符(UTF-8的中文是3个占位符)
// 计算出截取文字个数的占位符长度进行截取
function cut_str($msg,$cut_size,$charset="UTF-8",$suffix=".."){
        //验证截取个数,如果是0将不截取
        if($cut_size<=0) return $msg;
        $i=1;
        $han=0;
        $eng=0;
        while ($i <= strlen($msg)) {
                //判断是否是ASCII扩展字符
                if(ord($msg[($i-1)])>127){
                        $han++;
                        if($charset=="UTF-8"){
                                $str .=$msg[($i-1)].$msg[($i)].$msg[($i+1)];
                                //如果是UTF-8跳过3个ASCII
                                $i=$i+3;
                        }else{
                                $str .=$msg[($i-1)].$msg[($i)];
                                $i=$i+2;
                        }
                }else{
                        $eng++;
                        $str .=$msg[($i-1)];
                        $i++;
                }
                //如果汉字和英文总和等于要截取的字符个数那么跳出循环
                if(($han+$eng)==$cut_size){break;}
        }
        //如果汉字和英文总和等于要截取的字符个数那么不显示后缀
        $suffix = ($han+$eng)<$cut_size?"":$suffix;
        return $str.$suffix;
}

//提取URL的域名
function breakurl($url)
{
	if($url<>"-"){
		$urlarrary=explode("/",$url);
		$breakurl=$urlarrary[2];
	}else{
		$breakurl=$url;
	}
	return $breakurl;
}
/*---------------------- 
过滤HTML代码的函数 
-----------------------*/ 
function htmlEncode($string){ 
	$string=trim($string);
	$string=str_replace("&","&",$string);
	$string=str_replace("'","'",$string); 
	$string=str_replace("&amp;","&",$string);
	$string=str_replace("&quot;","",$string); 
	$string=str_replace("\"","",$string); 
	$string=str_replace("&lt;","<",$string); 
	$string=str_replace("<","<",$string); 
	$string=str_replace("&gt;",">",$string); 
	$string=str_replace(">",">",$string); 
	$string=str_replace("&nbsp;"," ",$string);
	$string=nl2br($string); 
	return $string; 
} 

/*---------------------- 
// 
// Function: 获取远程图片并把它保存到本地
// 
//  确定您有把文件写入本地服务器的权限 
// 
// 变量说明: 
// $url 是远程图片的完整URL地址，不能为空。
// $filename 是可选变量: 如果为空，本地文件名将基于时间和日期 
// 自动生成. 
-----------------------*/ 
function GrabImage($url,$filename="") { 
	if($url==""):return false;endif; 
	
	if($filename=="") { 
		$ext=strrchr($url,"."); 
	if($ext!=".gif" && $ext!=".jpg"):return false;endif; 
		$filename=date("dMYHis").$ext; 
	} 
	
	ob_start(); 
	readfile($url); 
	$img = ob_get_contents(); 
	ob_end_clean(); 
	$size = strlen($img); 
	
	$fp2=@fopen($filename, "a"); 
	fwrite($fp2,$img); 
	fclose($fp2); 
	
	return $filename; 
} 
/**
* 随机字符串
*
* @返回 string	数量
* 作者：Jesson Wu
* 日期：2013-03-16
*/
function randomkeys($length)
{
    $pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $key  = $pattern{rand(0,62)};
    for($i=1;$i<$length;$i++)
    {
        $key .= $pattern{rand(0,62)};
    }
    return $key;
}
/**
* Turns two or more consecutive newlines (separated by possible white space) into a <p>...</p>.
* Pass result to regular nl2br() to add <br/> to remaining nl's, eg,
* 内容用<p>...</p>包围
*
* @返回 string	数量
* 作者：Jesson Wu
* 日期：2013-03-16
*/
function nls2p($str)
{
	return str_replace('<p></p>', '', '<p>'.preg_replace('#([\r\n]\s*?[\r\n]){2,}#', '</p> <p>', $str).'</p>');
}
function nl2p($text){
  return "<p>" . str_replace("\n", "</p><p>", $text) . "</p>";
}

/**
* 去除字符串空格
*
* @返回 string	数量
* 作者：Jesson Wu
* 日期：2013-04-18
*/
function nls2nbsp($string)
{
	$pat[0] = "/^\s+/";
	$pat[1] = "/\s{2,}/";
	$pat[2] = "/\s+$/";
	$rep[0] = "";
	$rep[1] = " ";
	$rep[2] = "";
	$string = preg_replace($pat,$rep,$string);
	$string = preg_replace("/s+([rn$])/", "\1", $string);
	$string = str_replace(" ","",$string);
    return $string;
}
/**
* 判断是否移动设备访问
*
* @返回 string
* 作者：Jesson Wu
* 日期：2013-12-24

if( isMobile() ){
	echo "Y";
}else{
	echo "N";	
}

*/

function isMobile()
{ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
} 


/**
 * 校验日期格式是否正确
 * 
 * @param string $date 日期
 * @param string $formats 需要检验的格式数组
 * @return boolean
 */
function checkDateIsValid($date, $formats = array("Y-m-d", "Y/m/d")) {
    $unixTime = strtotime($date);
    if (!$unixTime) { //strtotime转换不对，日期格式显然不对。
        return false;
    }
    //校验日期的有效性，只要满足其中一个格式就OK
    foreach ($formats as $format) {
        if (date($format, $unixTime) == $date) {
            return true;
        }
    }
    return false;
}

//测试是不是时间
function testdate($date){
	$date = explode('-',$date);
	if(checkdate($date[1],$date[2],$date[0])&&count($date)===3){
		$date=implode('-',$date);
		return  $date;
	}else{
		return false;
	}
}
//对通过post方式传递的数据进行过滤
function my_post($name,$state=false) {
	$value = '';
	eval ( '$value = @$_POST["' . $name . '"];' );
	$value =  clean_up_input ( $value,$state);
	return $value;
}
//对通过get方式传递的数据进行过滤
function my_get($name,$state=false) {
	$value = '';
	eval ( '$value = @$_GET["' . $name . '"];' );
	$value =  clean_up_input ( $value ,$state);
	return $value;
}
function clean_up_input($input,$state) {
	if (! is_null ( $input )) {
		$input = trim ( $input );
		$input = strip_tags ( $input ,$state ? "<img><p> <strong> <span> <sem> <ol> <li> <div>> <u>":"");
		$input = htmlspecialchars ( $input );
		if (! get_magic_quotes_gpc ())
		$input = addslashes ( $input );
	}
	return $input;
}
//对输入进行五次加密
function my_md5($source, $md5_times = 5) {
	if (! is_int ( $md5_times ) || $md5_times < 0 || ! is_string ( $source ))
	return FALSE;
	if ($md5_times > 0) {
		$source = md5 ( $source );
		$md5_times --;
		return my_md5 ( $source, $md5_times );
	}
	return $source;
}
//测试是否为空，为空返回false,不为空返回true
function testkong($a){
	if($a===''||$a===null||$a===""){
		return false;
	}else{
		return true;
	}
}
//测试是不是整型
function my_is_int($int) {
	if (FALSE === filter_var ( $int, FILTER_VALIDATE_INT ))
	return FALSE;
	else
	return TRUE;
}
function comom_faile(){
	echo '<script>';
	echo "alert(\"该操作非法，请从新登录\");";
	echo '</script>';
	session_destroy();
	echo '<a href="admin_login.php">登录</a>';
	exit;
}

/**
 * 对上传的图片进行校验
 * @param unknown_type $file 表示上传的文件
 * @param unknown_type $size 表示上传文件的最大值
 * @param unknown_type $array 表示上传文件的格式要求
 * @param unknown_type save_path表示上传的本地目录
 */
function check_images($file,$size,$array,$save_path){
	$error='';
	if($file['error']>0){
		switch($file['error']){
			case '1':
			$error = '超过php.ini允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = '上传文件被扩展阻止';
			break;
		case '999':
		default:
			$error = '未知错误。';
		}
	}else{
		if(testkong($file)){
			$type_array=explode('.',$file['name']);
			$type=strtolower(end($type_array));
			if(!in_array($type,$array,true)){
				$error='上传图片的扩展名是不允许的扩展名';
			}			
			else if(!@is_uploaded_file($file['tmp_name'])){
				$error='上传失败';
			}else if($file['size']>$size){
				$error='上传的图片超过限制，只允许：'.implode($array).'格式图片';
			}else if(!getimagesize($file['tmp_name'])){
				$error='上传的不是图片';
			}else{
				$w=getimagesize($file['tmp_name']);
			    $width=$w[0];
			    if(!file_exists($save_path)){
			    	mkdir($save_path);
			    }
			    $newfilename=date("YmdHis") . '_' . rand(10000, 99999) . '.'.$type;
			    $uploadfile=$save_path.$newfilename;
			    if(!move_uploaded_file($file['tmp_name'],$uploadfile)){
			    	$error='上传文件失败';
			    }
			}
			
		}else{
			$error='上传的图片为空';
		}
	}
	return array('state'=>$error==='' ?'success':'error','message'=>$error===''? $uploadfile:$error,'width'=>$error===''? $width:'');
}
?>