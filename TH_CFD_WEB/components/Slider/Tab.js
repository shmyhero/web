var React = require("react");
var ReactDOM = require('react-dom');
var Base = require("Base");
var SliderList = require("SliderList");
var ScrollLoadmore = require("ScrollLoadmore");
var SearchBox = require("SearchBox");
var Sortable = require("Sortable");

var tabNames = ['自选', '美股', '指数', '外汇', '现货']
var SERVER_IP = 'http://cfd-webapi.chinacloudapp.cn';
var GET_USER_BOOKMARK_LIST_API = SERVER_IP + '/api/security/bookmark';
var GET_US_STOCK_TOP_GAIN_API = SERVER_IP + '/api/security/stock/topGainer';
var GET_US_STOCK_TOP_LOSER_API = SERVER_IP + '/api/security/stock/topLoser';
var GET_INDEX_LIST_API = SERVER_IP + '/api/security/index';
var GET_FX_LIST_API = SERVER_IP + '/api/security/fx';
var GET_FUTURE_LIST_API = SERVER_IP + '/api/security/futures';

var GET_SEARCH_STOCK_API = SERVER_IP + '/api/security/search'

var urls = [GET_USER_BOOKMARK_LIST_API,
            GET_US_STOCK_TOP_GAIN_API,
            GET_INDEX_LIST_API,
            GET_FX_LIST_API,
            GET_FUTURE_LIST_API];

var SliderTest = React.createClass({
        slideCallback : function(index){
                this.state.currentSelectedTab=index;
                this.init();
        },
        getInitialState: function() {
            return {
                currentSelectedTab : 0,
                skipOnScrollEvent: false,
                isNext:false,
                ischange:false,
                sliderNext:-1,
                indexTranslate:0
            }
        },
        componentWillMount: function() {

            $.connection.hub.start().done(this.init);

            var prefix = Base.getBrowserPrefix();
            var hidden = Base.hiddenProperty(prefix);
            //var visibilityState = visibilityState(prefix);
            var visibilityEvent = Base.visibilityEvent(prefix);

            document.addEventListener(visibilityEvent, function(event) {
                  if (document[hidden]) {
                      console.log('hidden');
                  } else {
                      console.log('show');
                      $.connection.hub.error(function (error) {
                        console.log(error);
                        $.connection.hub.start().done(this.init);
                    });
                  }
            }.bind(this));


            var o=this;
            $(".yo-Htab li").click(function(){

               var index= $(this).index();
               if (index !== o.state.currentSelectedTab) {

                    $(".yo-Htab li").removeClass('item-on');
                    $(this).addClass('item-on');
                    if(index===0){
                         $(".regret").show();}
                    else{$(".regret").hide();}
                    var isNext = index > o.state.currentSelectedTab;
                    o.refs['Slider1'].getShowprops(index,isNext);

                }
            })
        },
        componentDidMount  : function() {
            $.connection.Q.client.p =  (stockInfo)=> {
                 this.refs['page' + this.state.currentSelectedTab].handleStockInfo(stockInfo)
            }
        },
        init: function() {
            if(this.state.currentSelectedTab===0)
            {
                //保存自选id
                localStorage.setItem('StockToOwn',this.refs['page' + this.state.currentSelectedTab].getShownStocks())
            }
            $.connection.Q.server.S(this.refs['page' + this.state.currentSelectedTab].getShownStocks());
        },
        componentWillUnmount: function() {
            $.connection.hub.stop()
        },
        render : function(){
            var elements=[];
            var tabs = tabNames.map(
            (tabName, i) =>
                elements.push(
                    <ScrollLoadmore dataURL={urls[i]} key={i} ref={'page' + i} isOwnStockPage={i==0}  header={i==1} hasMore={i==1} loadCallBack={this.slideCallback}  loadoverTitle={"没有更多信息了. . ."}  />
                )
            );
            return (
                <SliderList sliders= {elements} ref={'Slider1'}  sliderIndex={this.state.currentSelectedTab} sliderNext={this.state.sliderNext} ischange={this.state.ischange}  isNext={this.state.isNext} callback={this.slideCallback} isHorizontal={this.props.isHorizontal} slideType="drawer" />
            )
        }
});

var SearchBoxTest = React.createClass({
        slideCallback : function(index){

        },
        getInitialState: function() {
            return {
                suggestUrl : null,
                btnName: null,
            }
        },
        render : function(){

            return (
                <SearchBox suggestUrl={this.props.suggestUrl} btnName = {this.props.btnName} callback={this.slideCallback} />
            )
        }
});


ReactDOM.render(
<SliderTest isPager={false} isHorizontal = {true} />,
    document.getElementById("tab-content")
);


ReactDOM.render(
<SearchBoxTest suggestUrl={GET_SEARCH_STOCK_API} btnName = {"取消"} />,
     document.getElementById("Suggest")
);

ReactDOM.render(
<Sortable dataURL={GET_USER_BOOKMARK_LIST_API} />,
     document.getElementById("bookmark")
);
