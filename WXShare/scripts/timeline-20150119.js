"use strict";
function AssetsView(e) {
    this.$el = $(e.el), this.cacheDoms(), this.initEvents()
}
var pageName = "timeline",  timeLineId = "50597349", dataObj = null;
AssetsView.prototype.fetch = function() {
    var e = this;
   $.ajax({url: "https://cn1.api.tradehero.mobi/api/timeline/"+timeLineId,success: function(t) {
            dataObj = t;
            console.log(t), e.render(t), document.title = "精华帖"
        }})
}, AssetsView.prototype.render = function(e) {
    e = e || {}, 
    e.self = e.self || {} 
}, AssetsView.prototype.cacheDoms = function() {
    this.$content = this.$el.find(".assets-container")
}, AssetsView.prototype.initEvents = function() {
    this.$el.on("click", ".footer .btn-action",this.doAction.bind(this)), 
    this.$el.on("click", ".banner", this.doDownload.bind(this)),
    this.$el.on("click", ".btn-HYP", this.fetch.bind(this))
}, AssetsView.prototype.doDownload = function() {
        $.download()
}, AssetsView.prototype.doAction = function(e) {
		$(".dow").show();
}, $(function() {
    var e = new AssetsView({el: "body"});
    e.fetch()
});
