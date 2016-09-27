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
    $url = BASE_URL.'fn_system.php?target=StockPage.php';
    header("Location:".$url);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>行情</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="./style/yo-flex.css" />
    <style type="text/css">
        #tab-content{  background-color: #fff; }
        #Suggest{  z-index: 1000; }


        .drag-handle {
        margin-right: 10px;
        font: bold 20px Sans-Serif;
        }
    </style>

</head>
<body >
      <div class="spinner active"></div>
     <div   id="TestTip"></div>
<div  class=" bookmark" id="bookmark">
</div>
    <div  class="none Suggest">
        <div class=" yo-flex " id="Suggest"></div>
    </div>
<div class="yo-flex content">
    <header class="yo-header m-header">
        <h2 class="title">行情</h2>
        <span class="regret bianji">编辑</span>
        <span class="affirm yo-ico">&#xf067;</span>
    </header>
    <section class="m-layer">
            <ul class="yo-Htab">
                <li class="item item-on item-y-ico " id="li0"><sanp>自选</sanp> <i class="yo-ico bot"> <img src="./images/triangle.png" ></i> </li>
                <li class="item item-y-ico " id="li1">美股 <i class="yo-ico bot"> <img src="./images/triangle.png" ></i> </li>
                <li class="item item-y-ico " id="li2">指数 <i class="yo-ico bot"> <img src="./images/triangle.png" ></i> </li>
                <li class="item item-y-ico " id="li3">外汇 <i class="yo-ico bot"> <img src="./images/triangle.png" ></i> </li>
                <li class="item item-y-ico " id="li4">商品 <i class="yo-ico bot"> <img src="./images/triangle.png" ></i> </li>
           </ul>
    </section>
    <div class="flex" id="tab-content">

     </div>
    <section class="yo-tab yo-tab-view m-tabview">

        <a href="index.php" class="item item-y-ico ">
            <i class="yo-ico">&#xf04f;</i>
            首页
        </a>
        <a href="StockPage.php" class="item item-y-ico item-on">
            <i class="yo-ico">&#xf04e;</i>
            行情
        </a>
        <a href="PositionPage.php" class="item item-y-ico">
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
<script type="text/javascript" src="./dist/SliderTab.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="http://sdk.talkingdata.com/app/h5/v1?appid=23BDFF1EABC6BE3262059895744F28C6&vn=YJYWEB&vc=0.1"></script>
<script type="text/javascript">
  var appId=     '<?php echo $signPackage["appId"]; ?>';
  var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
  var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
  var signature= '<?php echo $signPackage["signature"]; ?>';
</script>
<script type="text/javascript" src="dist/util.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    TDAPP.onEvent("WebAPP","行情页面");
    $(".bookmark").hide();
    $(".Suggest").hide();
    $(".yo-header .affirm").click(function(){
        $(".Suggest").show();
        $(".content").hide();

    });

    $(".yo-header .bianji").click(function(){
        $(".bookmark").show();
         $(".content").hide();
    });

     //置顶
     var $top = $(".top");
     $top.click(function(){
      var $tr = $(this).parents("li");
      $tr.fadeOut().fadeIn();
      $("#handle-1").prepend($tr);
     });
});
</script>
    <script src="./dist/Sortable.js"></script>
      <script >
      Sortable.create(document.getElementById('handle-1'), {
            handle: '.drag-handle',
            animation: 150
      });
      </script>
</body>
</html>
