var React = require("react");
var LogicData = require("LogicData");
var NetConstants = require("NetConstants");
var Storage = require("Storage");
var Tip = require("Tip");
var Base = require("Base");

var PositionStatistical = React.createClass({
    propTypes :{
        loadingTitle    : React.PropTypes.string,                              //加载标题
        dataURL         : React.PropTypes.string,                             //数据url
        datas           : React.PropTypes.element,                   
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
            datas : [],
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
    componentWillMount:function(){
           
            
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
            categories: ['美股', '指数', '外汇', '现货'],
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
                fontSize: '0.11rem',
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
                pointWidth: 16
            }
        },
        series: [
        {
            name: '盈利',
            data: [3, 1, 0, 3]
        },
        {
            name: '亏损',
            data: [0, 0, 1, 0]
        }, 
        {
            name: '当前本金',
            data: [3, 4, 4, 2]
        }],
     });
    },
    render : function(){
        return (
            <section className="m-list " >
                  <section className="m-list " >
                    <ul className="yo-list centerText" >
                        <li className="item4" >
                           <div className="fontSize17a">总资产</div> 
                        </li>
                        <li className="item4">
                           <div className="fontSize44">99999.00</div> 
                        </li>
                        <li className="item4">
                           <div className="fontSize17">剩余资金</div> 
                        </li>
                        <li className="item4">
                           <div className="fontSize19">80000.00</div> 
                        </li>
                    </ul>
                </section>
                <section className="m-list " >
                    <ul className="yo-list">
                        <li className="itemf flexGrid">
                          <div className="last1 flexGrid-cell u-1of2" >
                            <div className="name alignleft">累计收益</div>
                           <div className="symbol alignleft"> 20099.69</div>
                        </div>
                        <div className="last1 flexGrid-cell u-1of2" >
                            <div className="name alignleft">总收益率</div>
                            <div className="symbol alignleft">21.59%</div>
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