"use strict";
function YieldView(e) {
    this.$el = $(e.el), this.cacheDoms(), this.initEvents()
}
var pageName = "yield", userId = util.urlParse("userId"), positionId = util.urlParse("positionId"), dataObj = null;
YieldView.prototype.render = function(e) {
    return e = e || {}, e.self = e.self || {}, this.$header.html(template("userTemplate", {picUrl: e.self.picUrl,name: e.self.name})), this.$content.html(template("chartTemplate", e)), this.$tips.html(template("tipsTemplate", {referCode: e.self.referCode,durationDays: e.durationDays,roi: e.roi})), this
}, YieldView.prototype.fetch = function() {
    if (userId && positionId) {
        var e = this;
        $.ajax({url: "https://cn1.api.tradehero.mobi/api/social/sharePosition",data: {userId: userId,positionId: positionId},success: function(t) {
                dataObj = t;
                console.log(t), document.title = t.self.name, e.render(t), $.doActionAgain(pageName)
            }})
    }
}, YieldView.prototype.cacheDoms = function() {
    this.$header = this.$el.find(".header"), this.$content = this.$el.find(".yield-container"), this.$tips = this.$el.find(".tips")
}, YieldView.prototype.initEvents = function() {
    this.$el.on("click", ".footer .btn-action", this.doAction.bind(this)), this.$el.on("click", ".btn-download", this.doDownload.bind(this))
}, YieldView.prototype.doDownload = function() {
    $.track({eventType: "ShareDownloadYield",userId: userId,sharerId: userId}, function() {
        $.download()
    })
}, YieldView.prototype.doAction = function(e) {
    window.auth.check() ? ($.track({eventType: "ShareClickYield",userId: window.auth.user.id,sharerId: userId}), $.ajax({type: "POST",url: "https://cn1.api.tradehero.mobi/api/users/" + userId + "/follow/free",beforeSend: function() {
            $(e.target).attr("disabled", "disabled")
        },success: function() {
            $(document).trigger("modal:show", ".modal.action")
        },error: function(e) {
            alert(window.util.getErrorMsg(e.response))
        },complete: function() {
            $(e.target).removeAttr("disabled")
        }})) : window.auth.redirect(pageName)
}, $(function() {
    var e = new YieldView({el: "body"});
    e.fetch(), $.track({eventType: "ShareDisplayYield",userId: userId,sharerId: userId})
});
