"use strict";
function RankView(e) {
    this.$el = $(e.el), this.cacheDoms(), this.initEvents()
}
var pageName = "rank", userId = util.urlParse("userId"), leaderboardId = util.urlParse("leaderboardId");
RankView.prototype.fetch = function() {
    var e = this;
    userId && leaderboardId && $.ajax({url: "https://cn1.api.tradehero.mobi/api/social/sharePositions",data: {userId: userId,leaderboardId: leaderboardId},success: function(t) {
            console.log(t), document.title = "我的排名:" + t.self.rank, e.render(t), $.doActionAgain(pageName)
        }})
}, RankView.prototype.render = function(e) {
    e = e || {}, e.self = e.self || {}, e.openPositions = e.openPositions || [], e.closedPositions = e.closedPositions || [], this.$header.html(template("headerTemplate", e.self)), this.$tips.html(template("tipsTemplate", {rank: e.self.rank,referCode: e.self.referCode}));
    var t = {name: null,positions: null};
    return e.openPositions.length > 0 ? (t.name = "持仓", t.positions = e.openPositions) : e.closedPositions.length > 0 && (t.name = "平仓", t.positions = e.closedPositions), t.name && this.$content.html(template("positionsTemplate", t)), this
}, RankView.prototype.cacheDoms = function() {
    this.$header = this.$el.find(".header"), this.$content = this.$el.find(".rank-container"), this.$tips = this.$el.find(".tips")
}, RankView.prototype.initEvents = function() {
    this.$el.on("click", ".footer .btn-action", this.doAction.bind(this)), this.$el.on("click", ".btn-download", this.doDownload.bind(this))
}, RankView.prototype.doDownload = function() {
    $.track({eventType: "ShareDownloadRank",userId: userId,sharerId: userId}, function() {
        $.download()
    })
}, RankView.prototype.doAction = function(e) {
    window.auth.check() ? ($.track({eventType: "ShareClickRank",userId: window.auth.user.id,sharerId: userId}), $.ajax({type: "POST",url: "https://cn1.api.tradehero.mobi/api/users/" + userId + "/follow/free",beforeSend: function() {
            $(e.target).attr("disabled", "disabled")
        },success: function() {
            $(document).trigger("modal:show", ".modal.action")
        },error: function(e) {
            alert(window.util.getErrorMsg(e.response))
        },complete: function() {
            $(e.target).removeAttr("disabled")
        }})) : window.auth.redirect(pageName)
}, $(function() {
    var e = new RankView({el: "body"});
    e.fetch(), $.track({eventType: "ShareDisplayRank",userId: userId,sharerId: userId})
});
