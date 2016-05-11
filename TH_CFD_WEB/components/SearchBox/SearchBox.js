var React = require("react");
var Base = require("Base");

var LogicData = require("LogicData");
var Storage = require("Storage");
var SearchBox = React.createClass({
    propTypes :{
        isSuggest       : React.PropTypes.bool,                       //是否显示
        suggestUrl      : React.PropTypes.string,                     //获取相关搜索的Url
        btnName         : React.PropTypes.string,                     //按钮名称
        isFocus         : React.PropTypes.bool,                       //是否获取焦点
        callback        : React.PropTypes.func                     //回调函数

    },
    getDefaultProps : function(){
        return {
            isFocus         : false,             //是否获取焦点
            isShowClear     : false,             //是否显示清楚按钮
            inputValue      : "",                //输入值
            suggestElement  : null,              //建议值
            btnName         : "取消"
        }
    },
    getInitialState : function(){
        return {
            isUpdate : false,
            searchStockRawInfo: [],
        }
    },
    componentDidMount : function(){

        

        //输入框获取焦点
        if(this.props.isFocus){
            this.refs.key.getDOMNode().focus();
        }
        //this.addlocalStorage(32060,"中国建筑","3311 HK");
        //this.addlocalStorage(21509,"英国富时100","UKX");
        this.getHistorySuggest();
    },
    clearInput : function(){
        this.refs.key.getDOMNode().value="";
        this.props.inputValue="";
        this.props.isShowClear = false;
        this.props.isFocus = true;
        this.props.suggestElement = null;
        this.setState({
            isUpdate : !this.state.isUpdate
        })
    },
    //输入框失去焦点
    onBlur : function(){
        // this.props.isFocus = false;
        // this.props.suggestElement = null;
        // this.refs.key.getDOMNode().blur();
        // this.setState({
        //     isUpdate : !this.state.isUpdate
        // })
    },
    onFocus: function(){
      //this.props.isFocus = true;
      //this.props.isSuggest=true;
       // if(!this.props.isSuggest){
       //      this.getHistorySuggest();
       // }
      
    },
    //输入框值发生变化
    inputChange : function(event){

        this.props.inputValue = event.target.value;
        this.props.isShowClear = this.props.inputValue!="";
        if(this.props.inputValue=="")
        {
            this.clearInput();
            this.props.isSuggest=false;
        }
        else
        {
            this.props.isSuggest=true;
        }
        if(this.props.isSuggest){
            this.getSuggest();
        }
        this.setState({
            isUpdate : !this.state.isUpdate
        })
    },
    setParam : function (name,value){  
        localStorage.setItem(name,value)  
    },  
    getParam : function(name){  
        return localStorage.getItem(name)  
    }, 
    addlocalStorage : function(id,name,symbol){

      var HistoryStock = this.getParam("HistoryStock");  
        if (HistoryStock == null || HistoryStock == "") {  
            //第一次加入历史
            var historystock = [{"id": 0,"name":"历史查询记录表头","symbol":""}];  
            var stock = { "id": id, "name": name,  "symbol": symbol };  
            historystock.push(stock);       
            this.setParam("HistoryStock", "'" + JSON.stringify(historystock));  
        }else{  
            var stocklist = JSON.parse(HistoryStock.substr(1, HistoryStock.length));  
            var result = false;  
            for (var i in stocklist) {  
                if (stocklist[i].id == id) {  
                    result = true;  
                }  
            }  
            if (!result) {  
                //没有 就直接加进去  
                stocklist.push({ "id": id, "name": name, "symbol": symbol} );  
            }
            //保存
            this.setParam("HistoryStock", "'" + JSON.stringify(stocklist));  
        }
        this.replacetotickview(id);
    },
    clearHistory: function(){
            
            var historystock = [{"id": 0,"name":"历史查询记录","symbol":""}];  
            this.setParam("HistoryStock", "'" + JSON.stringify(historystock));
            this.getHistorySuggest(); 
            this.setState({
            isUpdate : !this.state.isUpdate
            })
    },
    //获取历史搜索
    getHistorySuggest : function(){
         var o = this;
        var HistoryStock =this.getParam("HistoryStock");
        if (HistoryStock != null ) { 
        var HistorysuggestData = JSON.parse(HistoryStock.substr(1, HistoryStock.length));
        var isownStock=false;
            
            var rightPartContent = ( <div className=" Grid-cell u-1of5">已添加</div>);
             var arrStocks = localStorage.getItem('StockToOwn');
            
            this.props.getHistorySuggestElement = HistorysuggestData.map(function(key, index) {
                
                if(index==0)
                        {
                return (  <li className="label Grid" >
                                <div className=" Grid-cell u-1of1">
                                    <p >以下为历史查询记录 </p>
                                </div>
                            </li> )
                        }else{
                             
                 if(arrStocks.indexOf(key.id)==-1){
                           rightPartContent=( <div className="Grid-cell u-1of5"> <i className="yo-ico" onClick={o.addToMyListPressed.bind(this,key.id,index)} > &#xf04f;</i> </div>) 
                        }else{
                          rightPartContent = ( <div className=" Grid-cell u-1of5">已添加</div>);  
                        }            
                return (
                     <li className="item Grid" >
                        <div className="last Grid-cell u-1of1" onClick={o.replacetotickview.bind(this,key.id)}>
                            <p className="name">{key.name} </p>
                            <p className="symbol">{key.symbol}</p>
                        </div>
                        {rightPartContent}
                    </li>
                    )
                }
            });
        }else{
            this.props.getHistorySuggestElement = null;
        }
        this.setState({
            isUpdate : !this.state.isUpdate
        })
    },
    //获取相关搜索
    getSuggest : function(){

        $.ajax({
            url : this.props.suggestUrl + '?keyword=' + this.props.inputValue, 
            data : null,
            dataType : 'json',
            async : false,
            success : function(suggestData) {
                   //添加历史记录 及自选
                   // onClick={this.addlocalStorage()}
                    //

                   if(suggestData.length>0&&this.props.inputValue!="") {
                    var o = this;
                    var myListData = LogicData.loadOwnStocksData();
                   
                    var isownStock=false;
                     var rightPartContent = ( <div className=" Grid-cell u-1of5">已添加</div>);
                     var arrStocks = localStorage.getItem('StockToOwn'); 
                    this.props.suggestElement = suggestData.map(function(key, index) {
                      
                        if(arrStocks.indexOf(key.id)==-1){
                           rightPartContent=( <div className="Grid-cell u-1of5"> <i className="yo-ico" onClick={o.addToMyListPressed.bind(this,key.id,index)} > &#xf04f;</i> </div>) 
                        }else{
                          rightPartContent = ( <div className=" Grid-cell u-1of5">已添加</div>);  
                        } 
                        return (
                            <li className="item Grid" >
                                <div className="last Grid-cell u-1of1" onClick={o.addlocalStorage.bind(this,key.id,key.name,key.symbol)}>
                                    <p className="name">{key.name} </p>
                                    <p className="symbol">{key.symbol}</p>
                                </div>
                                {rightPartContent}
                            </li>
                        )
                     }, this);
                    }else {
                        if(this.props.inputValue!="")
                        {
                        this.props.suggestElement = 
                           <li className="label Grid" >
                                <div className=" Grid-cell u-1of1">
                                    <p >搜索无结果 </p>
                                </div>
                            </li>
                        }
                    }
                    this.setState({
                        searchStockRawInfo: suggestData
                    })
            }.bind(this),
            error : function(XMLHttpRequest,textStatus, errorThrown) {}
        });
    },
    //取消事件
    onCancel : function(){
        
        this.clearInput();
        $(".Suggest").hide();
         $(".content").show();
         //console.log(Storage.getItem('b'));
         Storage.setItem('b',parseInt(Storage.getItem('b'))+1);
         //this.refs['page0'].onLoadmore();
    },

    addToMyListPressed: function(id,rowID) {
        var userData = LogicData.getUserData();
        $.ajax({
                       
                        url :'http://cfd-webapi.chinacloudapp.cn/api/security/bookmark?securityIds='+id,
                        headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                        type: "POST",
                        data :null ,
                        dataType : 'json',
                        async : false,
                        success : function(data) {
                            console.log(data);
                            if(data.success)
                            {
                              LogicData.addStockToOwn(this.state.searchStockRawInfo[rowID]);
                              this.setState({
                                    isUpdate : !this.state.isUpdate
                                })
                            }
                        }.bind(this),
                        error : function(XMLHttpRequest,textStatus, errorThrown) {}
                    }); 
       
    },
    addToMyHistoryListPressed: function(id,rowID) {
        
        var userData = LogicData.getUserData();
        $.ajax({
                       
                        url :'http://cfd-webapi.chinacloudapp.cn/api/security/bookmark?securityIds='+id,
                        headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                        type: "POST",
                        data :null ,
                        dataType : 'json',
                        async : false,
                        success : function(data) {
                            console.log(data);
                            if(data.success)
                            {
                              var HistoryStock =this.getParam("HistoryStock");
                              var HistorysuggestData = JSON.parse(HistoryStock.substr(1, HistoryStock.length));
                              LogicData.addStockToOwn(HistorysuggestData[rowID]);   
                              this.setState({
                                    isUpdate : !this.state.isUpdate
                              })
                            }
                        }.bind(this),
                        error : function(XMLHttpRequest,textStatus, errorThrown) {}
                    }); 
       
    },
    replacetotickview: function(securityId) {
        //LogicData.addStockToOwn(this.state.stockInfo[rowID]);
        window.location.replace('tickview.html?securityId='+securityId);
    },
    render : function(){
        var suggestElement;
        if(this.props.isSuggest&&this.props.suggestElement!=null){
            suggestElement = (
                <div className="flex cont">
                   <div className="yo-group yo-list">
                        <ul className="yo-list" >
                             {this.props.suggestElement }
                         </ul>
                    </div>
                </div>
            )
        }else{
            suggestElement = (
            <div className="flex cont">
                <div className="yo-group yo-list">
                    <ul className="yo-list" >
                         {this.props.getHistorySuggestElement }
                    </ul>
                </div>
                <section>
                        <ul className="yo-tabclear">
                            <li className="item " >
                            <input type="button" value="清除历史记录" onClick={this.clearHistory} className="yo-btn yo-btn-e" />
                            </li>
                       </ul>
                </section>
            </div>
            )
        }
        return (
            <div className="yo-suggest yo-suggest-modal yo-suggest-on">
                <div className="operate yo-header">
                    <div className="action" >
                        <input type="search"  placeholder="搜索金融产品" className="input" onChange={this.inputChange}  onBlur={this.onBlur} ref="key" />
                        <label className="label" htmlFor="yo-search-input"><i className="yo-ico yo-ico-search"></i></label>
                        <i className={"yo-ico "+(this.props.inputValue !=""?"yo-ico-delete":"yo-ico-loading")} onClick={this.clearInput}></i>
                    </div>
                    <span className="cancel" onClick={this.onCancel} >{this.props.btnName}</span>
                </div>
                {suggestElement}
            </div>
            
        )
    }

});

module.exports = SearchBox;
