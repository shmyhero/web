var React = require("react");
React.initializeTouchEvents(true);
var Base = require("Base");
var PositionList = require("Position");
var Tip = require("Tip");
//var Form = require("Form");
var PositionLoadmore = require("PositionLoadmore");
var StockClosedPositionPage = require("StockClosedPositionPage");
var PositionStatistical = require("PositionStatistical");

var NetConstants = require("NetConstants");

var tabNames = ['持仓', '平仓', '统计']


var urls = [NetConstants.POST_CREATE_POSITION_API,
            NetConstants.POST_CREATE_POSITION_API,
            NetConstants.POST_CREATE_POSITION_API];

var PositionTest = React.createClass({
        slideCallback : function(index){
                 this.state.currentSelectedTab=index;
                // this.init();
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

            // $.connection.hub.start().done(this.init);
             
            // $.connection.hub.error(function (error) {
            //     console.log(error);
            //     //$.connection.hub.start().done(this.init);
            // });

            var o=this;
            $(".yo-Htab li").click(function(){
                
               var index= $(this).index();

               if (index !== o.state.currentSelectedTab) {
                     
                    $(".yo-Htab .item-on").removeClass('item-on');
                    $(this).addClass('item-on');
                    var isNext = index > o.state.currentSelectedTab;
                    o.refs['Slider1'].getShowprops(index,isNext);
                }
            })
        },
        componentDidMount  : function() {
            // $.connection.Q.client.p =  (stockInfo)=> {
            //      this.refs['page' + this.state.currentSelectedTab].handleStockInfo(stockInfo)
            // }
        },
        init: function() {
            if(this.state.currentSelectedTab===0)
            {
                console.log(this.refs['page' + this.state.currentSelectedTab].getShownStocks());
                localStorage.setItem('StockToOwn',this.refs['page' + this.state.currentSelectedTab].getShownStocks())  
            }else{
                console.log(this.refs['page' + this.state.currentSelectedTab].getShownStocks());
            }    
            $.connection.Q.server.S(this.refs['page' + this.state.currentSelectedTab].getShownStocks()); 
        },
        componentWillUnmount: function() {
            $.connection.hub.stop()
        },
        render : function(){
            var tabPages = [
            <PositionLoadmore dataURL={urls[0]}  ref={'page0'} isOwnStockPage={true} loadCallBack={this.slideCallback}  loadoverTitle={"没有更多信息了. . ."}  />, 
            <StockClosedPositionPage dataURL={urls[1]}  ref={'page1'} />,
            <PositionStatistical  />
            ]
            var elements=[];
            var tabs = tabNames.map(
            (tabName, i) =>
                elements.push(
                    tabPages[i]
                )
            );
            return (
                <PositionList sliders= {elements} ref={'Slider1'}  sliderIndex={this.state.currentSelectedTab} sliderNext={this.state.sliderNext} ischange={this.state.ischange} isNext={this.state.isNext} isNext={this.state.isNext} callback={this.slideCallback} isHorizontal={this.props.isHorizontal} slideType="drawer" />
            )
        }
//isPager ={this.props.isPager}

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


var TestTip = React.createClass({
    getInitialState : function(){
        return {
            tip : (
                <Tip message="Tip提示3秒后消失" timeout={3000}   callback={this.tipClose}/>
            )
        }
    },
    tipClose:function(){
        this.setState({
            tip : null
        })
    },
    render : function(){
        return (
            this.state.tip
        )
    }
})

React.render(
<PositionTest isPager={false} isHorizontal = {true} />,
    document.getElementById("tab-content")
);


// React.render(
// <SearchBoxTest suggestUrl={GET_SEARCH_STOCK_API} btnName = {"取消"} />,
//      document.getElementById("Suggest")
// );

// React.render(
// <Sortable dataURL={GET_USER_BOOKMARK_LIST_API} />,
//      document.getElementById("bookmark")
// );

// React.render(
// <TestTip />,
//      document.getElementById("TestTip")
// );

// React.render(
// <Form  />,
//      document.getElementById("Formtest")
// );