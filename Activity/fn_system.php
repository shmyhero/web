<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');

$friendid = Security_Util::my_get('friendid');
$source = Security_Util::my_get('source');
$participant = Session_Util::my_session_get('participant');
if($participant=== NULL){

	Session_Util::my_session_destory();
	header("Location:".BASE_URL."oauth.php?source=6&target=".urlencode(BASE_URL."index.php")."&pageName=fn_system.php"); //.urldecode(BASE_URL."
}else{
	$url = BASE_URL.'index.php';
	header("Location:".$url);
}
?>


