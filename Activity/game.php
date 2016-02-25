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
	$result=$participant->get_MyPoints();

	if($result['status'] === 'error')
	{
		$url = BASE_URL.'fn_system.php';
		header("Location:".$url);
		exit();
	}
	else {

		$uzfbcoed=$result['uzfbcoed'];
		$uzfbname=$result['uzfbname'];
		$uadd=$result['uadd'];
		
		$cz = intval($result['cz']);
		$jps = $cz > 5 ? 5 : $cz;
		
		$cc=intval($result['cc']);
		$joinNum=intval($result['joinNum']);
		$ClickNum=intval($result['ClickNum']);
		$kcs=$cz-$ClickNum;
		if($cz + $cc >0)
		{
		$percentboll=TRUE;
		$percent =intval( $cc / ( $cz + $cc ) * 100) ;
		}
		else{
			$percentboll=FALSE;
		}
		$lxcz=intval($result['lxcz']);
		
		$tags_result=$participant->GetTicketRecord_OpenidALL();
		$tags_resultcount=count($tags_result);
		
		$participant->Getssedetail();
	}
}
else {
		$url = BASE_URL.'fn_system.php';
		header("Location:".$url);
		exit();
}

//测试是否为空，为空返回false,不为空返回true
function testkong($a){
	if($a===''||$a===null||$a===""){
		return false;
	}else{
		return true;
	}
}

function TO_date($strALL)
{
	//$arr= explode('T',$strALL);
	$str=$strALL; //$arr[0];
	list($year, $month, $day) = split ('[-.-]', $str);
	$day=intval($day)<10 ? "0".intval($day): intval($day);
	$str_date = intval($month)."月". $day ."日";

	return $str_date;
}

function TO_jp($type,$iscz)
{
	
	if($type=="")
	{
		if($iscz==0)
		{
			return "未抽奖";	
		}else {
			return "没奖抽";
		}
	}
	else{
		switch ($type) {
		case 0:
			return "没抽中";
			break;
		case 1:
			return "彩票基金";
			break;
		case 2:
			return "模拟资金";
			break;
		case 3:
			return "笔记本子";
			break;
		case 4:
			return "100元";
			break;
		case 5:
			return "1000元";
			break;
		
		}
	}
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
<script src="js/jQueryRotate.2.2.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.circliful.min.js"></script>

<script type="text/javascript">
    var openid ='<?php echo $openid;?>';
    var nickname ='<?php echo $nickname;?>';
    var ismy =true ;
    var appId=     '<?php echo $signPackage["appId"]; ?>';
    var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
    var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
    var signature= '<?php echo $signPackage["signature"]; ?>';
    var ISBASE=<?php echo  ISBASE ;?>;
    var kcs='<?php echo $kcs; ?>';
    var lxcz='<?php echo $lxcz; ?>';
    $(document).ready(function(){
      
    	$(".btn").click(function(){
    		 _czc.push(['_trackEvent', 'game.php', '抽奖页面', 'btn','1','0']);
             ll('game',function(){});
    	});

    	$('#myStat').circliful();

    	
    	$(".btnsf").click(function(){
    		$(".pop").show();
    	});
    	
    	$(".pop").click(function(){
    		$(".pop").hide();
    	});

    	var timeOut = function(){  //超时函数
    		$("#lotteryBtn").rotate({
    			angle:0, 
    			duration: 10000, 
    			animateTo: 2160, //这里是设置请求超时后返回的角度，所以应该还是回到最原始的位置，2160是因为我要让它转6圈，就是360*6得来的
    			callback:function(){
    				alert('网络超时')
    			}
    		}); 
    	}; 
    	var rotateFunc = function(awards,angle,text){  //awards:奖项，angle:奖项对应的角度
    		$('#lotteryBtn').stopRotate();
    		$("#lotteryBtn").rotate({
    			angle:0, 
    			duration: 5000, 
    			animateTo: angle+1440, //angle是图片上各奖项对应的角度，1440是我要让指针旋转4圈。所以最后的结束的角度就是这样子^^
    			callback:function(){
    				alert(text)
    			}
    		}); 
    	};
    	
    	$("#lotteryBtn").rotate({ 
    	   bind: 
    		 { 
    			click: function(){
    		        
    		        if(kcs>0)
    		        {
    		        	kcs=kcs-1;
    		        	$.ajax({
    		    			url : 'action.php', 
    		    			type : 'post',
    		    			//async : false,
    		    			data : {
    		    				action : 'CJ'
    		    			},
    		    			cache : false,
    		    			success : function(obj) {
    		    				_czc.push(['_trackEvent', 'game.php', '抽奖结果', 'btn','1','0']);
    		    				var data = eval('(' + obj + ')');
    		    				//console.log(obj);
    		    				//var data = eval('({"status":"success","amount":1,"AwardID":2, "openid":"703134261","message":"\u62bd\u5956\u5b8c\u6210"})');
    		    				//{status: "success", AwardID: "2", amount: 0, openid: "703134261", message: "抽奖完成"}
    		    				console.log(data);
    		    				if(data.status=="success")
    		    				{
        		    				var AwardID=data.AwardID;
        		    				var amount=data.amount;
									
    		    					switch (AwardID) {	
    		    							case 1:
    		    								switch (amount) {
    		    									case 0:
    		    										rotateFunc(0,48,'很遗憾，这次您未抽中奖');
    		    										break;
    		    									case 1:
    		    										rotateFunc(1,132,'恭喜您抽中彩票基金');
    		    										break;
    		    								}
    		    								break;
    		    							case 2:
    		    								switch (amount) {
	    		    								case 0:
	    		    									rotateFunc(0,48,'很遗憾，这次您未抽中奖');
	    		    									break;
	    		    								case 1:
	    		    									rotateFunc(1,157,'恭喜您抽中彩票基金');
	    		    									break;
	    		    								case 2:
	    		    									rotateFunc(2,312,'恭喜您抽中模拟资金');
	    		    									break;
    		    								}
    		    								break;
    		    							case 3:
    		    								switch (amount) {
	    		    								case 0:
	    		    									rotateFunc(0,237,'很遗憾，这次您未抽中奖');
	    		    									break;
	    		    								case 1:
	    		    									rotateFunc(1,157,'恭喜您抽中彩票基金');
	    		    									break;
	    		    								case 2:
	    		    									rotateFunc(2,312,'恭喜您抽中模拟资金');
	    		    									break;
	    		    								case 3:
	    		    									rotateFunc(3,66,'恭喜您抽中本子');
	    		    									break;
	    		    								
    		    								}
    		    								break;
    		    							case 4:
    		    								switch (amount) {
	    		    								
	    		    								case 1:
	    		    									rotateFunc(1,157,'恭喜您抽中彩票基金');
	    		    									break;
	    		    								case 2:
	    		    									rotateFunc(2,312,'恭喜您抽中模拟资金');
	    		    									break;
	    		    								case 3:
	    		    									rotateFunc(3,66,'恭喜您抽中本子');
	    		    									break;
	    		    								case 4:
	    		    									rotateFunc(4,56,'恭喜您抽中100元');
	    		    									break;
    		    								}
    		    								break;
    		    							case 5:
    		    								switch (amount) {
	    		    								case 1:
	    		    									rotateFunc(1,107,'恭喜您抽中彩票基金');
	    		    									break;
	    		    								case 2:
	    		    									rotateFunc(2,342,'恭喜您抽中模拟资金');
	    		    									break;
	    		    								case 3:
	    		    									rotateFunc(3,186,'恭喜您抽中本子');
	    		    									break;
	    		    								case 4:
	    		    									rotateFunc(4,260,'恭喜您抽中100元');
	    		    									break;
	    		    								case 5:
	    		    									rotateFunc(5,55,'恭喜您抽中1000元');
	    		    									break;
	    		    									
	    		    								}
    		    								break;
    		    					}
    		    					$("#kcs").html(kcs); 
    		    					if(kcs==0){
    		    						 window.location.href = window.location.href;
    								     window.location.reload;
        		    					} 
    		    				}
    		    				else
    		    				{
    		    					alert(data.message);
        		    			}
    		    			},
    		    			error : function(
    		    					XMLHttpRequest,
    		    					textStatus, errorThrown) {
    		    			}
    		    		});
	    					
	    				
    		        }
    		        else
    		        {
    		        	alert('您没有抽奖资格');
        		    }
    			}
    		 } 
    	   
    	});

    	$(".awardtype").click(function(){
        	
    		$(".sucess").show();
    	});

    	$(".close1").click(function(){
    		$(".sucess").hide();
    	});

    	
        $(".btn1").click(function(){
        	
    		var mobile = $("#zfbcodeinput").val();
            var reg = /^[a-zA-Z0-9_.@]{3,26}$/ ;

            if (!reg.test(mobile)) {
            	
            	$(".btn1").html("账号格式不正确");
            }
            else {

            	$(".btn1").html("确认");
    		$.ajax( {
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : {
    				action : 'bind',uzfbcoed: $("#zfbcodeinput").val(),Textname : $("#nameinput").val(),add:$("#addinput").val()
    			},
    			cache : false,
    			success : function(obj) {
    						_czc.push(['_trackEvent', 'sucess.php', '绑定支付宝', 'btn','1','0']);
    						var data = eval('(' + obj+ ')');
    						console.log(data);
    						if(data.status=="success")
    						{
    							$(".btn1").html("更改");
    							//$(".dow1").show();
    							// window.location.href = window.location.href;
    						    //window.location.reload;
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


<div class="gridContainer2 clearfix">
<div class=" chouj">
<div class="box2">



<?php if($cz>0){ ?>
		<p>千万奖金火热派送中</p>
<p>您共猜中<?php echo $cz; ?>次，可以抽<?php echo $jps ?>个奖品,还有<a id="kcs" ><?php echo $kcs ?></a>次抽奖机会</p>
		<div class="ly-plate">
		<div class="rotate-bg"><img src="images/ly-plate<?php echo $jps; ?>.png"></div>
		<div class="lottery-star"><img src="images/rotate-static.png" id="lotteryBtn"></div>
		</div>
		
	<?php }else{ ?>	
		<p>千万奖金火热派送中</p>
	<p>尚未猜中，请等待结果</p>
		<div class="ly-plate">
		<div class="rotate-bg"><img src="images/ly-plate1.png"></div>
		<div class="lottery-star"><img src="images/rotate-static.png" id="lotteryBtn"></div>
		</div>
	
	<?php } ?>	
</div>
</div>
<div class="boxly">
		<fieldset class="round" style="height: <?php  echo 550+$tags_resultcount*80 ;?>px;">
<div class="list">
<p> 我的总战绩 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  class="btnsf"> 牛X的事情要分享</a></p>
		<hr width="90%"  style=" text-align: center; border-top: 1px solid #d9d9d9;" >
		<div class="demo" >
		<?php if($percentboll){ ?>
		<div class="divz">
		<p class="p1" > 猜中 </p>
		<p class="p2" style="color: #df2928"><b style="color: #df2928"><?php echo $cz; ?></b>次 </p>  </div>
		 <!-- <div id="myStat" data-dimension="250" data-text="VS"  data-info="8月30日" data-width="15" data-fontsize="15" data-percent="35" data-fgcolor="#1dc8a0" data-bgcolor="#ffdb00" data-fill="#eee"></div> -->
		<div class="divt" id="myStat" data-dimension="300" data-text="VS"  data-width="15" data-fontsize="35" data-percent="<?php echo $percent; ?>" data-fgcolor="#1dc8a0" data-bgcolor="#df2928" ></div>	
		<div class="divd"> 
		<p class="p1">猜错 </p>
		<p class="p2" style="color: #1dc8a0"><b style="color: #1dc8a0"><?php echo $cc; ?></b>次 </p>    </div>
		<?php }else{?>
			<div class="divz">
		<p class="p1" > 猜中 </p>
		<p class="p2" >0次</p>   </div>
		 <!-- <div id="myStat" data-dimension="250" data-text="VS"  data-info="8月30日" data-width="15" data-fontsize="15" data-percent="35" data-fgcolor="#1dc8a0" data-bgcolor="#ffdb00" data-fill="#eee"></div> -->
		<div class="divt" id="myStat" data-dimension="300" data-text="暂无结果"  data-width="15" data-fontsize="35" data-percent="0" data-fgcolor="#1dc8a0" data-bgcolor="#df2928" ></div>	
		<div class="divd"> 
		<p class="p1">猜错 </p>
		<p class="p2">0次 </p>    </div>
		<?php } ?>
		</div>
		<hr width="90%"  style=" text-align: center; border-top: 1px solid #d9d9d9;" >
<ul>
<?php if($percentboll){
		foreach($tags_result as $object){ ?>
	<li class="clearfix">
	<span style="color: #df2928"><?php echo  TO_date($object->czdtime) ?></span><span class="div2"><?php echo  $object->isaward == "1" ? "已抽奖" : "未抽奖" ?></span><span    <?php echo $object->iszd == 0 ? "style='color:#df2928'" : "style='color:#1dc8a0'"; ?> ><?php echo $object->iszd == 0 ? "猜中" : "猜错" ?></span><span class="awardtype" style="color: #df2928;cursor: pointer;"><?php echo $object->iszd == 0 ? TO_jp($object->awardtype,0) :TO_jp($object->awardtype,1)  ?></span>
	</li>
	<?php }} ?>

</ul>


</div>

</fieldset>


</div>

		<fieldset class="round" style="height: 2311px;">
<div class="list words">

		   <strong>活动规则</strong><br>
		  <p>
        全民猜大盘，无论您是开脑洞，问大神，看曲线还是股神灵魂附体，只要能够猜中大盘涨跌，就来试试运气吧，猜对可以抽奖哦，每多猜对一天即可升级抽奖奖品，千元大奖、千万彩票基金收入囊中。
        
         <br/>猜大盘时间：每个交易日13:00前猜当天大盘走势，13:00后猜后一个交易日大盘走势。
 		 
		  </p>
		    <strong>抽奖奖品</strong><br>
        <p>1、累计猜中一天可抽奖品：彩票基金2元</p>
		<p>2、累计猜中两天可抽奖品：彩票基金2元+全民股神模拟币1000元</p>
		<p>3、累计猜中三天可抽奖品：彩票基金2元+全民股神模拟币1000元+全民股神纪念本</p>
		<p>4、累计猜中四天可抽奖品：彩票基金2元+全民股神模拟币1000元+全民股神纪念本+股神奖金100元</p>
		<p>5、累计猜中五天可抽奖品：彩票基金2元+全民股神模拟币1000元+全民股神纪念本+股神奖金100元+股神奖金1000元</p>
          
          <strong>领奖须知</strong><br>
          <p>抽中奖品后根据领奖弹出框填写真实领奖信息，我们将在填写后的5个工作日发奖。逾期未填写或填写资料虚假的用户将视为弃奖处理哦。
          </p>
           
          <p style="color: #df2928">活动时间：2015年9月8日——2015年10月30日</p>
          <strong>权益声明</strong><br>
          <p>1、活动工作人员有权对股票竞猜活动的参与者和游戏过程进行审核，所有涉嫌通过违规行为（包括但不限于作弊、伪造、欺骗、有组织刷奖、程序刷奖等行为）而获得奖金的，将被取消游戏资格；已获得奖金的，将保留通过法律途径追回资金的权利。</p>
             
          <p>2、因兑奖所产生的税款，在在兑奖者配合提供纳税必要个人信息的前提下，由官方承担，不收取用户任何费用。</p>
        
          <p>3、全民股神保留对本活动所有相关事宜的最终解释权。 </p>
          <br>
        <span id="span2">咨询&投诉邮箱：support@tradehero.mobi<br/></span>
          <br>
           	 <br>
        </div>
</fieldset>

<div class="sucess">
<img src="images/x.png" class="close1"></img>
<div class="tc"> <div class="list7" >
		<ul>
			<li><input type="text" id="nameinput" class="btnname" placeholder="姓名："  value="<?php echo  $uzfbname ;?>"  > </li>
			<li><input type="text" id="zfbcodeinput" class="btnname" placeholder="支付宝账号：" value="<?php echo  $uzfbcoed ;?>" > </li>
			<li><input type="text" id="addinput" class="btnname" placeholder="地址：" value="<?php echo  $uadd ;?>" > </li>
			<li> 
			<?php if($uzfbcoed==''){ ?>
				<a  class="btn1">确认</a>
			
		<?php } else { ?>
			<a  class="btn1">更改</a>
		<?php } ?>
			
			</li>
		</ul>
	</div>
	</div>

</div>

</div>
<div class="pop"><img src="images/share.png" alt="分享"></div>


<script src="js/util.js"></script>
<div style="display: none"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256280463'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1256280463' type='text/javascript'%3E%3C/script%3E"));</script></div>
</body>
</html>