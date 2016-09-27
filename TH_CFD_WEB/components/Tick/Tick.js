var React = require("react");
//React.initializeTouchEvents(true);
var ReactDOM = require('react-dom');
var Picker = require("Picker");
var Base = require("Base");
var LogicData = require("LogicData");
var securityId = Base.urlParse("securityId");
var yesterdayClose = null;
var TipConfirm = require("TipConfirm");
var Tip = require("Tip");
var isdraw2 = true;
var isdraw3 = true;
var isLong = false;
var isLongclick = false;
var invest = 100;
var leverage = 2;
var benj = 0;
var available = 0;
var stockName = null;
var isOpen = true;
var stockPriceAsk = '--';
var stockPriceBid ='--';
var Tick = React.createClass({
  getInitialState: function() {
		return {
      value: 0,
      numberico: true,
      elements: [],
      security: null,
      isUpdate: false
		};
	},
  componentWillMount: function() {
    $.getJSON('http://cfd-webapi.chinacloudapp.cn/api/security/' + securityId, function(result) {
      //console.log(result);
      isOpen = result.isOpen;
      yesterdayClose = result.open;
      stockName = result.name;
      $(".stockPriceAsk").html(result.ask);
      $(".stockPriceBid").html(result.bid);
    });

    var userData = LogicData.getUserData();
    $.ajax({
      url: 'http://cfd-webapi.chinacloudapp.cn/api/user/balance',
      headers: {
        Authorization: 'Basic ' + userData.userId + '_' + userData.token
      },
      dataType: 'json',
      async: false,
      success: function(data) {
        available = data.available.toFixed(0);
        benj = available - invest;
        // $(".benj").html(data.available.toFixed(0));
        $('.spinner').removeClass('active');
        console.log(data);
      }.bind(this),
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
        $('.spinner').removeClass('active');
      }.bind(this)
    });
    $.connection.hub.start().done(this.init);

    var prefix = Base.getBrowserPrefix();
    var hidden = Base.hiddenProperty(prefix);
    var visibilityEvent = Base.visibilityEvent(prefix);
    document.addEventListener(visibilityEvent, function(event) {
      if (document[hidden]) {
        console.log('hidden');
      } else {
        console.log('show');
        $.connection.hub.error(function(error) {
          console.log(error);
          $.connection.hub.start().done(this.init);
        });
      }
    }.bind(this));

  },
  componentDidMount: function() {
    //up
    $(".yo-btn-c").click(function() {
      $(this).addClass('yo-btn-chover');
      $(".imgup").attr("src", 'images/click-up.png');

      $(".yo-btn-d").removeClass('yo-btn-dhover')
      $(".imgdown").attr("src", 'images/down.png');

      $("#position").removeClass('yo-btn-g');
      $("#position").addClass('yo-btn-g1');

      isLong = false;
      isLongclick = true;
    });

    //down
    $(".yo-btn-d").click(function() {
      $(this).addClass('yo-btn-dhover');
      $(".imgdown").attr("src", 'images/click-down.png');

      $(".yo-btn-c").removeClass('yo-btn-chover')
      $(".imgup").attr("src", 'images/up.png');

      $("#position").removeClass('yo-btn-g');
      $("#position").addClass('yo-btn-g1');
      isLong = true;
      isLongclick = true;
    });

    $("#numberico").click(function() {
      $(".divid").show();
      var _height = $(window).height();
      $(".divid").css("bottom", -$(".flex").scrollTop());
    });


    $("td").click(function() {
      var num = $("#number").html();
      var value = $(this).html();
      if (value != '') {
        var newNum = 0;
        if ($(this).attr('class') === undefined) {
          newNum = num + value;
          $("#number").html(num + value);
        } else {
          if (num) {
            newNum = num.substr(0, num.length - 1);
            $("#number").html(newNum);
          }
        }
        if (parseInt(newNum) < 10) {
          $(".f23719").html('最低金额10美金!');
        } else {
          $(".f23719").html('');
        }
      }
    });


    $("#position").click(function() {
      console.log(isOpen);
      if (isOpen) {
        if (isLongclick) {
          $('.spinner').addClass('active');
          var userData = LogicData.getUserData();
          console.log({
            'securityId': securityId,
            'isLong': isLong,
            'invest': invest,
            'leverage': leverage
          });
          $.ajax({
            url: 'http://cfd-webapi.chinacloudapp.cn/api/position',
            headers: {
              Authorization: 'Basic ' + userData.userId + '_' + userData.token
            },
            data: {
              'securityId': securityId,
              'isLong': isLong,
              'invest': invest,
              'leverage': leverage
            },
            type: 'POST',
            dataType: 'json',
            //async : false,
            success: function(data) {
              TDAPP.onEvent("WebAPP","下单成功");
              $('.spinner').removeClass('active');
              data.stockName = stockName;
              data.isCreate = true;
              data.invest = invest;
              data.leverage = leverage;
              data.createAt = new Date(data.createAt);
              console.log(data);
              this.refs['confirmPage'].show(data);
              $(".pop").show();
            }.bind(this),
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              $('.spinner').removeClass('active');
              console.log(XMLHttpRequest.responseText.Message);
              this.refs['confirmTip'].show(JSON.parse(XMLHttpRequest.responseText).Message)
              $(".pop").show();
            }.bind(this)
          });
        } else {

          this.refs['confirmTip'].show("请选择下单类型");
          $(".pop").show();
        }
      } else {

        this.refs['confirmTip'].show("未开市");
        $(".pop").show();
      }
    }.bind(this));

    $(".yo-ticktab .item").click(function() {
      var index = $(this).index();
      $(".yo-ticktab li").removeClass('item-on');
      $(this).addClass('item-on');

      $(".char").removeClass('container ');
      $("#container" + index).addClass('container');
      switch (index) {
        case 0:
          $("#container0").removeClass('none');
          $("#container1").addClass('none');
          $("#container2").addClass('none');
          //draw(securityId,yesterdayClose);
          break;
        case 1:
          if (isdraw2) {
            draw2(securityId, yesterdayClose);
            isdraw2 = false;
          }
          $("#container0").addClass('none');
          $("#container1").removeClass('none');
          $("#container2").addClass('none');
          break;
        case 2:
          $("#container0").addClass('none');
          $("#container1").addClass('none');
          $("#container2").removeClass('none');
          if (isdraw3) {
            draw3(securityId, yesterdayClose);
            isdraw3 = false;
          }
          break;
      }
    });

    $.connection.Q.client.p = (stockInfo) => {

      var result = stockInfo[0];
      $(".stockPriceAsk").html(result.ask);
      $(".stockPriceBid").html(result.bid);
    }
  },
  init: function() {
    $.connection.Q.server.S(securityId);
  },
  componentWillUnmount: function() {
    $.connection.hub.stop()
  },
  setToOwn: function(isownStock) {

    var userData = LogicData.getUserData();
    if (isownStock) {
      $.ajax({
        url: 'http://cfd-webapi.chinacloudapp.cn/api/security/bookmark?securityIds=' + securityId,
        type: 'DELETE',
        headers: {
          Authorization: 'Basic ' + userData.userId + '_' + userData.token
        },
        data: null,
        dataType: 'json',
        async: false,
        success: function(data) {
          if (data.success) {

            var arrStocks = localStorage.getItem('StockToOwn').split(',');
            arrStocks.splice($.inArray(securityId, arrStocks), 1);
            var result = ''
            for (var i = 0; i < arrStocks.length; i++) {
              result += (arrStocks[i] + ',')
            };
            result = result.substring(0, result.length - 1);
            localStorage.setItem('StockToOwn', result);
            this.setState({
              isUpdate: !this.state.isUpdate
            });
          }
        }.bind(this),
        error: function(XMLHttpRequest, textStatus, errorThrown) {}
      });
    } else {
      $.ajax({
        url: 'http://cfd-webapi.chinacloudapp.cn/api/security/bookmark?securityIds=' + securityId,
        headers: {
          Authorization: 'Basic ' + userData.userId + '_' + userData.token
        },
        type: "POST",
        data: null,
        dataType: 'json',
        async: false,
        success: function(data) {
          if (data.success) {
            localStorage.setItem('StockToOwn', localStorage.getItem('StockToOwn') + ',' + securityId);
            this.setState({
              isUpdate: !this.state.isUpdate
            });
          }
        }.bind(this),
        error: function(XMLHttpRequest, textStatus, errorThrown) {}
      });
    }
  },
  showCallback: function() {
    console.log('showCallback');
    window.location.replace('PositionPage.html');
  },
  getmaxLeverage: function() {
    var leverage=[];
    $.ajax({
      url: 'http://cfd-webapi.chinacloudapp.cn/api/security/' + securityId,
      type: "get",
      dataType: 'json',
      async: false,
      success: function(data) {
        var maxLeverage =data.maxLeverage;
        for (var i = 0; i < maxLeverage; i++) {
              if(i===0){
                leverage[i]="无"
              }else{
                leverage[i]=i+1
              }
        }
        if (data.levList !== undefined) {
			       leverage = data.levList
             leverage[0]="无";
		    }
      }
    });
    return leverage;
  },
  render: function() {
    var  leverage=this.getmaxLeverage();

    var arrStocks = localStorage.getItem('StockToOwn').split(',');
    var isownStock = $.inArray(securityId, arrStocks) !== -1;
    var headers = (
      <section >
                      <header className="yo-header yo-header-normal">
                          <div className="title"></div>
                            <a href="StockPage.html" className="regret yo-ico yypf-ico ">&#xE802;</a>
                         <span className="affirm "><input type="button" value={isownStock ? '- 自选': '+ 自选' }
                         onClick={this.setToOwn.bind(this,isownStock)}
                        className="yo-btn-h" />
                         </span>
                      </header>

                      </section>
    );

    var bodys = (
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
                <li className="item " >
                  <div className="yo-btn yo-btn-c Grid">
                    <div className="Grid-cell u-1 stockPriceAsk">{stockPriceAsk}</div>
                    <div className=" Grid-cell u-1of5 "> <img className="imgup" src="images/up.png" />  </div>
                  </div>
                </li>
                <li className="item " >
                  <div className="yo-btn yo-btn-d Grid">
                    <div className="Grid-cell u-1 stockPriceBid">{stockPriceBid}</div>
                    <div className=" Grid-cell u-1of5 "> <img className="imgdown" src="images/down.png" />  </div>
                  </div>
                </li>
           </ul>
    </section>
    <section >
            <ul className="yo-tab1">
                <li className="item " > <div className="">本金(美元)</div> </li>
                <li className="item " > <div className="">杠杆(倍)</div></li>
           </ul>
    </section>
    <section className="yo-picker">
          <div className="item Grid" >
              <div className=" Grid-cell u-1of2" id="picker"> { <Pickernum   />} </div>
               <div className=" Grid-cell u-1of2" id="picker1">{ <Pickerleverage propGroups={leverage}   />}</div>
           </div>
    </section>
    <section className="yo-manage"  >
                <p className="item " > 账户剩余资金:<span className="benj">{benj}</span>美元</p>
                <p className="item " >  <input type="button" value={isOpen ? "确认":"未开市"} className="yo-btn  yo-btn-g" id="position" /></p>

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
                 <TipConfirm ref='confirmPage'  />
                 <Tip ref='confirmTip' />

               </div>
    )

  }
});

var Pickernum = React.createClass({
  getInitialState: function() {
    return {
      //currentSelectedTab : 0,
      numberico: true,
      value: 0,
      valueGroups: {
        Num: 100
      },
      optionGroups: {
        Num: [100, 500, 1000, 2000, 3000, 5000, 7000, 10000, 20000]
      }
    }
  },
  componentWillMount: function() {
    invest = 100;
  },
  componentDidMount: function() {

    $(".wanc").click(function() {
      $(".divid").hide();
      if ($(".f23719").html() == '' && parseInt($("#number").html()) > 10) {

        this.setState({
          valueGroups: {
            Num: $("#number").html()
          },
          optionGroups: {
            Num: [100, 500, 1000, 2000, 3000, 5000, 7000, 10000, 20000, $("#number").html()]
          }
        })
        $(".benj").html(parseInt(available) - parseInt($("#number").html()));
        invest = parseInt($("#number").html());
        $("#number").html('');
      }
    }.bind(this));
  },
  getValue: function() {
    return this.setState.value;
  },
  handleChange: function(name, value) {

    $(".benj").html(parseInt(available) - parseInt(value));
    invest = parseInt(value);
    this.setState(({
        valueGroups
      }) => ({
        valueGroups: {
          valueGroups,
          [name]: value
        },
        value: value
      })

    );
  },
  render: function() {

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

var Pickerleverage = React.createClass({
  propTypes :{
              propGroups : React.PropTypes.object
          },
  getInitialState: function() {
    return {
      //currentSelectedTab : 0,
      numberico: false,
      value: 0,
      valueGroups: {
        Num: 2
      },
      optionGroups: {
        Num: this.props.propGroups
      }
    }
  },
  getValue: function() {
    return this.setState.value;
  },
  handleChange: function(name, value) {
    leverage = value !== '无' ? value : 0;
    this.setState(({
      valueGroups
    }) => ({
      valueGroups: {
        valueGroups,
        [name]: value
      },
      value: value
    }));
  },
  render: function() {

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

ReactDOM.render(
  <Tick   />,
  document.getElementById("contcontainer")
);
