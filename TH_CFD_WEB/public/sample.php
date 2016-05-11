<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$jssdk = new JSSDK(appid, secret);
$signPackage = $jssdk->GetSignPackage();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>微信jssdk测试</title>
</head>
<body>zsdvdsa
</body>
<script src="js/jquery.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script type="text/javascript">

var nickname="TW11";
var openid="122341";
var ismy =false;
var appId=     '<?php echo $signPackage["appId"]; ?>';
var timestamp= '<?php echo $signPackage["timestamp"]; ?>';
var nonceStr=  '<?php echo $signPackage["nonceStr"]; ?>';
var signature= '<?php echo $signPackage["signature"]; ?>';
var ISBASE=<?php echo  ISBASE ;?>;

</script>
<script src="js/util.js"></script>
</html>
