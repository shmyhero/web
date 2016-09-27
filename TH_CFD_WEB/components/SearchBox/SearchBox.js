var React = require("react");
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
    getInitialState : function(){
        return {
            isUpdate : false,
            searchStockRawInfo: [],
            getHistorySuggestElement: [],
            inputValue      : "",                //输入值
            isShowClear     : false,             //是否显示清楚按钮
            isFocus         : false,             //是否获取焦点
            suggestElement  : null,              //建议值
        }
    },
    componentDidMount : function(){



        //输入框获取焦点
        if(this.props.isFocus){
            $(".input").focus();
        }
        //this.addlocalStorage(32060,"中国建筑","3311 HK");
        //this.addlocalStorage(21509,"英国富时100","UKX");
        this.getHistorySuggest();
    },
    clearInput : function(){
        $(".input").val("");
        //this.refs.searchinput.getDOMNode().value="";
        this.state.inputValue="";
        this.state.isShowClear = false;
        this.state.isFocus = true;
        this.state.suggestElement = null;
        this.setState({
            isUpdate : !this.state.isUpdate
        })
    },
    //输入框失去焦点
    onBlur : function(){
        // this.props.isFocus = false;
        // this.props.suggestElement = null;
        // this.ref.searchinput.getDOMNode().blur();
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

        this.state.inputValue = event.target.value;
        this.state.isShowClear = this.state.inputValue!="";
        if(this.state.inputValue=="")
        {
            this.clearInput();
            this.state.isSuggest=false;
        }
        else
        {
            this.state.isSuggest=true;
        }
        if(this.state.isSuggest){
            this.getSuggest();
        }
    },
    setParam : function (name,value){
        localStorage.setItem(name,value)
    },
    getParam : function(name){
        return localStorage.getItem(name)
    },
    addlocalStorage : function(id,name,symbol,preClose,open,last){

      var HistoryStock = this.getParam("HistoryStock");
        if (HistoryStock == null || HistoryStock == "") {
            //第一次加入历史
            var historystock = [{"id": 0,"name":"历史查询记录表头","symbol":""}];
            var stock = { "id": id, "name": name,  "symbol": symbol,  "preClose": preClose,  "open": open,  "last": last };
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
                stocklist.push({"id": id, "name": name, "symbol": symbol, "preClose": preClose, "open": open, "last": last});
            }
            console.log(stocklist);
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
        var HistorysuggestData = JSON.parse(HistoryStock.substr(1, HistoryStock.length));
        console.log(HistorysuggestData);
        if (HistorysuggestData.length > 1 ) {

          var rightPartContent = ( <div className=" Grid-cell u-1of5">已添加</div>);
          var arrStocks = localStorage.getItem('StockToOwn');
          this.state.getHistorySuggestElement = HistorysuggestData.map(function(key, index) {
            if(index==0){

                  return (  <li className="label Grid" key={index} >
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
                       <li className="item Grid" key={index}>
                          <div className="last Grid-cell u-1of1" onClick={o.replacetotickview.bind(this,key.id)}>
                              <p className="name">{key.name} </p>
                              <p className="symbol">{key.symbol}</p>
                          </div>
                          {rightPartContent}
                      </li>
                      )
                  }
        },this);
      }else{
            this.state.getHistorySuggestElement = null;
      }
      this.setState({
            searchStockRawInfo: HistorysuggestData
      })
    },
    //获取相关搜索
    getSuggest : function(){
        if(this.state.inputValue.length>0){
        $.ajax({
            url : this.props.suggestUrl + '?keyword=' + this.state.inputValue,
            data : null,
            dataType : 'json',
            async : false,
            success : function(suggestData) {
                   //添加历史记录 及自选
                   if(suggestData.length>0&&this.state.inputValue!="") {
                    var o = this;
                     var rightPartContent = ( <div className=" Grid-cell u-1of5">已添加</div>);
                     var arrStocks = localStorage.getItem('StockToOwn');
                    this.state.suggestElement = suggestData.map(function(key, index) {

                        if(arrStocks.indexOf(key.id)==-1){
                           rightPartContent=( <div className="Grid-cell u-1of5"> <i className="yo-ico" onClick={o.addToMyListPressed.bind(this,key.id,index)} > &#xf04f;</i> </div>)
                        }else{
                          rightPartContent = ( <div className=" Grid-cell u-1of5">已添加</div>);
                        }
                        return (
                            <li className="item Grid" key={index}>
                                <div className="last Grid-cell u-1of1" onClick={o.addlocalStorage.bind(this,key.id,key.name,key.symbol,key.preClose,key.open,key.last)}>
                                    <p className="name">{key.name} </p>
                                    <p className="symbol">{key.symbol}</p>
                                </div>
                                {rightPartContent}
                            </li>
                        )
                     }, this);
                    }else {
                        if(this.state.inputValue!="")
                        {
                        this.state.suggestElement =
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
        }
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
        console.log(id);
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
                              localStorage.setItem('StockToOwn',localStorage.getItem('StockToOwn') + ',' + id);
                              this.getSuggest();
                              this.getHistorySuggest();
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
        window.location.replace('tickview.php?securityId='+securityId);
    },
    render : function(){
        var suggestElement;
        if(this.state.isSuggest&&this.state.suggestElement!=null){
            suggestElement = (
                <div className="flex cont">
                   <div className="yo-group yo-list">
                        <ul className="yo-list" >
                             {this.state.suggestElement }
                         </ul>
                    </div>
                </div>
            )
        }else{
            suggestElement = (
            <div className="flex cont">
                <div className="yo-group yo-list">
                    <ul className="yo-list" >
                         {this.state.getHistorySuggestElement }
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
                        <input type="search"  placeholder="搜索金融产品" className="input" onChange={this.inputChange}  onBlur={this.onBlur} ref="searchinput" />
                        <label className="label" htmlFor="yo-search-input"><i className="yo-ico yo-ico-search"></i></label>
                        <i className={"yo-ico "+(this.state.inputValue !=""?"yo-ico-delete":"yo-ico-loading")} onClick={this.clearInput}></i>
                    </div>
                    <span className="cancel" onClick={this.onCancel} >{this.props.btnName}</span>
                </div>
                {suggestElement}
            </div>

        )
    }

});

module.exports = SearchBox;
