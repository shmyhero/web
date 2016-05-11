<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$participant = new Participant();
$code = Security_Util::my_get('token');
//$friendid = Security_Util::my_get('friendid');
$participant->Inset_loginfo('获取token',$code);
if(!empty($code))
{
	$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.appid.'&secret='.secret.'&code='.$code.'&grant_type=authorization_code';
	$participant->Inset_loginfo('get_token_url',$get_token_url);	
	$r = Http::request($get_token_url);

	$token=json_decode($r,true);

	$participant->Inset_loginfo('request',$token['access_token']);	 //.$token['errcode'].$token['errmsg']);		
	if (!empty($token['access_token'])) 
	{	//获取成功
		Session_Util::my_session_set('access_token', $token['access_token']);
		$access_token=$token['access_token'];
		$openid=$token['openid'];
		//同步授权信息
		$get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
		$participant->Inset_loginfo('get_user_info_url',$get_user_info_url);	

		$user_info = Http::request($get_user_info_url);
		
		$user=json_decode($user_info,true);
		
		if(!empty($user['openid']))
		{
			$participant->Inset_loginfo('获取user',$user['openid']);
			$params = array("openid"=>$openid,"unionid"=>$user['unionid'],"nickname"=> $user['nickname'],"headimgurl"=> $user['headimgurl']);
			$signupAndLogin = Http::request("http://cfd-webapi.chinacloudapp.cn/api/user/signupByWeChat",$params,"POST");

			$signup=json_decode($signupAndLogin,true);
			
			if(!empty($signup['userId']))
			{
				// $participant->Inset_loginfo('获取token',$signup['token']);
				// $participant->Inset_loginfo('获取userId',$signup['userId']);
				// $participant->Inset_loginfo('登录nickname',$user['nickname']); 
				//localStorage.setItem('participant',"'".JSON.stringify(data));
				//Authorization: Basic {id}_{token} （用户userId_token）
				// Array{"isNewUser":true,"userId":22,"token":"0ca8a03d767c4a3395b983abcc7753b6","success":true}
				Session_Util::my_session_set('participant',
					json_encode(array('openid' => 	$signup['userId'],
						'userId' => 	$signup['userId'],
						'nickname' => $user['nickname'],
						'referCode' =>'BMQM53',
						'picUrl'=> $user['headimgurl'],
						'token' => $signup['token'],
						'friendid' =>'123456'
						)));		 
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
	} 
	else {
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
				$params = array("openid"=>$openid,"unionid"=>$user['unionid'],"nickname"=> $user['nickname'],"headimgurl"=> $user['headimgurl']);
			    $signupAndLogin = Http::request("http://cfd-webapi.chinacloudapp.cn/api/user/signupByWeChat",$params,"POST");
				$signup=json_decode($signupAndLogin,true);
				if($signup['success']===true)
				{
					//localStorage.setItem('participant',"'" + JSON.stringify(data));
				    //Authorization: Basic {id}_{token} （用户userId_token）
				    // Array{"isNewUser":true,"userId":22,"token":"0ca8a03d767c4a3395b983abcc7753b6","success":true}
					Session_Util::my_session_set('participant',
						json_encode(array('openid' => 	$signup['userId'],
							'userId' => 	$signup['userId'],
							'nickname' => $user['nickname'],
							'referCode' =>'BMQM53',
							'picUrl'=> $user['headimgurl'],
							'token' => $signup['token'],
							'friendid' =>'123456'
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
				$participant->Inset_loginfo('sourceALL',BASE_URL."获取失败2");
			}
		}
	}
}
?>
