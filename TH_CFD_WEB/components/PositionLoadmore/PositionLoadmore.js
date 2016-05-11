var React = require("react");
var LogicData = require("LogicData");
var NetConstants = require("NetConstants");
var Storage = require("Storage");
var TipConfirm = require("TipConfirm");
var Base = require("Base");
var height = $(".slider-inner").height();
var extendHeight = 0;
var PositionLoadmore = React.createClass({
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
            if(this.props.isOwnStockPage) {
               $.ajax({
                url : 'http://cfd-webapi.chinacloudapp.cn/api/position/open',
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
           }
       },
       componentDidMount:function(){
        //  if(this.props.isOwnStockPage) {
        //     Storage.setItem('a',1);
        //     window.addEventListener("storage",function(e){
        //           //console.log(e);
        //                     var value = LogicData.loadOwnStocksData()
        //                       if (value !== null) {
        //                           this.setState({
        //                                 rowStockInfoData: value,
        //                                 stockInfo: value
        //                             })
        //                        }
        //     }.bind(this),false);
        // }
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
        var userData = LogicData.getUserData()
        var url = NetConstants.POST_DELETE_POSITION_API
        
        $.ajax({
                 url : NetConstants.POST_DELETE_POSITION_API,
                 type: 'POST',
                 headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                 data : {'posId':rowData.id,'securityId':rowData.security.id,'isPosLong':rowData.isLong,'posQty':rowData.quantity},
                 dataType : 'json',
                 async : false,
                 success : function(data) {
                    
                    //
                    data.stockName = rowData.security.name;
                    data.isCreate = false;
                    data.isLong = rowData.isLong;
                    data.createAt = new Date(data.createAt);
                    console.log(data);
                    this.refs['confirmPage'].show(data);
                    
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
    showCallback : function(){
                console.log('showCallback');
                this.loadOpenPositionInfo();
     },
    renderDetailInfo: function(rowData) {
        var buttonEnable = true
        var tradeImage = rowData.isLong ? './images/dark_up.png' : './images/dark_down.png';
        var upl =  rowData.upl < 0 ? '亏损'+':$' +rowData.upl.toFixed(2) :'获利' +':$' +rowData.upl.toFixed(2);
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
            upl =  '确认'+':$' + rowData.upl.toFixed(2);
        }
        

        // {this.state.selectedSubItem !== 0 ? this.renderSubDetail(rowData): null}
         // <li className="item1 Grid">
                    
         //            <div onClick={()=>this.subItemPress(1, rowData)}
         //                className="extendLeft" >
         //                <span className="extendTextTop">手续费</span>
         //                <img className="extendImageBottom" />
         //            </div>
         //            <div onClick={()=>this.subItemPress(2, rowData)}
         //                className="extendMiddle" >
         //                <span className="extendTextTop">行情</span>
         //                <img className="extendImageBottom" />
         //            </div>
         //            <div className="extendRight">
         //            </div>
         //    </li>
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
                    <div className="symbol extendTextBottom alignright">{(rowData.security.last - rowData.settlePrice).toFixed(2)}</div>
                </div> 
            </li>
              <li className="item2 centerText ">
                <div className=" centerText ">
                {showNetIncome ?
                <div className=" netIncomeText">净收益:9.26</div>
                : null}
                <div className="name">
                <input type="button" onClick={() => this.okPress(rowData)} value={upl} className={"yo-btn " +(this.state.showExchangeDoubleCheck  ? "yo-btn-upl1" : "yo-btn-upl")  } />
                </div>
                {this.state.showExchangeDoubleCheck ?
                    <div className=" feeText">平仓费：0</div> :
                    null}
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
                    <li className="item2 "  >

                    <ul className="yo-list">
                    <li className="item1 Grid" onClick={o.stockPressed.bind(this,rowData,index)}> 
                        <div className="last Grid-cell u-1" >
                            <div className="name"> {rowData.security.name} </div>
                            <div className="symbol"><span className="currency">US</span> {rowData.security.symbol}</div>
                        </div>
                        <div className={"Percent Grid-cell u-1of51 "+( rowData.security.last === rowData.settlePrice ? "stopPercent" : ((rowData.security.last - rowData.settlePrice) > 0 ? "risePercent" :"fallPercent"))   }> 
                        {((rowData.security.last - rowData.settlePrice) / rowData.settlePrice * 100).toFixed(2)}%
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
                    <div className="last Grid-cell u-1" >
                    <div className="name"> {rowData.security.name} </div>
                    <div className="symbol"><span className="currency">US</span> {rowData.security.symbol}</div>
                    </div>
                    <div className={"Percent Grid-cell u-1of51 "+( rowData.security.last === rowData.settlePrice ? "stopPercent" : ((rowData.security.last - rowData.settlePrice) > 0 ? "risePercent" :"fallPercent"))   }> 
                    {((rowData.security.last - rowData.settlePrice) / rowData.settlePrice * 100).toFixed(2)}%
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
            <TipConfirm ref='confirmPage' callback={this.showCallback} />
            </section>
            )
    }
})

module.exports =  PositionLoadmore;