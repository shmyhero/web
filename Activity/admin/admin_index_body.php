<?php
header("Content-type: text/html; charset=utf-8");
session_start();
	require_once('./auth.php');
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');
	$count_article=0;
	$count_english=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理 - 首页</title>
<link href="css/2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="js/PublicJS.js" charset="utf-8"></script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
    <tr class="xingmu">
      <td width="204" class="xingmu"><strong>数据统计</strong></td>
      <td width="749" class="xingmu">详细信息</td>
    </tr>
    
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">文章信息</td>
      <td class="hback">总数：<?php echo $count_article;?></td>
    </tr>
    
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">文章信息</td>
      <td class="hback">总数：<?php echo $count_english;?></td>
    </tr>
    
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">&nbsp;</td>
      <td class="hback">&nbsp;</td>
    </tr>
    
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">&nbsp;</td>
      <td class="hback">&nbsp;</td>
    </tr>
    
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">&nbsp;</td>
      <td class="hback">&nbsp;</td>
    </tr>
    
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">&nbsp;</td>
      <td class="hback">&nbsp;</td>
    </tr>
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">&nbsp;</td>
      <td class="hback">&nbsp;</td>
    </tr>
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">&nbsp;</td>
      <td class="hback">&nbsp;</td>
    </tr>
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">&nbsp;</td>
      <td class="hback">&nbsp;</td>
    </tr>
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">&nbsp;</td>
      <td class="hback">&nbsp;</td>
    </tr>
    <tr onMouseOver=overColor(this) onMouseOut=outColor(this)>
      <td height="18" class="hback">&nbsp;</td>
      <td class="hback">&nbsp;</td>
    </tr>

</table>
<br>

<?php
	include("name.php");
?>


</body>
</html>