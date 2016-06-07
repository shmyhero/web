'use strict'

var userData = {};
var ownStocksData = [];
var USER_DATA_STORAGE_KEY = '@TH_CFD:userData';
var OWN_STOCKS_DATA_STORAGE_KEY = '@TH_CFD:ownStocksData';
var MYSecurity_KEY = '@TH_CFD:MYSecurity_KEY';
var StockToOwn = 'StockToOwn';

var LogicData = {
    //检测浏览器是否支持localStorage
    // if(typeof localStorage == 'undefined'){
    // //创建localStorage
    // var localStorageClass = function(){
    //         this.options = {
    //         expires : 60*24*3600,
    //         domain : "swe_ling@163.com"
    //     }
    // }
    // localStorageClass.prototype = {
    //     //初实化。添加过期时间
    //        init:function(){
    //         var date = new Date();
    //         date.setTime(date.getTime() + 60*24*3600);
    //         this.setItem('expires',date.toGMTString());
    //        },
    //     //内部函数 参数说明(key) 检查key是否存在
    //        findItem:function(key){
    //         var bool = document.cookie.indexOf(key);
    //         if( bool < 0 ){
    //             return true;
    //         }else{
    //             return false;
    //         }
    //        },
    //        //得到元素值 获取元素值 若不存在则返回 null
    //        getItem:function(key){
    //         var i = this.findItem(key);
    //         if(!i){
    //             var array = document.cookie.split(';')
    //             for(var j=0;j<array.length;j++){
    //                 var arraySplit = array[j];
    //                 if(arraySplit.indexOf(key) > -1){
    //                      var getValue = array[j].split('=');
    //                     //将 getValue[0] trim删除两端空格
    //                      getValue[0] = getValue[0].replace(/^\s\s*/, '').replace(/\s\s*$/, '')
    //                     if(getValue[0]==key){
    //                     return getValue[1];
    //                     }else{
    //                     return 'null';
    //                     }
    //                 }
    //             }
    //         }
    //        },
    //        //重新设置元素
    //        setItem:function(key,value){
    //            var i = this.findItem(key)
    //         document.cookie=key+'='+value;
    //        },
    //        //清除cookie 参数一个或多一
    //        clear:function(){
    //            for(var cl =0 ;cl<arguments.length;cl++){
    //             var date = new Date();
    //             date.setTime(date.getTime() - 100);
    //             document.cookie =arguments[cl] +"=a; expires=" + date.toGMTString();
    //         }
    //        }
    // }
    //     var localStorage = new localStorageClass();
    //     localStorage.init();
    // }
    setUserData: function(data) {
        userData = data;
    },

    getUserData: function() {
        var USER_DATA = localStorage.getItem(USER_DATA_STORAGE_KEY);
        userData = JSON.parse(USER_DATA);
        return userData;
    },
    loadStockToOwnSty: function() {
        var SecurityList = localStorage.getItem(StockToOwn);
        MYSecurityList = JSON.parse(SecurityList);
        return MYSecurityList;
    },

    loadMYSecurityData: function() {
        var Security = localStorage.getItem(MYSecurity_KEY);
        MYSecurityData = JSON.parse(Security.substr(1, Security.length));
        return MYSecurityData;
    },

    setMYSecurityData: function(SecurityData) {
        localStorage.setItem(MYSecurity_KEY, "'" + JSON.stringify(SecurityData));
    },

    loadOwnStocksData: function() {
        var ownStocks = localStorage.getItem(OWN_STOCKS_DATA_STORAGE_KEY);
        if (ownStocks !== null) {
            ownStocksData = JSON.parse(ownStocks.substr(1, ownStocks.length));
        }
        return ownStocksData;
    },

    setOwnStocksData: function(stocksData) {
        ownStocksData = stocksData
        localStorage.setItem(OWN_STOCKS_DATA_STORAGE_KEY, "'" + JSON.stringify(ownStocksData));
    },

    getOwnStocksData: function() {
        return ownStocksData
    },

    addStockToOwn: function(stockData) {
        console.log(stockData);

        var findResult = ownStocksData.find((stock) => {
            return stock.id === stockData.id
        })
        if (findResult === undefined) {
            ownStocksData.unshift(stockData)
            localStorage.setItem(OWN_STOCKS_DATA_STORAGE_KEY, "'" + JSON.stringify(ownStocksData));
        }
        console.log(ownStocksData);
        // if exist, not update.
        return ownStocksData
    },

    removeStockFromOwn: function(stockData) {
        var index = ownStocksData.findIndex((stock) => {
            return stock.id === stockData.id
        })
        if (index != -1) {
            ownStocksData.splice(index, 1)
            localStorage.setItem(OWN_STOCKS_DATA_STORAGE_KEY, "'" + JSON.stringify(ownStocksData));
        }
        return ownStocksData
    }
};

module.exports = LogicData;
