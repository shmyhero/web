//highstock K线图
var SfChart = function(divID,result){

	var firstTouch = true;
	
	var  open,high,low,close,y,zs,relativeWidth; 
	//定义数组highcharts
	var ohlcArray = [],volumeArray = [],data=[];
	var getDateUTCOrNot = 	function (date) {
		 
		  var Milliseconds=0;
		  var id = parseInt(date); 
		  var myDate = new Date();
		  var oldTime = (new Date(myDate.toLocaleDateString())).getTime(); 
		  if(id <=120)
			  {
			      //9:30起始
			  	  Milliseconds = (9.5*60 + id)*60*1000;
			  }else
			  {
				  Milliseconds = (13*60 + id - 121)*60*1000; //13点起始
			  }
		  var dateUTC=oldTime + Milliseconds;
//		  var newTime = new Date(dateUTC);
//		  console.log(newTime);
	      return  dateUTC ;
	}	
	var showTips = 	function (minTime,maxTime,chart){

		chart.showLoading();
		//定义当前时间区间中最低价的最小值，最高价的最大值 以及对应的时间
		var lowestPrice,highestPrice,array=[],highestArray=[],lowestArray=[],highestTime,lowestTime,flagsMaxData_1=[],flagsMaxData_2=[],flagsMinData_1,flagsMinData_2; 

		for(var i=0;i<ohlcArray.length-1;i++){
			if(ohlcArray[i][0]>=minTime && ohlcArray[i][0]<=maxTime){
				array.push([
				            ohlcArray[i][0],
				            ohlcArray[i][1], //最高价
				            ohlcArray[i][2] //最低价
				            ])
			}
		}
		if(!array.length>0){
			return;
		}
		highestArray = array.sort(function(x, y){  return y[1] - x[1];})[0];// 根据最高价降序排列
		
		highestTime =highestArray[0];  
		highestPrice =highestArray[1].toFixed(2);  
		lowestArray = array.sort(function(x, y){  return x[2] - y[2];})[0]; //根据最低价升序排列
		
		
		
		lowestTime =lowestArray[0];  
		lowestPrice =lowestArray[2].toFixed(2); 
		var formatDate1 = Highcharts.dateFormat('%Y-%m-%d',highestTime)
		var formatDate2 = Highcharts.dateFormat('%Y-%m-%d',lowestTime)
		flagsMaxData_1 = [
		               			{
		               			 x : highestTime,
		               			title : highestPrice+"("+formatDate1+")"
		               			}
		               		];
		
		flagsMaxData_2 = [
					               {
					                x : highestTime,
					                title : highestPrice
					               }
		               ];
		flagsMinData_1 = [
		                  {
		                	  x : lowestTime,
		                	  title : lowestPrice+"("+formatDate2+")"
		                  }
		                  ];
		
		flagsMinData_2 = [
		               {
		            	   x : lowestTime,
		            	   title : lowestPrice
		               }
		               ];
		var min =  parseFloat(flagsMinData_2[0].title) - parseFloat(flagsMinData_2[0].title)*0.05;
		var max =  parseFloat(flagsMaxData_2[0].title) + parseFloat(flagsMaxData_2[0].title)*0.05;
		var tickInterval = (( max-min)/5).toFixed(1)*1;
		
		var tickIntervalTime = 1000*1800,dataFormat='%H:%M';
		
		
		//Y轴坐标自适应
		 chart.yAxis[0].update({
	    	   	min : min,
	    	   	max : max,
	    	   	tickInterval: tickInterval
	       });
		//X轴坐标自适应
		 chart.xAxis[0].update({
			 min : minTime,
			 max : maxTime,
			 tickInterval: tickIntervalTime,
			 labels: {
				   	y:-78,//调节y偏移
	             formatter: function(e) {
	             		 return Highcharts.dateFormat(dataFormat, this.value);
	             }
	         }
		 });
   	chart.hideLoading();
	}
	
	  //修改colum条的颜色（重写了源码方法）
//	 var originalDrawPoints = Highcharts.seriesTypes.column.prototype.drawPoints;
//	    Highcharts.seriesTypes.column.prototype.drawPoints = function () {
//	        var merge  = Highcharts.merge,
//	            series = this,
//	            chart  = this.chart,
//	            points = series.points,
//	            i      = points.length;
//	        
//	        while (i--) {
//	            var candlePoint = chart.series[0].points[i];
//	            if(candlePoint.open != undefined && candlePoint.close !=  undefined){  //如果是K线图 改变矩形条颜色，否则不变
//		            var color = (candlePoint.open < candlePoint.close) ? '#DD2200' : '#33AA11';
//		            var seriesPointAttr = merge(series.pointAttr);
//		            seriesPointAttr[''].fill = color;
//		            seriesPointAttr.hover.fill = Highcharts.Color(color).brighten(0.3).get();
//		            seriesPointAttr.select.fill = color;
//	            }else{
//	            	var seriesPointAttr = merge(series.pointAttr);
//	            }
//	            
//	            points[i].pointAttr = seriesPointAttr;
//	        }
//	
//	        originalDrawPoints.call(this);
//	    }

	//常量本地化
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
	});
	//格式化数据，准备绘图 
	data = result;	
	
	//把当前最新K线数据加载进来
	var time,volume,oldvolume=0,olda=0,i=0;
	var avg_pxyAxisMin;
	var avg_pxyAxisMax;
	var percentageyAxisMin;
	var percentageyAxisMax;
	var volume_yAxisMin;
	var volume_yAxisMax;
	var red="#ff0000";
	var blue="#00a800";
	var isFirstLineColorflag=true;
	//保存昨收数据
	var yesterdayClose;
	  //今开
	var open_px =data.open_px;
	  //昨收
	var preclose_px =data.preclose_px;
	yesterdayClose = preclose_px;
	console.log(yesterdayClose);
	console.log(open_px);
	isFirstLineColorflag = open_px>preclose_px?true:false;
	$.each(data, function(key, value){
		var dateUTC = getDateUTCOrNot(value.id);
		var business_amount= value.v - oldvolume ;  //成交量 1
	      var columnColor = red;
	      if(i==0){//第一笔的 红绿柱 判断依据是根据 今天开盘价与昨日收盘价比较
	          if(isFirstLineColorflag==false){
	              columnColor = blue;
	          }
	          avg_pxyAxisMin=value.a;  //jinkai
	          avg_pxyAxisMax=value.a;  //jinkai
	          
	          percentageyAxisMin=Number(100*(value.a/yesterdayClose-1));  //昨收
	          percentageyAxisMax=Number(100*(value.a/yesterdayClose-1));  //昨收
	          
	          volume_yAxisMin=value.v; //成交量 1
	          volume_yAxisMax=value.v; //成交量  1
	      }
	      else {
	          //除了第一笔，其它都是  返回的 last_px 与前一个对比
	          if( olda - value.p>0){  //last_px
	              columnColor = blue;
	              }
	          business_amount=value.v- oldvolume ;  //成交量 1
	          }
	      //昨收
	      avg_pxyAxisMin=avg_pxyAxisMin>value.a ? value.a : avg_pxyAxisMin;
	      avg_pxyAxisMax=avg_pxyAxisMax>value.a ? avg_pxyAxisMax : value.a;
	      percentageyAxisMin=percentageyAxisMin>Number(100*(value.a/yesterdayClose-1)) ? Number(100*(value.a/yesterdayClose-1)) : percentageyAxisMin;
	      percentageyAxisMax=percentageyAxisMax>Number(100*(value.a/yesterdayClose-1)) ? percentageyAxisMax : Number(100*(value.a/yesterdayClose-1));
	      
	      volume_yAxisMin=volume_yAxisMin>business_amount?business_amount:volume_yAxisMin;
	      volume_yAxisMax=volume_yAxisMax>business_amount?volume_yAxisMax:business_amount;
	      //将数据放入 ohlc volume 数组中
	      
	    
	      ohlcArray.push([dateUTC,value.a]);//昨收
	      volumeArray.push({x:dateUTC,y:Number(business_amount)}); //,color:columnColor
	      
	      oldvolume = value.v;
	      olda = value.p;
		  i++;
      })
console.log(ohlcArray);
	console.log(volumeArray);
	
	//开始绘图
	return new Highcharts.StockChart({
		chart:{
			renderTo : divID,
			margin: [30, 30,30, 30],
			plotBorderColor: '#3C94C4',
			plotBorderWidth: 0.3,
			events:{
				load:function(){
					var length = ohlcArray.length-1;
					//showTips(ohlcArray[0][0],ohlcArray[length][0],this);	
				}
			}
		},
		loading: {
	    	labelStyle: {
                position: 'relative',
	            top: '10em',
	            zindex:1000
	    	}
	    },
		 credits:{
	            enabled:false
	        },
	    rangeSelector: {

			enabled:false,
	        inputDateFormat: '%H:%M'  //设置右上角的日期格式
	    },
	    plotOptions: {
	    	//修改蜡烛颜色
	    	candlestick: {
	    		color: '#33AA11',
	    		upColor: '#DD2200',
	    		lineColor: '#33AA11',	    		
	    		upLineColor: '#DD2200', 
	    		maker:{
	    			states:{
	    				hover:{
	    					enabled:false,
	    				}
	    			}
	    		}
	    	},
	    	//去掉曲线和蜡烛上的hover事件
            series: {
            	states: {
                    hover: {
                        enabled: false
                    }
                },
            line: {
                marker: {
                    enabled: false
                }
            }
            }
	    },
	    //格式化悬浮框
	    tooltip: {
		   formatter: function() {
			   if(this.y == undefined){
				   return;
			   }
		      var tip= '<b>'+ Highcharts.dateFormat('%Y-%m-%d  %A', this.x) +'</b><br/>';
    		  return tip ;
		   },
		 //crosshairs:	[true, true]//双线
		   crosshairs: {
   				dashStyle: 'dash'
		   },
   			borderColor:	'white',
	    	positioner: function () { //设置tips显示的相对位置
	    		var halfWidth = this.chart.chartWidth/2;//chart宽度
	    		var width = this.chart.chartWidth-155;
	    		var height = this.chart.chartHeight/5-8;//chart高度
	    		if(relativeWidth<halfWidth){
	    			return { x: width, y:height };
	    		}else{
	    			return { x: 30, y: height };
	    		}
	    	},
	    	shadow: false
		},
	    title: {
	        enabled:false
	    },
	    exporting: { 
            enabled: false  //设置导出按钮不可用 
        }, 
		scrollbar: {
			barBackgroundColor: 'gray',
			barBorderRadius: 7,
			barBorderWidth: 0,
			buttonBackgroundColor: 'gray',
			buttonBorderWidth: 0,
			buttonArrowColor: 'yellow',
			buttonBorderRadius: 7,
			rifleColor: 'yellow',
			trackBackgroundColor: 'white',
			trackBorderWidth: 1,
			trackBorderColor: 'silver',
			trackBorderRadius: 7,
			//enabled: false,
			liveRedraw: false //设置scrollbar在移动过程中，chart不会重绘
		},
		 navigator: {
			 adaptToUpdatedData: false,
			 xAxis: {
				 labels: {
					formatter:function(){
		                  var returnTime=Highcharts.dateFormat('%H:%M', this.value);
		                  if(returnTime=="11:30 ")
		                  {
		                      return "11:30/13:00";
		                  }
		                  return returnTime;
		              }
		         }
			 },
			 handles: {
		    		backgroundColor: '#808080',
		    	//	borderColor: '#268FC9'
		    	},
		     margin:-10
		 },
	    xAxis: {
        	type: 'datetime',
        	 tickLength: 0,//X轴下标长度
        	// minRange: 3600 * 1000*24*30, // one month
//        	 events: {
//        		 afterSetExtremes: function(e) {
// 	    			var minTime = Highcharts.dateFormat("%H:%M ", e.min);
// 	    			var maxTime = Highcharts.dateFormat("%H:%M ", e.max);
// 	    			var chart = this.chart;
// 	    			showTips(e.min,e.max,chart);
// 	    		}
//        	 }
    	},
	    yAxis: [{
            opposite: false,//是否把它显示到另一边（右边）
            labels: {
                style: {         //字体样式
                    font: 'normal 5px Verdana, sans-serif'
                    },
                     overflow: 'justify',
                align: 'left',
                x: 1,
                y:5,
                formatter:function(){
                    //最新价  px_last/preclose昨收盘-1
                    return (this.value).toFixed(2);
                  }
            },
            title: {
                text: ''
            },
            top:'0%',
            height: '65%',
            lineWidth: 1,
            showFirstLabel: true,
            showLastLabel:true,
            
            tickPositioner:function(){    //以yesterdayClose为界限，统一间隔值，从 最小到最大步进
                positions = [],
                tick = Number((avg_pxyAxisMin)),
                increment = Number(((avg_pxyAxisMax - avg_pxyAxisMin) / 5));
                  var tickMin=Number((avg_pxyAxisMin)),tickMax=Number((avg_pxyAxisMax));
                if(0==data.length){//还没有数据时，yesterdayClose 的幅值 在 -1% - 1%上下浮动
                    tickMin=0.99*yesterdayClose;
                    tickMax=1.01*yesterdayClose;
                }else if(0==increment){//有数据了  但是数据都是一样的幅值
                    if(yesterdayClose>Number(avg_pxyAxisMin)){
                        tickMin=Number(avg_pxyAxisMin);
                        tickMax=2*yesterdayClose-Number(avg_pxyAxisMin);
                    }else if(yesterdayClose<Number(avg_pxyAxisMin)){
                        tickMax=Number(avg_pxyAxisMax);
                        tickMin=yesterdayClose-(Number(avg_pxyAxisMax)-yesterdayClose);
                    }else{
                        tickMin=0.99*yesterdayClose;
                        tickMax=1.01*yesterdayClose;
                    }
                }else if(avg_pxyAxisMin-yesterdayClose<0&&avg_pxyAxisMax-yesterdayClose>0){//最小值在昨日收盘价下面，最大值在昨日收盘价上面
                    var limit=Math.max(Math.abs(avg_pxyAxisMin-yesterdayClose),Math.abs(avg_pxyAxisMax-yesterdayClose));
                    tickMin=yesterdayClose-limit;
                    tickMax=yesterdayClose+limit;
                }else if(avg_pxyAxisMin>yesterdayClose&&avg_pxyAxisMax>yesterdayClose){//最小最大值均在昨日收盘价上面
                    tickMax=avg_pxyAxisMax;
                    tickMin=yesterdayClose-(tickMax-yesterdayClose);
                    
                }else if(avg_pxyAxisMin<yesterdayClose&&avg_pxyAxisMax<yesterdayClose){//最小最大值均在昨日收盘价下面
                    tickMin=avg_pxyAxisMin;
                    tickMax=yesterdayClose+(yesterdayClose-tickMin);
                }
                if(tickMax>2*yesterdayClose){//数据超过100%了
                    tickMax=2*yesterdayClose;
                    tickMin=0;
                }
                var interval=Number(tickMax-yesterdayClose)/10;
                tickMax+=interval;
                tickMin=yesterdayClose-(tickMax-yesterdayClose);
                increment=(tickMax-yesterdayClose)/3;
                tick=tickMin;
                var i=0;
                for (tick;i ++ <7  ; tick += increment) {
                    positions.push(Number(tick));
                    }
                
            return positions;
            },
        },
        {
            opposite: true,//是否把它显示到另一边（右边）
            showFirstLabel: true,
            showLastLabel:true,
            labels: {
                overflow: 'justify',
                style: {         //字体样式
                    font: 'normal 5px Verdana, sans-serif'
                    },
                align: 'right',
                x: 1,
                y:5,
                formatter:function(){//最新价  px_last/preclose昨收盘-1
                    return (100*(this.value/yesterdayClose-1)).toFixed(2)+"%";
                  }
            },
            title: {
                text: ''
            },
            lineWidth: 1,
            top:'0%',
            height: '65%',
            gridLineWidth: 1,
            tickPositioner:function(){
                return positions;
            }
        },
        {
            opposite: false,//是否把它显示到另一边（右边）
            labels: {
                overflow: 'justify',
                style: {         //字体样式
                    font: 'normal 5px Verdana, sans-serif'
                    },
                align: 'left',
                x: 1,
                y:5,
                formatter:function(){
                    if(this.value>1000000000){
                        return Number((this.value/1000000000).toFixed(2))+"G";
                    }else if(this.value>1000000){
                        return Number((this.value/1000000).toFixed(2))+"M";
                    }else if(this.value>1000){
                        return Number((this.value/1000).toFixed(2))+"K";
                    }else{
                        return Number(this.value.toFixed(2));
                    }
                }
            },
            title: {
                text: ''
            },
            top: '70%',
            height: '30%',
            width:'100%',
            offset: 0,
            lineWidth: 1,
            showFirstLabel: true,
            showLastLabel:true,
            tickPositioner:function(){
                var positions = [],
                tickMax=volume_yAxisMax,
                tickMin=volume_yAxisMin,
                tick = 0,
                increment = 0;
                var limit=tickMax/2;
                tickMax+=limit;
                increment=tickMax/2;
                tick=0;
                for (tick; tick  <= tickMax; tick += increment) {
                    positions.push(Number(tick.toFixed(2)));
                    if(increment==0){
                        break;
                    }
                }
                return positions;
            },
        }],
	    series: [{
            name : 'AAPL Stock Price',
            data : ohlcArray,
            type : 'areaspline',
            tooltip : {
                valueDecimals : 2
            },
            fillColor : {
                linearGradient : {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops : [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
            yAxis:0,
        },{
            name : 'AAPL Stock Price',
            data : ohlcArray,
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
        },
	    {
	        type: 'column',//2
	        name: '成交量',
	        data: volumeArray,
	        yAxis: 2,
	        dataGrouping: {
				enabled: false
			}
	    }
	    ]
	});
}