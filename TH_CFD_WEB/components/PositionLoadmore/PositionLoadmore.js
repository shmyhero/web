var React = require("react");
var LogicData = require("LogicData");
var NetConstants = require("NetConstants");
var Storage = require("Storage");
var TipConfirm = require("TipConfirm");
var Base = require("Base");
var height = $(".slider-inner").height();
var extendHeight = 0;
var Slider = require('react-rangeslider');
var ischecked =false;
var ischecked1 =false;
var isendtakeOID=false; //已开启止盈 关闭后删除
var  isdraw1 =true,isdraw2 =true,isdraw3 =true, securityId='',yesterdayClose='';
function draw(secId,yesterdayClose){
      $.getJSON('http://cfd-webapi.chinacloudapp.cn/api/quote/'+ secId +'/tick/today', function (result) {
            //console.log(result);
            var data = new Array();
            $.each(result, function (i, tick) {
              var t = new Date(tick.time);
              data.push([t.getTime(), tick.p]);

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
              spacing: [1, 5, 1, 5],
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
              height: '93%',
              showFirstLabel: true,
              showLastLabel:true,
              labels: {
                align: 'left',
                style: {"color":"#7d7d7d"},
                x: 1,
                y: -3,
              },
            },{
              opposite: true,
              gridLineColor: '#FFF',
              gridLineWidth: 0.2,
              top:'5%',
              height: '93%',
              showFirstLabel: true,
              showLastLabel:true,
              labels: {
                  style: {"color":"#7d7d7d"},
                  formatter:function(){

                      return (100*(this.value/yesterdayClose-1)).toFixed(2)+"%";
                    }
                  },
            }],
            xAxis: {

                lineColor: 'transparent',
                tickColor: "transparent",
                labels: {
                  style: {"color":"#7d7d7d"},
                  formatter:function(){
                    var returnTime=Highcharts.dateFormat('%H:%M ', this.value);
                    return returnTime;
                  },
                },
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
                   y2: 0 //渐变区域阀值
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
function draw1(secId,yesterdayClose){
      $.getJSON('http://cfd-webapi.chinacloudapp.cn/api/quote/'+ secId +'/tick/week', function (result) {
            //console.log(result);
            var data = new Array();
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
              spacing: [1, 5, 1, 5],
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
              height: '93%',
              showFirstLabel: true,
              showLastLabel:true,
              labels: {
                align: 'left',
                style: {"color":"#7d7d7d"},
                x: 1,
                y: -3,
              },
            },{
              opposite: true,
              gridLineColor: '#FFF',
              gridLineWidth: 0.2,
              top:'5%',
              height: '93%',
              showFirstLabel: true,
              showLastLabel:true,
              labels: {
                  // align: 'left',
                  // x: 1,
                  // y: 1,
                  style: {"color":"#7d7d7d"},
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
                  style: {"color":"#7d7d7d"},
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
                   y2: 0 //渐变区域阀值
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
function draw2(secId,yesterdayClose){
      $.getJSON('http://cfd-webapi.chinacloudapp.cn/api/quote/'+ secId +'/tick/month', function (result) {
            //console.log(result);
            var data = new Array();
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
              spacing: [1, 5, 1, 5],
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
              height: '93%',
              showFirstLabel: true,
              showLastLabel:true,
              labels: {
                align: 'left',
                style: {"color":"#7d7d7d"},
                x: 1,
                y: -3,
              },
            },{
              opposite: true,
              gridLineColor: '#FFF',
              gridLineWidth: 0.2,
              top:'5%',
              height: '93%',
              showFirstLabel: true,
              showLastLabel:true,
              labels: {
                  // align: 'left',
                  // x: 1,
                  // y: 1,
                  style: {"color":"#7d7d7d"},
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
                  style: {"color":"#7d7d7d"},
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
                   y2: 0 //渐变区域阀值
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
var PositionLoadmore = React.createClass({
    propTypes :{
        loadingTitle    : React.PropTypes.string,                              //加载标题
        dataURL         : React.PropTypes.string,                             //数据url
        loadoverTitle   : React.PropTypes.string,                              //加载完成标题
        hasMore         : React.PropTypes.bool,                              //还有更多
        header          : React.PropTypes.bool,                               //涨跌榜
        isOwnStockPage: React.PropTypes.bool,                                //自选
        loadCallBack    : React.PropTypes.func                             //回调函数
    },
    getInitialState : function(){
        return {
            stockInfo: [],
            rowStockInfoData: [],
            selectedRow: -1,
            selectedSubItem: 0,
            stockDetailInfo: [],
            showSlider1: false,
            showSlider2: false,
            showstopPx: false,
            showtakePx: false,
            showokPress1: false,
            showokPress2: false,
            okPress: true,
            okPressorder: false,
            showExchangeDoubleCheck: false,
            value: 0,
            valuemax: 100,
            valuemin: 0,
            value1: 0,
            value1max: 100,
            value1min: 0,
        };
    },
    getDefaultProps : function(){
        return {
            elements : [],
            isLoading : false,
            isOwnStockPage: false,
            hasMore : false,
            header : false,
            isGainer : true,
            loadingTitle  : "正在加载更多. . . ",
            loadoverTitle : "没有更多信息. . . "
        }
    },
    getShownStocks: function() {
        var result = ''
        for (var i = 0; i < this.state.rowStockInfoData.length; i++) {
            result += ( this.state.rowStockInfoData[i].security.id + ',')
        };

        result = result.substring(0, result.length - 1);
        return result
    },
    handleStockInfo: function(realtimeStockInfo) {

        var hasUpdate = false
        for (var i = 0; i < this.state.rowStockInfoData.length; i++) {

            for (var j = 0; j < realtimeStockInfo.length; j++) {

                if (this.state.rowStockInfoData[i].security.id == realtimeStockInfo[j].id &&
                            this.state.rowStockInfoData[i].security.last !== realtimeStockInfo[j].last) {
                    this.state.rowStockInfoData[i].security.last = realtimeStockInfo[j].last;
                    this.state.rowStockInfoData[i].security.ask = realtimeStockInfo[j].ask;
                    this.state.rowStockInfoData[i].security.bid = realtimeStockInfo[j].bid;
                    hasUpdate = true;
                    break;
                }
            };
        };

        if (hasUpdate) {

            this.setState({
                stockInfo: this.state.rowStockInfoData
            })
        }
    },
    handleChange: function(value) {
        //e.stopImmediatePropagation();
        //console.log(value);
        //$(".slider-inner").css('pointer-events','none');

        this.setState({
            value: value,
        });
    },
    handleChange1: function(value) {
        this.setState({
            value1: value,
        });
    },
    componentWillMount:function(){
            var userData = LogicData.getUserData();
            if(this.props.isOwnStockPage) {
               $.ajax({
                url : 'http://cfd-webapi.chinacloudapp.cn/api/position/open',
                headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                data : null,
                dataType : 'json',
                async : false,
                success : function(data) {

                    $('.spinner').removeClass('active');
                    this.setState({
                       rowStockInfoData: data,
                       stockInfo: data
                   })
                }.bind(this),
                error : function(XMLHttpRequest,textStatus, errorThrown) {
                    $('.spinner').removeClass('active');
                    console.log(XMLHttpRequest);
                }
            });
           }
    },
    stockPressed: function(rowData, rowID) {
        ischecked =false;
        ischecked1 =false;
        isendtakeOID=false;
        this.setState({
            showExchangeDoubleCheck: false,
            showSlider1: false,
            showSlider2: false,
            showstopPx: false,
            showtakePx: false,
            showokPress1: false,
            showokPress2: false,
            okPress: true,
            okPressorder: false,
            value: 0,
            valuemax: 100,
            valuemin: 0,
            value1: 0,
            value1max: 100,
            value1min: 0,
        })
        var newData = []

        $.extend(true, newData, this.state.rowStockInfoData)    // deep copy

        if (this.state.selectedRow == rowID) {

            newData[rowID].hasSelected = false
            this.setState({
                stockInfo: newData,
                selectedRow: -1,
                selectedSubItem: 0,
                rowStockInfoData: newData
            })
        } else {
            // var maxY = (height-100)*20/21 - extendHeight
            // var listHeight = $(".slider-inner").height();
            if (this.state.selectedRow >=0) {
                newData[this.state.selectedRow].hasSelected = false
                //listHeight -= extendHeight
            }
            // var currentY = listHeight/newData.length*(parseInt(rowID)+1)
            // if (currentY > maxY && parseInt(this.state.selectedRow) < parseInt(rowID)) {

            //     $("#tab-content").scrollTop(Math.floor(currentY-maxY))
            // }

            newData[rowID].hasSelected = true
            this.setState({
                stockInfo: newData,
                selectedRow: rowID,
                selectedSubItem: 0,
                rowStockInfoData: newData,
            })
        }
    },

    subItemPress: function(item, rowData) {
        //LayoutAnimation.configureNext(LayoutAnimation.Presets.easeInEaseOut);
        this.setState({
            selectedSubItem: this.state.selectedSubItem === item ? 0 : item,
        })

        if (item === 2) {
            var stockid = rowData.security.id
            this.setState({
                stockDetailInfo: rowData.security
            })
            this.loadStockDetailInfo(stockid)
        }
    },
    okPress: function(rowData) {

        if (this.state.showExchangeDoubleCheck === false) {
            this.setState({
                showExchangeDoubleCheck: true,

            })
            return
        }
        $('.spinner').addClass('active');
        var userData = LogicData.getUserData()
        $.ajax({
                 url : NetConstants.POST_DELETE_POSITION_API,
                 type: 'POST',
                 headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                 data : {'posId':rowData.id,'securityId':rowData.security.id,'isPosLong':rowData.isLong,'posQty':rowData.quantity},
                 dataType : 'json',
                 //async : false,
                 success : function(data) {
                    $('.spinner').removeClass('active');
                    data.stockName = rowData.security.name;
                    data.isCreate = false;
                    data.isLong = rowData.isLong;
                    data.createAt = new Date(data.createAt);
                    data.invest = rowData.invest;
                    this.refs['confirmPage'].show(data);
                     $(".pop").show();
                    }.bind(this),
                 error : function(XMLHttpRequest,textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                    this.refs['confirmTip'].show(JSON.parse(XMLHttpRequest.responseText).Message)
                    $(".pop").show();
                 }
            });
    },
  percentToPrice: function(percent, basePrice, leverage, type, isLong) {
    if (type === 1) {
      // 止盈
      return isLong ? basePrice * (1+percent/100/leverage) : basePrice * (1-percent/100/leverage)
    }
    else {
      // 止损
      return isLong ? basePrice * (1-percent/100/leverage) : basePrice * (1+percent/100/leverage)
    }
  },
  percentToPriceWithRow: function(percent, rowData, type) {
    var leverage = rowData.leverage === 0 ? 1 : rowData.leverage
    return this.percentToPrice(percent, rowData.settlePrice, leverage, type, rowData.isLong)
  },
  priceToPercent: function(price, basePrice, leverage, type, isLong) {
    if (type === 1) {
      return (price-basePrice)/basePrice*100*leverage * (isLong?1:-1)
    }
    else {
      return (basePrice-price)/basePrice*100*leverage * (isLong?1:-1)
    }
  },
  priceToPercentWithRow: function(price, rowData, type) {
    var leverage = rowData.leverage === 0 ? 1 : rowData.leverage
    return this.priceToPercent(price, rowData.settlePrice, leverage, type, rowData.isLong)
  },
  okPressorder: function(rowData) {
        $('.spinner').addClass('active');
        var userData = LogicData.getUserData();
        console.log(this.state.value);
        var price = this.percentToPriceWithRow(this.state.value, rowData, 1)
        //止盈
        if(this.state.showSlider1){

            if(rowData.takeOID === undefined){
              //新建止盈
              $.ajax({
                     url : NetConstants.ADD_REMOVE_STOP_PROFIT_API,
                     type: 'POST',
                     headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                     data : {'posId':rowData.id,'securityId':rowData.security.id,'price':price},
                     dataType : 'json',
                     //async : false,
                     beforeSend:function(XMLHttpRequest){

                     },
                     success : function(data) {
                        $('.spinner').removeClass('active');
                        }.bind(this),
                     error : function(XMLHttpRequest,textStatus, errorThrown) {
                        console.log(XMLHttpRequest);
                        $('.spinner').removeClass('active');
                     }
                });
              }
             else{
                //修改止盈
                console.log('修改止盈'+price);
                $.ajax({
                     url : NetConstants.STOP_PROFIT_LOSS_API,
                     type: 'PUT',
                     headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                     data : {'posId':rowData.id,'securityId':rowData.security.id,'price':price,'orderId':rowData.takeOID},
                     dataType : 'json',
                     //async : false,
                     success : function(data) {
                        $('.spinner').removeClass('active');
                        }.bind(this),
                     error : function(XMLHttpRequest,textStatus, errorThrown) {
                        console.log(XMLHttpRequest);
                        $('.spinner').removeClass('active');
                     }
                });
              }
        }else{
          //删除止盈
           if(rowData.takeOID !== undefined){
            $.ajax({
                 url : NetConstants.ADD_REMOVE_STOP_PROFIT_API,
                 type: 'DELETE',
                 headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                 data : {'posId':rowData.id,'securityId':rowData.security.id,'orderId':rowData.takeOID},
                 dataType : 'json',
                 //async : false,
                 success : function(data) {

                       $('.spinner').removeClass('active');
                    }.bind(this),
                 error : function(XMLHttpRequest,textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                    $('.spinner').removeClass('active');
                 }
            });
           }
        }
        //止损
        if(this.state.showSlider2){
          //修改止损
          $.ajax({
                 url : NetConstants.STOP_PROFIT_LOSS_API,
                 type: 'PUT',
                 headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                 data : {'posId':rowData.id,'securityId':rowData.security.id,'orderId':rowData.stopOID,'price':this.percentToPriceWithRow(this.state.value1, rowData, 2)},
                 dataType : 'json',
                 //async : false,
                 success : function(data) {
                    $('.spinner').removeClass('active');
                    }.bind(this),
                 error : function(XMLHttpRequest,textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                    $('.spinner').removeClass('active');
                 }
            });
        }

  },
  loadOpenPositionInfo: function() {
        var userData = LogicData.getUserData()
        $.ajax({
                url :  NetConstants.GET_OPEN_POSITION_API,
                headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                data : null,
                dataType : 'json',
                async : false,
                success : function(responseJson) {
                    this.setState({
                        stockInfoRowData: responseJson,
                        stockInfo: responseJson,
                        rowStockInfoData: responseJson,
                        selectedRow: -1,
                        selectedSubItem: 0
                    })
                }.bind(this),
                error : function(XMLHttpRequest,textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                }
            });
  },
  loadStockDetailInfo: function(stockCode) {
        var userData = LogicData.getUserData();
        var url = NetConstants.GET_STOCK_PRICE_TODAY_API
        url = url.replace(/<stockCode>/, stockCode)
        $.ajax({
                url :  url,
                headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                data : null,
                dataType : 'json',
                async : false,
                success : function(responseJson) {
                    console.log(responseJson);
                    var tempStockInfo = this.state.stockDetailInfo
                    tempStockInfo.priceData = responseJson
                    this.setState({
                        stockDetailInfo: tempStockInfo,
                    })
                }.bind(this),
                error : function(XMLHttpRequest,textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                }
            });
  },
  showCallback : function(){
                console.log('showCallback');
                this.loadOpenPositionInfo();
  },
  slideThreeclick : function() {

        if($("#slideThree").prop("checked")){
           // on
           console.log('on');
           $(".slideThreeclick").css('background','#1a61dd');
           this.setState({ showtakePx: false })

        }else{
          console.log('off');
           $(".slideThreeclick").css('background','#fff');
           this.setState({ showtakePx: true })
         }
         ischecked=true;
  },
  slideThreeclick1 : function() {

        if($("#slideThree1").prop("checked")){
           //on
           console.log('on1');
           $(".slideThreeclick1").css('background','#1a61dd');
            this.setState({ showstopPx: true })
        }else{
          //off
           console.log('off1');
          $(".slideThreeclick1").css('background','#fff');
          this.setState({  showstopPx: false })
         }
         ischecked1=true;
  },
  tabclick : function(index) {
        if(index===0){
             //
             $("#tab0").removeClass('border');
             $("#tab0").addClass('borderon');

             $("#tab1").removeClass('borderon1');
             $("#tab1").addClass('border');

             $("#tab2").addClass('border');

             $(".tick-list").show();
             $(".contcontainer1").show();
             $(".contcontainer2").hide();
             $(".slideThree").hide();
             $(".Sliderdiv").hide();

             if(isdraw1){
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
                 isdraw1=false;
                 draw(securityId,yesterdayClose);
             }

            this.setState({
                 showokPress1: true,
                 showokPress2:false
            });
        }
        if(index===1){
             $(".contcontainer2").show();
             $("#tab1").removeClass('border');
             $("#tab1").addClass('borderon1');

             $("#tab0").removeClass('borderon');
             $("#tab0").addClass('border');

             $("#tab2").addClass('border');

             $(".tick-list").hide();
             $(".contcontainer1").hide();

             $(".slideThree").show();
             $(".Sliderdiv").show();

             this.setState({
                 showokPress1: false,
                 showokPress2:true
            });
        }
  },
  ticktab1itemclick : function(index) {

                   $(".yo-ticktab1 li").removeClass('item-on');
                   $(".yo-ticktab1 #li"+index).addClass('item-on');
                   $(".char").removeClass('container ');
                   $("#container"+index).addClass('container');
                    switch(index)
                        {
                        case 0:
                            $("#container0").removeClass('none');
                            $("#container1").addClass('none');
                            $("#container2").addClass('none');
                         break;
                        case 1:
                            if(isdraw2){
                              draw1(securityId,yesterdayClose);
                              isdraw2=false;
                            }
                            $("#container0").addClass('none');
                            $("#container1").removeClass('none');
                            $("#container2").addClass('none');
                         break;
                        case 2:
                            $("#container0").addClass('none');
                            $("#container1").addClass('none');
                            $("#container2").removeClass('none');
                            if(isdraw3){
                              draw2(securityId,yesterdayClose);
                              isdraw3=false;
                            }
                         break;
                       }
  },
  getLastPrice: function(rowData) {
    var lastPrice = rowData.isLong ? rowData.security.ask : rowData.security.bid
    return lastPrice === undefined ? rowData.security.last : lastPrice
  },
  renderDetailInfo: function(rowData) {
        var ischeckImage=false;
        isdraw1 =true,isdraw2 =true,isdraw3 =true;
        securityId=rowData.security.id;
        yesterdayClose=rowData.security.preClose;
        var buttonEnable = true
        var tradeImage = !rowData.isLong ? './images/dark_up.png' : './images/dark_down.png';

        var profitAmount = rowData.upl
        if (rowData.settlePrice !== 0) {
          var lastPrice = this.getLastPrice(rowData)

          var profitPercentage = (lastPrice - rowData.settlePrice) / rowData.settlePrice
          if (!rowData.isLong) {
            profitPercentage *= (-1)
          }
          profitAmount = profitPercentage * rowData.invest * rowData.leverage
        }

        var buttonText = (profitAmount < 0 ? '亏损':'获利') + ':$' + profitAmount.toFixed(2)
        if (this.state.showExchangeDoubleCheck) {
          buttonText = '确认:$' + profitAmount.toFixed(2)
        }


        var showNetIncome = false,
        extendHeight = 222;
        // if (showNetIncome) {
        //     extendHeight += 20
        // }
        // if (this.state.selectedSubItem === 1) {
        //     extendHeight += 51
        // }
        // if (this.state.selectedSubItem === 2) {
        //     extendHeight += 170
        // }
        // if (this.state.showExchangeDoubleCheck) {
        //     extendHeight += 28
        // }

        if(rowData.takeOID !== undefined||this.priceToPercentWithRow(rowData.stopPx, rowData, 2) <= 90){
          ischeckImage=true;
        }
        var checkImage = ischeckImage ? './images/check2.png' : './images/check.png';
        if( this.state.showokPress2) {
              if(rowData.takeOID !== undefined&&!this.state.showSlider1)
              {
                //console.log(this.priceToPercentWithRow(rowData.takePx, rowData, 1).toFixed(0));
                this.state.value = parseInt(this.priceToPercentWithRow(rowData.takePx, rowData, 1).toFixed(0));
                //this.state.valuemin=
                // this.setState({
                //   value: this.priceToPercentWithRow(rowData.takePx, rowData, 1),
                //   valuemax: 100,
                //   valuemin: 0 })
                 isendtakeOID=true;
                 this.state.showSlider1 = true;
                 $("#slideThree").attr("checked", true);
                 $(".slideThreeclick").css('background','#1a61dd');
              }

              if(ischecked) {
                if(this.state.showtakePx)
                {
                     this.state.showSlider1=false;
                }else{
                     this.state.showSlider1=true;
                }
              }

            if(this.priceToPercentWithRow(rowData.stopPx, rowData, 2) <= 90 &&!this.state.showSlider2){

                this.state.value1=parseInt(this.priceToPercentWithRow(rowData.stopPx, rowData, 2).toFixed(0));
                //this.state.value1min=

                this.state.showSlider2=true;
                $("#slideThree1").attr("checked", true);
                $(".slideThreeclick1").css('background','#1a61dd');
            }
            if(ischecked1){
                if(this.state.showstopPx)
                {
                     this.state.showSlider2=true;
                }else{
                     this.state.showSlider2=false;
                }
            }

            if(this.state.showSlider1||this.state.showSlider2||isendtakeOID)
            {
              this.state.okPressorder=true;
              this.state.okPress=false;

            }else{
               this.state.okPressorder=false;
               this.state.okPress=true;
            }


          //设置当前止盈止损线
          // if(this.state.showSlider1){


          // }

        }else{
               this.state.okPressorder=false;
               this.state.okPress=true;
          }
        var Slider1 = !this.state.showSlider1  ? null : (<li className="item5 Grid">
                  <div className="last1 Grid-cell u-full " >
                        <Slider value={this.state.value} onChange = {this.handleChange} />  <div className="span1">{this.state.valuemin}%</div>     <div className="span2">{this.state.valuemax}%</div>
                  </div>
            </li>);

        var Slider2 = !this.state.showSlider2  ? null :( <li className="item5 Grid">
                 <div className="last1 Grid-cell u-full " >
                  <Slider value={this.state.value1} min={this.state.value1min} max={this.state.value1max} onChange = {this.handleChange1} />  <div className="span1">-{this.state.value1min}%</div>     <div className="span2">-{this.state.value1max}%</div>
                 </div>
            </li>);

         var okPress1 = this.state.okPress  ? ( <li className="item2 centerText okPress1">
                <div className=" centerText ">
                {showNetIncome ?
                <div className=" netIncomeText">净收益:9.26</div>
                : null}
                <div className="name">
                <input type="button" onClick={() => this.okPress(rowData)} value={buttonText} className={"yo-btn " +(this.state.showExchangeDoubleCheck  ? "yo-btn-upl1" : "yo-btn-upl")  } />
                </div>
                {this.state.showExchangeDoubleCheck ?
                    <div className=" feeText">平仓费：0</div> :
                    null}
                </div>
            </li>) : null;

         var okPress2 =   this.state.okPressorder ? ( <li className="item2 centerText okPress2">
                <div className=" centerText ">
                <div className="name">
                <input type="button" onClick={() => this.okPressorder(rowData)} value="确定" className="yo-btn yo-btn-upl" />
                </div>
                </div>
            </li>) : null ;

        return (
            <ul className="yo-list">
            <li className="item1 Grid">
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name">类型</div>
                    <img className="symbol" src ={tradeImage} />
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name aligncenter">本金</div>
                    <div className="symbol aligncenter">{rowData.invest.toFixed(2)}</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name alignright">杠杆</div>
                    <div className="symbol alignright">{rowData.leverage}</div>
                </div>
            </li>
            <li className="item1 Grid">
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name">开仓价格</div>
                    <div className="symbol extendTextBottom">{rowData.settlePrice}</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name extendTextTop aligncenter">当前价格</div>
                    <div className="symbol extendTextBottom aligncenter">{rowData.security.last}</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name extendTextTop alignright">价差</div>
                    <div className="symbol extendTextBottom alignright">{(lastPrice - rowData.settlePrice).toFixed(rowData.security.dcmCount)}</div>
                </div>
            </li>
            <li className="item5 Grid" >
                <div className="last1 Grid-cell u-1of3 " id="tab0" onClick={() => this.tabclick(0)} >
                    <div className="name">行情</div>
                   <img className="symbol" src ="./images/market.png" />
                </div>
                <div className="last1 Grid-cell u-1of3  centerText " id="tab1" onClick={() => this.tabclick(1)} >
                    <div className="name extendTextTop aligncenter">止盈/止损</div>
                    <img className="symbol" src ={checkImage} />
                </div>
                <div className="last1 Grid-cell u-1of3 " id="tab2"  >
                    <div className="name extendTextTop aligncenter">&nbsp;</div>
                     <div className=" extendTextBottom alignright">&nbsp;</div>
                </div>
            </li>
            <section className="tick-list ">
                    <ul className="yo-ticktab1 ">
                        <li className="item item-on" id="li0" onClick={() => this.ticktab1itemclick(0)}>时分</li>
                        <li className="item " id="li1" onClick={() => this.ticktab1itemclick(1)}>5日</li>
                        <li className="item " id="li2" onClick={() => this.ticktab1itemclick(2)}>1月</li>
                   </ul>
            </section>
            <div className="yo-group yo-list contcontainer1 ">
                    <div id="container0" className="char container " ></div>
                    <div id="container1" className="char " ></div>
                    <div id="container2" className="char " ></div>
            </div>
          <ul className="yo-list contcontainer2">
          <li className="item5 Grid">
           <div className="last1 Grid-cell u-1of41 ">
                止盈
            </div>
             <div className="last1 Grid-cell u-1of5 risePercent">{!this.state.showSlider1  ? null : this.state.value+'%' }
                </div>
                <div className="last1 Grid-cell u-1of5 ">{ !this.state.showSlider1  ? null : rowData.isLong ? (rowData.settlePrice * (1+this.state.value/100/(rowData.leverage === 0 ? 1 : rowData.leverage))).toFixed(2) : (rowData.settlePrice * (1-this.state.value/100/(rowData.leverage === 0 ? 1 : rowData.leverage))).toFixed(2) }

                </div>
            <div className="last1 Grid-cell u-1of4">
                  <div className="slideThree slideThreeclick" >
                          <input type="checkbox" value="None" id="slideThree" name="check"  onClick={this.slideThreeclick}  />
                          <label htmlFor="slideThree"></label>
                        </div>
                  </div>
            </li>
            {Slider1}
            <li className="item5 Grid">
               <div className="last1 Grid-cell u-1of41 " >
                    止损
                </div>
                <div className="last1 Grid-cell u-1of5 fallPercent" >  { !this.state.showSlider2  ? null :'-'+this.state.value1+'%'}
                </div>
                <div className="last1 Grid-cell u-1of5 " > {!this.state.showSlider2  ? null : rowData.isLong ? (rowData.settlePrice * (1-this.state.value1/100/(rowData.leverage === 0 ? 1 : rowData.leverage))).toFixed(2) : (rowData.settlePrice * (1+this.state.value1/100/(rowData.leverage === 0 ? 1 : rowData.leverage))).toFixed(2) }
                </div>
                <div className="last1 Grid-cell u-1of4" >
                      <div className="slideThree slideThreeclick1" >
                              <input type="checkbox" value="None" id="slideThree1" name="check" onClick={this.slideThreeclick1} />
                              <label htmlFor="slideThree1"></label>
                            </div>
                      </div>
            </li>
            {Slider2}
           </ul>
            {okPress1}
            {okPress2}
            </ul>
            );

  },
  renderLoadingText: function() {
      if(this.state.stockInfo.length === 0) {
        return (
          <div >
            <span >暂无持仓记录</span>
          </div>
          )
      }
    },
  render : function(){
    var o = this;

    var newElements = this.state.stockInfo.map(function(rowData,index){
            var currency = rowData.security.tag ===undefined ?  null :  ( <span className="currency">US</span> );
            var profitPercentage = 0
            if (rowData.settlePrice !== 0) {
              profitPercentage = (rowData.security.last - rowData.settlePrice) / rowData.settlePrice * rowData.leverage
              if (!rowData.isLong) {
                profitPercentage *= (-1)
              }
            }
            if(this.state.selectedRow === index) {
                return (
                    <li className="item2 " key={index} >
                        <ul className="yo-list">
                            <li className="item1 Grid" onClick={o.stockPressed.bind(this,rowData,index)}>
                                <div className="last Grid-cell u-1" >
                                    <div className="name"> {rowData.security.name} </div>
                                    <div className="symbol">{currency} {rowData.security.symbol}</div>
                                </div>
                                <div className={"Percent Grid-cell u-1of51 "+( profitPercentage === 0 ? "stopPercent" : profitPercentage > 0 ? "risePercent" :"fallPercent")   }>
                                {(profitPercentage*100).toFixed(2)}%
                                </div>
                            </li>
                            <li>
                             {o.renderDetailInfo(rowData)}
                            </li>
                        </ul>
                    </li>
                    )
            }else{
               return (
                    <li className="item Grid" key={index}   onClick={o.stockPressed.bind(this,rowData,index)}>
                        <div className="last Grid-cell u-1" >
                        <div className="name"> {rowData.security.name} </div>
                        <div className="symbol">{currency} {rowData.security.symbol}</div>
                        </div>
                        <div className={"Percent Grid-cell u-1of51 "+(  profitPercentage === 0 ? "stopPercent1" : profitPercentage > 0 ? "risePercent1" :"fallPercent1")   }>
                        {(profitPercentage*100).toFixed(2)}%
                        </div>
                    </li>
                    )
            }
    }, this);
    var elements=[];
    elements.push(newElements);
        return (
            <section className="m-list scroll-in" ref="listview" >
            {this.renderLoadingText()}
            <ul className="yo-list">
                {elements}

            </ul>
            <TipConfirm ref='confirmPage' callback={this.showCallback} />
            </section>
            )
    }
})

module.exports =  PositionLoadmore;
