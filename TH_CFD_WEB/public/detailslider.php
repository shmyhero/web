<?php
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

  $jssdk = new JSSDK(appid, secret);
  $signPackage = $jssdk->GetSignPackage();

        $bannerid=Security_Util::my_get('id');
        $api = new API();
        $banner=json_decode($api->getbannerbyid($bannerid),true);

?>
<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <title><?php echo $banner["Header"]; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
     <!-- <link rel="stylesheet" href="./style/yo-flex1.css" /> -->
    <style type="text/css">
*, ::before, ::after {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
}

div {
    display: block;
}

body {
    margin: 0;
    font-size: 14px;
    line-height: 1.5;
    font-family: Helvetica Neue,Helvetica,STHeiTi,sans-serif;
    overflow: hidden;
}

html {
    background-color: #f0f0f0;
    color: #212121;
    font-size: 100px;
    -webkit-user-select: none;
    user-select: none;
}

.pop1 {
    display: none;
    z-index: 3001;
    background: rgba(0,0,0,1);
    position: fixed;
    height: 100%;
    width: 100%;
    left: 0;
    top: 0;
    text-align: center;
}
table {
    border-collapse: collapse;
    border-spacing: 0;
    table-layout: fixed;
    text-align: left;
}
ul, ol, dl, dd, h1, h2, h3, h4, h5, h6, figure, form, fieldset, legend, input, textarea, button, p, blockquote, th, td, pre, xmp {
    margin: 0;
    padding: 0;
}
      h1{
          color: #0f0f0f !important;
          display: block;
          font-size: 20px;
          line-height: 38px;
          letter-spacing: normal;
          margin-top: 10px;
          margin-right: 0;
          margin-bottom: 15px;
          margin-left: 0;
          text-align: left;
      }


      h3{
         color:#333333 !important;
         display:block;
         font-size:16px;
         line-height:100%;
         font-weight:400;
         letter-spacing:normal;
         margin-top:0;
         margin-right:0;
         margin-bottom:10px;
         margin-left:0;
         text-align:left;
      }




      .div4{
         color:#666666 !important;
        /* display:inline-block;
         white-space:nowrap;*/
         font-size:14px;
         font-weight:normal;
         line-height:100%;
         letter-spacing:normal;
         margin-top:0;
         margin-right:0;
         margin-bottom:5px;
         margin-left:0;
         text-align:left;

      }
    .div4 .logo{ float:left; background-color: #648fdc ;height: 24px;width:75px; line-height: 24px;font-size: 11px;  color:#fff; text-align: center;}
    .div4 .time{float:left;height: 24px;width:75px; line-height: 24px;font-size: 12px;  text-align: left;color: #cccccc;margin-left: 25px;}
    .time ul, ol, menu { list-style:disc ; }

      h6{
                 margin-top:0;
                 margin-right:0;
                 margin-bottom:12px;
                 margin-left:0;
                 text-align:left;
            }

      .bodyContent{
        color:#626262;

        font-size:16px;
        line-height:36px;
        padding-top:10px;
        padding-right:28px;
        padding-bottom:10px;
        padding-left:28px;
         text-align:left;
      }
      .bodyContent p{padding-top:5px; padding-bottom:5px;}
      .bodyContent b {color:#0f0f0f; }
      /* ======== Header Styles ======== */
      .bodyContent img{
        height:auto !important;
        max-width:480px !important;
        width:100% !important;
        padding-top:12px;
        padding-bottom:12px;
      }
            @media only screen and (max-height: 480px){
        h1{
           font-size:23px !important;
           line-height:100% !important;
        }

        h3{
           font-size:18px !important;
           line-height:100% !important;
        }

        h4{
           font-size:13px !important;
           line-height:100% !important;
        }


      }

      #show{
            position: absolute;
            width:100%;
           z-index: 3002;
        }
        #photo{
            cursor: pointer;
        }
         #photo img{ width: 100%; height:auto !important;}



#wrapper {
  position: relative;
  height: 100%;
  overflow: hidden;
  -ms-touch-action: none;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-text-size-adjust: none;
  -moz-text-size-adjust: none;
  -ms-text-size-adjust: none;
  -o-text-size-adjust: none;
  text-size-adjust: none;
}

#scroller {
  position: absolute;
  width: 100%;
  -webkit-tap-highlight-color: rgba(0,0,0,0);

  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);
}
</style>
<script type="text/javascript" src="./dist/jquery.min.js"></script>
<script type="text/javascript" src="./dist/iscroll.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="./dist/util.js"></script>
</head>
<body onload="loaded()">
   <div  id="wrapper">
    <div id="scroller">
            <section class="m-list " id="test" style="-webkit-user-select:none;">

                                            <div class="bodyContent">
                                                <h1><?php echo $banner["header"] ;   ?></h1>
                                                <div class="div4" >
                                                  <div class="logo">盈交易</div>

                                                  <div class="time"><ul><li class="daytime"><?php echo $banner["createdAt"] ;   ?></li></ul></div>
                                                </div>
                                              <br>
                                                <div id="TextContent">
                                                <?php echo $banner["body"] ;   ?>
                                            </div>
                                            </div>

            </section>
     </div>
<!--     <section  className="m-footlayer">
       <header class=" yo-foot m-header">
        <p class="title"><span class="pageid"></span> / <span class="pagecount"></span></p>
        <span class="regret  yo-ico prevBtn">&#xf07d;</span>
        <span class="affirm yo-ico nextBtn">&#xf07f;</span>
    </header>

    </section> -->

   <div class="pop1" >
    <div id="show"  style="display: none;">
        <div id="photo" >
            <img />
        </div>
    </div>
    </div>
</div>



<script type="text/javascript">

var myScroll;

function loaded () {
  myScroll = new IScroll('#wrapper', { preventDefault:false });
}

function shareinfo() {
  WebViewBridge.send('{"webpageUrl":"http://cn.tradehero.mobi/CDF_BSY/sucess.php?hjcode=1", "imageUrl":"http://cn.tradehero.mobi/TH_CFD_WEB/images/LOGO.png", "title":"一大波影券来啦！", "description":"俺的模拟投资战绩不佳，求大侠支招，助我拿到电影票！"}');
}


document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

    	function urlParse (e) {
            e = e.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var t = new RegExp("[\\?&]" + e + "=([^&#]*)"), n = t.exec(location.search);
            return null == n ? "" : decodeURIComponent(n[1])
         }
Date.prototype.Format = function(fmt)
{
  var o = {
    "M+" : this.getMonth()+1,                 //月份
    "d+" : this.getDate(),                    //日
    "h+" : this.getHours(),                   //小时
    "m+" : this.getMinutes(),                 //分
    "s+" : this.getSeconds(),                 //秒
    "q+" : Math.floor((this.getMonth()+3)/3), //季度
    "S"  : this.getMilliseconds()             //毫秒
  };
  if(fmt!==null)
  {
  if(/(y+)/.test(fmt))
    fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
  for(var k in o)
    if(new RegExp("("+ k +")").test(fmt))
  fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
  }
  return fmt;
}


var appId=     '<?php echo $signPackage["appId"]; ?>';
var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
var signature= '<?php echo $signPackage["signature"]; ?>';
        $(document).ready(function(){
          var daytime=$(".daytime").html();
          $(".daytime").html( new Date(daytime).Format("yyyy.MM.dd"));

          $("body").height(window.innerHeight);

           // var pagecount = <?php echo $pagecount; ?>;
           // var pageid = urlParse("pageid") == "" ? 1 : parseInt(urlParse("pageid"));
           // $(".pageid").html(pageid);
           // $(".pagecount").html(pagecount);
           // if(pageid===1){

           // 		$(".yo-foot .regret").css('color','#e7e7e7')
           // }
           // else{

           // 		$(".yo-foot .regret").css('color','#888f9c')
           // }
           // if(pageid===pagecount){

           // 		$(".yo-foot .affirm").css('color','#e7e7e7')

           // }else{

           // 		$(".yo-foot .affirm").css('color','#888f9c')

           // }

         // $("#test").swipe({
         //  swipe:function(event,
         //   direction, distance, duration, fingerCount) {
         //    if(distance>100){
         //      if(direction==="left"){
         //        if(pageid<pagecount)  {
         //          pageid=pageid+1;
         //          window.location.replace('detailslider.php?pageid='+pageid);
         //        }
         //      }else{
         //        if(pageid>1){
         //          pageid= pageid-1;
         //          window.location.replace('detailslider.php?pageid='+pageid);
         //        }
         //      }
         //    }
         //  },
         //  });
	     //   $(".yo-foot .prevBtn").click(function(){
	     //   		if(pageid>1){
	     //    		pageid= pageid-1;
	     //    		window.location.replace('detailslider.php?pageid='+pageid);
	     //    	}
	     //   });

	    	// $(".yo-foot .nextBtn").click(function(){
	    	// 	if(pageid<pagecount)	{
	     //    		pageid=pageid+1;
	     //    		window.location.replace('detailslider.php?pageid='+pageid);
	     //    	}
	    	// });

        $(".bodyContent img").click(function(){
                  $(".pop1").show();
                  $("#show").fadeIn(300);  //显示图片效果
                  //设置显示放大后的图片位置
                  //document.getElementById("show").style.left=$(window).width()/2-300;

                  console.log($(window).height()/2 - $(this).height()/2);
                  $("#show").css("top",$(window).height()/2 - $(this).height()/2);

                  //$("#show").css("height",$(this).height());
                  //$("#show").style.top= ;
                  //获得图片路径
                  var photo_url=$(this).attr("src");
                  //设置图片路径
                  $("#photo img").attr("src",photo_url);
                  //单击放大后的图片消失
                  $(".pop1").click(function(){
                  $(".pop1").hide();
                  $("#show").fadeOut(300); //图片消失效果
                });
            });
});
    </script>


</body>
</html>
