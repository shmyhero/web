"use strict";
function AssetsView(e) {
    this.$el = $(e.el), this.cacheDoms(), this.initEvents()
}
var pageName = "asserts", userId ="313529", securities="",  txtSearch = util.urlParse("txtSearch"), dataObj = null;
AssetsView.prototype.fetch = function() {
    var e = this;
    if(txtSearch!="")
    	{
    	$("#txtSearch")[0].value=txtSearch;
    	$.ajax({url: "https://cn1.api.tradehero.mobi/api/securities/search?q="+txtSearch,success: function(R) {
    		//dataObj = R;
            console.log(R), e.rendersearch(R), document.title = "推荐股票"
        }});
    	
    	}else{
    userId && $.ajax({url: "https://cn1.api.tradehero.mobi/api/recommend",success: function(t) {
            //dataObj = t;
            //api/securities/search?q=zgyh
            //console.log(t), document.title = t.self.name, e.render(t), $.doActionAgain(pageName)
            console.log(t), e.render(t), document.title = "推荐股票"
        }} );
    	}
       
},
AssetsView.prototype.search = function() {
    	var e = this;
    	 var inputField = $("#txtSearch")[0];
    	 var suggestText = $("#search_suggest")[0];
    	 
    	 if (inputField.value.length > 2) {
        $.ajax({url: "https://cn1.api.tradehero.mobi/api/securities/search?q="+inputField.value,success: function(R) {
            
            console.log(R);
            var sourceText = R;
            if(sourceText.length > 1) {
            	$("#search_suggest").show();
                
                var innerHTML = '<div class="pure-menu pure-menu-scrollable custom-restricted">';
               var i=0;
              $.each(R, function(key, value){
            	    var s='';
					if(i==0){
							s+='<a href="#" class="pure-menu-link libg"   onclick="javascript:setSearch(this.innerHTML);">' +value.reutersSymbol +'/'+ value.name +'</a><ul class="pure-menu-list">';
					}else{
							s+='<li class="pure-menu-item"><a href="#" class="pure-menu-link libg"   onclick="javascript:setSearch(this.innerHTML);">'  +value.reutersSymbol +'/'+ value.name +'</a></li>';
                  	}
					innerHTML += s;
					i++;
              	});
                
                suggestText.innerHTML = innerHTML+'</ul></div>';
            }
            else{
            	$("#search_suggest").hide();
        }
        }});
    	 }else{
         	$("#search_suggest").hide();
         }
    	 
    	 
//    	 var key = e.which;
//         if (key == 13) {
//    	  $.ajax({url: "https://cn1.api.tradehero.mobi/api/securities/search?q="+inputField.value,success: function(R) {
//              console.log(R);
//              var sourceText = R;
//              
//          }});
//         }
}, AssetsView.prototype.render = function(e) {
    e = e || {}, 
    e.self = e.self || {}, 
    
    e.openPositions = e.securities || [], 
    e.securities = e.securities || {};
    $.each(e.openPositions, function(key, value){
  	  if(value.chartSymbol!=null)
  		  {
  		  var list=value.chartSymbol.split(".");
  		  if(list.length> 0 )
  		   value.Symbol=list[0];
  		  }
  		  });

    var t = {name: null,positions: null};
    t.positions = e.openPositions;
    return  this.$content.html(template("positionsTemplate", t)), this
}, AssetsView.prototype.rendersearch = function(e) {
	 var t = this;

    
    $.each(e, function(key, value){
  	  if(value.reutersSymbol!=null)
  		  {
  		  var list=value.reutersSymbol.split(".");
  		  if(list.length> 0 )
  		   value.Symbol=list[0];
  		   value.chartSymbol=value.reutersSymbol;
  		  }
  		  });

    var t = {name: null,positions: null};
    t.positions = e;
    return this.$content.html(template("positionsTemplate", t)), this
}, AssetsView.prototype.cacheDoms = function() {
    this.$content = this.$el.find(".assets-container")
}, AssetsView.prototype.initEvents = function() {
    this.$el.on("click", ".footer .btn-action",this.doAction.bind(this)), 
    this.$el.on("click", ".banner", this.doDownload.bind(this)),
    this.$el.on("click", ".dow", this.dodowh.bind(this)),
    this.$el.on("click", ".btn-HYP", this.fetch.bind(this))
    //this.$el.on("keyup", "#txtSearch", this.search.bind(this))
    //this.$el.on("keydown", "#txtSearch", this.rendersearch.bind(this))
}, AssetsView.prototype.doDownload = function() {
        $.download()
},
AssetsView.prototype.dodowh = function() {
	//$(".dow").hide();
}, AssetsView.prototype.doAction = function(e) {
		$(".dow").show();
}, $(function() {
    var e = new AssetsView({el: "body"});
    e.fetch(), $.track({eventType: "ShareDisplayAssets",userId: userId,sharerId: userId})
});
