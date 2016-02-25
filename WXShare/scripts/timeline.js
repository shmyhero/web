var pageName = 'timeline';
var timeLineId = util.urlParse('id');
var response = null;
var responseitem = null;

function fetchTimeline(){
    var timeLineId = util.urlParse('id');
    //var response = null;
    var ajax = false;
    if(window.XMLHttpRequest)
        ajax = new XMLHttpRequest();
    else if(window.ActiveXObject)
        ajax = new ActiveXObject("Microsoft.XMLHTTP");

    var body = {"clientType":4,
                "clientVersion":"3.1.0.390",
                "deviceToken":"",
                "device_access_token":"",
                "useOnlyHeroCount":true,
                "isEmailLogin":true}

    var url = "https://cn1.api.tradehero.mobi/api/timeline/"+timeLineId;
    if(ajax != null)
    {
        ajax.open("GET",url,true);
        ajax.setRequestHeader("TH-Api-Key","TradeheroTempKey01");
        //ajax.setRequestHeader("Authorization","Basic amFja0B0cmFkZWhlcm8ubW9iaToxMTExMTE=");
        ajax.setRequestHeader("Content-Type","application/json; charset=UTF-8");
        ajax.send(JSON.stringify(body));
    }
    ajax.onreadystatechange=function(){
        if(ajax.status == 200){
            if(ajax.readyState == 4){
                var res = ajax.responseText;
                response = JSON.parse(res);
                renderTimeline();
            }
        }
    }
}


function fetchTimelineItem(){
    var timeLineId = util.urlParse('id');
    var ajax = false;
    if(window.XMLHttpRequest)
        ajax = new XMLHttpRequest();
    else if(window.ActiveXObject)
        ajax = new ActiveXObject("Microsoft.XMLHTTP");

    var body = {"clientType":4,
                "clientVersion":"3.1.0.390",
                "deviceToken":"",
                "device_access_token":"",
                "useOnlyHeroCount":true,
                "isEmailLogin":true}

    var url = "https://cn1.api.tradehero.mobi/api/discussions/timelineitem/"+timeLineId+"?page=1&perPage=10";    if(ajax != null){
        ajax.open("GET",url,true);
        ajax.setRequestHeader("TH-Api-Key","TradeheroTempKey01");
        //ajax.setRequestHeader("Authorization","Basic amFja0B0cmFkZWhlcm8ubW9iaToxMTExMTE=");
        ajax.send(JSON.stringify(body));
    }
    ajax.onreadystatechange=function(){
        if(ajax.status == 200){
            if(ajax.readyState == 4){
                var res = ajax.responseText;
                responseitem = JSON.parse(res);
                renderTimelineitem();
            }
        }
    }
}
function renderTimeline(){

    var createatutc = response.createdAtUtc;//时间    2014-12-10T03:41:48
    var text = response.text;//内容
    var comcount = response.commentCount;//评论数
    var upvote = response.upvoteCount;//点赞数
    var user = response.user;//
    var pic = user.picture;//头像
    var displayname = user.displayName;


  /*  var items = responseitem.data;
    var itemcreatedatutc = new Array();
    var itemtext = new Array();
    var itemdisplayname = new Array();
    var itempic = new Array();
    for(var i = 0 ;i < items.length ;i++){
        itemcreatedatutc.push(items[i].createdAtUtc); 
        itemtext.push(items[i].text);
        itemdisplayname.push(items[i].user.displayName);
        itempic.push(items[i].user.picture);
    }//评论信息
    */
    var t = parseText(text);
    var time = toNiceTime(createatutc);
    $("#img").attr('src',pic);
    $("#nicname").text(displayname);
    $("#maintime").text(time);
    $("#cont").html(t);
    $("#up .spanl").text(upvote);
    $("#com .spanl").text(comcount);

    
}

function renderTimelineitem(){
    var items = responseitem.data;
    var itemcreatedatutc = new Array();//评论时间
    var itemtext = new Array();//评论内容
    var itemdisplayname = new Array();//评论名
    var itempic = new Array();//评论者头像
    for(var i = 0 ;i < items.length ;i++){
        itemcreatedatutc.push(items[i].createdAtUtc); 
        itemtext.push(items[i].text);
        itemdisplayname.push(items[i].user.displayName);
        itempic.push(items[i].user.picture);
        
        var time = toNiceTime(itemcreatedatutc[i]);
        var a = $("<div class='comitem'></div>");
        $('#comment').append(a);
        $(a).append($("<img>").attr('src',itempic[i]));  
        $(a).append($("<div class='cname name'>").text(itemdisplayname[i]));  
        $(a).append($("<div class='ccont spanl'>").text(itemtext[i]));//!!!!
        $(a).append($("<div class='ctime spanl'>").text(time));
        $(a).append($("<div class='corder spanl'>").text((i+1)+"楼"));


        /*var a=$("<div class='cimg spanl'>").append($("<img>").attr('src',itempic[i]));
        var b=$("<div class='ccont spanl'>").text(itemtext[i]);
        var c=$("<div class='ctime spanl'>").text(itemcreatedatutc[i]);
        var d=$("<div class='corder spanl'>").text(i+"楼");
        var e=$("<div class='comitem'>");
        e.append(a);
        e.append(b);
        e.append(c);
        e.append(d);
        $('#comment').append(e);*/
    }

}


function parseText(text){
      var r1 = new RegExp("\\[.*\\]");
      var r2 = new RegExp("\\(.*\\)");
      var r3 = new RegExp("\\*.*\\*")
      //alert(text);
      var a = text.match(r1);
      var link = text.match(r2);
      var des = text.match(r3);
      //[$SHA:600879](tradehero://security/58644_SHA_600879) *还要跌*"
      a = a[0];
      link = link[0];
      des = des[0];
      if(a != null){
         a = a.slice(1,a.length-1);
      }
      if(link != null){
        link = link.slice(1,link.length-1);
      }
      if(des != null){
        des = des.slice(1,des.length-1);
      }
      
      var html = "<a href='" + link + "'>" + a + "</a>" +des;
      return html;

}

function toNiceTime(time){
   var now = new Date();
   //2014-11-17T21:10:57

   var timestamp = Date.parse( new Date( time ) );
   var second = Math.floor( ( now - timestamp ) / 1000 );
   if(second < 60) { return "刚刚"; }

   var minute = Math.floor( second / 60 );
   if(minute < 60) { return minute + "分钟前"; }

   var day = Math.floor( minute / 60 / 24 );
   var year = Math.floor( day / 365 );

   if(day == 0)
     {
        var hour = Math.floor( minute / 60 );
        return hour + "小时前";
     }
   var temp = time.split("T"); 
   var ti = temp[0]+" "+temp[1];
   return ti;

}

function doDownload(){
    if (window.util.os.isIOS) { //ios 用户暂时不让下载
      alert('IOS敬请期待!');
      return
    }
    if (util.os.isWeiXin && util.download.wexinAppUrl) { //微信内 跳转到 应用宝
      window.location.href = util.download.wexinAppUrl;
      return
    }
    if (util.os.isAndroid && util.download.androidApkUrl) { //android 下载apk
      window.location.href = util.download.androidApkUrl;
      return
    }
    // if (util.os.isIOS && util.download.appStoreUrl) { //ios 跳转到app store
    //   window.location.href = util.download.appStoreUrl;
    //   return
    // }
    else {
      window.open(util.download.wexinAppUrl);
    }

}

function doAction(){
    
        var ajax = false;
        if(window.XMLHttpRequest)
            ajax = new XMLHttpRequest();
        else if(window.ActiveXObject)
            ajax = new ActiveXObject("Microsoft.XMLHTTP");
        var version = 'v0.0.1'

        //var body = {"userIds":users};

        var token = (JSON.parse(localStorage.getItem(version))).token;

        var url = "https://cn.tradehero.mobi/api/discussions/timelineitem/" + timeLineId + "/vote/up";

        if(ajax != null)
    {
        ajax.open("POST",url,true);
        ajax.setRequestHeader("Authorization",token);
        //token
        //ajax.setRequestHeader("Authorization","Basic amFja0B0cmFkZWhlcm8ubW9iaToxMTExMTE=");
        ajax.setRequestHeader("Content-Type","application/json; charset=UTF-8");
        ajax.send(null);
    }

    ajax.onreadystatechange=function(){
        if(ajax.status == 200){
            if(ajax.readyState == 4){
               

               
            }
        }
    }
}

function upVote(){
     follow();
     var a = document.getElementsByClassName("modal action");
     a[0].className = "modal action show";
}

function doHide(){
     var a = document.getElementsByClassName("modal action");
     a[0].className = "modal action hide";
}

function hide(){
     var a = document.getElementsByClassName("modal share");
     a[0].className = "modal share hide";
}


window.onload = function(){

  fetchTimeline();
  fetchTimelineItem();
  $('.btn-download').bind('click',doDownload);
  $('#shr').bind('click',show);
}

