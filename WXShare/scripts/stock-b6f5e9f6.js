"use strict";
function StockView(t) {
    this.$el = $(t.el), this.cacheDoms(), this.initEvents()
}
// util.urlParse("userId")
var pageName = "stock", id=util.urlParse("id"), name = util.urlParse("name"), lastPrice = util.urlParse("lastPrice"), chartSymbol = util.urlParse("chartSymbol")  ,currencyDisplay=util.urlParse("currencyDisplay"),risePercent=util.urlParse("risePercent"), chart=util.urlParse("chart");
StockView.prototype.fetch = function() {
    var t = this;
//    securityId && userId && $.ajax({url: "https://cn1.api.tradehero.mobi/api/social/shareSecurity",data: {securityId: securityId,userId: userId},success: function(e) {
//            
//        }})
     document.title =name, t.render(t)
    //, $.doActionAgain(pageName)
}, StockView.prototype.render = function(t) {
    return t = t || t, 
    t.self = t.self || {},
    t.name=name,
    t.lastPrice=lastPrice,
    t.chartSymbol=chartSymbol,
    t.currencyDisplay=currencyDisplay,
    t.risePercent=risePercent,
    t.chart=chart,
    this.$content.html(template("stockTemplate", t)), 
    //this.$tips.html(template("tipsTemplate", {referCode: t.self.referCode,name: t.name})),
    this
}, StockView.prototype.cacheDoms = function() {
    this.$header = this.$el.find(".header"), this.$content = this.$el.find(".stock-container"), this.$tips = this.$el.find(".tips")
}, StockView.prototype.initEvents = function() {
    this.$el.on("click", ".stock-tabs .tab", this.switchTab.bind(this)), 
    this.$el.on("click", ".btn-action", this.doAction.bind(this)), 
    this.$el.on("click", ".btn-download", this.doAction1.bind(this)),
    this.$el.on("click", ".btn-download1", this.doDownload.bind(this))
}, StockView.prototype.switchTab = function(t) {
    var e = $(t.target).index(), i = this.$el.find(".stock-charts .chart");
    $(t.target).addClass("active").siblings(".tab").removeClass("active"), $(i[e]).addClass("active").siblings(".chart").removeClass("active")
}, StockView.prototype.doDownload = function() {
        $.download()
}, StockView.prototype.doAction = function(t) {
	
	$.track({eventType: "BatchCreateWatchlistPositions", }), $.ajax({type: "POST",url: "https://cn1.api.tradehero.mobi/api/BatchCreateWatchlistPositions" ,data:{securityIds:[id]} ,beforeSend: function() {
        $(t.target).attr("disabled", "disabled")
    },success: function() {
        $(document).trigger("modal:show", ".modal.action")
    },error: function(e) {
        alert(window.util.getErrorMsg( e.response))
    },complete: function() {
        $(t.target).removeAttr("disabled")
    }})
}, StockView.prototype.doAction1 = function(t) {
	
	$.track({eventType: "BatchCreatePositions", }), $.ajax({type: "POST",url: "https://cn1.api.tradehero.mobi/api/BatchCreatePositions" ,data:{securityIds: [id] },beforeSend: function() {
        $(t.target).attr("disabled", "disabled")
    },success: function() {
        $(document).trigger("modal:show", ".modal.action")
    },error: function(e) {
    	
        alert(window.util.getErrorMsg( e.response))
    },complete: function() {
        $(t.target).removeAttr("disabled")
    }})
}, $(function() {
    var t = new StockView({el: "body"});
    t.fetch()
    //, $.track({eventType: "ShareDisplaySecurity",userId: userId,sharerId: userId})
});
