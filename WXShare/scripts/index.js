"use strict";

function MatchView(e) {
    this.$el = $(e.el),  this.initEvents()
}
var pageName = "match", userId ="676915" ,userIds="", competitionId = "301";
 
MatchView.prototype.initEvents = function() {
    this.$el.on("click", ".banner", this.doDownload.bind(this))
}, 
MatchView.prototype.doDownload = function() {
        $.download()
},
$(function() {
    var e = new MatchView({el: "body"});
});
