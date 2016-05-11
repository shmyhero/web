var React=require("react");
var Tip=React.createClass({
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
            visible: false
        }
    },
    componentDidMount : function(){
        if(this.props.timeout>0){
            window.setTimeout(this.onClose,this.props.timeout);
        }
        if(this.state.visible)
        {
            $(".pop2").show();
        }
    },
    onClose:function(){
        // //回调函数
        // if(this.props.callback) {
        //     this.props.callback();
        // }
        // this.props.message= null;
        //  $(".pop2").hide();
        this.setState({
            visible: false
        })
    },
    show: function(transactionInfo) {
        console.log(transactionInfo);
        if (transactionInfo !== null) {
            this.props.message=transactionInfo;

        }

        this.setState({
            visible: true
        })
        //this.state.dialogY.setValue(height)
        
    },
    render:function(){
        if (!this.state.visible) {
            return null
        }
        return (
          <div  className="pop2" onClick={this.onClose}  > 
            <div className="yo-tip" > {this.props.message} </div>
         </div>
        )
    }
});

module.exports = Tip;