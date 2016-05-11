/**
 * Created by Tony.Tan on 2014-08-19.
 */
function postFile1(f1, url) {
    console.log(f1);
    popShow();
    $.ajax({
        url: url, // 跳转到 action//
        type: 'post',
        data: {
            file0: f1
        },
        cache: false,
        success: function (data) {
        	var obj = eval('(' + data + ')');
        	checkGifStatus(obj.id);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
        }
    });
   
}

function postFile2(f1, f2, url) {
    popShow();
    var data = new FormData();
    $.ajax({
        url: url, // 跳转到 action//
        type: 'post',
        data: {
            file0: f1,
            file1:f2
        },
        cache: false,
        success: function (data) {
        	var obj = eval('(' + data + ')');
        	checkGifStatus(obj.id);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

        }
    });
    
}

function postFile3(f1, f2, f3, url) {
    popShow();
    $.ajax({
        url: url, // 跳转到 action//
        type: 'post',
        data: {
            file0: f1,
            file1: f2,
            file2:f3
        },
        cache: false,
        success: function (data) {
        	var obj = eval('(' + data + ')');
        	checkGifStatus(obj.id);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

        }
    });
}

$(function () {
    $("#btn_camera2").show();

    $("#play").click(function () {
        $("#play").hide();
    });
    $("#btn_camera").hide();
});

function popShow() {
    $('#loading').show();
    $('#black_bg').show();
    startPercent();

}


function popHide() {
    $('#loading').hide();
    $('#black_bg').hide();
}


function checkGifStatus(id) {
    console.log(id);
    $.ajax({
        url: 'getStatus.php', // 跳转到 action//
        type: 'post',
        data: {
            id: id
        },
        cache: false,
        success: function (data) {
        	var obj = eval('(' + data + ')');
        	
            if (obj.exist == 0) {
                setTimeout(function () {
                    checkGifStatus(id)
                }, 5000);
            }
            else {
                window.location = "produce.html?id="+id+"&type="+obj.type;
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
        }
    });
}

function setCanvasShade() {

}

function startPercent() {
    var percentText = 0;
    addPercent();
    function addPercent() {
        //var rd = Math.round(Math.random() * 10) % 3 + 1;
//        var rd = Math.round(Math.random() * 10) % 9 + 1;
        var rd = Math.round(Math.random() * 20) + 1;
        setTimeout(function () {
            percentText = percentText + rd > 99 ? percentText : percentText += rd;
            $('#pText').html(percentText + "%");
            addPercent();
        }, 500);
    }
}