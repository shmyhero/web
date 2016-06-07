var React = require("react");
var LogicData = require("LogicData");
var NetConstants = require("NetConstants");
var Storage = require("Storage");
var Tip = require("Tip");
var Base = require("Base");
var height = $(".slider-inner").height();
var extendHeight = 0;
var StockClosedPositionPage = React.createClass({
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
            var userData = LogicData.getUserData();
           
            //'Basic 9_083f416be4a64a15968841cdb75b60d1'
           
               $.ajax({
                url : NetConstants.GET_CLOSED_POSITION_API,
                headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                data : null,
                dataType : 'json',
                async : false,
                success : function(data) {
                    console.log(data);
                    this.setState({
                       rowStockInfoData: data,
                       stockInfo: data
                   })
                }.bind(this),
                error : function(XMLHttpRequest,textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                }
            });
       },
       componentDidMount:function(){
    },

    stockPressed: function(rowData, rowID) {
      
        this.setState({
            showExchangeDoubleCheck: false,
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
            var stockid = rowData.id
            this.setState({
                stockDetailInfo: rowData
            })
            this.loadStockDetailInfo(stockid)
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
    getLastPrice: function(rowData) {
    var lastPrice = rowData.isLong ? rowData.security.ask : rowData.security.bid
    return lastPrice === undefined ? rowData.security.last : lastPrice
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
                    <div className="symbol extendTextBottom">{rowData.openPrice}</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name extendTextTop aligncenter">平仓价格</div>
                    <div className="symbol extendTextBottom aligncenter">{rowData.closePrice}</div>
                </div>
                <div className="last1 Grid-cell u-1of3" >
                    <div className="name extendTextTop alignright">净收益</div>
                    <div className="symbol extendTextBottom alignright">{rowData.pl.toFixed(2)}</div>
                </div> 
            </li>
           
            </ul>  
            );
},
render : function(){
    var o = this;
    var newElements = this.state.stockInfo.map(function(rowData,index){
            
            var currency = rowData.security.tag ===undefined ?  null :  ( <span className="currency">US</span> );    
            var liheader = null;    
            if(this.state.selectedRow === index) {
                return (
                    <li className="item2 " >
                    <ul className="yo-list" >
                    <li className="item1 Grid" onClick={o.stockPressed.bind(this,rowData,index)}> 
                                <div className="last Grid-cell  u-1of21" >
                                    <div className="name"> {rowData.security.name} </div>
                                    <div className="symbol">{currency} {rowData.security.symbol}</div>
                                </div>
                                <div className="Price Grid-cell u-1of41"> {rowData.pl.toFixed(2)}</div>
                                <div className={"Percent Grid-cell u-1of51 "+( rowData.pl == 0 ? "stopPercent" : (rowData.pl > 0 ? "risePercent" :"fallPercent"))   }> 
                                    {( rowData.pl / rowData.invest * 100).toFixed(2)}%
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
                        <div className="last Grid-cell  u-1of21" >
                        <div className="name"> {rowData.security.name} </div>
                        <div className="symbol">{currency} {rowData.security.symbol}</div>
                        </div>
                        <div className="Price Grid-cell u-1of41"> {rowData.pl.toFixed(2)}</div>
                        <div className={"Percent Grid-cell u-1of51 "+( rowData.pl == 0 ? "stopPercent1" : (rowData.pl > 0 ? "risePercent1" :"fallPercent1"))   }> 
                        {( rowData.pl / rowData.invest * 100).toFixed(2)}%
                        </div> 
                    </li>
                    )
            }

            
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