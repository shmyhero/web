<?php
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

  $jssdk = new JSSDK(appid, secret);
  $signPackage = $jssdk->GetSignPackage();

function cutstr($string, $length) {
  preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $info);
  for($i=0; $i<count($info[0]); $i++) {
    $wordscut .= $info[0][$i];
    $j = ord($info[0][$i]) > 127 ? $j + 2 : $j + 1;
    if ($j > $length - 3) {
      return $wordscut."...";
    }
  }
  return join('', $info[0]);
}
?>
<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <title>盈交易签到</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
          color: #000000 !important;
          display: block;
          font-size: 17px;
          line-height: 24px;
          letter-spacing: normal;
          /*margin-top: 10px;*/
          margin-right: 0;
          margin-bottom: 7px;
          margin-left: 0;
          text-align: left;
      }


      h3{
         color:#0252d4 !important;
         display:block;
         font-size:16px;
         /*line-height:100%;*/
         /*font-weight:400;*/
         /*letter-spacing:normal;
         margin-top:0;
         margin-right:0;
         margin-bottom:10px;
         margin-left:0;*/
         text-align:center;
      }

   .time{  font-size: 12px;  text-align: left;color: #999999; }

    .TextContent{ margin-top: 10px; }
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
        /*padding-top:16px;*/
        padding-right:13px;
        padding-bottom:14px;
        padding-left:13px;
         text-align:left;
      }
      .bodyContent p{padding-top:5px; padding-bottom:5px;}
      .bodyContent b {color:#3078ef;  }
      /* ======== Header Styles ======== */
      .bodyContent img{
        height:auto !important;
        max-width:480px !important;
        width:100% !important;
        padding-top:12px;
        padding-bottom:12px;
      }




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

  -webkit-tap-highlight-color: rgba(0,0,0,0);

  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);

}

#header .logo {
    padding: 0 0 0 15px;
    height: 64px;
    line-height: 64px;
    white-space: nowrap;
  }
  .logo img {
   vertical-align:middle;

 }
.img2{float: right;margin: 15px 15px 0 0;}

 .span1{  margin: 0 0 0 1%; font-size:17px; }
 #header {
  /*position: fixed;*/
    top: 0;
    left: 0;
  width: 100%;
  z-index: 20;
  background: #1a61dd;
  -webkit-background-size: 100% auto;
  background-size: 100% auto;
  color: #fff;
}
hr { color: #999999;height:1px;border:0px;border-top:1px solid #999999;margin:0px;padding:0px;overflow:hidden; }

.head {text-align: center;}
.head img{
  height:auto !important;
  max-width:480px !important;
  width:100% !important;
}
.divborderleft{
border-left: 2px solid #3879ec;
padding-left: 6px;
margin-bottom: 20px;
font-size: 13px;
color: #6a9ffb;
line-height: 28px;
}
</style>

</head>
<body onload="loaded()">
   <div  id="wrapper">
    <div id="scroller">
             <div id="header">
    <div class="logo"><img class="img1" src="./images/HLOGO.png" width="127" height="56" > <img src="./images/Dapp.png" class="img2 banner-bg"   width="75" height="28"></div>
  </div>
  <div class="head"><img src="./images/rule.png"></div>
            <section class="m-list " id="test" style="-webkit-user-select:none;">
                <div class="bodyContent">
                    <h3>获取交易金须知</h3>
<div class="divborderleft"> 签到1天，赠送0.5元交易金;<br>
  连续签到5天后，第6天起，赠送0.6元交易金;<br>
连续签到10天后，第11天起，赠送0.8元交易金;<br>
<div style="line-height: 22px;  ">连续签到中断，即恢复到每日赠送0.5元交易金，重新累积连续签到天数。</div></div>

<div class="divborderleft"> 模拟交易，按天赠送0.5元交易金;<br>
  模拟注册盈交易App，赠送20元交易金;<br>
连续签到10天后，第11天起，赠送0.8元交易金;</div>

<div class="divborderleft" ><b>您在盈交易App获取的交易金，在开通实盘交易的时候1:1兑换成实盘资金，打入到您的实盘帐户。</b></div>
                </div>

            </section>
     </div>

</div>
<script type="text/javascript" src="./dist/jquery.min.js"></script>
<script type="text/javascript" src="./dist/iscroll.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="./dist/util.js"></script>
<script type="text/javascript">
var myScroll;

function loaded () {
  myScroll = new IScroll('#wrapper', { preventDefault:false });
}


document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

var appId=     '<?php echo $signPackage["appId"]; ?>';
var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
var signature= '<?php echo $signPackage["signature"]; ?>';
        $(document).ready(function(){
          $("body").height(window.innerHeight);

$('.banner-bg').click(function () {
      //window.location.href="http://cfd-web-cn2.cloudapp.net/activity/download.html";
      window.location.href="http://a.app.qq.com/o/simple.jsp?pkgname=com.tradehero.cfd";
  });

});
    </script>


</body>
</html>
