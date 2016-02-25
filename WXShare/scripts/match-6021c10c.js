"use strict";

function MatchView(e) {
    this.$el = $(e.el), this.cacheDoms(), this.initEvents()
}
//util.urlParse("userId") util.urlParse("competitionId")
var pageName = "match", userId ="676915" ,userIds="", competitionId = "301";
MatchView.prototype.fetch = function() {
    var e = this;
    userId && competitionId && 
    $.ajax({
    	url: "https://cn1.api.tradehero.mobi/api/recommend",
    	//dataType : "json",
    	success: function(t) {
            console.log(t), e.render(t), document.title = "推荐股神"
        }})
}, 
MatchView.prototype.render = function(e) {
    return e = e || {}, 
    //e.self = e.self || {}, 
    e.securities = e.securities || {}, 
    e.users = e.users || [],
    e.indexid=1,
    e.userIds="",
    $.each(e.users, function(key, value){
    	 e.userIds= e.userIds+ value.id+",";
    }),
    //this.$banner.html( template("bannerTemplate", {name: e.name,description: e.description,endDate: e.endDate,startDate: e.startDate,bannerUrl: e.bannerUrl,exchange: e.exchange})),
    this.$match.html(  template("matchTemplate", e)),
    //this.$tips.html(template("tipsTemplate", {referCode: e.self.referCode})), 
    this
}, 
MatchView.prototype.cacheDoms = function() {
	//this.$banner = this.$el.find(".banner"), 
	this.$match = this.$el.find(".match-container")
	//, this.$tips = this.$el.find(".tips") 
}, 
MatchView.prototype.initEvents = function() {
    this.$el.on("click", ".btn-action", this.doAction.bind(this)), 
    this.$el.on("click", ".btn-download", this.dodow.bind(this)), 
    //this.$el.on("click", ".banner", this.doDownload.bind(this)),
    this.$el.on("click", ".btn-HYP", this.fetch.bind(this)),
    this.$el.on("click", ".dow", this.dodowh.bind(this)),
    this.$el.on("click", ".btn-download1", this.doDownload.bind(this))
}, 
MatchView.prototype.doDownload = function() {
        $.download()
},
MatchView.prototype.dodow = function() {
	$(".dow").show();
},
MatchView.prototype.dodowh = function() {
	$(".dow").hide();
},
MatchView.prototype.doAction = function(e) {
   $.track({eventType: "Batchfollow", }), $.ajax({type: "POST",url: "https://cn1.api.tradehero.mobi/api/users/batchfollow/free" ,data:{ userIds:[e.userIds] },beforeSend: function() {
            $(e.target).attr("disabled", "disabled")
        },success: function() {
            $(document).trigger("modal:show", ".modal.action")
        },error: function(e) {
        	
            alert(window.util.getErrorMsg( e.response))
        },complete: function() {
            $(e.target).removeAttr("disabled")
        }}) 
}, 
$(function() {
    var e = new MatchView({el: "body"});
    e.fetch()
    //, $.track({eventType: "ShareDisplayMatch",userId: userId,sharerId: userId})
});
