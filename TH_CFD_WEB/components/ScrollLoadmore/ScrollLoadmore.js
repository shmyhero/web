var React = require("react");
var LogicData = require("LogicData");
var Storage = require("Storage");

var Base = require("Base");
var ScrollLoadmore = React.createClass({
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
            isLoading : false, 
            stockInfo:[],
            datas : [],
            sortType: this.props.header ? 0: -1,
            rowStockInfoData: [],
            
        }
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
        
        if(!this.props.isOwnStockPage) {
            $.ajax({
                url : this.props.dataURL + '?page=1&perPage=20',
                data : null,
                dataType : 'json',
                async : false,
                success : function(data) {
                    //this.props.datas=data;
                    //console.log(data);
                    this.setState({
                                rowStockInfoData
                                : data,
                                stockInfo: data
                                //this.sortRawData(this.state.sortType, data)
                            })
                }.bind(this),
                error : function(XMLHttpRequest,textStatus, errorThrown) {
                        console.log(XMLHttpRequest);
                }
            });
        }else{
                    var userData = LogicData.getUserData();
                   $.ajax({
                        url : this.props.dataURL + '?page=1&perPage=20',
                        headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                        data : null,
                        dataType : 'json',
                        async : false,
                        success : function(data) {
                            LogicData.setOwnStocksData(data)
                            var value = LogicData.loadOwnStocksData()
                              if (value !== null) {
                                  this.setState({
                                        rowStockInfoData: value,
                                        stockInfo: value
                                    })
                               }
                        }.bind(this),
                        error : function(XMLHttpRequest,textStatus, errorThrown) {
                            console.log(XMLHttpRequest);
                        }
                    }); 
        }
    },
    componentDidMount:function(){
         if(this.props.isOwnStockPage) {
            Storage.setItem('a',1);
            window.addEventListener("storage",function(e){
                  //console.log(e);
                            var value = LogicData.loadOwnStocksData()
                              if (value !== null) {
                                  this.setState({
                                        rowStockInfoData: value,
                                        stockInfo: value
                                    })
                               }
            }.bind(this),false);
        }
    },
    handlePress: function() {
        var newType = this.state.sortType === 0?1:0
        var newRowData = this.sortRawData(newType)
        this.setState({
            sortType: newType,
            stockInfo: newRowData,
        });
    },
    sortRawData: function(newType, data) {
        
        if (data===undefined) {
            data = this.state.rowStockInfoData
        }
        // newTyep: 0:降序，1:升序
        var result = data;
        if (newType == 1){
            result.sort((a,b)=>{
                if (a.open === 0) {
                    return 1
                }
                else if (b.open === 0) {
                    return -1
                }
                var pa = (a.last - a.open) / a.open
                var pb = (b.last - b.open) / b.open
                return pa-pb
            });
        }
        else if (newType == 0) {
            result.sort((a,b)=>{
                if (a.open === 0) {
                    return 1
                }
                else if (b.open === 0) {
                    return -1
                }
                var pa = (a.last - a.open) / a.open
                var pb = (b.last - b.open) / b.open
                return pb-pa
            });
        }
        return result
    },
    renderSortText: function() {
        if (this.state.sortType ===0) {
            return (
                    <div >
                        <span >涨幅</span>
                        <span className="risePercent"> ↓ </span>
                    </div>);
        } else {
            return (
                    <div >
                        <span >跌幅</span>
                        <span className="fallPercent"> ↑ </span>
                    </div>);
        }
    },
    onLoadmore : function(){
                        
                      var value = LogicData.loadOwnStocksData()
                      if (value !== null) {
                          LogicData.setOwnStocksData(value);
                          this.setState({
                                stockInfo: value
                            })
                       }
    },
    onScroll : function(){
        var $scroll =$(".scroll-in");
        var scrollHeight = $scroll[0].scrollHeight;
        var scrollTop =  $scroll[0].scrollTop;
        var height =$scroll.height();
        if(!this.props.isLoading) {
            if ((height + scrollTop) >= scrollHeight) {
                //this.onLoadmore;
                this.props.isLoading = true;
                this.setState({
                    isUpdate: this.state.isUpdate
                })
                // if (this.props.loadCallBack) {
                //         this.props.loadCallBack();
                //      }
            }
        }
    },
    replacetotickview: function(securityId) {
        //LogicData.addStockToOwn(this.state.stockInfo[rowID]);
        window.location.replace('tickview.html?securityId='+securityId);
    },

    render : function(){
        var o = this;
        var newElements = this.state.stockInfo.map(function(rowData,index){
           return (
                <li className="item Grid" onClick={o.replacetotickview.bind(this,rowData.id)}>
                               <div className="last Grid-cell u-1of21" >
                                    <div className="name"> {rowData.name} </div>
                                    <div className="symbol"><span className="currency">US</span> {rowData.symbol}</div>
                                </div>
                                <div className="Price Grid-cell u-1of41"> {rowData.last.toFixed(4)}</div>
                                <div className={"Percent Grid-cell u-1of51 "+( rowData.last === rowData.open ? "stopPercent" : ((rowData.last - rowData.open) > 0 ? "risePercent" :"fallPercent"))   }> 
                                    {((rowData.last - rowData.open) / rowData.open * 100).toFixed(2)}%
                                </div>
                </li>
            )
        }, this);
        var elements=[];
        elements.push(newElements);

            //涨跌榜支持
         var liheader = null;    
        if(this.props.header) {
                liheader = (
                    <li className="label  Grid" onClick={this.handlePress}> 
                    <div className=" Grid-cell u-1"> 涨跌榜 </div>
                    <div className=" Grid-cell u-2">{ this.renderSortText()} </div> 
                     </li>
                )
            }

        //onScroll={this.props.hasMore?this.onScroll : null }
        return (
            <section className="m-list scroll-in" >
                 <ul className="yo-list">
                {liheader}
                {elements}
                 </ul>
                
             </section>
        )
    }
})

module.exports =  ScrollLoadmore;