<?php
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');

$participant = Session_Util::my_session_get('participant');
if($participant !== NULL) {
        //$participant = json_decode($participant);
        $jssdk = new JSSDK(appid, secret);
        $signPackage = $jssdk->GetSignPackage();
}else{
    $securityId = Security_Util::my_get('securityId');
    $url = BASE_URL.'fn_system.php?target=tickview.php?securityId='.$securityId;
    header("Location:".$url);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>交易 </title>
  <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
  <meta name="format-detection" content="telephone=no,email=no" />
  <link rel="stylesheet" href="./style/yo-flex.css" />
  <style >
  .item >.Grid {display: flex;flex-direction: row;}
  .Grid >.Grid-cell {flex: 1;}
  .Grid >.Grid-cell.u-full {flex: 0 0 100%;}
  .Grid >.Grid-cell.u-1 {flex: 0 0 75%; text-align: left;}
  .Grid >.Grid-cell.u-1of2 {flex: 0 0 50%;}
  .Grid >.Grid-cell.u-1of21 { flex: 0 0 40%;}
  .Grid >.Grid-cell.u-1of3 { flex: 0 0 33.3333%;}
  .Grid >.Grid-cell.u-1of4 {flex: 0 0 25%;padding-left: .4rem;}
  .Grid >.Grid-cell.u-1of5 { flex: 0 0 20%;text-align: right;}
  .Grid >.Grid-cell.u-1of41 { flex: 0 0 30%;}
  .Grid >.Grid-cell.u-1of51 { flex: 0 0 25%;  margin-left: .15rem;}
  .yo-btn img{ height: .3rem;
     margin-bottom: .1rem;
    margin-right: .05rem;
    }
    .yo-tabfoot>.item>div {
    vertical-align: middle;
}
  </style>
</head>
<body>
<div class="spinner active"></div>
  <div id="contcontainer" class="yo-flex contcontainer scroll-in"></div>
  <script type="text/javascript" src="./dist/jquery.min.js"></script>
  <script type="text/javascript" src="./dist/highstock.js"></script>
  <script type="text/javascript" src="./dist/jquery.signalR.core.js"></script>
  <script src="./dist/hubs.js"></script>
  <script src="http://sdk.talkingdata.com/app/h5/v1?appid=23BDFF1EABC6BE3262059895744F28C6&vn=YJYWEB&vc=0.1"></script>
  <script type="text/javascript" src="./dist/Tick.js"></script>
  <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

  <script type="text/javascript">
    var appId=     '<?php echo $signPackage["appId"]; ?>';
    var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
    var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
    var signature= '<?php echo $signPackage["signature"]; ?>';
  </script>
  <script type="text/javascript" src="dist/util.js"></script>
  <script type="text/javascript">
  TDAPP.onEvent("WebAPP","交易页面");
  function urlParse (e) {
    e = e.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var t = new RegExp("[\\?&]" + e + "=([^&#]*)"), n = t.exec(location.search);
    return null == n ? "" : decodeURIComponent(n[1])
  }

    $(function () {
        //21761
        var securityId= urlParse("securityId")=="" ? '21535': urlParse("securityId");
        Highcharts.setOptions({
                global : {
                  useUTC : false
                },
                lang: {
                  rangeSelectorFrom:"日期:",
                  rangeSelectorTo:"至",
                  rangeSelectorZoom:"范围",
                  loading:'加载中...',
                  shortMonths:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                  weekdays:['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
                },
                colors: ['#5f97f6', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
          });
          $.getJSON('http://cfd-webapi.chinacloudapp.cn/api/security/'+securityId, function (result) {
             $(".title").html(result.name);
             draw(securityId,result.open);
          })
    });

    function draw(secId,yesterdayClose) {
        $.getJSON('http://cfd-webapi.chinacloudapp.cn/api/quote/'+ secId +'/tick/today', function (result) {
              //console.log(result);
              data = new Array();
              $.each(result, function (i, tick) {
                var t = new Date(tick.time);

                // if(i==0){
                //   avg_pxyAxisMin = tick.p;
                //   avg_pxyAxisMax = tick.p;
                // }
                // else {
                //   avg_pxyAxisMin = avg_pxyAxisMin > tick.p ? tick.p : avg_pxyAxisMin ;
                //   avg_pxyAxisMax = avg_pxyAxisMax > tick.p ? avg_pxyAxisMax : tick.p ;
                // }
                data.push([t.getTime(), tick.p]);
              //Date.UTC(year,month,day,hours,minutes,seconds,millisec)
              //通过UTC方式获取指定时间的毫秒数，例如获取 2013-11-14 00:00:00的毫秒数代码如下：
              //time = Date.UTC(2013,11,14,0,0,0,0); // time = 1386979200000 (ms);
              //data.push([tick.time, tick.p]);
              });
              $('#container0').highcharts('StockChart', {
               title: {
                text: ''
               },
               scrollbar: {
                enabled: false
               },
               navigator: {
                enabled: false
               },
               subtitle: {
                text: ''
               },
               chart: {
                spacing: [5, 5, 5, 5],
                plotShadow: true,
               },
               rangeSelector : {
                buttons : [{
                    type : 'hour',
                    count : 1,
                    text : '1h'
                  },{
                  type : 'day',
                  count : 1,
                  text : '1D'
                  }],
                enabled: false,
                selected : 1,
                inputEnabled : false
              },
              yAxis: [{
                opposite: false,
                //minTickInterval:0.001,
                //minorTickInterval:0.001,
                gridLineColor: '#FFF',
                gridLineWidth: 0.2,
                top:'5%',
                height: '90%',
                showFirstLabel: true,
                showLastLabel:true,
                labels: {
                  align: 'left',
                  x: 1,
                  y: -3,
                },
              },{
                opposite: true,
                gridLineColor: '#FFF',
                gridLineWidth: 0.2,
                top:'5%',
                height: '90%',
                showFirstLabel: true,
                showLastLabel:true,
                labels: {
                    // align: 'left',
                    // x: 1,
                    // y: 1,
                    formatter:function(){
                        //return  this.value;
                        //(100*(this.value-yesterdayClose)/yesterdayClose).toFixed(2)+"%";
                        return (100*(this.value/yesterdayClose-1)).toFixed(2)+"%";
                      }
                    },
              }],
              xAxis: {
                  // type: 'datetime',
                  // tickLength: 0,
                  lineColor: 'transparent',
                  tickColor: "transparent",
                  labels: {
                    formatter:function(){
                      var returnTime=Highcharts.dateFormat('%H:%M ', this.value);
                      // if(returnTime=="11:30 ")
                      // {
                      //     return "11:30/13:00";
                      // }
                      return returnTime;
                    },
                  },
              // tickPositioner:function(){
              //     var positions=[am_startTimeUTC,am_midTimeUTC,am_lastTimeUTC,pm_midTimeUTC,pm_lastTimeUTC];
              //     return positions;
              // },
                  //minRange:  3600 * 1000
                  //gridLineColor: 'red',
             //   breaks: [{
             //         repeat: 24 * 36e5
             //     }]
             },
             plotOptions: {
              area:  {
                    connectNulls:true,//该设置会连接空值点
                   // gapSize:1,//缺失点小于gapSize则连接
                   enableMouseTracking: false
                 }
               },
             series : [{
                 name : 'AAPL',
                 //type: 'areaspline',
                 type: 'area',
                 data : data,
                 gapSize: 1,
                 tooltip: {
                   valueDecimals: 2
                 },
                 lineColor:"#fff",
                 lineWidth:1,
                 fillColor : {
                   linearGradient : {
                     x1: 0,
                     y1: 0,
                     x2: 0,
                         y2: 0.9 //渐变区域阀值
                       },
                       stops : [
                       [0, Highcharts.getOptions().colors[0]],
                       [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                       ]
                     },
                     threshold: null
                   },
                   {
                    name : 'AAPL Stock Price',
                    data : data,
                    type : 'scatter',
                    cursor:'pointer',
                    onSeries : 'candlestick',
                    color:'transparent',
                    tooltip : {
                      valueDecimals : 2
                    },
                    style:{
                     fontSize: '0px',
                     fontWeight: '0',
                     textAlign: 'center'
                   },
                   zIndex:-1000,
                   yAxis:1,
               }]
           });
      });
  }

    function draw2(secId,yesterdayClose) {
        $.getJSON('http://cfd-webapi.chinacloudapp.cn/api/quote/'+ secId +'/tick/week', function (result) {
              //console.log(result);
              data = new Array();
              $.each(result, function (i, tick) {
                var t = new Date(tick.time);

                // if(i==0){
                //   avg_pxyAxisMin = tick.p;
                //   avg_pxyAxisMax = tick.p;
                // }
                // else {
                //   avg_pxyAxisMin = avg_pxyAxisMin > tick.p ? tick.p : avg_pxyAxisMin ;
                //   avg_pxyAxisMax = avg_pxyAxisMax > tick.p ? avg_pxyAxisMax : tick.p ;
                // }
                data.push([t.getTime(), tick.p]);
              //Date.UTC(year,month,day,hours,minutes,seconds,millisec)
              //通过UTC方式获取指定时间的毫秒数，例如获取 2013-11-14 00:00:00的毫秒数代码如下：
              //time = Date.UTC(2013,11,14,0,0,0,0); // time = 1386979200000 (ms);
              //data.push([tick.time, tick.p]);
              });
        $('#container1').highcharts('StockChart', {
               title: {
                text: ''
               },
               scrollbar: {
                enabled: false
               },
               navigator: {
                enabled: false
               },
               subtitle: {
                text: ''
               },
               chart: {
                spacing: [5, 5, 5, 5],
                plotShadow: true,
               },
               rangeSelector : {
                buttons : [{
                    type : 'hour',
                    count : 1,
                    text : '1h'
                  },{
                  type : 'day',
                  count : 1,
                  text : '1D'
                  }],
                enabled: false,
                selected : 1,
                inputEnabled : false
              },
              yAxis: [{
                opposite: false,
                //minTickInterval:0.001,
                //minorTickInterval:0.001,
                gridLineColor: '#FFF',
                gridLineWidth: 0.2,
                top:'5%',
                height: '90%',
                showFirstLabel: true,
                showLastLabel:true,
                labels: {
                  align: 'left',
                  x: 1,
                  y: -3,
                },
              },{
                opposite: true,
                gridLineColor: '#FFF',
                gridLineWidth: 0.2,
                top:'5%',
                height: '90%',
                showFirstLabel: true,
                showLastLabel:true,
                labels: {
                    // align: 'left',
                    // x: 1,
                    // y: 1,
                    formatter:function(){
                        //return  this.value;
                        //(100*(this.value-yesterdayClose)/yesterdayClose).toFixed(2)+"%";
                        return (100*(this.value/yesterdayClose-1)).toFixed(2)+"%";
                      }
                    },
              }],
              xAxis: {
                  // type: 'datetime',
                  // tickLength: 0,
                  lineColor: 'transparent',
                  tickColor: "transparent",
                  labels: {
                    formatter:function(){
                      var returnTime=Highcharts.dateFormat('%m-%d ', this.value);
                      // if(returnTime=="11:30 ")
                      // {
                      //     return "11:30/13:00";
                      // }
                      return returnTime;
                    },
                  },
              // tickPositioner:function(){
              //     var positions=[am_startTimeUTC,am_midTimeUTC,am_lastTimeUTC,pm_midTimeUTC,pm_lastTimeUTC];
              //     return positions;
              // },
                  //minRange:  3600 * 1000
                  //gridLineColor: 'red',
             //   breaks: [{
             //         repeat: 24 * 36e5
             //     }]
             },
             plotOptions: {
              area:  {
                    connectNulls:true,//该设置会连接空值点
                   // gapSize:1,//缺失点小于gapSize则连接
                   enableMouseTracking: false
                 }
               },
             series : [{
                 name : 'AAPL',
                 //type: 'areaspline',
                 type: 'area',
                 data : data,
                 gapSize: 1,
                 tooltip: {
                   valueDecimals: 2
                 },
                 lineColor:"#fff",
                 lineWidth:1,
                 fillColor : {
                   linearGradient : {
                     x1: 0,
                     y1: 0,
                     x2: 0,
                         y2: 0.9 //渐变区域阀值
                       },
                       stops : [
                       [0, Highcharts.getOptions().colors[0]],
                       [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                       ]
                     },
                     threshold: null
                   },
                   {
                    name : 'AAPL Stock Price',
                    data : data,
                    type : 'scatter',
                    cursor:'pointer',
                    onSeries : 'candlestick',
                    color:'transparent',
                    tooltip : {
                      valueDecimals : 2
                    },
                    style:{
                     fontSize: '0px',
                     fontWeight: '0',
                     textAlign: 'center'
                   },
                   zIndex:-1000,
                   yAxis:1,
               }]
           });
  });
  }
    function draw3(secId,yesterdayClose) {
        $.getJSON('http://cfd-webapi.chinacloudapp.cn/api/quote/'+ secId +'/tick/month', function (result) {
              //console.log(result);
              data = new Array();
              $.each(result, function (i, tick) {
                var t = new Date(tick.time);

                // if(i==0){
                //   avg_pxyAxisMin = tick.p;
                //   avg_pxyAxisMax = tick.p;
                // }
                // else {
                //   avg_pxyAxisMin = avg_pxyAxisMin > tick.p ? tick.p : avg_pxyAxisMin ;
                //   avg_pxyAxisMax = avg_pxyAxisMax > tick.p ? avg_pxyAxisMax : tick.p ;
                // }
                data.push([t.getTime(), tick.p]);
              //Date.UTC(year,month,day,hours,minutes,seconds,millisec)
              //通过UTC方式获取指定时间的毫秒数，例如获取 2013-11-14 00:00:00的毫秒数代码如下：
              //time = Date.UTC(2013,11,14,0,0,0,0); // time = 1386979200000 (ms);
              //data.push([tick.time, tick.p]);
              });

          $('#container2').highcharts('StockChart', {
               title: {
                text: ''
               },
               scrollbar: {
                enabled: false
               },
               navigator: {
                enabled: false
               },
               subtitle: {
                text: ''
               },
               chart: {
                spacing: [5, 5, 5, 5],
                plotShadow: true,
               },
               rangeSelector : {
                buttons : [{
                    type : 'hour',
                    count : 1,
                    text : '1h'
                  },{
                  type : 'day',
                  count : 1,
                  text : '1D'
                  }],
                enabled: false,
                selected : 1,
                inputEnabled : false
              },
              yAxis: [{
                opposite: false,
                //minTickInterval:0.001,
                //minorTickInterval:0.001,
                gridLineColor: '#FFF',
                gridLineWidth: 0.2,
                top:'5%',
                height: '90%',
                showFirstLabel: true,
                showLastLabel:true,
                labels: {
                  align: 'left',
                  x: 1,
                  y: -3,
                },
              },{
                opposite: true,
                gridLineColor: '#FFF',
                gridLineWidth: 0.2,
                top:'5%',
                height: '90%',
                showFirstLabel: true,
                showLastLabel:true,
                labels: {
                    // align: 'left',
                    // x: 1,
                    // y: 1,
                    formatter:function(){
                        //return  this.value;
                        //(100*(this.value-yesterdayClose)/yesterdayClose).toFixed(2)+"%";
                        return (100*(this.value/yesterdayClose-1)).toFixed(2)+"%";
                      }
                    },
              }],
              xAxis: {
                  // type: 'datetime',
                  // tickLength: 0,
                  lineColor: 'transparent',
                  tickColor: "transparent",
                  labels: {
                    formatter:function(){
                      var returnTime=Highcharts.dateFormat('%m-%d ', this.value);
                      // if(returnTime=="11:30 ")
                      // {
                      //     return "11:30/13:00";
                      // }
                      return returnTime;
                    },
                  },
              // tickPositioner:function(){
              //     var positions=[am_startTimeUTC,am_midTimeUTC,am_lastTimeUTC,pm_midTimeUTC,pm_lastTimeUTC];
              //     return positions;
              // },
                  //minRange:  3600 * 1000
                  //gridLineColor: 'red',
             //   breaks: [{
             //         repeat: 24 * 36e5
             //     }]
             },
             plotOptions: {
              area:  {
                    connectNulls:true,//该设置会连接空值点
                   // gapSize:1,//缺失点小于gapSize则连接
                   enableMouseTracking: false
                 }
               },
             series : [{
                 name : 'AAPL',
                 //type: 'areaspline',
                 type: 'area',
                 data : data,
                 gapSize: 1,
                 tooltip: {
                   valueDecimals: 2
                 },
                 lineColor:"#fff",
                 lineWidth:1,
                 fillColor : {
                   linearGradient : {
                     x1: 0,
                     y1: 0,
                     x2: 0,
                         y2: 0.9 //渐变区域阀值
                       },
                       stops : [
                       [0, Highcharts.getOptions().colors[0]],
                       [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                       ]
                     },
                     threshold: null
                   },
                   {
                    name : 'AAPL Stock Price',
                    data : data,
                    type : 'scatter',
                    cursor:'pointer',
                    onSeries : 'candlestick',
                    color:'transparent',
                    tooltip : {
                      valueDecimals : 2
                    },
                    style:{
                     fontSize: '0px',
                     fontWeight: '0',
                     textAlign: 'center'
                   },
                   zIndex:-1000,
                   yAxis:1,
               }]
           });
  });
  }
</script>
</body>
</html>
