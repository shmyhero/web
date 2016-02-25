<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

$url='';
$object=TRUE;
$participant = Session_Util::my_session_get('participant');
if ($participant !== NULL) {
	$again=Security_Util::my_get('again');

	$jssdk = new JSSDK(appid, secret);
	$signPackage = $jssdk->GetSignPackage();
	
	$participant = json_decode($participant);
	$openid=$participant->openid;
	$nickname=$participant->nickname;
	
	$participant = new Participant();
	$day= $participant->get_current_day();
	if(time() > strtotime($day.' 13:00:00'))
	{
		//11点后 预测下个交易日
		$day=$participant->get_next_day();
	}
	//更新我的预测
	$participant->Gethb_recordByK();
	
	//我的
	$result=$participant->get_F_Points($day);
	
	//我的猜中次数
	if($participant->get_FWC_tis())
	{
	$myresult=$participant->get_MyPoints();
	$cz=intval($myresult['cz']);
	$cc=intval($myresult['cc']);
	$lxcz=intval($myresult['lxcz']);
	if($lxcz>0){
		$participant->UP_ShareNum();
	}
	
	}else {
		$lxcz=6;
	}
	
	//当前全部
	$resultWC=$participant->get_FWC_Points($day);
	
	if($result['status'] === 'error')
		{
			$url = BASE_URL.'follow.php';
			header("Location:".$url);
			exit();
		}
		else {
			$ZNum=intval($resultWC['ZNum']);
		    $DNum=intval($resultWC['DNum']);
			$allnum=$ZNum+$DNum;
		}
}
else {
	$url = BASE_URL.'fn_system.php';
	header("Location:".$url);
	exit();
}

function testkong($a){
	if($a===''||$a===null||$a===""){
		return false;
	}else{
		return true;
	}
}

function TO_date($strALL)
{
	list($year,$month,$day) = split ('[-.-]', $strALL);  
			//输出为另一种时间格式  
	echo intval($month)."月".intval($day)."日";; 
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
 <meta name="viewport" content="width=720,user-scalable=no">
<meta name="msapplication-tap-highlight" content="no" />
<meta name="format-detection" content="telephone=no" />
<meta name="keywords" content="全民股神" />
<meta name="description" content="全民股神" />
<title>全民股神</title>
<link href="css/boilerplate.css" rel="stylesheet" type="text/css">
<link href="css/mobile.css" rel="stylesheet" type="text/css">
<script src="js/jquery.min.js"></script>
<script src="localytics.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
 <!-- <script src="js/highstock.js"></script> -->
<script src="http://cdn.hcharts.cn/highstock/highstock.js"></script>

<script src="js/chartExt.js"></script>
<script type="text/javascript">

var openid ='<?php echo $openid;?>';
var nickname ='<?php echo $nickname;?>';
var ismy =true ;
var appId=     '<?php echo $signPackage["appId"]; ?>';
var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
var signature= '<?php echo $signPackage["signature"]; ?>';
var ISBASE=<?php echo  ISBASE ;?> ;
var day = '<?php echo  $day ;?>' ;
var kcs=<?php echo $lxcz; ?>;

$(document).ready(function(){

	_czc.push(['_trackEvent', 'index.php', '访问主页', 'btn','1','0']);
	ll('index',function(){});
	Chart();
	var czz=true;
	var cdd=true;
	
	switch (kcs) {
	case 0:
		$(".alert-content").html("昨天大盘跟你想的不一样哦");
		$(".action-ok").html("求大神帮忙猜");
		$(".modal").removeClass("hide");
		break;
	case 1:
		$(".alert-content").html("您昨天猜对了");
		$(".action-ok").html("炫耀");
		$(".modal").removeClass("hide");
		break;
	case 2:
		$(".alert-content").html("连续两次猜中 这不是巧合");
		$(".action-ok").html("炫耀");
		$(".modal").removeClass("hide");
		break;
	case 3:
		$(".alert-content").html("三天都中 你就是传说中的股神吗？");
		$(".action-ok").html("炫耀");
		$(".modal").removeClass("hide");
		break;
	case 4:
		$(".alert-content").html("四天都中 你就是传说中的股神吗？");
		$(".action-ok").html("炫耀");
		$(".modal").removeClass("hide");
		break;
	case 5:
		$(".alert-content").html("预言帝诞生！你群里的人知道吗？");
		$(".action-ok").html("炫耀");
		$(".modal").removeClass("hide");
		break;
	}
	
		
		
	
	var n = {"TH-Api-Key": "TradeheroTempKey01","TH-Language-Code": "zh-CN","Authorization":"TH-WeChatU otwHxjmPO8e-6eUbblUTyx-Tpkxw"};
	function Chart(){

		$.ajax({url: "https://cn1.api.tradehero.mobi/api/cn/v2/quotes/SHA/1A0001/detail",async:false,headers:n, success: function(d) {
			 $("#last").html(d.last.toFixed(2)); 
			 var zf= (d.last - d.prec ) / d.prec *100  ;
			 $("#zf").html(zf.toFixed(2)+"%"); 
			}
		}); 
	    
	$.ajax({url: "https://cn1.api.tradehero.mobi/api/cn/v2/quotes/SHA/1A0001/klines/day",async:false,headers:n, success: function(y) {

   	 $.each(y, function(key, value){
   		    var temp = value.time.split("T");
         	var starttime = temp[0]+" "+temp[1];
         	starttime = starttime.replace(new RegExp("-","gm"),"/");
         	value.time = (new Date(starttime)).getTime(); 
	      })
	new KChart('container',y.reverse());
      }});
    
	};

	$(".btnindex").click(function(){
		Chart();
	});

	$(".action-ok").click(function(){
		$(".modal").addClass("hide");
		$(".pop").show();
	});
	
	
	$(".pop").click(function(){
		$(".pop").hide();
	});

	$(".btnkz").click(function(){
		if(czz)
		{
		_czc.push(['_trackEvent', 'index.php', '猜涨', 'btn','1','0']);
		
		czz=false;
		$.ajax({
			url : 'action.php', 
			type : 'post',
			//async : false,
			data : {
				action : 'CZD',czdtype : '0',day : day
			},
			cache : false,
			success : function(obj) {
				console.log(obj);
				var data = eval('(' + obj+ ')');
				
				if(data.status=="1")
		 		{
				 window.location.href="follow.php"
				}
			},
			error : function(
					XMLHttpRequest,
					textStatus, errorThrown) {
			}
		});
		}
	});

	$(".btnkd").click(function(){
		if(cdd)
		{
		cdd=false;
		_czc.push(['_trackEvent', 'index.php', '猜跌', 'btn','1','0']);
		$.ajax({
			url : 'action.php', 
			type : 'post',
			//async : false,
			data : {
				action : 'CZD',czdtype: '1',day : day
			},
			cache : false,
			success : function(obj) {
				console.log(obj);
				var data = eval('(' + obj+ ')');
				if(data.status=="1")
				{
				 window.location.href="follow.php"
				}

			},
			error : function(
					XMLHttpRequest,
					textStatus, errorThrown) {
			}
		});
		}
	});
});
</script>
</head>
<body>


<div class="gridContainer clearfix">

<div class="box">
		<p>已有<b> <?php echo $allnum; ?> </b>名 <br>
		股神预测 <?php TO_date($day) ; ?> 大盘涨跌，你怎么看？</p>
		<p><a  class="btnkz"> &nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="btnkd">&nbsp;</a> </p>
		<p> 目前上证指数 <span id="last" >3794.11</span>,涨幅 <span id="zf" >3.89%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a  class="btnindex"></a></p> 
		<div id="container"  style="height: 300px; min-width: 700px" ></div>  
		<div class="f"><a href="http://mp.weixin.qq.com/s?__biz=MjM5NTcxMDE1MA==&mid=202581011&idx=1&sn=cfbe90ec6d5b5bb91214c0e849da26ae#rd">活动咨询 奖品领取请关注“全民股神”</a></div>
		
</div>

<div id="modal" class="modal action hide">
<div class="overlay"></div>
<div class="alert">
<div class="alert-content"></div>
<div class="alert-btns"><a class="action-ok">确定</a> 
	</div>
</div>
</div>
</div>
<div class="pop"><img src="images/share.png" alt="分享"></div>

 <script src="js/util.js"></script>

<div style="display: none"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256280463'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1256280463' type='text/javascript'%3E%3C/script%3E"));</script></div>
</body>
</html>
