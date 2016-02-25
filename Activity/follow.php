<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$url='';
$object=TRUE;
$participant = Session_Util::my_session_get('participant');
if ($participant !== NULL) {
			$jssdk = new JSSDK(appid, secret);
			$signPackage = $jssdk->GetSignPackage();
		$participant = json_decode($participant);
		$openid=$participant->openid;
		$nickname=$participant->nickname;
	
	$participant = new Participant();	
	$day= $participant->get_current_day();
	$current_day=$day;
	if(time() > strtotime($day.' 13:00:00'))
	{
		//11点后 预测下个交易日
		$day=$participant->get_next_day();
		$currentresult=$participant->get_FWC_Points($current_day);
		$CZNum=intval($currentresult['ZNum']);
		$CDNum=intval($currentresult['DNum']);
	}else {
		$currentresult=$participant->get_FWC_Points($day);
		$CZNum=intval($currentresult['ZNum']);
		$CDNum=intval($currentresult['DNum']);
	}
	$info= TO_date($day);
	$result=$participant->get_FWC_Points($day);

	if($result['status'] === 'error')
	{
		$url = BASE_URL.'fn_system.php';
		header("Location:".$url);
		exit();
	}
	else {
		//print_r($result);
		$ZNum=intval($result['ZNum']);
		$DNum=intval($result['DNum']);
		$allnum=$ZNum+$DNum;
		if($ZNum + $DNum >0)
		{
		
		$percent =intval( $DNum / ( $ZNum + $DNum ) * 100) ;
		}
		else{
			$percent=0;
		}
		//$participant->Gethb_recordByK();
		//echo $percent;
	}
}
else {
		$url = BASE_URL.'fn_system.php';
		header("Location:".$url);
		exit();
}

function TO_date($strALL)
{
	list($year,$month,$day) = split ('[-.-]', $strALL);  
			//输出为另一种时间格式  
	return  intval($month)."月".intval($day)."日";; 
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
 <meta name="viewport" content="width=720,user-scalable=no">
<meta name="msapplication-tap-highlight" content="no"/>
<meta name="format-detection" content="telephone=no" />
<meta name="keywords" content="全民股神"/>
<meta name="description" content="全民股神" />
<title>全民股神</title>
<link href="css/boilerplate.css" rel="stylesheet" type="text/css">
<link href="css/mobile.css" rel="stylesheet" type="text/css">
<script src="js/jquery.min.js"></script>
<script src="localytics.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="js/jquery.circliful.min.js"></script>
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
    var ISBASE=<?php echo  ISBASE ;?>;
    var percent=<?php echo  $percent ;?>;
    $(document).ready(function(){
  	   _czc.push(['_trackEvent', 'follow.php', '查看结果', 'btn','1','0']);
       ll('game',function(){});
        
    	$(".btn").click(function(){
    		 window.location.href="game.php"
    	});

    	$(".btngame").click(function(){
   		 window.location.href="game.php"
   		});
    	
    	Chart();
    	
    	var n = {"TH-Api-Key": "TradeheroTempKey01","TH-Language-Code": "zh-CN","Authorization":"TH-WeChatU otwHxjmPO8e-6eUbblUTyx-Tpkxw"};
    	function Chart(){
    		console.log('Chart');
    		$.ajax({url: "https://cn1.api.tradehero.mobi/api/cn/v2/quotes/SHA/1A0001/detail",async:false,headers:n, success: function(d) {
    			 $("#last").html(d.last.toFixed(2)); 
    			 var zf= (d.last - d.prec ) / d.prec *100;
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
    	
    	$('#myStat').circliful();
    	
    	$(".pop").click(function(){
    		$(".pop").hide();
    	});

    	$("#pop").click(function(){
    		_czc.push(['_trackEvent', 'follow.php', '分享我的预测', 'btn','1','0']);
    		//$(".page4div #page4btn").removeClass('hide');
    		$(".pop").show();
    	});

    	$(".btnindex").click(function(){
        	
    		Chart();
    	});
    	

});
       
    
    </script>
    </head>
   <body>


<div class="gridContainer1 clearfix">
	
<div class="box1">
         <div class="ckzj"><a class="btn"  >战绩！抽奖！</a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
         <p><?php echo $info; ?>共<b> <?php echo $allnum; ?> </b>名股神预测 <br>
        <?php if($ZNum<$DNum)
         {?>
      		吓死宝宝了，大家都要跑了呢！</p>
         <?php }else{ ?>
		大家都看好呢，大盘必涨呀！</p>
		<?php }?>
		<hr width="90%"  style=" text-align: center;  " >
		<div class="demo" >
		<div class="divz">
		<p class="p1">涨↑&nbsp;&nbsp;<?php echo $CZNum; ?> </p>
		<p class="p2" style="color: #ffdb00"> <?php echo 100-$percent; ?>% </p>
		 </div>
		 <!-- <div id="myStat" data-dimension="250" data-text="VS"  data-info="8月30日" data-width="15" data-fontsize="15" data-percent="35" data-fgcolor="#1dc8a0" data-bgcolor="#ffdb00" data-fill="#eee"></div> -->
		<div class="divt" id="myStat" data-dimension="300" data-text="VS"  data-info="<?php echo $info; ?>" data-width="15" data-fontsize="35" data-percent="<?php echo $percent; ?>" data-fgcolor="#1dc8a0" data-bgcolor="#ffdb00" ></div>	
		<div class="divd">
		<p class="p1">跌↓&nbsp;&nbsp;<?php echo $CDNum; ?> </p>
		<p class="p2" style="color: #1dc8a0"> <?php echo $percent; ?>% </p>
		  </div>
		</div>
		<hr width="90%"  style=" text-align: center;   " >
		<p><span><?php echo TO_date($current_day); ?></span> 猜涨<span><?php echo $CZNum; ?>人</span> 猜跌<span><?php echo $CDNum; ?>人</span> </p> 
		<p> <a class="btns" id="pop">告诉炒股的小伙伴</a></p> 
		<p> <a class="btns btngame">猜中的来抽奖</a></p> 
		<p>  目前上证指数 <span id="last">3794.11</span>,涨幅 <span id="zf">3.89%</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a  class="btnindex"></a></p> 
		<div id="container"  style="height: 300px; min-width: 700px" ></div>  
</div>
</div>
<div class="pop"><img src="images/share.png" alt="分享"></div>
 <script src="js/util.js"></script>
<div style="display: none"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256280463'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1256280463' type='text/javascript'%3E%3C/script%3E"));</script></div>
</body>
</html>