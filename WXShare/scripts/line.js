"use strict";
function AssetsView(e) {
    this.$el = $(e.el), this.cacheDoms(), this.initEvents()
}
var pageName = "timeline",  timeLineId ="707244136" , dataObj = null;
AssetsView.prototype.fetch = function() {
    var e = this;
    e.render();

}, AssetsView.prototype.render = function() {

//    this.$match.html(template("lineTemplate", {
//    	time:  time,
//    	content: content,
//    	title:  title}))
}, AssetsView.prototype.cacheDoms = function() {
    this.$match = this.$el.find(".match-container")
}, AssetsView.prototype.initEvents = function() {
    this.$el.on("click", ".btn-action",this.doAction.bind(this)), 
    this.$el.on("click", ".banner", this.doDownload.bind(this)),
    this.$el.on("click", ".btn-download1", this.doDownload.bind(this)),
    this.$el.on("click", ".dow", this.dodowh.bind(this)),
    this.$el.on("click", ".btn-download", this.dodow.bind(this))
    
}, AssetsView.prototype.doDownload = function() {
        $.download()
},
AssetsView.prototype.dodow = function() {
	$(".dow").show();
},
AssetsView.prototype.dodowh = function() {
	$(".dow").hide();
},
AssetsView.prototype.doAction = function(e) {
	   $.track({eventType: "Batchfollow", }), $.ajax({type: "POST",url: "https://cn1.api.tradehero.mobi/api/discussions/timelineitem/" + timeLineId + "/vote/up",data:{ } ,beforeSend: function() {
	            $(e.target).attr("disabled", "disabled")
	        },success: function() {
	            $(document).trigger("modal:show", ".modal.action")
	        },error: function(e) {
	        	 console.log(e), 
	            alert(window.util.getErrorMsg( e.response))
	        },complete: function() {
	            $(e.target).removeAttr("disabled")
	        }}) 
}, 
$(function() {
    var e = new AssetsView({el: "body"});
    e.fetch()
});