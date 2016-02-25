"use strict";
function StockSearchView(t) {
    this.$el = $(t.el), this.cacheDoms(), this.initEvents()
}
// util.urlParse("userId")
var pageName = "StockSearch", id=util.urlParse("id"),name=util.urlParse("name");
StockSearchView.prototype.fetch = function() {
    var t = this;
    $.ajax({
    	url: "https://cn1.api.tradehero.mobi/api/securities/search?q="+id,
    	success: function(R) {
    	 //console.log(R); 
    	 document.title =name, t.render(R)
        }})
}, StockSearchView.prototype.render = function(t) {
    return t = t || t, 
    t.name=t[0].name,
    t.lastPrice=t[0].lastPrice,
    t.chartSymbol=id,
    t.currencyDisplay=t[0].currencyDisplay,
    t.risePercent=id, //t[0].risePercent,
    t.chart=t[0].reutersSymbol,
    this.$content.html(template("StockSearchemplate", t)), 
    this
}, StockSearchView.prototype.cacheDoms = function() {
    this.$content = this.$el.find(".stock-container");
}, StockSearchView.prototype.initEvents = function() {
    this.$el.on("click", ".stock-tabs .tab", this.switchTab.bind(this)), 
    this.$el.on("click", ".btn-action", this.doAction.bind(this)), 
    this.$el.on("click", ".btn-download", this.doAction1.bind(this)),
    this.$el.on("click", ".btn-download1", this.doDownload.bind(this))
}, StockSearchView.prototype.switchTab = function(t) {
    var e = $(t.target).index(), i = this.$el.find(".stock-charts .chart");
    $(t.target).addClass("active").siblings(".tab").removeClass("active"), $(i[e]).addClass("active").siblings(".chart").removeClass("active")
}, StockSearchView.prototype.doDownload = function() {
        $.download()
}, StockSearchView.prototype.doAction = function(t) {
	
	$.track({eventType: "BatchCreateWatchlistPositions", }), $.ajax({type: "POST",url: "https://cn1.api.tradehero.mobi/api/BatchCreateWatchlistPositions" ,data:{securityIds:[id]} ,beforeSend: function() {
        $(t.target).attr("disabled", "disabled")
    },success: function() {
        $(document).trigger("modal:show", ".modal.action")
    },error: function(e) {
        alert(window.util.getErrorMsg( e.response))
    },complete: function() {
        $(t.target).removeAttr("disabled")
    }})
}, StockSearchView.prototype.doAction1 = function(t) {
	
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
    var t = new StockSearchView({el: "body"});
    t.fetch()
    //, $.track({eventType: "ShareDisplaySecurity",userId: userId,sharerId: userId})
});
