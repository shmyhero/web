<?php
session_start();
	require_once('./auth.php');
	include("../inc/config.php");
	include("../inc/class.db.php");
	require_once('../inc/utils.php');

	$u_id = intval($_GET["id"]);
	if(empty($u_id)){
		echo ("<script type='text/javascript'> alert('参数传递错误!');location.href='egg_user_index.php';</script>");
	}
	if(@$_POST["Action"]=="edit"){
	
		$Edit_ID= intval($_POST["Edit_ID"]);
		$amount= intval($_POST["amount"]);
		$ClickNum= intval($_POST["ClickNum"]);
		$sql="update hb_user set poolamount = poolamount+".$amount.", ClickNum=ClickNum+".$ClickNum." where uid=".$Edit_ID;
		
		$sqlhb_record= 'update hb_record set isaward = "01" where openid='.$Edit_ID;
		
		$curID = $wpdb->query($sql);
		$currecord = $wpdb->query($sqlhb_record);
		
		echo  $curID.'currecord'.$currecord;
		if($curID==1&&$currecord==1){
			echo ("<script type='text/javascript'> alert('修改成功!');location.href='egg_user_index.php';</script>");
			exit();
		}else{
			echo ("<script type='text/javascript'> alert('资料修改失败!');location.href='hongbao_edit.php?id=$Edit_ID';</script>");
			exit();
		}
	}

	//开始查询
	$query = "SELECT * FROM hb_user   where uid=".$u_id.' order by addtime';
	$results = $wpdb->get_results($query); 
	if($results != null){
		$nickname	= $results[0]->name;
		$typeid 	= $results[0]->utype;
		$poolamount 	= $results[0]->poolamount;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>补发红包</title>
<link href="css/2.css" rel="stylesheet" type="text/css">

</head>
<body>
<?php
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="table">
  <form action="" method="post" id="form1" name="form1" ">
  <tr>
		<td width="200px" align="right">用户昵称：</td>
		<td width="200px" align="left"><?php echo $nickname; ?></td>
		<td width="200px" align="right">当前金额：</td>
		<td width="200px" align="left"><?php echo $poolamount; ?></td>
			</tr>
    <tr>
		<td width="200px" align="right">补发人数：</td>
		<td align="left"> <input name="ClickNum" type="text" class="flat" id="ClickNum" style="width:150px" size="16" maxlength="4" /></td>
		
		</tr>
		    <tr>
		<td width="200px" align="right">补发金额：</td>
		<td align="left"> <input name="amount" type="text" class="flat" id="amount" style="width:150px" size="16" maxlength="4" /></td>
		
		</tr>
    <tr>
        <td height="30" colspan="2" class="hback" align="center">
            <input type="hidden" name="Edit_ID" id="Edit_ID" value="<?php echo $u_id; ?>" />
            <input type='hidden' name='Action' value='edit' />
            <input type="submit" name="Submit" value=" 保存修改 " class="flat" style="cursor:pointer;"/>
        </td>
    </tr>
  </form>
</table>
<?php
	include("name.php");
?>


</body>
</html>
