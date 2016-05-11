<?php
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

$participant = Session_Util::my_session_get('participant');
if ($participant !== NULL) {
        $participant = json_decode($participant);
        //print_r($participant);
}else{
     //echo "Session_Util::my_session_get";
    // $url = BASE_URL.'fn_system.php';
    // header("Location:".$url);
    // exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="./prd/yo/usage/export/yo-flex.css" />
    <link rel="stylesheet" href="./themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="./style/nivo-slider.css" type="text/css" media="screen" />
<style>
.blockImage {
        width: .39rem;
        height: .39rem;
        margin-bottom: 10%;
        margin-top: 10%;
    } 
 .blockTitleText{ 
        color: #ffe400;
        font-size: .2rem;
        margin-bottom: 5%;
    }
.blockTitleContent{
        color: #dde8ff;
        font-size: .11rem;
        margin-bottom: 15%;
    }
.divimg{/*height: 1.9rem;*/ height: auto; justify-content: center;}
.div1left{   border:1px solid #268dff; background-color: #0079ff; border-top: 0px;   border-left: 0px; text-align: center; } 
.div1right{ border:1px solid #268dff; background-color: #0079ff;   border-top: 0px; border-left: 0px; border-right:0px;  text-align: center; }

.div2left{  border:1px solid #268dff; background-color: #0079ff; border-top: 0px;   border-left: 0px; border-bottom: 0px;  text-align: center; } 
.div2right{ border:1px solid #268dff; background-color: #0079ff;   border-top: 0px; border-left: 0px; border-right:0px; border-bottom: 0px;  
    text-align: center; }
</style> 
<script type="text/javascript">
    var userId= '<?php echo $participant->userId; ?>';
    var token= '<?php echo $participant->token; ?>';
    var userdata={"userId":userId,"token":token };
    localStorage.setItem('@TH_CFD:userData',JSON.stringify(userdata));
     var Security = localStorage.getItem('@TH_CFD:userData');
     var MYSecurityData =JSON.parse(Security);  //.substr(1, Security.length)
    console.log(MYSecurityData);
</script>
</head>
<body>
   <div class="yo-flex">
      <section class="m-list "> 
       <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
                <a href="mydetailslider.html"> <img src="images/bannar01.png"  data-thumb="images/bannar01.png" alt="" data-transition="slideInLeft"/></a>
                <a href="mydetailslider.html"><img src="images/bannar02.png"   data-thumb="images/bannar02.png" alt=""  data-transition="slideInLeft"/></a>
            </div>
        </div> 
      </section>
    <section class="flex" > 
    <section class="flexGrid m-list " > 
        <div class="div1left divimg flexGrid-cell u-1of2">
            <img class="blockImage" src="./images/updown.png" >
            <div class="blockTitleText">涨跌双盈</div>
            <div class="blockTitleContent">市场行情的涨跌动态都是<br/>盈利时机</div>
        </div> 
        <div class="div1right divimg flexGrid-cell u-1of2">
            <img class="blockImage" src="./images/smallbig.png">
            <div class="blockTitleText">以小搏大</div>
            <div class="blockTitleContent">盈利无上限 亏损有底线<br/>杠杆收益</div>
        </div> 
    </section>

    <section class="flexGrid m-list " > 
    <div class="div2left divimg flexGrid-cell u-1of2">
        <img class="blockImage" src="./images/markets.png">
        <div class="blockTitleText">实时行情</div>
            <div class="blockTitleContent">市场同步的行情助您掌控<br/>涨跌趋势</div>
    </div> 
    <div class="div2right divimg  flexGrid-cell u-1of2">
        <img class="blockImage" src="./images/advantage.png">
        <div class="blockTitleText">体验简单</div>
        <div class="blockTitleContent">选择涨跌 本金和杠杆三步<br/>便捷交易</div>
    </div> 
    </section>  </section>
         <section class="yo-tab yo-tab-view m-tabview">
          
        <a href="index.php" class="item item-y-ico item-on">
            <i class="yo-ico">&#xf04f;</i>
            首页
        </a>
        <a href="StockPage.html" class="item item-y-ico ">
            <i class="yo-ico">&#xf04e;</i>
            行情
        </a>
        <a href="PositionPage.html" class="item item-y-ico ">
            <i class="yo-ico">&#xf050;</i>
            交易
        </a>
        <a href="mywenda.html" class="item item-y-ico ">
            <i class="yo-ico yypf-ico">&#xE80D;</i>
            问答
        </a>
    </section>
</div> 
</body>

<script type="text/javascript" src="./dist/jquery.min.js"></script>
    <script type="text/javascript" src="./dist/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
 
    
    $(window).load(function() {
        $('#slider').nivoSlider();
    });

        $(function(){  
  
        var imglist =$(".divimg");
        var _width = window.screen.width; 
        var _height =  window.screen.height-20;
        var imageHeight = 478 / 750 * _width; 
        
        var yotabheight =$(".yo-tab").height(); 
        console.log(_height +'|'+imageHeight+'|'+yotabheight);
        imglist.css("height",(_height-imageHeight-yotabheight)/2 );   
        //安卓4.0+等高版本不支持window.screen.width，安卓2.3.3系统支持  
        /* 
        var _width = window.screen.width; 
        var _height = window.screen.height - 20; 
         
        var _width = document.body.clientWidth; 
        var _height = document.body.clientHeight - 20; 
        */  
        // var _width,   
        //     _height;  
        // doDraw();  
          
        // window.onresize = function(){  
        //     doDraw();  
        // }  
          
        // function doDraw(){  
      
        //     _height = window.innerHeight;  
        //     for( var i = 0, len = imglist.length; i < len; i++){  
               
        //     }  
        // }  
          
          
     
})
    </script>
</html>