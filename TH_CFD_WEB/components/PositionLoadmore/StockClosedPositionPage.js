var React = require("react");
var LogicData = require("LogicData");
var NetConstants = require("NetConstants");
var Storage = require("Storage");
var Tip = require("Tip");
var Base = require("Base");
var height = $(".slider-inner").height();
var extendHeight = 0;
var tempData = [
    {id:13001, symbol:'AAPL UW', name:'新东方', tag: 'US', profitPercentage: 0.1},
    {id:13001, symbol:'AAPL UW2', name:'新东方2', tag: 'US', profitPercentage: 0.05},
    {id:13001, symbol:'AAPL UW3', name:'新东方3', profitPercentage: -0.08},
    {id:13001, symbol:'AAPL UW4', name:'新东方4', profitPercentage: 0},
    {id:13001, symbol:'AAPL UW5', name:'新东方5', tag: 'US', profitPercentage: 0.1},
    {id:13001, symbol:'AAPL UW6', name:'新东方6', tag: 'US', profitPercentage: 0.05},
    {id:13001, symbol:'AAPL UW7', name:'新东方7', profitPercentage: -0.08},
    {id:13001, symbol:'AAPL UW8', name:'新东方8', profitPercentage: 0},
    {id:13001, symbol:'AAPL UW9', name:'新东方9', tag: 'US', profitPercentage: 0.1},
    {id:13001, symbol:'AAPL UW10', name:'新东方10', tag: 'US', profitPercentage: 0.05},
    {id:13001, symbol:'AAPL UW11', name:'新东方11', profitPercentage: -0.08},
    {id:13001, symbol:'AAPL UW12', name:'新东方12', profitPercentage: 0},
]
var StockClosedPositionPage = React.createClass({
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
            stockInfo: tempData,
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
    getShownStocks: function() {
        var result = ''
        for (var i = 0; i < this.state.rowStockInfoData.length; i++) {
            result += ( this.state.rowStockInfoData[i].id + ',')
        };

        result = result.substring(0, result.length - 1);
        return result
    },
    handleStockInfo: function(realtimeStockInfo) {

        var hasUpdate = false
        for (var i = 0; i < this.state.rowStockInfoData.length; i++) {
            for (var j = 0; j < realtimeStockInfo.length; j++) {
                if (this.state.rowStockInfoData[i].id == realtimeStockInfo[j].id && 
                            this.state.rowStockInfoData[i].last !== realtimeStockInfo[j].last) {
                    this.state.rowStockInfoData[i].last = realtimeStockInfo[j].last;
                    hasUpdate = true;
                    break;
                }
            };
        };
        if (hasUpdate) {
            //console.log(this.state.rowStockInfoData);
            this.setState({
                stockInfo: this.state.rowStockInfoData
            })
        }
    },
    componentWillMount:function(){
           //  var userData = LogicData.getUserData();
           
           //  //'Basic 9_083f416be4a64a15968841cdb75b60d1'
           //  if(this.props.isOwnStockPage) {
           //     $.ajax({
           //      url : 'http://cfd-webapi.chinacloudapp.cn/api/position/open',
           //      headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
           //      data : null,
           //      dataType : 'json',
           //      async : false,
           //      success : function(data) {
           //          console.log(data);
           //          this.setState({
           //             rowStockInfoData: data,
           //             stockInfo: data
           //         })
           //      }.bind(this),
           //      error : function(XMLHttpRequest,textStatus, errorThrown) {
           //          console.log(XMLHttpRequest);
           //      }
           //  });
           // }
       },
       componentDidMount:function(){
    },

    stockPressed: function(rowData, rowID) {
        this.setState({
            showExchangeDoubleCheck: false,
        })
        if (this.state.selectedRow == rowID) {
           
            //newData[rowID].hasSelected = false
            this.setState({
                stockInfo: tempData,
                selectedRow: -1,
                
            })
        } else {
            // var maxY = (height-100)*20/21 - extendHeight
            // var listHeight = $(".slider-inner").height();
            // if (this.state.selectedRow >=0) {
            //     newData[this.state.selectedRow].hasSelected = false
            //     //listHeight -= extendHeight
            // }
            // var currentY = listHeight/newData.length*(parseInt(rowID)+1)
            // if (currentY > maxY && parseInt(this.state.selectedRow) < parseInt(rowID)) {
                
            //     $("#tab-content").scrollTop(Math.floor(currentY-maxY))
            // }

            //newData[rowID].hasSelected = true

            //LayoutAnimation.configureNext(LayoutAnimation.Presets.spring);
            this.setState({
                stockInfo: tempData,
                 selectedRow: rowID,
                // selectedSubItem: 0,
                // rowStockInfoData: newData,
            })
        }
    },

    subItemPress: function(item, rowData) {
        //LayoutAnimation.configureNext(LayoutAnimation.Presets.easeInEaseOut);
        this.setState({
            selectedSubItem: this.state.selectedSubItem === item ? 0 : item,
        })

        if (item === 2) {
            var stockid = rowData.id
            this.setState({
                stockDetailInfo: rowData
            })
            this.loadStockDetailInfo(stockid)
        }
    },

    okPress: function(rowData) {
        console.log('okPress');
        if (this.state.showExchangeDoubleCheck === false) {
            this.setState({
                showExchangeDoubleCheck: true,
            })
            return
        }
        var userData = LogicData.getUserData();
        var url = NetConstants.POST_DELETE_POSITION_API;
        //console.log({'posId':rowData.id,'securityId':rowData.security.id,'isPosLong':rowData.isLong,'posQty':rowData.quantity});
        $.ajax({
                 url : NetConstants.POST_DELETE_POSITION_API,
                 type: 'POST',
                 headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                 data : {'posId':rowData.id,'securityId':rowData.security.id,'isPosLong':rowData.isLong,'posQty':rowData.quantity},
                 dataType : 'json',
                 async : false,
                 success : function(data) {
                    console.log(data);
                    this.loadOpenPositionInfo();
                    data.stockName = rowData.security.name;
                    data.isCreate = false;
                    data.isLong = rowData.isLong;
                    data.time = new Date(data.createAt);
                    this.refs['confirmPage'].show(data)
                    }.bind(this),
                 error : function(XMLHttpRequest,textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                 }
            }); 
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
                    console.log(responseJson);
                    this.setState({
                        stockInfoRowData: responseJson,
                        stockInfo: responseJson,
                        selectedRow: -1,
                        selectedSubItem: 0
                    })
                    // var stockIds = []
                    // for (var i = 0; i < responseJson.length; i++) {
                    //     var stockId = responseJson[i].security.id
                    //     if (stockIds.indexOf(stockId) < 0) {
                    //         stockIds.push(stockId)
                    //     }
                    // };
                    // WebSocketModule.registerInterestedStocks(stockIds.join(','))
                    // WebSocketModule.registerCallbacks(
                    //     (realtimeStockInfo) => {
                    //         this.handleStockInfo(realtimeStockInfo)
                    // })
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
    renderDetailInfo: function(rowData) {
        var buttonEnable = true
        var tradeImage = rowData.isLong ? './images/dark_up.png' : './images/dark_down.png';
        var showNetIncome = false,
        extendHeight = 222;
        if (showNetIncome) {
            extendHeight += 20
        }
        if (this.state.selectedSubItem === 1) {
            extendHeight += 51
        }
        if (this.state.selectedSubItem === 2) {
            extendHeight += 170
        }
        if (this.state.showExchangeDoubleCheck) {
            extendHeight += 28
        }
        return (
            <ul className="yo-list">
            <li className="item1 Grid"> 
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name">类型</div>
                    <img className="symbol" src ={tradeImage} />
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name aligncenter">本金</div>
                    <div className="symbol aligncenter">100</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name alignright">杠杆</div>
                    <div className="symbol alignright">x10</div>
                </div> 
            </li>
            <li className="item1 Grid"> 
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name">开仓价格</div>
                    <div className="symbol extendTextBottom">10.24</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name extendTextTop aligncenter">开仓费</div>
                    <div className="symbol extendTextBottom aligncenter">0.24</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name extendTextTop alignright">16/03/24</div>
                    <div className="symbol extendTextBottom alignright">13:30</div>
                </div> 
            </li>
           <li className="item1 Grid"> 
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name">开仓价格</div>
                    <div className="symbol extendTextBottom">10.24</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name extendTextTop aligncenter">开仓费</div>
                    <div className="symbol extendTextBottom aligncenter">1.24</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name extendTextTop alignright">16/03/24</div>
                    <div className="symbol extendTextBottom alignright">14:30</div>
                </div> 
            </li>
             <li className="item1 Grid"> 
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name">留仓费</div>
                    <div className="symbol extendTextBottom">0.24</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name extendTextTop aligncenter">净收益</div>
                    <div className="symbol extendTextBottom aligncenter netIncomeText">14.28</div>
                </div>
                
            </li>
            </ul>  
            );
},
render : function(){
    var o = this;
    var newElements = this.state.stockInfo.map(function(rowData,index){
            
            var liheader = null;    
            if(this.state.selectedRow === index) {
                liheader = (
                    <li className="item2 " >
                    <ul className="yo-list" >
                    <li className="item1 Grid" onClick={o.stockPressed.bind(this,rowData,index)}> 
                        <div className="last Grid-cell u-1of21" >
                            <div className="name"> {rowData.name} </div>
                            <div className="symbol"><span className="currency">US</span> {rowData.symbol}</div>
                        </div>
                        <div className={"Price Grid-cell u-1of51 "}> 
                            111
                        </div> 
                        <div className={"Percent Grid-cell u-1of51 "+( rowData.profitPercentage===0 ? "stopPercent" : (rowData.profitPercentage > 0 ? "risePercent" :"fallPercent"))   }> 
                       {(rowData.profitPercentage * 100).toFixed(2)}%
                        </div> 
                    </li>
                    <li>
                     {o.renderDetailInfo(rowData)}
                    </li>
                    </ul> 
                    </li>
                    )
            }else{
                liheader = (
                    <li className="item Grid" onClick={o.stockPressed.bind(this,rowData,index)}>
                    <div className="last Grid-cell u-1of21" >
                    <div className="name"> {rowData.name} </div>
                    <div className="symbol"><span className="currency">US</span> {rowData.symbol}</div>
                    </div>
                    <div className={"Price Grid-cell u-1of51 "}> 
                            111
                        </div> 
                    <div className={"Percent Grid-cell u-1of51 "+( rowData.profitPercentage===0 ? "stopPercent" : (rowData.profitPercentage > 0 ? "risePercent" :"fallPercent"))   }> 
                    {(rowData.profitPercentage * 100).toFixed(2)}%
                    </div> 
                    </li>
                    )
            }

            return (
                {liheader}
                )
    }, this);
    var elements=[];
    elements.push(newElements);
        return (
            <section className="m-list scroll-in" ref="listview" >
            <ul className="yo-list">

            {elements}
            </ul>
            <Tip ref='confirmPage1'/>
            </section>
            )
    }
})

module.exports =  StockClosedPositionPage;