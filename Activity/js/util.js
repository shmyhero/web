$(function () {
	var page = location.href.split('/').pop();
	if (page.indexOf('?') > -1) {
	    page = page.split('?')[0];
	}
function urlParse (name) { // 获取url参数
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]")
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search)
        return results == null ? "": decodeURIComponent(results[1])
    }

  // 注意：所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。 
  // 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
  // 完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
  wx.config({
	//debug: true, 
    appId: appId,
    timestamp: timestamp,
    nonceStr: nonceStr,
    signature: signature,
    jsApiList: [
		'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo',
		'hideMenuItems',
		'showMenuItems',
		'hideAllNonBaseMenuItem',
		'showAllNonBaseMenuItem',
		'translateVoice',
		'startRecord',
		'stopRecord',
		'onRecordEnd',
		'playVoice',
		'pauseVoice',
		'stopVoice',
		'uploadVoice',
		'downloadVoice',
		'chooseImage',
		'previewImage',
		'uploadImage',
		'downloadImage',
		'getNetworkType',
		'openLocation',
		'getLocation',
		'hideOptionMenu',
		'showOptionMenu',
		'closeWindow',
		'scanQRCode',
		'chooseWXPay',
		'openProductSpecificView',
		'addCard',
		'chooseCard',
		'openCard'
    	]
  });
 
  var titles=["3000人说明天大盘会涨，反正我是信了","快叫我股神，连续3天猜中大盘走势。"];

  
  var BASE_URL=  null;
  
  switch (ISBASE) {
	case 0:
		BASE_URL="http://myherochina.com/caizd/";
		break;
	case 1:
		BASE_URL="http://amazingsh.com/caizd/";
		break;
	case 2:
		BASE_URL="http://fajiangpin.com/caizd/";
		break;
	case 3:
		BASE_URL="http://myherosh.com/caizd/";
		break;
	case 4:
		BASE_URL="http://tradingsh.com/caizd/";
		break;
	case 5:
		BASE_URL="http://buyingspan.com/caizd/";
		break;
	case 6:
		BASE_URL="http://myheroweb.com/caizd/";
		break;
	case 7:
		BASE_URL="http://cashkindom.com/caizd/";
		break;
	case 8:
		BASE_URL="http://gateofmarket.com/caizd/";
		break;
		
  	};
  var lineLink = BASE_URL+'fn_system.php';
  var shareTitle = titles[Math.floor(Math.random()*2)], descContent = titles[Math.floor(Math.random()*2)];

  function changeTitle() {
  	lineLink=BASE_URL;
  	shareTitle = titles[Math.floor(Math.random()*2)];
  	descContent = shareTitle;
  	if (page == 'index.php')
	    {   
  			if(kcs>0 &&kcs<=3) {
  					shareTitle = "连续"+kcs+"天猜中大盘走势";
  					descContent = "万名股神猜大盘 跟买没错";
  			}else if(kcs>3 &&kcs<=5) {
				    shareTitle = "A股涨跌听我的 每天都猜对";
				    descContent = "万名股神猜大盘 跟买没错";
			}else{
					shareTitle = "猜大盘涨跌 赢千万奖金";
					descContent = "万名股神猜大盘 股市风向标";
			}
	    }
	else if(page == 'follow.php')
		  	{
					if(percent>50){
			  			shareTitle=percent+'%的人说明天股市会跌，还不快清仓';
						descContent = "万名股神猜大盘 股市风向标";
					}else{
				  		shareTitle=100-percent+'%的人说明天股市会涨，反正我是信了';
						descContent = "万名股神猜大盘 跟买没错";
						}
		  }
	else{
			if(lxcz>0 &&lxcz<=3) {
					shareTitle = "连续"+kcs+"天猜中大盘走势";
					descContent = "万名股神猜大盘 跟买没错";
			}else if(lxcz>3 &&lxcz<=5) {
			        shareTitle = "A股涨跌听我的 每天都猜对";
			        descContent = "万名股神猜大盘 跟买没错";
			}else{
					shareTitle = "猜大盘涨跌 赢千万奖金";
					descContent = "万名股神猜大盘 股市风向标";
			}
		}
	}
  wx.ready(function () {
	  
	  changeTitle();
	  wx.checkJsApi({
		    jsApiList: ['onMenuShareTimeline'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
		    success: function(res) {
		    	//alert('chooseImage'+res);
		        // 以键值对的形式返回，可用的api值true，不可用为false
		        // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
		    	}
		    });
	  
	  wx.onMenuShareAppMessage({
	        title: shareTitle, // 分享标题
	        desc: descContent, // 分享描述
	        link: lineLink, // 分享链接
	        imgUrl: "http://myherochina.com/caizd/images/icon.png", // 分享图标
	        type: '', // 分享类型,music、video或link，不填默认为link
	        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
	        success: function () {
	            // 用户确认分享后执行的回调函数
	            $(".pop").hide();
	           _czc.push(['_trackEvent', page, 'ShareAppMessage', 'WeixinJSBridge','1','0']);
	        },
	        cancel: function () {
	            // 用户取消分享后执行的回调函数
	        }
	    });

	  wx.onMenuShareTimeline({
	        title: shareTitle, // 分享标题
	        link: lineLink, // 分享链接
	        imgUrl: "http://myherochina.com/caizd/images/icon.png", // 分享图标
	        success: function () {
	            // 用户确认分享后执行的回调函数
	            $(".pop").hide();
	        	 _czc.push(['_trackEvent', page, 'ShareTimeline', 'WeixinJSBridge','1','0']);
	        },
	        cancel: function () {
	            // 用户取消分享后执行的回调函数
	        }
	    });
  });


	$('.logo').click(function () {
	    $.ajax({
	        url: 'action.php', // 跳转到 action//
	        type: 'post',
	        data: {
	    	action:'download'
	        },
	        cache: false,
	        success: function (obj) {
	        	var data = eval('(' + obj + ')');
	        	
	            ll('Download',function(){
	            	if (data.status == "1") {
		        		 window.location.href="http://a.app.qq.com/o/simple.jsp?pkgname=com.tradehero.th";
		        		 if(navigator.userAgent.match(/iPhone|iPad|iPod/i)){
		        			 		_czc.push(['_trackEvent', pageEvent, '首次下载', 'IOS','1','0']);
		        			 }
		      	   		 else if(navigator.userAgent.match(/Android/i)){
		      	   					_czc.push(['_trackEvent','页面头', '下载', 'Android','1','0']);
		      	   		 	 }
		      	   		 else{
				      		   		alert("亲 暂时不支持您的手机哦! 尽请期待!");
					         }
		      		   }
		        	else
		        	{
		        		window.location.href="http://a.app.qq.com/o/simple.jsp?pkgname=com.tradehero.th";
		        		if(navigator.userAgent.match(/iPhone|iPad|iPod/i)){
		        			_czc.push(['_trackEvent','页面头', '下载', 'IOS','1','0']);
		        		}
		      	   		else if(navigator.userAgent.match(/Android/i)){
		      	   				_czc.push(['_trackEvent','页面头', '下载', 'Android','1','0']);	
		      		   }else{
		      		   		alert("亲 暂时不支持您的手机哦! 尽请期待!");}
		        		
			        }
	            });
	        	
	        	
	        },
	        error: function (XMLHttpRequest, textStatus, errorThrown) {
	        }
	    });
	});

});