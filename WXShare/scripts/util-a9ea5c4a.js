!function() {
    function e(e) {
        return e.replace($, "").replace(y, ",").replace(b, "").replace(x, "").replace(S, "").split(k)
    }
    function t(e) {
        return "'" + e.replace(/('|\\)/g, "\\$1").replace(/\r/g, "\\r").replace(/\n/g, "\\n") + "'"
    }
    function n(n, r) {
        function o(e) {
            return d += e.split(/\n/).length - 1, c && (e = e.replace(/\s+/g, " ").replace(/<!--[\w\W]*?-->/g, "")), e && (e = w[1] + t(e) + w[2] + "\n"), e
        }
        function a(t) {
            var n = d;
            if (l ? t = l(t, r) : i && (t = t.replace(/\n/g, function() {
                return d++, "$line=" + d + ";"
            })), 0 === t.indexOf("=")) {
                var o = f && !/^=[=#]/.test(t);
                if (t = t.replace(/^=[=#]?|[\s;]*$/g, ""), o) {
                    var a = t.replace(/\s*\([^\)]+\)/, "");
                    p[a] || /^(include|print)$/.test(a) || (t = "$escape(" + t + ")")
                } else
                    t = "$string(" + t + ")";
                t = w[1] + t + w[2]
            }
            return i && (t = "$line=" + n + ";" + t), v(e(t), function(e) {
                if (e && !g[e]) {
                    var t;
                    t = "print" === e ? y : "include" === e ? b : p[e] ? "$utils." + e : h[e] ? "$helpers." + e : "$data." + e, x += e + "=" + t + ",", g[e] = !0
                }
            }), t + "\n"
        }
        var i = r.debug, u = r.openTag, s = r.closeTag, l = r.parser, c = r.compress, f = r.escape, d = 1, g = {$data: 1,$filename: 1,$utils: 1,$helpers: 1,$out: 1,$line: 1}, m = "".trim, w = m ? ["$out='';", "$out+=", ";", "$out"] : ["$out=[];", "$out.push(", ");", "$out.join('')"], $ = m ? "$out+=text;return $out;" : "$out.push(text);", y = "function(){var text=''.concat.apply('',arguments);" + $ + "}", b = "function(filename,data){data=data||$data;var text=$utils.$include(filename,data,$filename);" + $ + "}", x = "'use strict';var $utils=this,$helpers=$utils.$helpers," + (i ? "$line=0," : ""), S = w[0], k = "return new String(" + w[3] + ");";
        v(n.split(u), function(e) {
            e = e.split(s);
            var t = e[0], n = e[1];
            1 === e.length ? S += o(t) : (S += a(t), n && (S += o(n)))
        });
        var A = x + S + k;
        i && (A = "try{" + A + "}catch(e){throw {filename:$filename,name:'Render Error',message:e.message,line:$line,source:" + t(n) + ".split(/\\n/)[$line-1].replace(/^\\s+/,'')};}");
        try {
            var M = new Function("$data", "$filename", A);
            return M.prototype = p, M
        } catch (T) {
            throw T.temp = "function anonymous($data,$filename) {" + A + "}", T
        }
    }
    var r = function(e, t) {
        return "string" == typeof t ? m(t, {filename: e}) : i(e, t)
    };
    r.version = "3.0.0", r.config = function(e, t) {
        o[e] = t
    };
    var o = r.defaults = {openTag: "<%",closeTag: "%>",escape: !0,cache: !0,compress: !1,parser: null}, a = r.cache = {};
    r.render = function(e, t) {
        return m(e, t)
    };
    var i = r.renderFile = function(e, t) {
        var n = r.get(e) || g({filename: e,name: "Render Error",message: "Template not found"});
        return t ? n(t) : n
    };
    r.get = function(e) {
        var t;
        if (a[e])
            t = a[e];
        else if ("object" == typeof document) {
            var n = document.getElementById(e);
            if (n) {
                var r = (n.value || n.innerHTML).replace(/^\s*|\s*$/g, "");
                t = m(r, {filename: e})
            }
        }
        return t
    };
    var u = function(e, t) {
        return "string" != typeof e && (t = typeof e, "number" === t ? e += "" : e = "function" === t ? u(e.call(e)) : ""), e
    }, s = {"<": "&#60;",">": "&#62;",'"': "&#34;","'": "&#39;","&": "&#38;"}, l = function(e) {
        return s[e]
    }, c = function(e) {
        return u(e).replace(/&(?![\w#]+;)|[<>"']/g, l)
    }, f = Array.isArray || function(e) {
        return "[object Array]" === {}.toString.call(e)
    }, d = function(e, t) {
        var n, r;
        if (f(e))
            for (n = 0, r = e.length; r > n; n++)
                t.call(e, e[n], n, e);
        else
            for (n in e)
                t.call(e, e[n], n)
    }, p = r.utils = {$helpers: {},$include: i,$string: u,$escape: c,$each: d};
    r.helper = function(e, t) {
        h[e] = t
    };
    var h = r.helpers = p.$helpers;
    r.onerror = function(e) {
        var t = "Template Error\n\n";
        for (var n in e)
            t += "<" + n + ">\n" + e[n] + "\n\n";
        "object" == typeof console && console.error(t)
    };
    var g = function(e) {
        return r.onerror(e), function() {
            return "{Template Error}"
        }
    }, m = r.compile = function(e, t) {
        function r(n) {
            try {
                return new s(n, u) + ""
            } catch (r) {
                return t.debug ? g(r)() : (t.debug = !0, m(e, t)(n))
            }
        }
        t = t || {};
        for (var i in o)
            void 0 === t[i] && (t[i] = o[i]);
        var u = t.filename;
        try {
            var s = n(e, t)
        } catch (l) {
            return l.filename = u || "anonymous", l.name = "Syntax Error", g(l)
        }
        return r.prototype = s.prototype, r.toString = function() {
            return s.toString()
        }, u && t.cache && (a[u] = r), r
    }, v = p.$each, w = "break,case,catch,continue,debugger,default,delete,do,else,false,finally,for,function,if,in,instanceof,new,null,return,switch,this,throw,true,try,typeof,var,void,while,with,abstract,boolean,byte,char,class,const,double,enum,export,extends,final,float,goto,implements,import,int,interface,long,native,package,private,protected,public,short,static,super,synchronized,throws,transient,volatile,arguments,let,yield,undefined", $ = /\/\*[\w\W]*?\*\/|\/\/[^\n]*\n|\/\/[^\n]*$|"(?:[^"\\]|\\[\w\W])*"|'(?:[^'\\]|\\[\w\W])*'|\s*\.\s*[$\w\.]+/g, y = /[^\w$]+/g, b = new RegExp(["\\b" + w.replace(/,/g, "\\b|\\b") + "\\b"].join("|"), "g"), x = /^\d[^,]*|,\d[^,]*/g, S = /^,+|,+$/g, k = /^$|,+/;
    o.openTag = "{{", o.closeTag = "}}";
    var A = function(e, t) {
        var n = t.split(":"), r = n.shift(), o = n.join(":") || "";
        return o && (o = ", " + o), "$helpers." + r + "(" + e + o + ")"
    };
    o.parser = function(e) {
        e = e.replace(/^\s/, "");
        var t = e.split(" "), n = t.shift(), o = t.join(" ");
        switch (n) {
            case "if":
                e = "if(" + o + "){";
                break;
            case "else":
                t = "if" === t.shift() ? " if(" + t.join(" ") + ")" : "", e = "}else" + t + "{";
                break;
            case "/if":
                e = "}";
                break;
            case "each":
                var a = t[0] || "$data", i = t[1] || "as", u = t[2] || "$value", s = t[3] || "$index", l = u + "," + s;
                "as" !== i && (a = "[]"), e = "$each(" + a + ",function(" + l + "){";
                break;
            case "/each":
                e = "});";
                break;
            case "echo":
                e = "print(" + o + ");";
                break;
            case "print":
            case "include":
                e = n + "(" + t.join(",") + ");";
                break;
            default:
                if (/^\s*\|\s*[\w\$]/.test(o)) {
                    var c = !0;
                    0 === e.indexOf("#") && (e = e.substr(1), c = !1);
                    for (var f = 0, d = e.split("|"), p = d.length, h = d[f++]; p > f; f++)
                        h = A(h, d[f]);
                    e = (c ? "=" : "=#") + h
                } else
                    e = r.helpers[n] ? "=#" + n + "(" + t.join(",") + ");" : "=" + e
        }
        return e
    }, "function" == typeof define ? define(function() {
        return r
    }) : "undefined" != typeof exports ? module.exports = r : this.template = r
}(), function(e) {
    "use strict";
    e.helper("statusClass", function(e) {
        return e >= 0 ? "up" : "down"
    }), e.helper("abs", function(e) {
        return Math.abs(e)
    }), e.helper("fixed2", function(e, t) {
        if (void 0 === e || null === e)
            return "";
        var n = Math.round(100 * e) / 100;
        return t && (n = (e >= 0 ? "+" : "") + n), n
    }), e.helper("fixed2Percentage", function(e, t) {
        if (void 0 === e || null === e)
            return "";
        var n = Math.round(100 * e * 100) / 100 + "%";
        return t && (n = (e >= 0 ? "+" : "") + n), n
    }), e.helper("currency", function(e) {
        return void 0 === e || null === e ? "" : e
    }), e.helper("w", function(e) {
        return void 0 === e || null === e ? "" : e >= 1e4 ? Math.round(e / 1e4) + "w" : e
    }), e.helper("W", function(e) {
        return void 0 === e || null === e ? "" : e >= 1e4 ? Math.round(e / 1e4 * 100) / 100 + "万" : e
    }), e.helper("shortDate", function(e) {
        if (void 0 === e || null === e)
            return "";
        var t = new Date(e).toISOString();
        return new Date(t).toShortDate()
    }), e.helper("niceDate", function(e) {
        if (void 0 === e || null === e)
            return "";
        var t = new Date(e).toISOString();
        return new Date(t).toShortDate()
    })
}(window.template), function(e) {
    "use strict";
    e.util = {download: {appStoreUrl: "http://a.app.qq.com/o/simple.jsp?pkgname=com.tradehero.th",androidApkUrl: "http://tradehero.b0.upaiyun.com/th_android.apk",wexinAppUrl: "http://a.app.qq.com/o/simple.jsp?pkgname=com.tradehero.th"},os: {isAndroid: navigator.userAgent.match(/Android/i),isIOS: navigator.userAgent.match(/iPhone|iPad|iPod/i),isWeiXin: navigator.userAgent.toLowerCase().match(/micromessenger/),isWeibo: navigator.userAgent.toLowerCase().match(/weibo/),isQQ: navigator.userAgent.toLowerCase().match(/qq/) || navigator.userAgent.toLowerCase().match(/and_sq_/)},urlParse: function(e) {
            e = e.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var t = new RegExp("[\\?&]" + e + "=([^&#]*)"), n = t.exec(location.search);
            return null == n ? "" : decodeURIComponent(n[1])
        },extend: function(e) {
            if (!("function" == typeof e || "object" == typeof e && e))
                return e;
            for (var t, n, r = 1, o = arguments.length; o > r; r++) {
                t = arguments[r];
                for (n in t)
                    e[n] = t[n]
            }
            return e
        },getErrorMsg: function(e) {
            var t = "操作失败了...";
            try {
                t = JSON.parse(e).Message
            } catch (n) {
                console.log(n)
            }finally {
                return t
            }
        }}, Date.prototype.format = function(e) {
        var t = {"M+": this.getMonth() + 1,"d+": this.getDate(),"h+": this.getHours() % 12 == 0 ? 12 : this.getHours() % 12,"H+": this.getHours(),"m+": this.getMinutes(),"s+": this.getSeconds(),"q+": Math.floor((this.getMonth() + 3) / 3),S: this.getMilliseconds()}, n = {0: "日",1: "一",2: "二",3: "三",4: "四",5: "五",6: "六"};
        /(y+)/.test(e) && (e = e.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length))), /(E+)/.test(e) && (e = e.replace(RegExp.$1, (RegExp.$1.length > 1 ? RegExp.$1.length > 2 ? "星期" : "周" : "") + n[this.getDay() + ""]));
        for (var r in t)
            new RegExp("(" + r + ")").test(e) && (e = e.replace(RegExp.$1, 1 == RegExp.$1.length ? t[r] : ("00" + t[r]).substr(("" + t[r]).length)));
        return e
    }, Date.prototype.toShortDate = function() {
        return this.format("MM/dd")
    }, Date.prototype.toNiceTime = function() {
        var e = new Date, t = Math.floor((e - this) / 1e3);
        if (60 > t)
            return "刚刚";
        var n = Math.floor(t / 60);
        if (60 > n)
            return n + "分钟前";
        var r = Math.floor(n / 60 / 24), o = Math.floor(r / 365);
        if (0 == r) {
            var a = Math.floor(n / 60);
            return a + "小时前"
        }
        return 1 == r ? "昨天" + this.format("HH:mm") : 2 == r ? "前天" + this.format("HH:mm") : (0 == o, this.toShortDate())
    }
}(window), function(e) {
    "use strict";
    var t = "v0.0.1", n = "oauth.html", r = {qq: 4,weibo: 5,weixin: 6}, o = r.qq;
    e.auth = {user: {source: function() {
                return e.util.os.isWeiXin ? r.weixin : e.util.os.isWeibo ? r.weibo : e.util.os.isQQ ? r.qq : o
            }(),id: null,token: null},getLocal: function() {
            var e = JSON.parse(localStorage.getItem(t));
            e && e.id && e.token && auth.extendUser(e)
        },check: function() {
            return e.auth.user.id && e.auth.user.token ? !0 : !1
        },extendUser: function(t) {
            e.util.extend(auth.user, t)
        },redirect: function(e) {
            window.location.replace(n + "?source=" + auth.user.source + "&pageName=" + e + "&target=" + encodeURIComponent(window.location.href))
        }}, e.auth.getLocal()
}(window), function(e, t) {
    "use strict";
    //var n = {"TH-Api-Key": "TradeheroTempKey01","TH-Language-Code": "zh-CN"};
    var n = {"TH-Api-Key": "TradeheroTempKey01","TH-Language-Code": "zh-CN","Authorization":"TH-WeChatU otwHxjmPO8e-6eUbblUTyx-Tpkxw"};
    e.auth.check() && (n.Authorization = e.auth.user.token), t.extend(t.ajaxSettings, {headers: n,dataType: "json",beforeSend: function() {
            0 === t(".spinner").length && t("body").append('<div class="spinner"/>'), t(".spinner").addClass("active")
        },complete: function() {
            setTimeout(function() {
                t(".spinner").removeClass("active")
            }, 500)
        }}), t(document).on("click", ".modal .action-cancel", function() {
        t(document).trigger("modal:hide", t(this).parents(".modal")), setTimeout(function() {
            //t(document).trigger("modal:show", ".modal.share")
        }, 20)
    }), t(document).on("click", ".modal .overlay", function() {
        t(document).trigger("modal:hide", t(this).parents(".modal"))
    }), t(document).on("modal:show", function(e, n) {
        n && t(n).removeClass("hide")
    }), t(document).on("modal:hide", function(e, n) {
        n && t(n).addClass("hide")
    }), t.track = function(e, n) {
//        t.ajax({type: "POST",url: "https://cn1.api.tradehero.mobi/api/analytics/share",data: e,success: function() {
//                console.log(e.eventType + " success"), n && "function" == typeof n && n()
//            }})
    }, t.download = function() {
    	
    	window.location.href = "http://a.app.qq.com/o/simple.jsp?pkgname=com.tradehero.th";
        //return util.os.isIOS && util.download.appStoreUrl ? void (window.location.href = util.download.appStoreUrl) : util.os.isWeiXin && util.download.wexinAppUrl ? void (window.location.href = util.download.wexinAppUrl) : util.os.isAndroid && util.download.androidApkUrl ? void (window.location.href = util.download.androidApkUrl) : void alert("亲 暂时不支持您的手机哦! 尽请期待!")
    }, t.doActionAgain = function(e) {
        localStorage.getItem("oauthed_" + e) && (t(".footer .btn-action").trigger("click"), localStorage.removeItem("oauthed_" + e))
    }
}(window, Zepto);
