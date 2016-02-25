<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');


//POST
$action = Security_Util::my_post('action');
switch ($action) {
	case 'CZD':
		CZD(Security_Util::my_post('czdtype'),Security_Util::my_post('day'));
		break;
	case 'download':
		downloadrecord();
		break;
	case 'CJ':
		choujiang();
		break;
	case 'sharebyo':
		sharerecordByO();
		break;
	case 'getpoints':
		get_cny_points(Security_Util::my_post('friendid'));
		break;
	case 'yjusers':
		get_yjusers(Security_Util::my_post('users'));
		break;
	case 'yjsecurities':
		get_yjsecurities(Security_Util::my_post('securities'));
		break;
	case 'stockpick':
		get_stockpick(Security_Util::my_post('securityId'));
		break;
	case 'StockpickHistory':
		get_StockpickHistory(Security_Util::my_post('perPage'));
		break;
	case 'SecuritiesSearch':
		get_SecuritiesSearch(Security_Util::my_post('txtSearch'));
		break;
	case 'bind':
		binduzfbcoed(Security_Util::my_post('uzfbcoed'),Security_Util::my_post('Textname'),Security_Util::my_post('add'));
		break;
	default:
		logout();
}
exit;


function binduzfbcoed($uzfbcoed,$Textname,$addt) {
	$participant = new Participant();
	echo urldecode(
	json_encode($participant->binduzfbcoed($uzfbcoed,$Textname,$addt)));
	unset($lottery);
}



function CZD($Type,$day) {

	$participant = new Participant();
	
	echo urldecode( json_encode($participant->CZD($Type,$day)));

	unset($participant);

}

function downloadrecord() {

	$participant = new Participant();
	echo urldecode(
	json_encode($participant->insert_download()));
	unset($lottery);

}

function choujiang() {
	$lottery = new lottery();
	echo urldecode(json_encode($lottery->luckDrawByF()));
	unset($lottery);
}

function sharerecordByO() {

	$lottery = new lottery();
	echo urldecode(
	json_encode($lottery->insert_shareBYopenid()));
	unset($lottery);

}

function get_cny_points($friendsid) {
	$participant = new Participant();
	echo urldecode(json_encode($participant->Getlocalytics($friendsid)));
	unset($participant);
}

function get_yjusers($users) {
	$participant = new Participant();
	echo urldecode(json_encode($participant->get_yjusers($users)));
	unset($participant);
}

function get_yjsecurities($securities) {
	$participant = new Participant();
	echo urldecode(json_encode($participant->get_yjsecurities($securities)));
	unset($participant);
}

function get_stockpick($securityId) {
	$API = new API();
	echo $API->stockpick($securityId);
	unset($API);
}
function get_StockpickHistory($perPage) {
	$API = new API();
	echo urldecode(json_encode($API->StockpickHistory($perPage)));
	unset($API);
}

function get_SecuritiesSearch($Search) {
	$API = new API();
	echo urldecode(json_encode($API->SecuritiesSearch($Search)));
	unset($API);
}


function logout() {
	$participant = new Participant();
	echo urldecode(json_encode('1'));
	unset($participant);
}