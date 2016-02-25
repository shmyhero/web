<?php
header("Content-type: text/html; charset=utf-8");
session_start();
	require_once('./auth.php');
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>DedeCms menu</title>

<link href="css/admin_menu.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<base target="main">
<body class="Leftback" topmargin="0" leftmargin="0" onselectstart="return false" onpaste="return false" oncontextmenu="return false" ondragstart="return false">

  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td colspan="2" background="images/5_bg_03.gif" height="8"></td>
    </tr>
    

    <tr>
      <td height="20" valign="bottom">
          <span style="color:#F2F2F2;font-family:Arial, Helvetica, sans-serif; font-size:12px">&nbsp;&nbsp;当前用户：<?php echo $_SESSION['Admin_Nick']; ?>&nbsp;&nbsp;||&nbsp;&nbsp;级别：<?php if($TypeID == "999"){?>超级管理员<?php }else{?>普通管理<?php }?>&nbsp;&nbsp;||&nbsp;&nbsp;当前日期：
            <font style='font-size:9pt;font-family: 宋体'>
            <?php
                echo date("Y年m月d日");
                echo "&nbsp;";
                $week = date("N");
                if($week == 1){
                    $weekinfo = "一";
                }elseif($week == 2){
                    $weekinfo = "二";
                }elseif($week == 3){
                    $weekinfo = "三";
                }elseif($week == 4){
                    $weekinfo = "四";
                }elseif($week == 5){
                    $weekinfo = "五";
                }elseif($week == 6){
                    $weekinfo = "六";
                }elseif($week == 7){
                    $weekinfo = "日";
                }
                echo "星期".$weekinfo;
            ?>
            </font>
        </span>
    </td>
      <td valign="bottom" style="color:#F2F2F2;font-family:Arial, Helvetica, sans-serif;font-size:9px;"><div align="right"><?php echo $config['Copyright'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
    </tr>
  </table>
</body>
</html>
