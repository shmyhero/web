<?php
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

$participant = Session_Util::my_session_get('participant');
if($participant !== NULL) {
        $participant = json_decode($participant);
        $jssdk = new JSSDK(appid, secret);
        $signPackage = $jssdk->GetSignPackage();

}else{
    $url = BASE_URL.'fn_system.php?target=PositionPage.php';
    header("Location:".$url);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的交易</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
<!--     如果设置为 default，状态栏将为正常的，即白色，网页从状态栏以下开始显示；
如果设置为 black，状态栏将为黑色，网页从状态栏以下开始显示；
如果设置为 black-translucent，状态栏将为灰色半透明，网页将充满整个屏幕，状态栏会盖在网页之上； -->
    <link rel="stylesheet" href="./style/yo-flex.css" />

    <style type="text/css">
        #tab-content{  background-color: #fff; }
        #Suggest{  z-index: 1000; }

        #container{ height: 260px; width: 100%; padding-top: 0.2rem;}

    </style>

</head>
<body>
<div class="spinner active"></div>
<div id="horizontal-1"></div>
<div class="yo-flex content">
    <header class="yo-header m-header">
        <h2 class="title">我的交易</h2>
    </header>
    <section class="m-layer">
            <ul class="yo-Htab">
                <li class="item item-on item-y-ico " id="li0">持仓<i class="yo-ico bot"> <img src="./images/triangle.png" ></i> </li>
                <li class="item item-y-ico " id="li1">平仓 <i class="yo-ico bot"> <img src="./images/triangle.png" ></i> </li>
                <li class="item item-y-ico " id="li2">统计</li>
           </ul>

    </section>
    <div class="flex" id="tab-content">
    </div>
    <section class="yo-tab yo-tab-view m-tabview">
        <a href="index.php" class="item item-y-ico ">
            <i class="yo-ico">&#xf04f;</i>
            首页
        </a>
        <a href="StockPage.php" class="item item-y-ico ">
            <i class="yo-ico">&#xf04e;</i>
            行情
        </a>
        <a href="PositionPage.php" class="item item-y-ico item-on">
            <i class="yo-ico">&#xf050;</i>
            交易
        </a>
        <a href="mywenda.html" class="item item-y-ico ">
            <i class="yo-ico">&#xf052;</i>
            问答
        </a>
    </section>
</div>

<script type="text/javascript" src="./dist/jquery.min.js"></script>
<script type="text/javascript" src="./dist/highstock.js"></script>
<script type="text/javascript" src="./dist/jquery.signalR.core.js"></script>
<script src="./dist/hubs.js"></script>
<script type="text/javascript">
    var userId= '<?php echo $participant->userId; ?>';
    var token= '<?php echo $participant->token; ?>';
    var userdata={"userId":userId,"token":token };
    localStorage.setItem('@TH_CFD:userData',JSON.stringify(userdata));
    var ownStocksData = localStorage.getItem('@TH_CFD:ownStocksData');
    if(ownStocksData==null){
      var ownStocksData= [];
      localStorage.setItem('@TH_CFD:ownStocksData',"'" + JSON.stringify(ownStocksData));
    }
</script>
<script type="text/javascript" src="./dist/PositionTab.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<!-- <script src="http://sdk.talkingdata.com/app/h5/v1?appid=23BDFF1EABC6BE3262059895744F28C6&vn=YJYWEB&vc=0.1"></script> -->
<script type="text/javascript">
  var appId=     '<?php echo $signPackage["appId"]; ?>';
  var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
  var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
  var signature= '<?php echo $signPackage["signature"]; ?>';
</script>
<script type="text/javascript" src="dist/util.js"></script>
</body>
</html>
