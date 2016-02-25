var res = null;
var email = null;
var psswd =null;

var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var base64DecodeChars = new Array(
     -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
     -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
      -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63,
     52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1,
     -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14,
     15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1,
     -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
     41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);
 //编码的方法
function base64(str) {
      var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
 var base64DecodeChars = new Array(
     -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
     -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
      -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63,
     52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1,
     -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14,
     15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1,
     -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
     41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);
     var out, i, len;
     var c1, c2, c3;
     len = str.length;
     i = 0;
     out = "";
     while(i < len) {
     c1 = str.charCodeAt(i++) & 0xff;
     if(i == len)
     {
         out += base64EncodeChars.charAt(c1 >> 2);
         out += base64EncodeChars.charAt((c1 & 0x3) << 4);
         out += "==";
         break;
     }
       c2 = str.charCodeAt(i++);
       if(i == len)
       {
           out += base64EncodeChars.charAt(c1 >> 2);
           out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
           out += base64EncodeChars.charAt((c2 & 0xF) << 2);
           out += "=";
           break;
       }
       c3 = str.charCodeAt(i++);
       out += base64EncodeChars.charAt(c1 >> 2);
       out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
       out += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >>6));
       out += base64EncodeChars.charAt(c3 & 0x3F);
       }
       return out;
 }

function fetch(){
//	$.ajax({
//		type:'POST',
//		url:'https://cn.api.tradehero.mobi/api/signupAndLogin',
//	})
    var ajax = false;
	if(window.XMLHttpRequest)
	    ajax = new XMLHttpRequest();
	else if(window.ActiveXObject)
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    
    email = document.getElementById("inputEmail3").value;
    psswd = document.getElementById("inputPassword3").value;
    var data = email+":"+psswd;
    var body = {"clientType":4,
                "clientVersion":"3.1.0.390",
                "deviceToken":"",
                "device_access_token":"",
                "useOnlyHeroCount":true,
                "isEmailLogin":true}

    var url = "https://cn.api.tradehero.mobi/api/signupAndLogin";
    if(ajax != null)
    {
    	ajax.open("POST",url,true);
    	ajax.setRequestHeader("Authorization","Basic "+base64(data));
    	ajax.setRequestHeader("Content-Type","application/json; charset=UTF-8");
    	ajax.send(JSON.stringify(body));
    }

    ajax.onreadystatechange = function(){
    	if(ajax.status == 200){
    		if(ajax.readyState == 4){
                 res = JSON.parse(ajax.responseText);
                 render();
    		}
    	}
      else if(ajax.status == 403){
        if(ajax.readyState == 4){
            alert("用户名或密码不正确！");
        }
      }
    }
}

function checkLocalstorage(){
    var em = localStorage.getItem("email");
    var pw = localStorage.getItem("password");
    if(email != null && password != null){
       $('#inputEmail3').val(em);
       $('#inputPassword3').val(pw);
    }
}

function setLocalStorage(){
    if($('#store').attr('checked') == true)
      { 
           var storage = window.localStorage;
           storage["email"] = $('#inputEmail3').val();
           storage["password"] = $('#inputPassword3').val();
      }
}

function render(){
     $('#login').removeClass('show').addClass('hide');
     $('#info').removeClass('hide').addClass('show');

     var pic = res.profileDTO.picture;
     var name = res.profileDTO.displayName;

     $('#icon').attr('src',pic);
     $('#name').text(name);
}

window.onload = function(){ checkLocalStorage(); };
