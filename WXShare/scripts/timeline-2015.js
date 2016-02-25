"use strict";
function TimelineView(e) {
    this.$el = $(e.el), this.cacheDoms(), this.initEvents()
}
var pageName = "timeline", userId ="313529", securities="", dataObj = null;
TimelineView.prototype.fetch = function() {
    var e = this;
    userId && $.ajax({url: "rsstoxml.php",success: function(t) {
            dataObj = t;
            e.render(t), document.title = "资讯"
        }})
},TimelineView.prototype.dodowh = function() {}
, TimelineView.prototype.render = function(e) {
    e = e || {}, 
    e.self = e.self || {}; 
    
    var t = {name: null,positions: null};
  $.each(e.channel.item, function(key, value){
	  if(value.pubDate!=null)
		  {
	     var datetime = new Date(value.pubDate);
		 var year = datetime.getFullYear();
		 var month = datetime.getMonth()+1;//js从0开始取 
		 var date = datetime.getDate(); 
		 var hour = datetime.getHours(); 
		 var minutes = datetime.getMinutes(); 
		 var second = datetime.getSeconds();
		 
		 if(month<10){
		  month = "0" + month;
		 }
		 if(date<10){
		  date = "0" + date;
		 }
		 if(hour <10){
		  hour = "0" + hour;
		 }
		 if(minutes <10){
		  minutes = "0" + minutes;
		 }
		 //if(second <10){
		 // second = "0" + second ;
		 //}
		 var time = month+"-"+date+" "+hour+":"+minutes ; 
		 var sdate = year +"-"+month+"-"+date+" "+hour+":"+minutes+":"+second; //2009-06-12 17:18:05
	     value.pubDate=time;
	     value.Date=sdate;
	     
		  }
//	  if(value.description!=""){
//		  
//		  //value.description=value.description.replace('<br/>','\n') ;
//		  value.description=value.description.substring(0,value.description.indexOf('<a href="http://xueqiu.com'));  
//	  }
  });
  	t.positions =e.channel.item; 
    console.log(t.positions);
    return  this.$content.html(template("timelineTemplate", t)), this
}, TimelineView.prototype.cacheDoms = function() {
    this.$content = this.$el.find(".Timeline-container")
}, TimelineView.prototype.initEvents = function() {
    this.$el.on("click", ".footer .btn-action",this.doAction.bind(this)), 
    this.$el.on("click", ".banner", this.doDownload.bind(this)),
    this.$el.on("click", ".dow", this.dodowh.bind(this)),
    this.$el.on("click", ".btn-HYP", this.fetch.bind(this))
}, TimelineView.prototype.doDownload = function() {
        $.download()
}
, TimelineView.prototype.doAction = function(e) {
		$(".dow").show();
}, $(function() {
    var e = new TimelineView({el: "body"});
    e.fetch(),
    $.track({eventType: "ShareDisplayTimeline",userId: userId,sharerId: userId})
});
