<?php
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');


$registerUrl=BASE_URL.'fn_callback.php';
	
?>
<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>处理中...</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="viewport"
	content="initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<!--<script type="text/javascript">
        window.location = "empty.html";
    </script>-->
<style type="text/css">
* {
	box-sizing: border-box;
}

@
keyframes spin {
	from {-webkit-transform: rotate(0);
	transform: rotate(0)
}

to {
	-webkit-transform: rotate(360deg);
	transform: rotate(360deg)
}

}
@
-webkit-keyframes spin {
	from {-webkit-transform: rotate(0)
}

to {
	-webkit-transform: rotate(360deg)
}

}
.spinner {
	border: 4px solid #eee;
	font-size: 40px;
	width: 1em;
	height: 1em;
	border-radius: .5em;
	-webkit-animation: spin 1s linear infinite;
	animation: spin 1s linear infinite;
	border-top-color: #1789d5;
	position: absolute;
	top: 50%;
	left: 50%;
	z-index: 99999;
	margin-left: -.5em;
	margin-top: -.5em;
	display: none
}

.spinner.active {
	display: block
}
</style>
<script type="text/javascript">
    function urlParse (name) { //获取url参数
      name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]")
      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
      results = regex.exec(location.search)
      return results == null ? "": decodeURIComponent(results[1])
    }

    function register(data, succCallback, errorCallback) { //"注册"

      var xhr = new XMLHttpRequest() //不让老子用 XMLHttpRequest 2.0
      // alert(registerUrl+data.token);
      xhr.open('POST', registerUrl+'?token=' + data.token+'&friendid='+ data.friendid, true)
      xhr.setRequestHeader('TH-Language-Code', 'zh-CN')
      xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8")
      xhr.onreadystatechange = function() {
        if(this.readyState == 4) {
        	
          if (this.status == 200){
        	  
            succCallback && succCallback.call(this, arguments)}
          else{
        
            errorCallback && errorCallback.call(this, arguments)}
        }
      }
      xhr.onerror = function() {
        errorCallback && errorCallback.call(this, arguments)
      }
      xhr.send(JSON.stringify(data))
    }

    var versionkey = 'v0.0.hb1', //存储用户数据key
    targetKey = 'v0.0.hb1_target', //存储来源页面key
    registerType=urlParse('type')
    source = urlParse('source'), //来源平台
    pageName = urlParse('pageName') //来自哪个页面
    target = urlParse('target'), //完成业务后的回调页面
    code = urlParse('code'),  //授权后的code
    error = urlParse('error'), //授权错误信息
    status = (function () { //当前状态
      if(!code && !error && !!source) return 1 //请求授权
      if(!!code && (code !== 'authdeny')) return 2 //授权成功
      if((code === 'authdeny') || !!error) return 0 //取消授权或者授权失败了
      return -1
    })(),
    redirect = encodeURIComponent(window.location.origin + window.location.pathname + '?source=' + source + '&pageName=' + pageName), //授权完成后的回调页面(当前页面)
    
    registerUrl = '<?php echo $registerUrl ;?>',//code获取userid的地址
    
    platformMap = { //各平台信息
      4: { //qq
        appid: '101159941',
        oauthUrl: function () {
          return 'https://graph.qq.com/oauth2.0/authorize?display=mobile&response_type=code&scope=get_user_info'
          + '&client_id='
          + this.appid
          + '&state=1'
          + '&redirect_uri='
          + redirect
        }
      },
      5: { //微博
        appid: '1546253421',
        oauthUrl: function () {
          return 'https://api.weibo.com/oauth2/authorize'
          + '?client_id='
          + this.appid
          + '&response_type=code'
          + '&redirect_uri='
          + redirect
        }
      },
      6: { //微信
        //appid: 'wx992a0a8ce6ec3d2b',
        appid: '<?php echo appid ;?>',
        oauthUrl: function() {
          return 'https://open.weixin.qq.com/connect/oauth2/authorize'
          + '?appid='
          + this.appid
          + '&redirect_uri='
          + redirect
          + '&response_type=code'
          + '&scope=snsapi_userinfo'
          + '&state=1#wechat_redirect'
        }
    //redirect_uri=http%3A%2F%2Flocalhost%2Factivity%2Foauth.html%3Fsource%3D6%26pageName%3Dfn_system.php&response_type=code&scope=snsapi_userinfo&state=1&connect_redirect=1#wechat_redirect
      }
    }

    switch(+status) {
      case 0:
        // todo:
        alert('授权失败..')
        break;
      case 1:
        localStorage.setItem(targetKey, target) //保存 来源页面 方便授权成功后回跳
        window.location.replace(platformMap[source].oauthUrl()) //跳转对应平台的授权页面
        break
      case 2:
        register({
          token: code,
          source: source,
          friendid: localStorage.getItem(targetKey).split('=')[1]
        }
        , function() {
          localStorage.setItem('oauthed_' + pageName, 'oauthed') //记录来源页面授权完成 回跳后 通过此字段 来重新完成 跟单 等类似操作
          var result = this.responseText
          localStorage.setItem(versionkey, result) //保存服务端返回的用户信息
          var targeturl = localStorage.getItem(targetKey)
          
          if(!!targeturl) window.location.replace(targeturl) //跳回此次授权的来源页面
        }, function(err) {
          alert('网络不给力呢，请再尝试一下吧~')
        })
        break
      default:
    	  alert('网络不给力呢，请再尝试一下吧~')
        break
    }
    </script>
</head>
<body ontouchstart="">
<div class="spinner active"></div>
</body>
</html>