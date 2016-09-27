var React = require("react");
React.initializeTouchEvents(true);
var Picker = require("Picker");
var Base = require("Base");
var LogicData = require("LogicData");
var securityId=  Base.urlParse("securityId");
var yesterdayClose=  null;
var TipConfirm = require("TipConfirm");
var Tip = require("Tip");
var isdraw2 =true;
var isdraw3 =true;
var isLong =false;
var isLongclick =false;
var invest= 0;
var leverage=1;
var benj=0;
var stockName=null;
var Tick = React.createClass({
        slideCallback : function(index){
                // this.state.currentSelectedTab=index;
                // console.log('slideCallback');
                // this.init();
        },
        getInitialState: function() {
            return {
                value : 0,
                numberico: true,
                elements:[],
                security:null,
                isUpdate : false
            }
        },
        componentWillMount: function() {
              $.getJSON('http://cfd-webapi.chinacloudapp.cn/api/security/'+securityId, function (result) {
                 yesterdayClose=  result.preClose;
                 stockName= result.name;
              })
              var userData = LogicData.getUserData();
              $.ajax({
                          url : 'http://cfd-webapi.chinacloudapp.cn/api/user/balance',
                          headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                          dataType : 'json',
                          async : false,
                          success : function(data) {
                           benj=data.available.toFixed(0);
                           // $(".benj").html(data.available.toFixed(0));
                             console.log(data);
                          }.bind(this),
                          error : function(XMLHttpRequest,textStatus, errorThrown) {
                            console.log(XMLHttpRequest);
                          }.bind(this)
                      });
            //$.connection.hub.start().done(this.init);
 
        },
        componentDidMount  : function() {
             //up
        $(".yo-btn-c").click(function(){
                 $(this).addClass('yo-btn-chover');
                 $(this).attr("src",'images/click-up.png'); 

                 $(".yo-btn-d").removeClass('yo-btn-dhover')
                 $(".yo-btn-d").attr("src",'images/down.png');  

                 isLong=false;
                 isLongclick=true;
             });

          //down
            $(".yo-btn-d").click(function(){
                 $(this).addClass('yo-btn-dhover');
                 $(this).attr("src",'images/click-down.png'); 

                 $(".yo-btn-c").removeClass('yo-btn-chover')
                 $(".yo-btn-c").attr("src",'images/up.png');  
                 
                 isLong=true;
                 isLongclick=true;
             });

           $("#numberico").click(function(){
               $(".divid").show();
               var _height= $(window).height();
               $(".divid").css("bottom",-$(".flex").scrollTop());
             });

      
            $("td").click(function(){
              var num=  $("#number").html();
              var value = $(this).html();
              if(value!='')
              {
                  var newNum=0;
                  if($(this).attr('class')===undefined){
                        newNum=num+value;
                        $("#number").html(num+value);
                  }else{
                         if(num){
                            newNum = num.substr(0, num.length - 1);
                            $("#number").html(newNum);
                         } 
                  }
                  if( parseInt(newNum)<10)
                  {
                    $(".f23719").html('最低金额10美金!');
                  }else
                  {
                    $(".f23719").html('');
                  }
              }
            });


            $("#position").click(function(){
              if(isLongclick){
                  var userData = LogicData.getUserData();
                  console.log({'securityId':securityId,'isLong':isLong,'invest':invest,'leverage':leverage});
                  $.ajax({
                          url : 'http://cfd-webapi.chinacloudapp.cn/api/position',
                          headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                          data : {'securityId':securityId,'isLong':isLong,'invest':invest,'leverage':leverage},
                          type: 'POST',
                          dataType : 'json',
                          async : false,
                          success : function(data) {
                             data.stockName=stockName;
                             data.isCreate=true;
                             data.createAt = new Date(data.createAt);
                             console.log(data);
                             this.refs['confirmPage'].show(data);
                             $(".pop").show();
                          }.bind(this),
                          error : function(XMLHttpRequest,textStatus, errorThrown) {
                            console.log(XMLHttpRequest);
                            this.refs['confirmTip'].show(JSON.parse(XMLHttpRequest.responseText).Message)
                            
                          }.bind(this)
                      });
                   }else{
                    
                   }    
              }.bind(this));

            $(".yo-ticktab .item").click(function(){
                 var index= $(this).index();
                   $(".yo-ticktab li").removeClass('item-on');
                   $(this).addClass('item-on');

                   $(".char").removeClass('container ');
                   $("#container"+index).addClass('container');
                    switch(index)
                        {
                        case 0: 
                            $("#container0").removeClass('none');
                            $("#container1").addClass('none');
                            $("#container2").addClass('none');
                            //draw(securityId,yesterdayClose);
                         break;
                        case 1:
                            if(isdraw2){
                              draw2(securityId,yesterdayClose);
                              isdraw2=false;
                            }
                            $("#container0").addClass('none');
                            $("#container1").removeClass('none');
                            $("#container2").addClass('none');
                         break;
                        case 2: 
                            $("#container0").addClass('none');
                            $("#container1").addClass('none');
                            $("#container2").removeClass('none');
                            if(isdraw3){
                              draw3(securityId,yesterdayClose);
                              isdraw3=false;
                            }
                         break;
                       }
            }); 
        },
        init: function() {
             // console.log(this.refs['page' + this.state.currentSelectedTab].getShownStocks());
             // $.connection.Q.server.S(this.refs['page' + this.state.currentSelectedTab].getShownStocks()); 
        },
        setToOwn: function(isownStock) {
            console.log(isownStock)
            var userData = LogicData.getUserData();
            if(isownStock){
              $.ajax({
                 url : 'http://cfd-webapi.chinacloudapp.cn/api/security/bookmark?securityIds='+securityId,
                 type: 'DELETE', 
                 headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                 data : null,
                 dataType : 'json',
                 async : false,
                 success : function(data) {
                  if(data.success) {

                      var arrStocks = localStorage.getItem('StockToOwn').split(',');
                      arrStocks.splice($.inArray(securityId,arrStocks),1);
                      var result = ''
                      for (var i = 0; i < arrStocks.length; i++) {
                          result += ( arrStocks[i] + ',')
                      };
                      result = result.substring(0, result.length - 1);
                      localStorage.setItem('StockToOwn',result);   
                      this.setState({isUpdate : !this.state.isUpdate}); 
                      }
                }.bind(this),
                 error : function(XMLHttpRequest,textStatus, errorThrown) {}
            });
            }else{
              $.ajax({
                        url :'http://cfd-webapi.chinacloudapp.cn/api/security/bookmark?securityIds='+securityId,
                        headers: {Authorization: 'Basic ' + userData.userId + '_' + userData.token},
                        type: "POST",
                        data :null ,
                        dataType : 'json',
                        async : false,
                        success : function(data) {
                         if(data.success) {
                          localStorage.setItem('StockToOwn',localStorage.getItem('StockToOwn') + ',' + securityId) ;
                          this.setState({isUpdate : !this.state.isUpdate});   
                          }
                        }.bind(this),
                        error : function(XMLHttpRequest,textStatus, errorThrown) {}
                    }); 
            }
        },
        componentWillUnmount: function() {
            //$.connection.hub.stop()
        },
        showCallback : function(){
                console.log('showCallback');
                window.location.replace('PositionPage.html');
        },
        render : function(){
            var arrStocks = localStorage.getItem('StockToOwn').split(',');
            
            var isownStock=  $.inArray(securityId,arrStocks) !==-1;
            
            var headers=  (
                     <section >
                      <header className="yo-header yo-header-normal">
                          <div className="title"><p className="p1"> </p><p className="p2"></p> </div> 
                            <a href="StockPage.html" className="regret yo-ico yypf-ico ">&#xE802;</a>
                         <span className="affirm "><input type="button" value={isownStock ? '- 自选': '+ 自选' } 
                         onClick={this.setToOwn.bind(this,isownStock)}
                        className="yo-btn-h" />
                         </span>
                      </header>
                      <div className="yo-div "><span>68</span>% 买涨</div>
                          <div className="yo-proportion">
                                  <div className="inner" ></div>
                          </div>
                      </section>
                        );   
            
            var bodys=  (
               <div className="flex "  >
       <section >
            <ul className="yo-ticktab ">
                <li className="item item-on" id="li0">时分</li>
                <li className="item " id="li1">5日</li>
                <li className="item " id="li2">1月</li>
           </ul>
       </section>       
       <div className="yo-group yo-list">
        <div id="container0" className="char container " ></div>
        <div id="container1" className="char " ></div>
        <div id="container2" className="char " ></div>
       </div>
    <section>
            <ul className="yo-tabfoot">
                <li className="item " ><input value="" className="yo-btn yo-btn-c" type="image" src="images/up.png"  /></li>
                <li className="item " ><input value="" className="yo-btn  yo-btn-d" type="image" src="images/down.png" /></li>
           </ul>
    </section>
    <section >
            <ul className="yo-tab1">
                <li className="item " >  <div className="">本金(美元)</div> </li>
                <li className="item " > <div className="">杠杆(倍)</div></li>
           </ul>
    </section>
    <section className="yo-picker">
          <div className="item Grid" >
              <div className=" Grid-cell u-1of2" id="picker"> { <Pickernum   />} </div>
               <div className=" Grid-cell u-1of2" id="picker1">{ <PickerTest   />}</div>
           </div> 
    </section>
    <section className="yo-manage"  >
                <p className="item " > 账户剩余资金:<span className="benj">{benj}</span>美元</p>
                <p className="item " > </p> 
                <p className="item " >  <input type="button" value="确认" className="yo-btn  yo-btn-g" id="position" /></p>
                
    </section>
   <div id="divid" className="yo-list divid" >
                        <ul className="yo-list"> 
                        <li className="item Grid ededed" > 
                          <div className="Grid-cell u-1of4 000000"  id="number"></div>
                            <div className="Grid-cell u-1of2 f23719" ></div>
                            <div className="Grid-cell u-1of4 wanc c1b5ecd" >完成</div>
                        </li>
                      </ul>
                        <table id="table_0909099" border="0" cellspacing="0" cellpadding="0"><tbody>
                            <tr><td>1</td><td>2</td><td>3</td></tr>
                            <tr><td>4</td><td>5</td><td>6</td></tr>
                            <tr><td>7</td><td>8</td><td>9</td></tr>
                            <tr><td className="c565759"></td><td>0</td>
                            <td  className="yo-ico yypf-ico c565759">&#xE827;</td></tr>
                        </tbody></table>
    </div> 
</div>
                        );  
        
        return (
               <div >
                  {headers}
                  {bodys}
                 <TipConfirm ref='confirmPage' callback={this.showCallback} />
                 <Tip ref='confirmTip' />
                 
               </div>
        )
             
        }
});

var Pickernum = React.createClass({
        slideCallback : function(index){
                // this.state.currentSelectedTab=index;
                // console.log('slideCallback');
                // this.init();
        },
        getInitialState: function() {
            return {
                //currentSelectedTab : 0,
                numberico: true,
                value:0,
                valueGroups: {
                    Num: '30'
                  }, 
                optionGroups: {
                    Num: ['10', '20', '30', '40', '50', '60']
                  }
            }
        },
        componentWillMount: function() {
            //$.connection.hub.start().done(this.init);
            
        },
        componentDidMount  : function() {

         $(".wanc").click(function(){
              $(".divid").hide();
              if($(".f23719").html()==''&& parseInt($("#number").html())>10){
                  
                  this.setState({
                    valueGroups: {Num: $("#number").html()},
                    optionGroups:{Num: ['10', '20', '30', '40', '50', '60',$("#number").html()]}
                    })
                  $(".benj").html(parseInt(benj) - parseInt($("#number").html()));
                  invest=parseInt($("#number").html());
                  $("#number").html('');
              }
            }.bind(this));
        },
        init: function() {
             // console.log(this.refs['page' + this.state.currentSelectedTab].getShownStocks());
             // $.connection.Q.server.S(this.refs['page' + this.state.currentSelectedTab].getShownStocks()); 
        },
        getValue: function() {
             return this.setState.value;
        },
        onLoadbookmark: function() {
            // console.log(onLoadbookmark);
            // this.refs['page' + this.state.currentSelectedTab].onLoadmore()
        },
        componentWillUnmount: function() {
            //$.connection.hub.stop()
        },
        handleChange : function (name, value) {
            var benj =8000;

            $(".benj").html(parseInt(benj) - parseInt(value));
            this.setState( ({valueGroups}) => ({
              valueGroups: {
               valueGroups,
                [name]: value
              },value: value
            })

            );
        },
        render : function(){
            
            return (
            <div className="page ">
                <main className="page-body">
                  <div className="picker-inline-container">
                      <Picker
                        numberico={this.state.numberico}
                        optionGroups={this.state.optionGroups}
                        valueGroups={this.state.valueGroups}
                        onChange={this.handleChange} />
                    </div>
                 </main>
                
            </div>
            );
        }


});

var PickerTest = React.createClass({
        slideCallback : function(index){
                // this.state.currentSelectedTab=index;
                // console.log('slideCallback');
                // this.init();
        },
        getInitialState: function() {
            return {
                //currentSelectedTab : 0,
                numberico: false,
                value:0,
                valueGroups: {
                    Num: '2'
                  }, 
                optionGroups: {
                    Num: ['无', '2', '3', '4', '5', '6', '7', '8', '9', '10']
                  }
            }
        },
        componentWillMount: function() {

            //$.connection.hub.start().done(this.init);
            
        },
        componentDidMount  : function() {

            // $.connection.Q.client.p =  (stockInfo)=> {
            //      this.refs['page' + this.state.currentSelectedTab].handleStockInfo(stockInfo)
            // }
        },
        init: function() {
             // console.log(this.refs['page' + this.state.currentSelectedTab].getShownStocks());
             // $.connection.Q.server.S(this.refs['page' + this.state.currentSelectedTab].getShownStocks()); 
        },
        onLoadbookmark: function() {
            // console.log(onLoadbookmark);
            // this.refs['page' + this.state.currentSelectedTab].onLoadmore()
        },
        componentWillUnmount: function() {
            //$.connection.hub.stop()
        },
        getValue: function() {
             return this.setState.value;
        },
        handleChange : function (name, value) {
            leverage = value!=='无'? value:0;
            this.setState(({valueGroups}) => ({
              valueGroups: {
               valueGroups,
                [name]: value
              },value: value
            }));
        },
        render : function(){
            
            return (
            <div className="page ">
                <main className="page-body">
                  <div className="picker-inline-container">
                      <Picker
                        numberico={this.state.numberico}
                        optionGroups={this.state.optionGroups}
                        valueGroups={this.state.valueGroups}
                        onChange={this.handleChange} />
                    </div>
                 </main>

            </div>
            );
        }


});

React.render(
<Tick   />,
    document.getElementById("contcontainer")
);

// React.render(
// <Pickernum   />,
//     document.getElementById("picker")
// );

// React.render(
// <PickerTest  />,
//     document.getElementById("picker1")
// );
