<?php
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

$participant = Session_Util::my_session_get('participant');
if($participant !== NULL) {
        $participant = json_decode($participant);
        $jssdk = new JSSDK(appid, secret);
        $signPackage = $jssdk->GetSignPackage();
        $api = new API();
        $banner=json_decode($api->getbanner(),true);
        // print_r($participant);
        // print_r($banner);
}else{

    $url = BASE_URL.'fn_system.php?target=index.php';
    header("Location:".$url);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="./style/yo-flex.css" />
    <link rel="stylesheet" href="./style/nivo-slider.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="./themes/default/default.min.css" type="text/css" media="screen" />
    <style>

    .blockImage {
            width: .39rem;
            height: .39rem;
            margin-bottom: 5%;
            margin-top: 8%;
        }

    .blockTitleText{
                color: #ffe400;
                font-size: .2rem;
                margin-bottom: 5%;
            }
    .blockTitleContent{
                color: #dde8ff;
                font-size: .11rem;
                margin-bottom: 10%;
            }
    @media only screen and (max-height: 480px){
          .blockImage {
                  margin-bottom: 1%;
                  margin-top: 3%;
              }
           .blockTitleText{
                      margin-bottom: 2%;
            }
        }

    @media only screen and (max-height: 560px){
          .blockImage {
                  margin-bottom: 1%;
                  margin-top: 3%;
              }
          .blockTitleText{
                      margin-bottom: 2%;
                  }
        }

    .divimg{height: auto; justify-content: center;}
    .div1left{   border:1px solid #268dff; background-color: #0079ff; border-top: 0px;   border-left: 0px; text-align: center; }
    .div1right{ border:1px solid #268dff; background-color: #0079ff;   border-top: 0px; border-left: 0px; border-right:0px;  text-align: center; }

    .div2left{  border:1px solid #268dff; background-color: #0079ff; border-top: 0px;   border-left: 0px; border-bottom: 0px;  text-align: center; }
    .div2right{ border:1px solid #268dff; background-color: #0079ff;   border-top: 0px; border-left: 0px; border-right:0px; border-bottom: 0px;
        text-align: center; }

.list-optimization {
    list-style-type: none;
    text-align: center;
    position: relative;
    background-color:#0079ff;
}

.list-optimization:before, .list-optimization:after {
    content: '';
    display: block;
    position: absolute;
    background: #ebf2fa;
}

.list-optimization:before {
    left: 50%;
    top: 0;
    bottom: 0;
    width: 1px;
}

.list-optimization:after {
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
}

.list-optimization li {
    width: calc(50% - 4px);
    display: inline-block;
    text-align: left;
    font-size: 16px;
    position: relative;
}

.cols:after, .step:after, .shell:after, .paging:after, .shell-inner:after, .list-optimization:after, .list-optimization li:after, .carbon_customrecentposts li:after, .section-reports .section-head:after {
    clear: both;
    display: block;
    content: '';
    font-size: 0;
    line-height: 0;
    text-indent: -4000px;
}
article {
    text-align: center;
    margin: 5px 0;
}
@media (max-width: 320px) {
  article {
    text-align: center;
    margin: 9px 0;
}
}
.slider-wrapper{ height: 160px; background-color: #0079ff;}
.bsy_rk{
background-color: #ccc;
padding: 5px 0;}
    </style>

<script type="text/javascript">
    var userId= '<?php echo $participant->userId; ?>';
    var token= '<?php echo $participant->token; ?>';
    var userdata={"userId":userId,"token":token };
    localStorage.setItem('@TH_CFD:userData',JSON.stringify(userdata));
     var Security = localStorage.getItem('@TH_CFD:userData');
     var MYSecurityData =JSON.parse(Security);  //.substr(1, Security.length)
    console.log(MYSecurityData);
    var ownStocksData= [];
    localStorage.setItem('@TH_CFD:ownStocksData',"'" + JSON.stringify(ownStocksData));
</script>
</head>
<body>
    <!-- <div class="spinner active"></div> -->
   <div class="yo-flex">
      <section class="m-list">
       <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
            <?php foreach($banner as $k=>$val){ ?>
            <?php  if( $val["id"] =='30' ){?>
              <a href=<?php echo 'http://cn.tradehero.mobi/CDF_BSY_WX/index.php' ;   ?> > <img src=<?php echo $val["imgUrl"] ;   ?>  data-thumb=<?php echo $val["imgUrl"] ;   ?>  data-transition="slideInLeft"/></a>
                <?php }else{  ?>
                  <a href=<?php echo $val["url"]==="" ? "detailslider.php?id=".$val["id"] : $val["url"].'?userId='.$participant->userId ;   ?> > <img src=<?php echo $val["imgUrl"] ;   ?>  data-thumb=<?php echo $val["imgUrl"] ;   ?>  data-transition="slideInLeft"/></a>
            <?php }}  ?>
            </div>
        </div>
      </section>
      <section class="m-list">
       <div class="bsy_rk yo-list">
        <div class="item Grid">
          <div class="last Grid-cell u-1of3 ">
            <div class="name">电影票来袭</div>
            <div class="symbol">每日模拟交易前三名</div>
          </div>
          <div class="Grid-cell u-1of41"><img src="./images/LOGO.png"> </div>
            </div>
        </div>
      </section>
 <section class="flex" >
<ul class="list-optimization" >
<li>
                <article>
                     <img class="blockImage" src="./images/updown.png" >
            <div class="blockTitleText">涨跌双赢</div>
            <div class="blockTitleContent">市场行情的涨跌动态都是<br/>盈利时机</div>

                </article>
            </li>
<li>
                <article>
                    <img class="blockImage" src="./images/smallbig.png">
            <div class="blockTitleText">以小搏大</div>
            <div class="blockTitleContent">盈利无上限 亏损有底线<br/>杠杆收益</div>

                </article>
            </li>
<li>
                <article>
                   <img class="blockImage" src="./images/markets.png">
        <div class="blockTitleText">实时行情</div>
            <div class="blockTitleContent">市场同步的行情助您掌控<br/>涨跌趋势</div>

                </article>
            </li>
<li>
                <article>
                    <img class="blockImage" src="./images/advantage.png">
        <div class="blockTitleText">体验简单</div>
        <div class="blockTitleContent">选择涨跌 本金和杠杆三步<br/>便捷交易</div>

                </article>
            </li>
</ul>
 </section>
         <section class="yo-tab yo-tab-view m-tabview">

        <a href="index.php" class="item item-y-ico item-on">
            <i class="yo-ico">&#xf04f;</i>
            首页
        </a>
        <a href="StockPage.php" class="item item-y-ico ">
            <i class="yo-ico">&#xf04e;</i>
            行情
        </a>
        <a href="PositionPage.php" class="item item-y-ico ">
            <i class="yo-ico">&#xf050;</i>
            交易
        </a>
        <a href="mywenda.html" class="item item-y-ico ">
            <i class="yo-ico">&#xf052;</i>
            问答
        </a>
    </section>
</div>
</body>
<script type="text/javascript" src="./dist/jquery.min.js"></script>
<script type="text/javascript" src="./dist/jquery.nivo.slider.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
  var appId=     '<?php echo $signPackage["appId"]; ?>';
  var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
  var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
  var signature= '<?php echo $signPackage["signature"]; ?>';
</script>
<script type="text/javascript" src="dist/util.js"></script>
<script type="text/javascript">

    // $(window).load(function() {
    //
    //
    // });
    $(function(){

      $('.slider-wrapper').css("height","auto");
      // $('.spinner').removeClass('active');
      $('#slider').nivoSlider();
    $(".bsy_rk").click(function() {

        window.location.href="http://cn.tradehero.mobi/CDF_BSY_WX/index.php";

   	 });
          var imglist =$(".divimg");
          var _width = window.screen.width;
          var _height =  window.screen.height;
          var imageHeight = 478 / 750 * _width;

          var yotabheight =$(".yo-tab").height();
          console.log(_height +'|'+imageHeight+'|'+yotabheight);
          imglist.css("height",(_height-imageHeight-yotabheight)/2 );
  });
    </script>
</html>
