$(function() {
	var page = location.href.split('/').pop();
	if (page.indexOf('?') > -1) {
		page = page.split('?')[0];
	}

	function urlParse(name) { // 获取url参数
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]")
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search)
		return results == null ? "" : decodeURIComponent(results[1])
	}

	wx.config({
		// debug: true,
		appId: appId,
		timestamp: timestamp,
		nonceStr: nonceStr,
		signature: signature,
		jsApiList: [
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage'
		]
	});

	var BASE_URL = 'http://cn.tradehero.mobi/TH_CFD_WEB/';
	var lineLink = 'http://cn.tradehero.mobi/TH_CFD_WEB/index.php';
	var shareTitle = document.title;
	var descContent = document.title;

	function changeTitle() {

		if (page == 'index.php') {

		}
		else if (page == 'StockPage.php') {
			lineLink = window.location.href;
		}
		else if (page == 'tickview.php') {
			lineLink = window.location.href;
		}
		else if (page == 'PositionPage.php') {
			lineLink = window.location.href;
		}
		else if (page == 'detailShare.php') {
			lineLink = window.location.href;
			var title = document.title.split('||');
			shareTitle = title[0];
			descContent = title[1];
		} else if (page == 'FocusShare.php') {
			lineLink = window.location.href;
			var title = document.title.split('||');
			shareTitle = title[0];
			descContent = title[1];
		} else {
			//lineLink = BASE_URL;
		}

	}

	wx.ready(function() {

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
			imgUrl: "http://cn.tradehero.mobi/TH_CFD_WEB/images/ShareLogo.png", // 分享图标
			type: '', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function() {
				// 用户确认分享后执行的回调函数
				//$(".pop").hide();
				//_czc.push(['_trackEvent', page, 'ShareAppMessage', 'WeixinJSBridge','1','0']);
			},
			cancel: function() {
				// 用户取消分享后执行的回调函数
			}
		});

		wx.onMenuShareTimeline({
			title: shareTitle, // 分享标题
			link: lineLink, // 分享链接
			imgUrl: "http://cn.tradehero.mobi/TH_CFD_WEB/images/ShareLogo.png", // 分享图标
			success: function() {
				// 用户确认分享后执行的回调函数
				//$(".pop").hide();
				// _czc.push(['_trackEvent', page, 'ShareTimeline', 'WeixinJSBridge','1','0']);
			},
			cancel: function() {
				// 用户取消分享后执行的回调函数
			}
		});
	});



});
