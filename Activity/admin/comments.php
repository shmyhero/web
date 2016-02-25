<?php
header("Content-type: text/html; charset=utf-8");
session_start();
	require_once("./auth.php");
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once("../inc/utils.php");
	require_once("inc/class_page.php");

	$whereclause = "where 1=1";

	$d = $_GET["d"];
		if(!empty($d)){
			$whereclause.=" and adddate LIKE '%".$d."%'";
		}

	$c = $_GET["c"];
	if(!empty($c)){
		$whereclause.= " and cid=$c";
	}
	
	$s = csubstr(strip_tags($_GET["s"]),0,30);
	if($s=="输入您要搜索内容"){
		$s = "";
	}
	if(!empty($s)){
		$whereclause.=" and comment LIKE '%".$s."%'";
	}

	$count_s = "SELECT count(*) FROM comments ".$whereclause;
	$totalnum = $wpdb->get_var($count_s);

	$page = $_REQUEST["page"];
	$perPage = 20;
	$startnum = ((($page > 1)?$page:1)-1) * $perPage;
	$endnum = $perPage;
	$pages = ceil($totalnum/$perPage);

	$query = "SELECT * FROM comments ".$whereclause." order by id desc limit $startnum,$endnum";
	$comments = $wpdb->get_results($query);

/*---------------------- 
替换表情到HTML代码的函数 
/**
* 判断URL请求参数中是否包含非法字符
*
* @参数		string	字段名
* @返回		string
* 作者：Jesson Wu
* 日期：2012-7-6
-----------------------*/ 
	function EmotToHtml($string){
		$string=trim($string);
		$string = str_replace("[微笑]", "<img src=\"../emot/default/smile.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[吐舌头]", "<img src=\"../emot/default/tongue.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[偷笑]", "<img src=\"../emot/default/titter.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[大笑]", "<img src=\"../emot/default/laugh.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[难过]", "<img src=\"../emot/default/sad.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[委屈]", "<img src=\"../emot/default/wronged.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[快哭了]", "<img src=\"../emot/default/fastcry.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[哭]", "<img src=\"../emot/default/cry.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[大哭]", "<img src=\"../emot/default/wail.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[酷]", "<img src=\"../emot/default/mad.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[敲打]", "<img src=\"../emot/default/knock.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[骂人]", "<img src=\"../emot/default/curse.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[抓狂]", "<img src=\"../emot/default/crazy.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[发火]", "<img src=\"../emot/default/angry.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[惊讶]", "<img src=\"../emot/default/ohmy.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[尴尬]", "<img src=\"../emot/default/awkward.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[惊恐]", "<img src=\"../emot/default/panic.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[害羞]", "<img src=\"../emot/default/shy.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[可怜]", "<img src=\"../emot/default/cute.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[羡慕]", "<img src=\"../emot/default/envy.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[得意]", "<img src=\"../emot/default/proud.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[奋斗]", "<img src=\"../emot/default/struggle.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[安静]", "<img src=\"../emot/default/quiet.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[闭嘴]", "<img src=\"../emot/default/shutup.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[疑问]", "<img src=\"../emot/default/doubt.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[鄙视]", "<img src=\"../emot/default/despise.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[睡觉]", "<img src=\"../emot/default/sleep.gif\" align=\"absmiddle\">", $string);
		$string = str_replace("[再见]", "<img src=\"../emot/default/bye.gif\" align=\"absmiddle\">", $string);
		return $string; 
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理 - 首页</title>
<link href="css/2.css" rel="stylesheet" type="text/css">
<link href="css/page.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="js/PublicJS.js" charset="utf-8"></script>
<SCRIPT language=javascript src="js/arclist.js"></SCRIPT>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="table">
  <tr class="hback">
    <td class="xingmu"><strong>评论管理</strong></td>
  </tr>
  <tr>
    <form action="" method="get" id="form1" name="form1" onsubmit="return Chk(this);">
      <td height="18" class="hback"><table width="99%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
          <td><div align="right">
          类别
            <select name="c" id="c">
              <option value=""<?php if(empty($c)){?> selected="selected"<?php }?>>全部...</option>
              <option value="1"<?php if($c == 1){?> selected="selected"<?php }?>>精彩瞬间</option>
              <option value="2"<?php if($c == 2){?> selected="selected"<?php }?>>精彩故事</option>
              <option value="3"<?php if($c == 3){?> selected="selected"<?php }?>>游泳知识</option>
              <option value="4"<?php if($c == 4){?> selected="selected"<?php }?>>视频欣赏</option>
            </select>
            日期
<input id="d" type="text" name="d" class="Wdate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php echo $d;?>" />
            关键字
                <input name="s" type="text" id="s" value="" size="20" />
                <input type="submit" name="Submit2" value=" 搜 索 "style="cursor:pointer" />
            &nbsp;</div></td>
        </tr>
      </table></td>
    </form>
  </tr>
</table>
<DIV id="updated" style="DISPLAY: none" align="center">
	<table width="98%" border="0" align="center" cellpadding="4" cellspacing="4">
		<tr>
			<td height="50"> 
			<div align="center"><b>正在统计，请稍后...<b> <img height="15" alt="Laoding..." src="Image/loading.gif" width="150"></b></b></div>
			</td>
		</tr>
	</table>
</DIV>
		<table width="98%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
          <form name="form2" id="form2" method="post" action="">
            <tr class="xingmu">
              <td colspan="2" class="xingmu"><div align="center">编号</div></td>
              <td width="467" class="xingmu"><div align="center">评论内容</div></td>
              <td width="273" class="xingmu"><div align="center">所属类别</div></td>
              <td width="405" class="xingmu"><div align="center">评论者</div></td>
              <td width="168" class="xingmu"><div align="center">添加IP地址</div></td>
              <td width="131" class="xingmu"><div align="center">添加时间</div></td>
              <td width="131" class="xingmu"><div align="center">管理操作</div></td>
            </tr>
<?php
	//echo $query;
	if ($comments != null){
		foreach ($comments as $rs) {
			$News_id=($rs->id);
			$cid=($rs->cid);
			$uid=($rs->uid);
			$username = $wpdb->get_var("SELECT username FROM members where uid = ".$uid);
			
			if($cid == 1){
				$classtitle = "精彩瞬间";
			}elseif($cid == 2){
				$classtitle = "精彩故事";
			}elseif($cid == 3){
				$classtitle = "游泳知识";
			}elseif($cid == 4){
				$classtitle = "视频欣赏";
			}
			$comment = EmotToHtml($rs->comment);
			//$comment = ($comment->comment);
			
			$addtime = $rs->addtime;
			$addtime = date("Y-m-d H:i",$addtime);
			$ipaddress = $rs->ipaddress;
//id
//title
//username
//img
//img_count
//addtime
?>
            
            <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
              <td width="20" height="3%" align="center" class="hback"><input id=arcID type=checkbox value="<?php echo $News_id ?>" name=arcID></td>
              <td width="20" height="3%" align="center" class="hback"><?php echo $News_id ?></td>
              <td class="hback"><?php echo $comment ?></td>
              <td class="hback"><div align="center"><?php echo $classtitle ?></div></td>
              <td class="hback"><div align="center"><?php echo $username; ?></div></td>
              <td class="hback"><?php echo $ipaddress;?></td>
              <td class="hback"><div align="center"><?php echo $addtime; ?></div></td>
              <td class="hback"><div align="center">
                <input type="button" name="Submit3" style="cursor:pointer;COLOR: red" value=" 删除 " onclick="{if(confirm('确定清除您所选择的记录吗？')){location='comments_del.php?id=<?php echo $News_id ?>&amp;Action=Del';return true;}return false;};" />
              </div></td>
            </tr>
<?php
		}
?>
            <tr>
              <td height="18" colspan="8" class="hback">
                <input type="button" name="Submit73" style="cursor:pointer; color:" value=" 全 选 " onclick="javascript:selAll();" />
                <input type="button" name="Submit54" style="cursor:pointer; color:" value=" 取 消 " onclick="javascript:noSelAll();" />
				<input type="button" name="Submit35" style="cursor:pointer;COLOR: red" value=" 删除 " onclick="{if(confirm('确定清除您所选择的记录吗？')){this.document.form2.submit();javascript:delComment(0);return true;}return false;};" /></td>
            </tr>
          </form>
		  <tr>
            <td height="18" colspan="8" class="hback"><span class="mainbox notice"><?php echo paging($pages, "page"); ?>&nbsp;&nbsp;共<?php echo $totalnum; ?>&nbsp;&nbsp;每页<?php echo $perPage; ?>条信息</span></td>
	      </tr>
<?php
	}else{
?>
<tr class="hback">
    <td height="50" colspan="8">暂无内容</td>
</tr>
<tr class="hback">
  <td height="50" colspan="8">&nbsp;</td>
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