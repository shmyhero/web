var React = require("react");
var LogicData = require("LogicData");
var Storage = require("Storage");


var Sortable = React.createClass({
    propTypes :{
        loadingTitle    : React.PropTypes.string,               //加载标题
        dataURL         : React.PropTypes.string,               //数据url
        postdataURL         : React.PropTypes.string,               //数据url
    },
    getDefaultProps : function(){
        return {
            elements : [],
            liheader : []
        }
    },
    getInitialState : function(){
        return {
            isUpdate : false,
            stockInfo:[]
        }
    },
    componentWillMount:function(){

      var value = LogicData.loadOwnStocksData()
      if (value !== null) {
          LogicData.setOwnStocksData(value);
          this.setState({
                stockInfo: value
            })
       }

    },
    selectAll:function(){
         if($("#selectAll").val()=='全部')
         {
             $("#handle-1 :checkbox").prop("checked", true);
             $("#selectAll").val('取消');
             $("#getValue").removeClass('yo-btn-e');
             $("#getValue").addClass('yo-btn-e1');
         }
         else
         {
             $("#handle-1 :checkbox").prop("checked", false);
             $("#selectAll").val('全部');
             $("#getValue").removeClass('yo-btn-e1');
             $("#getValue").addClass('yo-btn-e');
         }

    },
    getValue:function(){
        var userData = LogicData.getUserData();
         var valArr ='';
         $("#handle-1 :checkbox").each(function(i){
              if ($(this).prop('checked')) {
                 valArr += $(this).val()+",";
              }
         });
        valArr=valArr.substring(0,valArr.length-1);
        console.log(valArr);
         $.ajax({
                 url : 'http://cfd-webapi.chinacloudapp.cn/api/security/bookmark?securityIds='+valArr,
                 type: 'DELETE',
                 //type: 'DELETE',
                 headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                 data : null,
                 dataType : 'json',
                 async : false,
                 success : function(data) {
                     console.log(data);
                     this.reload();
                    }.bind(this),
                 error : function(XMLHttpRequest,textStatus, errorThrown) {}
            });

    },
    getList:function(){
        var userData = LogicData.getUserData();
         var valArr ='';
         $("#handle-1 :checkbox").each(function(i){
                 valArr += $(this).val()+",";
         });
         valArr=valArr.substring(0,valArr.length-1);
         var OwnStockstr = localStorage.getItem("StockToOwn");
         if(valArr!==OwnStockstr)
         {
                $.ajax({
                        url : 'http://cfd-webapi.chinacloudapp.cn/api/security/bookmark?securityIds='+valArr,
                        headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                        data : null,
                        type: 'PUT',
                        dataType : 'json',
                        async : false,
                        success : function(data) {
                            console.log(data);
                            this.reload();
                        }.bind(this),
                        error : function(XMLHttpRequest,textStatus, errorThrown) {
                           console.log(textStatus);
                        }
                    });
        }
        $(".bookmark").hide();
        $(".content").show();
       // console.log(Storage.getItem('b'));
         Storage.setItem('b',parseInt(Storage.getItem('b'))+1);
    },
    reload:function(){
       $("#handle-1 :checkbox").prop("checked", false);
        var userData = LogicData.getUserData();
        $.ajax({
           url : this.props.dataURL + '?page=1&perPage=20',
           headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
           data : null,
           dataType : 'json',
           async : false,
           success : function(data) {
                LogicData.setOwnStocksData(data)
                this.setState({
                    stockInfo: data,
                    isUpdate : !this.state.isUpdate
                })
           }.bind(this),
           error : function(XMLHttpRequest,textStatus, errorThrown) {}
           });
    },
    settop:function(){
         var $tr = $(this).parents("li");
         $tr.fadeOut().fadeIn();
         $("#handle-1").prepend($tr);
    },
    render : function(){
        var newElements =   this.state.stockInfo.map(function(rowData,index){
           return (
                <li className="item  Grid">
                        <div className="checkboxFive">
                            <input type="checkbox" value={rowData.id} id={"checkboxFiveInput"+ index}  />
                            <label htmlFor={"checkboxFiveInput"+ index} ></label>
                        </div>
                        <div className="last col c1  Grid-cell u-1of2">
                            <p className="name">{rowData.name}</p>
                            <p className="symbol">{rowData.symbol}</p>
                        </div>
                        <div className="Grid-cell u-1of4"> <span className="top yo-ico yypf-ico">&#xE804;</span> </div>
                        <div className="Grid-cell u-1of5">  <span className="drag-handle yo-ico yypf-ico">&#xE818;</span></div>
                </li>
            )
        },this);
       var elements=[];
        elements.push(newElements);


        return (
        <div className="yo-flex scroll-in" >
            <header className="yo-header m-header">
                <h2 className="title">我的自选</h2>
                <span className="regret wancheng" onClick={this.getList}>完成</span>
            </header>
            <section className="m-list">
                <ul className="yo-list">
                    <li className="listheader  Grid " >
                            <div className="Grid-cell u-1of2 ">全部产品</div>
                            <div className="Grid-cell u-1of3 ">置顶</div>
                            <div className="Grid-cell u-1of5 ">拖动</div>
                    </li>
                </ul>
            </section>
            <div className="flex1 " >
                 <section className="m-list">
                    <ul className="yo-list" id="handle-1">
                       {elements}
                    </ul>
                 </section>
            </div>
            <section className="m-footlayer">
                <ul className="yo-tabfoot">
                    <li className="item " ><input type="button"  onClick={this.selectAll} value="全部" className="yo-btn yo-btn-s" id="selectAll" /> </li>
                    <li className="item " ><input type="button"  onClick={this.getValue} value="删除" className="yo-btn yo-btn-e " id="getValue" /></li>
                </ul>
            </section>
        </div>
        )
    }
})

module.exports =  Sortable;
