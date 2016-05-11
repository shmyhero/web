var React=require("react");
Date.prototype.Format = function(fmt)   
{ //author: meizz   
  var o = {   
    "M+" : this.getMonth()+1,                 //月份   
    "d+" : this.getDate(),                    //日   
    "h+" : this.getHours(),                   //小时   
    "m+" : this.getMinutes(),                 //分   
    "s+" : this.getSeconds(),                 //秒   
    "q+" : Math.floor((this.getMonth()+3)/3), //季度   
    "S"  : this.getMilliseconds()             //毫秒   
  };
  if(fmt!==null)
  {   
  if(/(y+)/.test(fmt))   
    fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));   
  for(var k in o)   
    if(new RegExp("("+ k +")").test(fmt))   
  fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length))); 
  }  
  return fmt;   
}
var TipConfirm=React.createClass({
    propTypes :{
        isShowBtn   : React.PropTypes.bool,                              //是否显示
        timeout     : React.PropTypes.number,                            //显示多久事件后，自动关闭
        message     : React.PropTypes.string,                            //显示信息
        callback    : React.PropTypes.func
    },
    getDefaultProps : function(){
        return {
            isShowBtn   : false    //是否显示关闭按钮
        }
    },
    getInitialState: function(){
        return {
            visible: false,
            name: 'ABC',
            isCreate: true,
            isLong: true,
            invest: 0,
            leverage: 0,
            settlePrice: 0,
            time: new Date()
        }
    },
    componentDidMount : function(){
        if(this.props.timeout>0){
            window.setTimeout(this.onClose,this.props.timeout);
        }
    },
    onClose:function(){
        this.setState({
            visible: false
        })
        $(".pop2").hide();
        //回调函数
        if(this.props.callback) {
            this.props.callback();
        }
    },
    show: function(transactionInfo, callback) {
        $(".pop2").show();
        if (transactionInfo !== null) {
            this.setState({
                name: transactionInfo.stockName,
                isCreate: transactionInfo.isCreate,
                isLong: transactionInfo.isLong,
                invest: transactionInfo.invest,
                leverage: transactionInfo.leverage,
                settlePrice: transactionInfo.settlePrice,
                time: transactionInfo.createAt,
            })
        }
        this.setState({
            visible: true,
        })
        //this.state.dialogY.setValue(height)
        
    },
    render:function(){
       if (!this.state.visible) {
            return null
        }
        // <div className=" Grid-cell u-1of5" >
        //          {this.state.isCreate ? '':'0.00%'}
        //         </div>
        var tradeImage = this.state.isLong ? './images/dark_up.png' : './images/dark_down.png';
        return (
            <div  className="pop2" onClick={this.onClose}  > 
            <div className="yo-tip"  > 
               
               <ul className="yo-list">
                <li   className="item3 Grid"> 
                <div className="last1 Grid-cell u-1">
                    <div className="name">{this.state.name} - {this.state.isCreate?'开仓':'平仓'} </div>
                </div>
                
            </li>
            <li className="itemall flexGrid"> 
                <div className="last1 flexGrid-cell u-1of3" >
                    <div className="name">类型</div>
                   <div className="symbol"><img  src ={tradeImage} /></div> 
                </div>
                <div className="last1 flexGrid-cell u-1of3" >
                    <div className="name aligncenter">本金</div>
                    <div className="symbol aligncenter">{this.state.invest}</div>
                </div>
                <div className="last1 flexGrid-cell u-1of3" >
                    <div className="name alignright">杠杆</div>
                    <div className="symbol alignright">{this.state.leverage}</div>
                </div> 
            </li>
            <li className="itemall flexGrid"> 
                <div className="last1 flexGrid-cell u-1of3" >
                    <div className="name">交易价格</div>
                    <div className="symbol extendTextBottom">{this.state.settlePrice}</div>
                </div>
                <div className="last1 flexGrid-cell u-1of3" >
                    <div className="name extendTextTop aligncenter">止损</div>
                    <div className="symbol extendTextBottom aligncenter">{this.state.invest}</div>
                </div>
                <div className="last1 flexGrid-cell u-1of3" >
                    <div className="name extendTextTop alignright"> {this.state.time.Format('yy/MM/dd')}</div>
                    <div className="symbol extendTextBottom alignright">{this.state.time.Format('hh:mm')}</div>
                </div> 
            </li>
            </ul>
            </div>
            </div>
        )
    }
});

module.exports = TipConfirm;