function urlParse (name) { // 获取url参数
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]")
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search)
        return results == null ? "": decodeURIComponent(results[1])
    }

var friendid=urlParse('friendid');
	// 判断微信
	var ua = navigator.userAgent.toLowerCase();
	if (ua.match(/MicroMessenger/i) != "micromessenger") {
		// 不是微信 跳转到 qq 微博登陆页
		var WBQQurl='http://cn.tradehero.mobi/laba/';
		if(friendid=="")
			{
				window.location.replace(WBQQurl+"share.html");
			}
		else
			{
			window.location.replace(WBQQurl+"share.html?friendid="+friendid);
			}
	}
	else
		{
		// 微信页
	var WXurl='http://myherochina.com/labaplus1/';
		if(friendid=="")
		{
			window.location.replace(WXurl+"fn_system.php?source=6");
		}
		else
		{
		window.location.replace(WXurl+"fn_system.php?friendid="+friendid+"&source=6");
		}
		
		}
	
	