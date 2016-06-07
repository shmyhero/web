var React = require("react");
//React.initializeTouchEvents(true);

var PositionItem = require("./PositionItem");
//var Tip = require("Tip");
var wWidth =0; 
var wHeight =0; 
var sliderIndex =0; 
var PositionList = React.createClass({
        propTypes :{
            sliders         : React.PropTypes.node,                                 //幻灯片
            delateWidth     : React.PropTypes.number,                               //切换成功的宽度
            isHorizontal    : React.PropTypes.bool,                                 //是否是水平方向
            isLoop          : React.PropTypes.bool,                                 //是否循环
            slideType       : React.PropTypes.oneOf(['smooth','drawer']),           //效果
            callback        : React.PropTypes.func,                                 //函数
            sliderIndex     : React.PropTypes.number,                               //当前页

        },
        //初始化状态
        getInitialState :function(){
            return {
                isUpdate : false,
                // sliderIndex       : 0,                       //当前页
                sliderNext        : -1,                       //下一页
                isNext            : false,                    //是否是下一页
                isTouchdown       : false,                    //是否滑动结束
                isTouchend        : false,                    //触屏结束
                indexTranslate    : 0,                        //切换位置
                nextTranslate     : 0,                        //切换位置
                touchDelate       : 0,                        //滑动的距离
                isSuccess         : false,                    //滑动成功
                startPos          : {                         //触屏开始位置
                        x : 0,
                        y : 0
                    },
                nowPos            : {                         //触屏结束位置
                        x : 0,
                        y : 0
                    }
                //tip : null
            }
        },
        getDefaultProps :function(){
            return {
                delateWidth       : 50,                       //切换成功的宽度
                pager             : null,
                sliderCount       : 3,                        //幻灯片页数
            }
        },
        componentWillMount : function(){
            //this.props.sliderCount = this.props.sliders.length;

        },
        componentDidMount : function(){
            wWidth = $(".slider-inner").width();
            wHeight = $(".slider-inner").height();
        },
        componentDidUpdate : function(){
            if(this.state.isTouchend){
                if (!this.state.isSuccess) {
                } else {
                    /**
                     * Tab头切换
                     */
                    // console.log(this.props.sliderIndex);
                    // console.log(this.props);
                    $("#li" + sliderIndex).removeClass('item-on');
                    sliderIndex = this.state.sliderNext;
                    $("#li" + sliderIndex).addClass('item-on');
                    $("#tab-content").scrollTop(0);
                    /**
                     *自选显示编辑
                     */
                    if(sliderIndex==0){$(".regret").show();}
                    else{$(".regret").hide();}

                     if (this.props.callback) {
                        // this.setState({
                        //     tip : (<Tip message="Tip提示3秒后消失" timeout={1000}   callback={this.tipClose}/>)
                        // });
                        this.props.callback(sliderIndex);
                     }
                }
                this.state.isTouchend = false;
                this.state.touchDelate = 0;
                this.state.isSuccess = false;
                this.state.indexTranslate = 0;
                this.state.nextTranslate = 0;
            }
        },
        getShowprops: function(sliderIndex,isNext) {
            this.state.isNext=isNext;
            wWidth = $(".slider-inner").width();
            wHeight = $(".slider-inner").height();
            if(this.props.slideType=="smooth"){
                this.state.indexTranslate = this.state.touchDelate;
            }else if(this.props.slideType=="drawer"){
                this.state.indexTranslate = this.state.touchDelate/5;
            }
            if(this.state.isNext){
                this.state.sliderNext = sliderIndex <= (this.props.sliderCount-1) ? sliderIndex : 0;
                this.state.nextTranslate = (wWidth + this.state.touchDelate) ;
            }else{
                this.state.sliderNext = sliderIndex < (this.props.sliderCount-1) ? sliderIndex  : 0;
                this.state.nextTranslate =  (-wWidth + this.state.touchDelate);
            }

            this.state.isTouchend = true;
            this.state.isSuccess=true;

            if(this.state.isNext){
                    this.state.indexTranslate = this.props.isHorizontal ? wWidth : wHeight;
                    this.state.nextTranslate = 0;
            }else{
                    this.state.indexTranslate = this.props.isHorizontal ? wWidth : wHeight;
                    this.state.nextTranslate = 0;
            }
            this.setState(
                {
                    isUpdate : !this.state.isUpdate,
                }
            );
         },
        /**
         * 页面滑动
         */
        setPageTranslate :function(){
            /**
             * 获取滑动距离
             * 向下滑动，下一张的初始位置为  -wWidth
             * 向上滑动，下一张的初始位置为  wWidth
             */
            if(this.props.slideType=="smooth"){
                this.state.indexTranslate = this.state.touchDelate;
            }else if(this.props.slideType=="drawer"){
                this.state.indexTranslate = this.state.touchDelate/5;
            }
            if(this.state.isNext){
                this.state.sliderNext = sliderIndex< (this.props.sliderCount-1) ? (sliderIndex + 1) : 0;
                this.state.nextTranslate = this.props.isHorizontal ? (wWidth + this.state.touchDelate) : (wHeight + this.state.touchDelate);
            }else{
                this.state.sliderNext = sliderIndex > 0 ? (sliderIndex - 1) : (this.props.sliderCount-1);
                this.state.nextTranslate = this.props.isHorizontal ? (-wWidth + this.state.touchDelate) : (-wHeight + this.state.touchDelate);
            }

        },
        /**
         * 切换成功
         * @param index 当前页位置
         * @param isNext 是否滑到下一页
         * @param touchDelate   滑动距离
         */
        translateSuccess : function(){
            this.onTranslateEnd(true);
        },
        /**
         * 切换失败
         * @param index 当前页位置
         * @param isNext 是否滑到下一页
         * @param touchDelate   滑动距离
         */
        translateFail : function(){
            this.onTranslateEnd(false)
        },
        /**
         * 滑动结束
         */
        onTranslateEnd : function(isSuccess){
            this.state.isTouchend = true;
            this.state.isSuccess = isSuccess;
            /**
             * 设置下一页滑动距离：nextDelate、
             * 获取结束时，下一页和当前页的位置：indexTranslate、nextTranslate
             */
            if(this.state.isNext){
                if(isSuccess){
                    this.state.indexTranslate = this.props.isHorizontal ? (-wWidth) : (-wHeight);
                    this.state.nextTranslate = 0;
                }else{
                    this.state.nextTranslate = this.props.isHorizontal ? wWidth : wHeight;
                    this.state.indexTranslate = 0;
                }
            }else{
                if(isSuccess){
                    this.state.indexTranslate = this.props.isHorizontal ? wWidth : wHeight;
                    this.state.nextTranslate = 0;
                }else{
                    this.state.nextTranslate = this.props.isHorizontal ? (-wWidth) : (-wHeight);
                    this.state.indexTranslate = 0;
                }
            }
            if(isSuccess){
                //this.props.pager = null;
            }

            /**
             * 重置状态
             */
            this.setState(
                {
                    isUpdate : !this.state.isUpdate
                }
            );
        },
        onTouchStart : function(e){
            if(this.state.isTouchdown){
                return ;
            }
            this.state.isTouchdown = true;
            /**
             * 获取开始触屏的坐标
             */
            var event=e||window.event;

            this.state.startPos = {
                x : event.touches[0].pageX,
                y : event.touches[0].pageY
            }

        },
        onTouchMove : function(e){

            //阻止默认动作 大坑
            // e.cancelBubble = true;
            // e.returnValue = false;
            // if (e.stopPropagation) {
            //     e.stopPropagation();
            // }
            // if (e.preventDefault) {
            //     e.preventDefault();
            // }

            if(!this.state.isTouchdown){
                return;
            }
            //获取滑动坐标
            var event=e||window.event;
            this.state.nowPos = {
                x : event.touches[0].pageX,
                y : event.touches[0].pageY
            }

            if(this.props.isHorizontal){
                this.state.touchDelate = this.state.nowPos.x - this.state.startPos.x;
            }else{
                this.state.touchDelate = this.state.nowPos.y - this.state.startPos.y ;
            }


            if(Math.abs(this.state.touchDelate)>0){
                this.state.isNext = this.state.touchDelate<0;
                this.setPageTranslate();
                this.setState({
                    isUpdate : !this.state.isUpdate
                })
            }

        },
        onTouchEnd : function(e){
            if(!this.state.isTouchdown){
                return;
            }

            this.state.isTouchdown = false;
            //判断切换成功？
            if(Math.abs(this.state.touchDelate)>0) {
                if (Math.abs(this.state.touchDelate) > this.props.delateWidth) {
                    this.translateSuccess();
                } else {
                    this.translateFail();
                }
                this.setState({
                    isUpdate : !this.state.isUpdate
                })
            }

        },
        // tipClose:function(){
        //     this.setState({
        //         tip : null
        //     })
        // },
        render : function () {
            var $that = this;

            //遍历构造幻灯片项
            var SliderItems = this.props.sliders.map(function(sliderValue,index){
                //是否显示
                var isShow = false;
                var zIndex = 0;
                var dataTranslate = 0;
                
                var slideShadow = "";
                if(index==sliderIndex || index==$that.state.sliderNext){
                    isShow = true;
                }
                if(sliderIndex == index){

                    dataTranslate = $that.state.indexTranslate;
                    zIndex = 2;
                }else if($that.state.sliderNext == index){
                    dataTranslate =  $that.state.nextTranslate;
                    zIndex = 10;
                    if($that.props.slideType!="smooth"){
                        if($that.props.isHorizontal) {
                            slideShadow = $that.state.isNext?'-2px 0px 3px rgba(0,0,0,0.3)':'2px 0px 3px rgba(0,0,0,0.3)';
                        }else{
                            slideShadow = $that.state.isNext?'0px -2px 3px rgba(0,0,0,0.3)':'0px 2px 3px rgba(0,0,0,0.3)';
                        }
                    }
                }

                return (
                    <PositionItem key={index} element = {sliderValue}
                        zIndex = {zIndex}
                        isShow = {isShow}
                        slideShadow ={slideShadow}
                        slideType = {$that.props.slideType}
                        isTouchdown = {$that.state.isTouchdown}
                        translateDelate = {dataTranslate}
                        isHorizontal ={$that.props.isHorizontal}
                        />
                );
            })

            //事件绑定
            var Events ={
                onTouchStart   : this.onTouchStart,        //开始触屏
                onTouchMove    : this.onTouchMove,         //触屏滑动
                onTouchEnd     : this.onTouchEnd           //触屏结束
            }
            //{...Events}
            return (
                <div className="slider">
                <div className="slider-inner"  >
                
                {SliderItems}
                </div>
                </div>
            )
    }
});

module.exports = PositionList;