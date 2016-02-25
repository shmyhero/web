$(document).ready(function(){
/******************************/
//【获取积分】 GetMemberPointAll
/******************************/
	//$('#btn_login').click(function(){
		//信息
		//document.getElementById("pointinfo").innerHTML = "<img src='images/common/indicator_tiny_red.gif' align='absmiddle'/>";
		//程序开始执行
		$.ajax({
			type:"POST",
			url:"gift_update.php",
			data:"action=update",
			dataType:"text",
			success: function(msg){//如果调用php成功 
				document.getElementById("integra_info2").innerHTML = msg;
			}
		});
//最外层
});
