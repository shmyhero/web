<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$participant = new Participant();
$code = Security_Util::my_get('token');
$friendid = Security_Util::my_get('friendid');
if(!empty($code))
{
	$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.appid.'&secret='.secret.'&code='.$code.'&grant_type=authorization_code';
	$r = Http::request($get_token_url);
	$token=json_decode($r,true);
		
	if (!empty($token['access_token'])) {//获取成功

		Session_Util::my_session_set('access_token', $token['access_token']);
		$access_token=$token['access_token'];
		$openid=$token['openid'];
		//同步授权信息
		
		
		
		$get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
		

		$user_info = Http::request($get_user_info_url);
		
		$user=json_decode($user_info,true);
		
		if(!empty($user['openid']))
		{
			$params = array("access_token"=>$access_token,"open_id"=>$openid,"source"=> 6,"channelId"=> 6);
			$signupAndLogin = Http::request("https://cn.api.tradehero.mobi/api/signupAndLoginNew",$params,"POST");
	
			$signup=json_decode($signupAndLogin,true);
			if(!empty($signup['id']))
			{
				Session_Util::my_session_set('participant',
				json_encode(
							  array('openid' => 	$signup['id'],
									'nickname' => $user['nickname'],
									'referCode' => $signup['referCode'],
									'picUrl'=> $user['headimgurl'],
									'token' => $signup['token'],
							        'friendid' => $friendid
				)));
				//$participant->Inset_loginfo('登录',$signup['name']); $signup['picUrl'] $signup['name']
				$result = $participant->insert_participant_login();
				if ($result['status'] === 'error') {
					$participant->Inset_loginfo('sourceALL',$result['message']);
				}
			}
			else if(!empty($signup['Message'])){
				$participant->Inset_loginfo('signupAndLogin',"{access_token:".$access_token.",open_id:".$openid.",Message:".$signup['Message']."}");
			}
		}
		else {
			$participant->Inset_loginfo('sourceALL',BASE_URL."获取失败1");
		}
	} else {
		$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.appid.'&secret='.secret.'&code='.$code.'&grant_type=authorization_code';
		$r = Http::request($get_token_url);
		$token=json_decode($r,true);
		if (!empty($token['access_token'])) {//获取成功
				
			Session_Util::my_session_set('access_token', $token['access_token']);
			$access_token=$token['access_token'];
			$openid=$token['openid'];
			//同步授权信息
				
		$get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
		
		
		$user_info = Http::request($get_user_info_url);
		
		$user=json_decode($user_info,true);
		
		if(!empty($user['openid']))
		{
			$params = array("access_token"=>$access_token,"open_id"=>$openid,"source"=> 6,"channelId"=> 6);
			$signupAndLogin = Http::request("https://cn.api.tradehero.mobi/api/signupAndLoginNew",$params,"POST");
	
			$signup=json_decode($signupAndLogin,true);
			if(!empty($signup['id']))
			{
				Session_Util::my_session_set('participant',
				json_encode(
							  array('openid' => 	$signup['id'],
									'nickname' => $user['nickname'],
									'referCode' => $signup['referCode'],
									'picUrl'=> $user['headimgurl'],
									'token' => $signup['token'],
							        'friendid' => $friendid
				)));
				//$participant->Inset_loginfo('登录',$signup['name']); $signup['picUrl'] $signup['name']
				$result = $participant->insert_participant_login();
				if ($result['status'] === 'error') {
					$participant->Inset_loginfo('sourceALL',$result['message']);
				}
			}
			else if(!empty($signup['Message'])){
				$participant->Inset_loginfo('signupAndLogin',"{access_token:".$access_token.",open_id:".$openid.",Message:".$signup['Message']."}");
			}
		}
				
		}
		else {
			$participant->Inset_loginfo('sourceALL',BASE_URL."获取失败2");
		}
	}
}

?>