<?php
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

  $jssdk = new JSSDK(appid, secret);
  $signPackage = $jssdk->GetSignPackage();

        $headlinesid=Security_Util::my_get('id');
        $api = new API();
        $headlines=json_decode($api->getheadlinebyid($headlinesid),true);
        $headlines=$headlines[0];
        //print_r( $headlines)
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
    <title><?php echo $headlines["header"].'||'.cutstr($headlines["body"],80); ?></title>
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
        padding-top:16px;
        padding-right:15px;
        padding-bottom:14px;
        padding-left:15px;
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
           font-size:17px !important;
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
</style>
<script type="text/javascript" src="./dist/jquery.min.js"></script>
<script type="text/javascript" src="./dist/iscroll.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="./dist/util.js"></script>
</head>
<body onload="loaded()">

   <div  id="wrapper">
    <div id="scroller">
             <div id="header">
    <div class="logo"><img class="img1" src="./images/HLOGO.png" width="127" height="56" > <img src="./images/Dapp.png" class="img2 banner-bg"   width="75" height="28"></div>
  </div>
            <section class="m-list " id="test" style="-webkit-user-select:none;">

                                            <div class="bodyContent">
                                                <h1><?php echo $headlines["header"] ;   ?></h1>

                                                <div class="time daytime"><?php echo $headlines["createdAt"] ;   ?></div>
                                             <hr>
                                                <div id="TextContent" class="TextContent">
                                                <?php echo $headlines["body"] ;   ?>
                                            </div>
                                             <?php if($headlines["image"]!=''){ ?>
                                            <div><img src="<?php echo $headlines["image"] ;   ?>"></div>
                                            <?php } ?>
                                            </div>

            </section>
     </div>

</div>

<script type="text/javascript">

var myScroll;

function loaded () {
  myScroll = new IScroll('#wrapper', { preventDefault:false });
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

$('.banner-bg').click(function () {
      //window.location.href="http://cn.tradehero.mobi/activity/index.php";
      window.location.href="http://a.app.qq.com/o/simple.jsp?pkgname=com.tradehero.cfd";
  });

});
    </script>


</body>
</html>
