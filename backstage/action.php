<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');


//POST
$action = Security_Util::my_post('action');
switch ($action) {
	case 'login':
		login(Security_Util::my_post('email'),Security_Util::my_post('password'));
		break;
	case 'userswitching':
		userswitching(Security_Util::my_post('email'));
		break;
	
	case 'fabu':
		fabutimeline(urldecode(Security_Util::my_post('editor')) ,Security_Util::my_post('header'));
		break;
	case 'fabuprize':
		fabutimelineprize(urldecode(Security_Util::my_post('editor')) ,Security_Util::my_post('header'));
		break;
	c、




		ase 'hftz':
		huifutimeline(urldecode(Security_Util::my_post('editor')) ,Security_Util::my_post('timelineid'));
		break;
	case 'hftzitem':
		huifutimelineitem(urldecode(Security_Util::my_post('editor')) ,Security_Util::my_post('timelineid'),Security_Util::my_post('userid'),Security_Util::my_post('username'));
		break;
		
	case 'hfgp':
		huifusecurity(urldecode(Security_Util::my_post('editor')) ,Security_Util::my_post('securityid'));
		break;
	case 'hfgpitem':
		huifusecurityitem(urldecode(Security_Util::my_post('editor')) ,Security_Util::my_post('securityid'),Security_Util::my_post('userid'),Security_Util::my_post('username'));
		break;
		
	case 'operation':
		operation(Security_Util::my_post('type'),Security_Util::my_post('id'),Security_Util::my_post('stickType'));
		break;
	case 'falseoperation':
		falseoperation(Security_Util::my_post('type'),Security_Util::my_post('id'));
		break;	
	case 'fenghao':
		fenghao(Security_Util::my_post('id'));
		break;
	case 'report':
		report(Security_Util::my_post('id'));
		break;
	case 'download':
		downloadrecord();
		break;
	case 'sharebyf':
		sharerecordByF(Security_Util::my_post('friendsid'),Security_Util::my_post('amount'));
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
		binduzfbcoed(Security_Util::my_post('uzfbcoed'),Security_Util::my_post('Textname'));
		break;
	default:
		logout();
}
exit;


function login($name,$password) {

 
//	  setcookie('name',$name,time()+3600);
//	  setcookie('password',$password,time()+3600);
//	  setcookie('remember',$remember,time()+3600);
//  
  
  $array=	array('TH-Client-Version: 2.4.2.5705',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn.api.tradehero.mobi",
				 "Authorization:Basic ".base64_encode($name.":".$password)) ;
				 //"Authorization:Basic amFja0B0cmFkZWhlcm8ubW9iaToxMTExMTE=") ;
	
	$params='{"useOnlyHeroCount":"true","clientVersion":"2.4.2","clientType":5}';
	$login=Http::request("https://cn1.api.tradehero.mobi/api/login",$params,"POST",true,$array);
  	$UserInfo=json_decode($login,true);
  	if(count( $UserInfo["profileDTO"])>0)	{
  		Session_Util::my_session_set('participant',
				json_encode(
							  array('openid' =>    $UserInfo["profileDTO"]["portfolio"]["userId"],
									'nickname' =>  $UserInfo["profileDTO"]["displayName"], 
							  		'name' =>  	   $name, 
							  		'password' =>  $password, 
							  		'remember' =>  $remember, 
							  		'email' =>     $UserInfo["profileDTO"]["email"],			
									'referCode' => $UserInfo["profileDTO"]["referralCode"],
									'picUrl'=> 	   $UserInfo["profileDTO"]["picture"],
									'token' =>     "Basic ".base64_encode($name.":".$password)
				)));	
  }
  echo  json_encode(array('status' => $UserInfo["profileDTO"]>0 ? 'success' : $UserInfo["Message"]  ));
}

function userswitching($name) {

$participant = Session_Util::my_session_get('participant');
$participant = json_decode($participant);
  
$array=	array('TH-Client-Version: 2.4.2.5705',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn.api.tradehero.mobi",
				 "Authorization:Basic ".base64_encode($name.":".$participant->password)) ;
				
	$params='{"useOnlyHeroCount":"true","clientVersion":"2.4.2","clientType":5}';
	$login=Http::request("https://cn1.api.tradehero.mobi/api/login",$params,"POST",true,$array);
  	$UserInfo=json_decode($login,true);
  	if(count( $UserInfo["profileDTO"])>0)	{
  		Session_Util::my_session_set('participant',
				json_encode(
							  array('openid' =>    $UserInfo["profileDTO"]["portfolio"]["userId"],
									'nickname' =>  $UserInfo["profileDTO"]["displayName"], 
							  		'name' =>  	   $name, 
							  		'password' =>  $participant->password, 
							  		'remember' =>  $remember, 
							  		'email' =>     $UserInfo["profileDTO"]["email"],			
									'referCode' => $UserInfo["profileDTO"]["referralCode"],
									'picUrl'=> 	   $UserInfo["profileDTO"]["picture"],
									'token' =>     "Basic ".base64_encode($name.":".$participant->password)
				)));
  }
  echo  json_encode(array('status' => $UserInfo["profileDTO"]>0 ? 'success' : $UserInfo["Message"]  ));
}

function binduzfbcoed($uzfbcoed,$Textname) {
	$participant = new Participant();
	echo urldecode(
	json_encode($participant->binduzfbcoed($uzfbcoed,$Textname)));
	unset($lottery);
}



function fabutimeline($text,$header) {
	$API = new API();
	echo $API->timeline($text,$header);
	unset($API);
}

function fabutimelineprize($text,$header) {

	$API = new API();
	echo $API->xstimeline($text,$header);
	unset($API);
}


function huifutimeline($text,$inReplyToId) {
	$API = new API();
	echo $API->discussions($text,$inReplyToId);
	unset($API);
}


function huifutimelineitem($text,$inReplyToId,$uid,$uname) {
	$API = new API();
	$text="<@@".$uname.",".$uid."@>".$text;
	echo $API->discussions($text,$inReplyToId);
	unset($API);
}

function huifusecurity($text,$inReplyToId) {
	$API = new API();
	echo $API->DiscussionsSecurity($text,$inReplyToId);
	unset($API);
}


function huifusecurityitem($text,$inReplyToId,$uid,$uname) {

	$API = new API();
	$text="<@@".$uname.",".$uid."@>".$text;
	echo $API->DiscussionsSecurity($text,$inReplyToId);
	unset($API);
}





function operation($type,$timelineid,$stickType) {

	$API = new API();
	echo $API->operation($timelineid,$type,$stickType);
	unset($API);
}


function falseoperation($type,$timelineid) {

	$API = new API();
	echo $API->operationfalse($timelineid,$type);
	unset($API);
}


function fenghao($timelineid) {

	$API = new API();
	echo $API->fenghao($timelineid);
	unset($API);
}

function report($commentid) {

	$API = new API();
	echo $API->report($commentid);
	unset($API);
}



function downloadrecord() {

	$participant = new Participant();
	echo urldecode(json_encode($participant->insert_download()));
	unset($lottery);

}

function sharerecordByF($friendsid,$amount) {
	$lottery = new lottery();
	echo urldecode(
	json_encode($lottery->insert_shareBYFriendsId($friendsid,$amount)));
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