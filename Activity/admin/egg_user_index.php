<?php
header("Content-type: text/html; charset=utf-8");
	include("auth.php");
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');
	require_once('inc/class_page.php');
	
	$key = @$_REQUEST["start_time"];
	$key1 = @$_REQUEST["class_id"];
	$pxxx = @$_REQUEST["type"];
	$px='';
	//$px = " where UserType=0 and  ClickNum >1000 OR  ShareNum >1000 ";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>高级用户管理</title>
<link href="css/2.css" rel="stylesheet" type="text/css">
<link href="css/page.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="js/PublicJS.js" charset="utf-8"></script>
<SCRIPT language=javascript src="js/arclist.js"></SCRIPT>

<SCRIPT language=javascript src="js/jquery.min.js"></SCRIPT>
<SCRIPT language=javascript src="js/jqModal.js"></SCRIPT>
<style>
.pack_pic {
	width: 200px;
	height: 260px;
	float: left;
	overflow: hidden;
	border: solid 1px #ddd;
	padding: 5px;
	font-size: 12px;
	background: #FFF;
	margin: 3px;
}
.pack_pic .wide {
	width: 185px;
	height: 185px;
	overflow: hidden;
	margin-left:auto;
	margin-right:auto;
	text-align:center;
}
.pack_pic .wide img {
/*	width: 185px;
*/	height:185px;
	margin-left:auto;
	margin-right:auto
}
.pack_pic ul {
	color: #333;
	line-height: 16px;
	padding: 2px 0 0 0;
	margin: 0;
}
.pack_pic ul li{
}
.pack_pic ul a {
	text-decoration: underline;
}
.pack_pic1 {	width: 118px;
	height: 180px;
	float: left;
	overflow: hidden;
	border: solid 1px #ddd;
	padding: 5px;
	font-size: 12px;
	background: #f5f5f5;
	margin: 3px;
}



/* jqModal base Styling courtesy of;
  Brice Burgess <bhb@iceburg.net> */

/* The Window's CSS z-index value is respected (takes priority). If none is supplied,
  the Window's z-index value will be set to 3000 by default (in jqModal.js). You
  can change this value by either;
    a) supplying one via CSS
    b) passing the "zIndex" parameter. E.g.  (window).jqm({zIndex: 500}); */
  
.jqmWindow {
    display: none;
    
    position: fixed;
    top: 3%;
    left: 50%;
    
    margin-left: -500px;
    width: 750px;
    
    background-color: #EEE;
    color: #333;
    border: 1px solid black;
    padding: 10px;
}

.jqmOverlay { background-color: #000; }

/* Fixed posistioning emulation for IE6
     Star selector used to hide definition from browsers other than IE6
     For valid CSS, use a conditional include instead */
* html .jqmWindow {
     position: absolute;
     top: expression((document.documentElement.scrollTop || document.body.scrollTop) + Math.round(17 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + 'px');
}
</style>
</head>

<body>
<?php //echo $query;?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="table">
  <tr class="hback">
    <td class="xingmu"><strong>列表</strong> </td>
  </tr>
</table>

<table class="table" cellspacing=1 cellpadding=1 width="98%" align=center border=0>
  <tbody>
  <form name="form2" id="form2">
    <tr align="middle" class="xingmu">
      <td class="xingmu" width="4%">ID</td>
      <td class="xingmu" align="left">&nbsp;日期</td>
      <td class="xingmu" align="left">&nbsp;上证指数收盘</td>
      <td class="xingmu" align="left">&nbsp;涨/跌</td>
      <td class="xingmu" align="left">&nbsp;猜涨数</td>
      <td class="xingmu" align="left">&nbsp;猜跌数</td>
      
       <td class="xingmu" width="20%">操作</td>
    </tr>
<?php	
	$page = @$_REQUEST["page"];
	$perPage = 20;
	$startnum = ((($page > 1)?$page:1)-1) * $perPage;
	$endnum = $perPage;
	$totalnum = $wpdb->get_var("SELECT count(*) FROM ssedetail $px order by date desc");
	$pages = ceil($totalnum/$perPage);
	$R_sql = "SELECT * FROM ssedetail $px order by date desc  limit $startnum,$endnum";
	$comments = $wpdb->get_results($R_sql);
	
	
	//SELECT A.openid, COUNT( A.a ) AL FROM (SELECT openid, CONCAT( openid, FriendsId ) a FROM  `laba_record` WHERE  `openid` =  `FriendsId`)AGROUP BY A.a ORDER BY AL DESC
	//print_r($comments);
	$alternate='0';
	if ($comments != null){
		foreach ($comments as $comment){
			$id			= $comment->id;
			$userid		= $comment->date;
			$uname 		= $comment->SSE;
			$typeid 		= $comment->ischange;
			$ZNum 	= $comment->ZNum;
			$DNum		= $comment->DNum;
			
			if($typeid == "0"){
				$usertype = "涨";
			}else{
				$usertype = "跌";
			}
			
		
			//颜色循环代码__________________
			if ($alternate == "1"){
				$color = "#F6F6F6"; $alternate = "2"; 
			}else{
				$color = "#ffffff"; $alternate = "1"; 
			}
?>
    <tr onMouseOver="overColor(this)" onMouseOut="outColor(this)" style="cursor:pointer;">
        <td class="hback" align="center"><?php echo $id ?></td>
        <td class="hback" align=left>&nbsp;<?php echo $userid; ?></td>
        <td class="hback" align="left">&nbsp;<?php echo $uname; ?></td>
          <td class="hback" align="left">&nbsp;<?php echo $usertype; ?></td>
        <td class="hback" align="left">&nbsp;<?php echo $ZNum; ?></td>
        <td class="hback" align="left">&nbsp;<?php echo $DNum; ?></td>
 
          <td class="hback" align=left>&nbsp;<a href="egg_user_edit.php?id=<?php echo $id ?>">设置人数</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
<?php
	}
?>
<!--    <tr class="hback">-->
<!--        <td class="hback" colspan="8" height="30">-->
<!--            &nbsp;&nbsp;<a class=inputbutx href="javascript:selAll()">全选</a>-->
<!--            &nbsp;&nbsp;<a class=inputbutx href="javascript:noSelAll()">取消</a>-->
<!--            -->
<!--        </td>-->
<!--    </tr>-->
  </form>
    <tr class="hback">
        <td class="hback" colspan="8">
            <span class="mainbox notice">
				<?php echo paging($pages, "page"); ?>&nbsp;&nbsp;<font class='page'>共<?php echo $totalnum; ?>&nbsp;&nbsp;每页<?php echo $perPage; ?>条信息</font>
            </span>
        </td>
    </tr>
  <?php 
	}else{
?>
  <tr>
    <td height="50" colspan="8">&nbsp;暂无内容</td>
  </tr>
  <?php	
	}
?>
</table>

<?php
	include("name.php");
?>

</body>
</html>