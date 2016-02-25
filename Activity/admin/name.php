<br>
<table width="98%" border="0" align="center" cellpadding="1" cellspacing="0">
  <tr onMouseMove="javascript:this.bgColor='#F2F2F2';" onMouseOut="javascript:this.bgColor='#F2F2F2';" bgcolor="#F2F2F2">
    <td width="91%" height="18" style="color:#006699;font-family:Arial, Helvetica, sans-serif;font-size:9px;"><!--文件名：
      <?php 	$path=$_SERVER["PHP_SELF"];
	echo"$path";?>
&nbsp;&nbsp;|&nbsp;-->&nbsp;完整路径：<!-- <?php echo 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; ?> --><?php echo $_SERVER["REQUEST_URI"]; ?></td>
    <td width="9%" align="right"><input type="button" name="Submit_00" value=" 返回上页 " style="cursor:pointer" onclick="javascipt:history.back()" id="Submit_00" class='flat'/></td>
  </tr>
</table>
<br>