var React = require("react");
var LogicData = require("LogicData");
var NetConstants = require("NetConstants");
var Storage = require("Storage");
var Tip = require("Tip");
var Base = require("Base");
var total=0;
var balance=0;
var available=0;
var data=[];
var sumPl = '--'
var avgPlRate = '--'
var PositionStatistical = React.createClass({
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
            showExchangeDoubleCheck: false,
        };
    },
    getDefaultProps : function(){
        return {
            elements : [],
            isLoading : false,
            isOwnStockPage: false,
            hasMore : false,
            header : false,
            liheader : null,
            isGainer : true,
            loadingTitle  : "正在加载更多. . . ",
            loadoverTitle : "没有更多信息. . . "
        }
    },
    componentWillMount : function() {

              var userData = LogicData.getUserData();

              $.ajax({
                          url : NetConstants.GET_USER_BALANCE_API,
                          headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                          dataType : 'json',
                          async : false,
                          success : function(data) {
                                console.log(data);
                                 total=data.total.toFixed(2);
                                 balance=data.balance.toFixed(2);
                                 available=data.available.toFixed(2);
                          }.bind(this),
                          error : function(XMLHttpRequest,textStatus, errorThrown) {
                            console.log(XMLHttpRequest);
                          }.bind(this)
                    });


                $.ajax({
                          url : NetConstants.GET_USER_STATISTICS_API,
                          headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                          dataType : 'json',
                          async : false,
                          success : function(successdata) {
                                sumPl = 0;
                                var sumInvest = 0;

                                var arr1=[], arr2=[],arr3=[],arr4=[];
                                successdata.map(function(rowData,index){

                                sumPl += rowData.pl;
                                sumInvest += rowData.invest;
                                     switch(index)
                                    {
                                    case 0:
                                    if(rowData.invest===0){
                                         arr1=[0,0,0]
                                    }else{
                                      if(rowData.pl >0){
                                        arr1[0]=rowData.pl;
                                        arr1[1]=0;
                                      }else{
                                        arr1[0] =0;
                                        arr1[1] = -rowData.pl;
                                      }
                                      arr1[2]=rowData.invest;
                                     }
                                     break;
                                    case 1:
                                      if(rowData.invest===0){
                                         arr2=[0,0,0]
                                    }else{
                                      if(rowData.pl >0){
                                        arr2[0]=rowData.pl;
                                        arr2[1]=0;
                                      }else{
                                        arr2[0]=0;
                                        arr2[1]=-rowData.pl;
                                      }
                                      arr2[2]=rowData.invest;
                                     }
                                     break;
                                    case 2:
                                      if(rowData.invest===0){
                                         arr3=[0,0,0]
                                    }else{
                                      if(rowData.pl >0){
                                        arr3[0]=rowData.pl;
                                        arr3[1]=0;
                                      }else{
                                        arr3[0]=0;
                                        arr3[1]=-rowData.pl;
                                      }
                                      arr3[2]=rowData.invest;
                                     }
                                     break;
                                    case 3:
                                       if(rowData.invest===0){
                                         arr4=[0,0,0]
                                    }else{
                                      if(rowData.pl >0){
                                        arr4[0]=rowData.pl;
                                        arr4[1]=0;
                                      }else{
                                        arr4[0]=0;
                                        arr4[1]=-rowData.pl;
                                      }
                                      arr4[2]=rowData.invest;
                                     }
                                     break;
                                    }
                                });
                                avgPlRate = (sumInvest > 0) ? sumPl / sumInvest * 100: 0
                                sumPl = sumPl.toFixed(2)
                                avgPlRate = avgPlRate.toFixed(2)

                                data=[{name: '盈利',
                                 data: [arr1[0], arr2[0], arr3[0], arr4[0]]
                                },
                                {
                                    name: '亏损',
                                    data: [arr1[1], arr2[1], arr3[1], arr4[1]]
                                },
                                {
                                    name: '当前本金',
                                    data: [arr1[2], arr2[2], arr3[2], arr4[2]]
                                }];

                          }.bind(this),
                          error : function(XMLHttpRequest,textStatus, errorThrown) {
                            console.log(XMLHttpRequest);
                          }.bind(this)
                    });


       },
    componentDidMount:function(){
        Highcharts.setOptions({
                global : {
                    useUTC : false
                },
                //5f97f6 50B432
                colors: ['#f16b5f', '#5fd959', '#629af3', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
          });

    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '盈亏分布',
            align: 'left',
            style: {
                color: '#333',
                fontSize: '0.14rem'
            }
        },
        xAxis: {
            categories: ['美股', '指数', '外汇', '商品'],
            gridLineColor: 'transparent',
            lineColor: 'transparent',
            tickColor: "transparent",
            labels: {
                style: {
                    color: '#979797'
                }
            }
        },
        yAxis: {
            gridLineColor: 'transparent',
            visible: false,
            min: 0,
            title: {
                text: ''
            },
            labels: {
                enabled: false
            }
        },
        legend: {
            lineHeight:12,
            align: 'right',
            x: 0,
            verticalAlign: 'top',
            y: 0,
            color: '#adadad',
            floating: true,
            borderColor: 'transparent',
            borderWidth: 1,
            shadow: false,
            itemStyle: {
                color: '#adadad',
                fontSize: '0.14rem',
                fontWeight: 'normal'
            }
        },
        tooltip: {
            enabled: false,
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false
                }
            },
            series: {
                pointWidth: 20
            }
        },
        series: data,
     });
    },
    render : function(){

        // (total-100000).toFixed(2)  ((total-100000) /balance * 100).toFixed(2)
        return (
            <section className="m-list " >
                  <section className="m-list" >
                    <ul className="yo-list centerText" >
                        <li className="item4" >
                           <div className="fontSize17a">总资产</div>
                        </li>
                        <li className="item4" >
                           <div className="fontSize44">{total}</div>
                        </li>
                        <li className="item4" >
                           <div className="fontSize17">剩余资金</div>
                        </li>
                        <li className="item4" >
                           <div className="fontSize19">{available}</div>
                        </li>
                    </ul>
                </section>
                <section className="m-list " >
                    <ul className="yo-list">
                        <li className="itemf flexGrid">
                          <div className="last1 flexGrid-cell u-1of2" >
                            <div className="name alignleft">累计收益</div>
                           <div className="symbol alignleft"> {sumPl}</div>
                        </div>
                        <div className="last1 flexGrid-cell u-1of2" >
                            <div className="name alignleft">总收益率</div>
                            <div className="symbol alignleft">{avgPlRate}%</div>
                        </div>
                        </li>
                    </ul>
                </section>
                <section className="m-list " >
                   <div id="container"></div>

                </section>
            </section>
            )
    }
})

module.exports =  PositionStatistical;
