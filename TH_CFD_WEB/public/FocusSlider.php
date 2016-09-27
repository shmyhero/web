<?php
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

  $jssdk = new JSSDK(appid, secret);
  $signPackage = $jssdk->GetSignPackage();

  $api = new API();
  $headline=json_decode($api->getheadline(),true);
  //print_r($headline); //color


function abslength($str)
{
    if(empty($str)){
        return 0;
    }
    if(function_exists('mb_strlen')){
        return mb_strlen($str,'utf-8');
    }
    else {
        preg_match_all("/./u", $str, $ar);
        return count($ar[0]);
    }
}
//格林时间转北京时间
function TO_date($strALL)
{
  return date("H:i",strtotime("+8hours",strtotime($strALL)));
}

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
   <title>今日头条</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name=viewport content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <script src="http://sdk.talkingdata.com/app/h5/v1?appid=23BDFF1EABC6BE3262059895744F28C6&vn=YJYWEB&vc=0.1"></script>
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

  .hidden{display: none;  }

  body {
    margin: 0;
    font-size: 14px;
    line-height: 1.5;
    font-family: Helvetica Neue,Helvetica,STHeiTi,sans-serif;
  }

  html {
    background-color: #f8f8f8;
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

 .section {-webkit-user-select:none; margin-bottom:15px;  }


 .div3{
   color:#666666 !important;
   height:25px;
   background-color: #ebebeb;
   font-size:14px;
   font-weight:normal;
   line-height:100%;
   letter-spacing:normal;
   text-align:left;
 }

 .div3 .logo{ float:left;height:16px; width:5px; background-color: #1962dd; line-height: 24px;font-size: 11px;  color:#fff;
  text-align: center;margin-top: 4px;}
 .div3 .time{
    line-height: 25px;
    font-size: 13px;
    text-align: left;
    color: #000;
    margin-left: 11px;}



  .div4{
     color:#393939 !important;
     font-size:14px;
     font-weight:normal;
     line-height:100%;
     letter-spacing:normal;
     margin-top:14px;
     margin-right:0;
     margin-bottom:0px;
     margin-left:0;
     text-align:left;

   }
  .div4 .time{ float:left; height: 24px;width:54px; line-height: 24px;font-size: 13px;  text-align: left; padding-left: 11px;}
  .div4 .content{
    line-height: 21px;
    font-size: 15px;
    text-align: left;
    margin-left: 55px;
    padding-bottom: 22px;
    padding-right: 30px;
    border-bottom: 1px solid #dddddd;
  }

  .div4 .content1 {
    line-height: 21px;
    font-size: 15px;
    text-align: left;
    margin-left: 55px;
    padding-bottom: 22px;
    padding-right: 30px;
    border-bottom: 1px solid #dddddd;
  }

  .colorcontent{ color: #cb3a3a; }

  .div4 .bntExpand{  font-size: 13px; color:#1962dd; }
  .div4 .bntExpand1{ margin-bottom: 22px;font-size: 13px; color:#1962dd; }

  h6{
   margin-top:0;
   margin-right:0;
   margin-bottom:12px;
   margin-left:0;
   text-align:left;
 }

  .div4 .spancontentimg{
    height:auto !important;
    max-width:480px !important;
    width:100% !important;
    padding-top:12px;
    /*padding-bottom:12px;*/
  }

  .div4 .shareimg{
    height:17px !important;
    width:17px !important;
    /*padding-top:12px;*/
    /*padding-bottom:12px;*/
  }
  .div4 .sharea{
    float: right;
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

  body {
    overflow: hidden;
  }

  #wrapper {
    position: relative;
    height: auto;
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
        <!-- <script type="text/javascript" src="./dist/jquery.touchSwipe.min.js"></script> -->
        <script type="text/javascript" src="./dist/iscroll.js" ></script>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script src="./dist/util.js"></script>
        <script type="text/javascript">
var appId=     '<?php echo $signPackage["appId"]; ?>';
var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
var signature= '<?php echo $signPackage["signature"]; ?>';

var myScroll;
function loaded () {
  var id = urlParse("id");
  console.log(id);
  myScroll = new IScroll('#wrapper', { mouseWheel: true, click: true });
  if(id!=""){
  myScroll.scrollToElement(document.querySelector('#scroller .li'+id ))
  //, 1200, null, null, true
  //IScroll.utils.ease.elastic
  // myScroll.scrollToElement(document.querySelector('#scroller .li'+id ), null, null, true)
  }
//+id

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
  $(document).ready(function(){

    $("body").height(window.innerHeight);
    $("#wrapper").height(window.innerHeight);

    $('.sharea').click(function () {
      console.log("每日头条分享");
      TDAPP.onEvent("WebAPP","每日头条分享");
    });
    $('.bntExpandck').click(function () {

        if($(this).hasClass("open")){

          $(this).removeClass("open");
          $(this).addClass("colse");
          $(this).parent().parent().find(".spancontent").html( $(this).parent().parent().find('.hidden').html() );
          $(this).find("span").html('展开');
          myScroll.refresh();

        }else{

          $(this).removeClass("colse");
          $(this).addClass("open");
          $(this).parent().parent().find(".spancontent").html($(this).parent().find('.hidden').html());
          $(this).find("span").html('收起');
          myScroll.refresh();

        }
    });

    });
  </script>

</head>
<body onload="loaded()">
 <div  id="wrapper" >
  <div id="scroller" >

<?php foreach($headline as $k=>$val){ ?>

 <section  class="section">
        <div class="div3" ><div class="logo"> </div>  <div class="time"><?php echo $val["createdDay"] ;   ?></div> </div>
      <?php foreach($val["headlines"] as $k=>$headlines){ if(abslength($headlines["body"])>110){ ?>
            <div class="div4 <?php echo 'li'.$headlines["id"] ;   ?>" >
        <div class="time"> <?php echo  TO_date($headlines["createdAt"])   ?> </div>
        <div class="content"> <div class="hidden">   <?php echo cutstr($headlines["body"],110)   ?> </div>
        <span class="spancontent <?php echo $headlines["color"] == '1' ? 'colorcontent' : ''  ?>"> <?php echo cutstr($headlines["body"],110) ;   ?> </span>

         <?php if($headlines["image"]!=''){ ?>
        <div> <img class="spancontentimg" src="<?php echo $headlines["image"] ;   ?>" > </div>
       <?php } ?>
        <div class="bntExpand "> <span  class="bntExpandck colse">展开 </span> <div class="hidden"><?php echo $headlines["body"]   ?></div> <a class="sharea" href="cfd://page/share?title=<?php echo  urlencode($headlines["header"])?>&description=<?php echo urlencode(cutstr($headlines["body"],80))?>&webpageUrl=<?php echo  urlencode('http://cn.tradehero.mobi/TH_CFD_WEB1.5/FocusShare.php?id='.$headlines["id"]) ?>&imageUrl=<?php echo urlencode('http://cn.tradehero.mobi/TH_CFD_WEB/images/ShareLogo.png') ?>"> <img class="shareimg" src="./images/share.png"></a>  </div> </div>
      </div>
 <?php } else{ ?>
      <div class="div4 <?php echo 'li'.$headlines["id"]; ?>" >
        <div class="time"><?php echo TO_date($headlines["createdAt"])   ?></div>

        <div class="content1 scrollerdiv4"><span class="spancontent <?php echo $headlines["color"] == '1' ? 'colorcontent' : ''  ?> "> <?php echo $headlines["body"]  ?> </span>
       <?php if($headlines["image"]!=''){ ?>
        <div> <img class="spancontentimg" src="<?php echo $headlines["image"] ;   ?>" > </div>
       <?php } ?>
        <div class="bntExpand1 "> <a class="sharea" href="cfd://page/share?title=<?php echo  urlencode($headlines["header"])?>&description=<?php echo urlencode($headlines["body"])?>&webpageUrl=<?php echo urlencode('http://cn.tradehero.mobi/TH_CFD_WEB1.5/FocusShare.php?id='.$headlines["id"]) ?>&imageUrl=<?php echo urlencode('http://cn.tradehero.mobi/TH_CFD_WEB/images/ShareLogo.png') ?>" > <img class="shareimg" src="./images/share.png"></a>  </div>
        </div>

      </div>
  <?php  }  } ?>
  </section>
          <?  }  ?>


  </div>
</div>

<script type="text/javascript">
  // $("#scroller").find("section").eq(1).css({"margin-bottom":"150px"});


</script>

</body>
</html>
