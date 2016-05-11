'use strict'

var userData = {};
var wechatAuthData = {};
var wechatUserData = {};
var ownStocksData = [];
var USER_DATA_STORAGE_KEY = '@TH_CFD:userData';
var OWN_STOCKS_DATA_STORAGE_KEY = '@TH_CFD:ownStocksData';
var MYSecurity_KEY = '@TH_CFD:MYSecurity_KEY';
var StockToOwn = 'StockToOwn';

var LogicData = {

	setUserData: function(data) {
		userData = data;
	},

	getUserData: function() {
        var USER_DATA = localStorage.getItem(USER_DATA_STORAGE_KEY);
        userData =JSON.parse(USER_DATA); 
		return userData;
	},
    loadStockToOwnSty: function() {
        var SecurityList = localStorage.getItem(StockToOwn);
        MYSecurityList =JSON.parse(SecurityList); 
        return MYSecurityList;
    },

    loadMYSecurityData: function() {
        var Security = localStorage.getItem(MYSecurity_KEY);
        MYSecurityData =JSON.parse(Security.substr(1, Security.length)); 
        return MYSecurityData;
    },

    setMYSecurityData: function(SecurityData) {
        localStorage.setItem(MYSecurity_KEY,"'" + JSON.stringify(SecurityData));
    },

    loadOwnStocksData: function() {
        var ownStocks = localStorage.getItem(OWN_STOCKS_DATA_STORAGE_KEY);
        ownStocksData =JSON.parse(ownStocks.substr(1, ownStocks.length)); 
        return ownStocksData;
    },

    setOwnStocksData: function(stocksData) {
        ownStocksData = stocksData
 		localStorage.setItem(OWN_STOCKS_DATA_STORAGE_KEY,"'" + JSON.stringify(ownStocksData));
    },

    getOwnStocksData: function() {
        return ownStocksData
    },

    addStockToOwn: function(stockData) {
        console.log(stockData);
        
    	var findResult = ownStocksData.find((stock)=>{return stock.id === stockData.id})
    	if (findResult === undefined) {
    		ownStocksData.unshift(stockData)
            localStorage.setItem(OWN_STOCKS_DATA_STORAGE_KEY,"'" + JSON.stringify(ownStocksData));
    	}
        console.log(ownStocksData);
    	// if exist, not update.
    	return ownStocksData
    },

    removeStockFromOwn: function(stockData) {
    	var index = ownStocksData.findIndex((stock)=>{return stock.id === stockData.id})
    	if (index != -1) {
    		ownStocksData.splice(index, 1)
 			localStorage.setItem(OWN_STOCKS_DATA_STORAGE_KEY,"'" + JSON.stringify(ownStocksData));
    	}
    	return ownStocksData
    }
};

module.exports = LogicData;