/*!
 * ASP.NET SignalR JavaScript Library v2.2.0
 * http://signalr.net/
 *
 * Copyright Microsoft Open Technologies, Inc. All rights reserved.
 * Licensed under the Apache 2.0
 * https://github.com/SignalR/SignalR/blob/master/LICENSE.md
 *
 */
(function(d,c,f){if(typeof(d.signalR)!=="function"){throw new Error("SignalR: SignalR is not loaded. Please ensure jquery.signalR-x.js is referenced before ~/signalr/js.")}var a=d.signalR;function b(g,h){return function(){h.apply(g,d.makeArray(arguments))}}function e(i,m){var k,l,h,j,g;for(k in i){if(i.hasOwnProperty(k)){l=i[k];if(!(l.hubName)){continue}if(m){g=l.on}else{g=l.off}for(h in l.client){if(l.client.hasOwnProperty(h)){j=l.client[h];if(!d.isFunction(j)){continue}g.call(l,h,b(l,j))}}}}}d.hubConnection.prototype.createHubProxies=function(){var g={};this.starting(function(){e(g,true);this._registerSubscribedHubs()}).disconnected(function(){e(g,false)});g.Q=this.createHubProxy("Q");g.Q.client={};g.Q.server={S:function(h){return g.Q.invoke.apply(g.Q,d.merge(["S"],d.makeArray(arguments)))}};return g};a.hub=d.hubConnection("http://cfd-webapi.chinacloudapp.cn/signalr",{useDefaultPath:false});d.extend(a,a.hub.createHubProxies())}(window.jQuery,window));
