<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$friendsid=Security_Util::my_get('friendid');

//$memcache = new Memcache;
//$memcache->connect('127.0.0.1', 11211);
//$memcache->set('mem_key', 'Hello Memcache!', 0, 7200);
//$val = $memcache->get('mem_key');
//echo $val;


//echo  round(5.05, 1);
//$min = 0;$max = 1;
//$zhi=$min + mt_rand() / mt_getrandmax() * ($max - $min);
//echo $zhi .'<br>';
//echo  floatval(round($zhi, 1)).'<br>';
//$amount= 5500+floatval(round($zhi, 1)).'<br>';
//echo $amount;
//$amount=floatval($amount);
//
//		if($amount> GJ_amount)
//		{
//			echo "d大于";
//		}
//$isov=TRUE;
//if(!empty($friendsid))
//{
//	echo 'friendsid'.$friendsid;
//}
//	 //552234
//echo  substr(BASE_URL,0,-1).$_SERVER["SCRIPT_NAME"];
//echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$participant = new Participant();
			Session_Util::my_session_set('participant',
						json_encode(
								array('openid' => '22',
								'nickname' => 'SS0测试截取122',
								'userId' => '22',
								'referCode' =>'00E23T',
								'token' =>'0ca8a03d767c4a3395b983abcc7753b6'
								)));
//			$result = $participant->insert_participant_login();
//			print_r($result);

//			$result=$participant->get_MyPoints();
//			$referCode =$result['referCode'];
//				//更新抽奖次数
//				$DTO= $participant->get_UserActivityDTO($referCode);
//print_r($DTO);
//			$participant = Session_Util::my_session_get('participant');
//			$participant = json_decode($participant);
//
//			echo $result["message"]. $participant->openid ;


				$api = new API();
				$recommend=$api->topGainer();
				$recommend=json_decode($recommend,true);
				print_r($recommend);
//				foreach($recommend['securities'] as $k=>$val){
//					$sids=$sids.','.$val["id"];
//				}
//				echo $sids;
//				echo "|||". substr($sids,1);


//		$rt= $api->BatchCreatePositions(substr($sids,1));
//		echo $rt;
//		print_r($rt);
//
////$UserActivities =json_decode($UserActivities,true);
////print_r($UserActivities);
//
////signupAndLogin=	$api->signupAndLogin('','6','5');
//
////
//$UserActivities=	$api->UserActivities('00JLZD');
//$UserActivities=json_decode($UserActivities,true);
//print_r($UserActivities);
//
//$DTO= $participant->get_UserActivityDTO($referCode);
//print_r($DTO);

//echo '<br>';
//$referNum = $participant->Get_referNum('00E23T');
//echo $referNum;
//$UserActivity =$api->UserActivities('00BUNO');
//		$info=json_decode($UserActivity,true);
//print_r($info);

//$yjusers= $participant->get_yjusers('546903,559231,432492');
//echo '<br>';
//echo '546903,559231,432492';
//echo '<br>';
//print_r($yjusers);
//echo '<br>';
//$get_yjsecurities= $participant->get_yjsecurities('58644,58456,57916');
//echo '<br>';
//echo '58644,58456,57916';
//print_r($get_yjsecurities);
//echo '<br>';
//$reward=$api->reward('552948');
//echo 'reward:'.$reward;
////$yjusers=json_decode($yjusers,true);
////echo  unicode_decode($yjusers);


?>
