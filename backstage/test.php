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


$participant = new Participant();
			Session_Util::my_session_set('participant',
						json_encode(
								array('openid' => '703134261',
								'nickname' => '谭',
								'picUrl' => 'http://wx.qlogo.cn/mmopen/icDiaVkOzkFticTjwZISKDNzol7uO1ZDkGQa8BPS9NhUiaOA1BaSEZO2UOib8Ux6xpLWmYWOmpMvqWFDyJ6kVYxPG3Q/0',
								'referCode' =>'BMQM53',
								'token' =>'TH-WeChatU otwHxjhbli8SU_mCzoW1w5nahYGc',
								'friendid' =>'123456'
								)));
			$result = $participant->insert_participant_login();
			print_r($result);
			
			//$participant->insert_BDstockPick();
			
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
			$recommend=$api->report();
			print_r($recommend);
//				$recommend=json_decode($recommend,true);
//				echo '<br>'.'recommend';
//				//print_r($recommend);
//				
//
//				foreach($recommend['securities'] as $k=>$val){
//					$sids=$sids.$val["id"].',';
//					$snames=$snames.$val["name"].',';
//				}
//				$arr=explode(',',$sids);
//				$arrname=explode(',',$snames);
				//echo $arr[2];
				//echo $arrname[2];
//				print_r($arr);
//				print_r($arrname);
			    //print_r($api->SecuritiesSearch('1111'));
				
				//echo '58652';
				//$ms= $api->stockpick('127280');
				
				//$participant->Inset_loginfo('sourceALL',$ms);
//				echo '<br>'.'StockpickHistory';
				//print_r($api->StockpickHistory('1'));
		
				//print_r($api->timeline_original());
				//print_r($api->search_users('palmer'));
				//print_r($api->report());
				
				//print_r($api->timelinen_commentOnly());
				
				
			  //echo $api->Server();
				
//		$BD1=$BDstockPick[0]['pickedDate'];
//		$BD2='';$BD3='';
//		foreach($BDstockPick as $k=>$val){
//		 	$BD1 = $val["pickedDate"]
//		 	$BD2 = ''
//		 	
//		 }
//		$items = array();
//		foreach($BDstockPick as $k=>$item) {
//			$arr= explode('T',$item['pickedDate']);
//		    $order_id =$arr[0];
//		    unset($item['pickedDate']);
//		    
//		    if(!isset($items[$order_id])) {
//		        $items[$order_id] = array('pickedDate'=>$order_id, 'picked'=>array());
//		    }
//		    $items[$order_id]['picked'][] = $item;
//		}
//		echo '<pre style="font:10px Tahoma;">';
//		//print_r($items);
//		print_r($items);
		
//		$ar = array();
//$result = array();
//foreach($BDstockPick as $k => $v) {
//	
//	$arr= explode('T',$v['pickedDate']);
//	$order_id =$arr[0];
//   $ar[$order_id]['items'][] = array_slice($v, 1);
//}
//foreach($ar as $k => $v) $result[] = array('pickedDate' => $k, 'picked' => $v['items']);
//
//echo '<pre style="font:10px Tahoma;">';
////print_r($result);
//
//print_r($result[0]["picked"]);
//		
//				echo '<br>'.'MYstockPick';
//				print_r($api->MYstockPick());
				
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