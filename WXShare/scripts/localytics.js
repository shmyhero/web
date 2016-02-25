var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cspan id='cnzz_stat_icon_1253467108'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "v1.cnzz.com/z_stat.php%3Fid%3D1253467108' type='text/javascript'%3E%3C/script%3E"));
$(window).on('load', function () {
    //$('body>span').remove();

    var page = location.href.split('/').pop();
    if (page.indexOf('?') > -1) {
        page = page.split('?')[0];
    }


    (function (l, y, t, i, c, s) {
       // l['LocalyticsGlobal'] = i;
       // l[i] = function () {
       //     (l[i].q = l[i].q || []).push(arguments)
       // };
       // l[i].t = +new Date;
       // (s = y.createElement(t)).type = 'text/javascript';
       // s.src = '//web.localytics.com/v3/localytics.min.js';
       // (c = y.getElementsByTagName(t)[0]).parentNode.insertBefore(s, c);

       // ll('init', '8f24cffb81cc32757a011bd-a6396038-58f6-11e4-a5f7-009c5fda0a25', {} /* Options */);


       // ll('tagEvent', 'open share page', {'Page name': page});
        _czc.push(["_trackEvent", 'page,' + userId, 'load', page, 0, 0]);
        $('.btn-action').on('click', function () {
            if (window.auth.check()) {
                // ll('tagEvent', 'click action button with auth', {'userId': window.auth.user.id, 'page': page });
                _czc.push(["_trackEvent", 'page,' + userId, 'action', page, 0, window.auth.user.id]);
            } else {
                // ll('tagEvent', 'click action button with no auth', {'page': page});
                _czc.push(["_trackEvent", 'page,' + userId, 'action', page, 0, 0]);
            }
        });
        $('.btn-download').on('click', function () {
            // ll('tagEvent', 'click download button', {'page': page});
            _czc.push(["_trackEvent", 'page,' + userId, 'download', page, 0, 0]);
        });
    })(window, document, 'script', 'll');


    var lineLink = location.href;
    var shareTitle = '', descContent = '';
    var changeTitle = function () {
        shareTitle = document.title;
        if (page == 'assets.html' && dataObj) {
            if(dataObj.self.totalWealth >= 250000)
                shareTitle = '一不小心就有25W了，分分钟秒杀富二代';
            else
                shareTitle = '一不小心就有15W了，分分钟秒杀富二代';
        }
        if (page == 'match.html')
            shareTitle = '想上头条就从这个炒股比赛开始，现在参加还送一万美刀！';
        if (page == 'stock.html')
            shareTitle = '摊上大事了，我买了 ' + shareTitle + ' 股票，你看行吗？';
        if (page == 'trade.html' && dataObj) {
            if (dataObj.roi > 0) {
                shareTitle = '股神也就是我的小跟班，跟我炒股有钱赚，你懂的';
            }
            else
                shareTitle = '在股市亏本了，小伙伴们快来帮帮我吧！';
        }
        if (page == 'yield.html') {
            if(dataObj.securityName && dataObj.securityName != "")
                shareTitle = '股神也就是我的小跟班，跟我炒股有钱赚，你懂的'
            else shareTitle = '想上头条就从这个炒股比赛开始，现在参加还送一万美刀！';
        }
        descContent = shareTitle;
    }

    var appid = '';

    function shareFriend() {
        changeTitle();
        //ll('tagEvent', 'second time share to one friend');
        _czc.push(["_trackEvent", 'page,' + userId, 'second time share to one friend', page, 0, 0]);

        WeixinJSBridge.invoke('sendAppMessage', {
            "appid": appid,
            "img_url": 'http://tradehero.b0.upaiyun.com/logo.png',
            "img_width": "200",
            "img_height": "200",
            "link": lineLink,
            "desc": descContent,
            "title": shareTitle
        }, function (res) {
        })
    }

    function shareTimeline() {
        changeTitle();
        //ll('tagEvent', 'second time share to circle');
        _czc.push(["_trackEvent", 'page,' + userId, 'second time share to circle', page, 0, 0]);

        WeixinJSBridge.invoke('shareTimeline', {
            "img_url": 'http://tradehero.b0.upaiyun.com/logo.png',
            "img_width": "200",
            "img_height": "200",
            "link": lineLink,
            "desc": descContent,
            "title": shareTitle
        }, function (res) {
        });
    }

    function shareWeibo() {
        changeTitle();
        //ll('tagEvent', 'second time share to weibo');
        _czc.push(["_trackEvent", 'page,' + userId, 'second time share to weibo', page, 0, 0]);

        WeixinJSBridge.invoke('shareWeibo', {
            "content": descContent,
            "url": lineLink,
        }, function (res) {
        });
    }

    // 当微信内置浏览器完成内部初始化后会触发WeixinJSBridgeReady事件。
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        // 发送给好友
        WeixinJSBridge.on('menu:share:appmessage', function (argv) {
            shareFriend();
        });
        // 分享到朋友圈
        WeixinJSBridge.on('menu:share:timeline', function (argv) {
            shareTimeline();
        });
        // 分享到微博
        WeixinJSBridge.on('menu:share:weibo', function (argv) {
            shareWeibo();
        });
    }, false);


});


