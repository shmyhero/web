<?php
class Participant extends Dao_Impl {
	private $return = 0;
	private $tip = '';
	private $openid = '';
	private $snsname = '';
	private $snsavatar = '';


	public function __construct() {
		parent::__construct();
	}

	/**
	 *
	 * urlencode值
	 * @param string $val
	 */
	private static function _urlencode_val($val) {
		return urlencode($val);

	}

	/**
	 *
	 * 生成统一结果数组返回
	 * @param array $other_result 其余需要返回值的数组
	 */
	private function _get_result_array($other_result = NULL) {
		$base_result = array('Return' => $this->return, 'Tip' => $this->tip);//
		if (is_array($other_result) && count($other_result) > 0) {
			$base_result = array_merge($base_result, $other_result);
		}
		$base_result = array_map(array(__CLASS__, '_urlencode_val'), $base_result);
		return $base_result;
	}





	/**
	 * loginfo
	 */
	public function Inset_loginfo($log,$content) {
		$success = false;

		$this->db->query('BEGIN');
		$insert_result = $this->db->query(' INSERT INTO loginfo(logName,logcontent,logtime) VALUE("'. $log . '","'. $content . '","'. date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']). '")');
		if ($insert_result === FALSE) {
			$success = false;
		} else {
			$success = true;
			$this->db->query('COMMIT');
		}
		return $success ;
	}

	/**
	 *
	 * 是否登录
	 */
	public function isLogin() {
		$success = false;
		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$success = true;
		} else {
			$success = false;
		}
		return $success ? 'true' : 'false';
	}


	/**
	 *
	 * 查询当前FriendsId中奖信息
	 */
	public function GetTicketRecord_SNkey($FriendsId) {
		$FriendsId=$this->db->escape($FriendsId);
		$success = false;
		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$participant = json_decode($participant);
			$row = $this->db->get_row(' SELECT amount FROM egg_zdrecord WHERE openid="'. $FriendsId . '" and FriendsId="'. $participant->openid . '"');
			if ($row === NULL) {
				$success = FALSE;
				$error = '查询中奖信息出错';
			}
			else {
				$success = true;
				$amount  = $row->amount;
			}
		} else {
			$success = false;
			$error = '未授权！';
		}
		return array('status' => $success ? 'success' : 'error',
		 		'amount' => $amount,
				'message' =>  $error);
	}

	public function iskong($a){
		if($a===''||$a===null||$a===""){
			return false;
		}else{
			return true;
		}
	}

	/**
	 *
	 * 查询当前FriendsId分享资源
	 */
	public function Getlocalytics($fid) {
		$success = false;
		$error ='';
		$amount='';
		$openid ='';
		$FriendsId ='';
		$oamount ='';
		$onickname ='';
		$famount ='';
		$fnickname ='';

		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$participant = json_decode($participant);
			if($this->iskong($fid))
			{
				$getrowSQl='SELECT egg_zdrecord.amount,egg_zdrecord.openid,egg_zdrecord.FriendsId,A.amount oamount,A.nickname onickname,B.amount famount,B.nickname fnickname FROM egg_zdrecord
							LEFT JOIN egg_user A on egg_zdrecord.openid=A.openid
							LEFT JOIN egg_user B on egg_zdrecord.FriendsId=B.openid
	 						WHERE egg_zdrecord.openid="'. $fid . '" and egg_zdrecord.FriendsId="'. $participant->openid . '"';

				$row = $this->db->get_row($getrowSQl);
				if ($row === NULL) {
					$success = FALSE;
					$error = '查询中奖信息出错';
				}
				else {
					$success = true;
					$amount  = $row->amount;
					$openid  = $participant->openid ;
					$FriendsId = $fid ;
					$oamount = $row->oamount;
					$onickname = $row->onickname;
					$famount = DJ_amount-intval($row->famount);
					$fnickname = $row->fnickname;
				}
			}
			else {
				$getrowSQl='SELECT nickname,amount FROM egg_user  WHERE openid="'. $participant->openid . '"';
				$row = $this->db->get_row($getrowSQl);
					
				if ($row === NULL) {
					$success = FALSE;
					$error = '查询中奖信息出错';
				}
				else {
					$success = true;
					$famount  = DJ_amount-intval($row->amount);
					$openid  = $participant->openid;
				}
			}

		} else {
			$success = false;
			$error = '未授权！';
		}

		return array('status' => $success ? 'success' : 'error',
		 		'amount' => $amount,
				'openid' => $openid,
				'oamount' => $oamount,//归属人金钱
				'friendsid' => $FriendsId,//砸蛋人
				'onickname' => $onickname,//帮"+ $onickname +" 到了"+ $amount +"元  //砸蛋人?+$FriendsId
				'famount' => $famount, //我的还差"+amount+"就   ?+$openid
				'fnickname' => $fnickname,// my砸蛋人名
				'message' =>  $error);
	}

	/**
	 *
	 * 抽奖记录 200条
	 */
	public function GetTicketRecord_Openid($friendsid) {
		$friendsid=$this->db->escape($friendsid);
		$tags_image_result=null;
		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$participant = json_decode($participant);

			$tags_image_result= $this->db->get_results( 'select amount,Friendname,Friendurl FROM hb_record  where openid="'.$friendsid.'" order by Friendname desc limit 200  ');
		}
		return $tags_image_result;
	}

	/**
	 *
	 * 抽奖记录200条
	 */
	public function GetMYRecordALL() {
		$tags_image_result=null;
		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$participant = json_decode($participant);
			$tags_image_result= $this->db->get_results( 'select hb_record.*,hb_user.name  Fname  FROM hb_record,hb_user  where   hb_record.FriendsId="'.$participant->openid.'"  AND hb_record.openid= hb_user.uid ');
		}

		return $tags_image_result;
	}

	/**
	 *
	 * 抽奖记录 5条
	 */
	public function GetSUMamount() {
		$tags_image_result=null;
		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$participant = json_decode($participant);
			$tags_image_result= $this->db->get_row( ' select SUM(amount) sl FROM hb_record  where   FriendsId="'.$participant->openid.'"  ');
		}
		return $tags_image_result->sl ;
	}

	//我的
	public function GetMYSUMamount() {
		$tags_image_result=null;
		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$participant = json_decode($participant);
			$tags_image_result= $this->db->get_row(' select amount FROM hb_record  where   FriendsId="'.$participant->openid.'" and openid="'.$participant->openid.'"  ');
		}
		return $tags_image_result->amount ==null ? 0: $tags_image_result->amount;
	}

	//朋友发的
	public function GetFSUMamount() {
		$tags_image_result=null;
		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$participant = json_decode($participant);
			$tags_image_result= $this->db->get_row( ' select SUM(amount) sl FROM hb_record  where   FriendsId="'.$participant->openid.'" and openid<>"'.$participant->openid.'" ');
		}
		return $tags_image_result->sl ==null ? 0: $tags_image_result->sl;
	}

	/**
	 *
	 * 抽奖记录全部
	 */
	public function GetTicketRecord_OpenidALL($friendsid) {
		$tags_image_result=null;
		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$participant = json_decode($participant);
			$tags_image_result= $this->db->get_results( 'select * FROM hb_record  where openid="'.$friendsid.'" order by ClickTime desc limit 5  ');
		}
		return $tags_image_result;
	}

	/**
	 *
	 * 退出
	 */
	public function logout() {

		$participant = Session_Util::my_session_get('participant');
		if ($participant !== NULL) {
			$sina = new Sina_Web();
			$logout_result = $sina->revoke_oauth();
			if ($logout_result === FALSE) {
				$this->tip = '注销授权Token失败';
			}
		} else {
			$this->tip = '用户未授权登录';
		}
		if ($this->tip === '') {
			$this->return = 1;
			Session_Util::my_session_destory();

		}
		//Session_Util::my_session_unregister('sina_token');
		return $this->_get_result_array();
	}

	public function get_F_Points($friendsid) {
		$friendsid=$this->db->escape($friendsid);
		//查询发起者积分
		$success=true;
		$participant = Session_Util::my_session_get('participant');

		if ($participant === NULL) {
			$success = FALSE;
			$error = '用户未授权';
		} else {
			$participant = json_decode($participant);

			$row = $this->db
			->get_row('SELECT hb_user.name,hb_user.poolamount,hb_user.picUrl,hb_record.amount FROM hb_user,hb_record  WHERE uid="'. $friendsid . '" AND hb_record.FriendsId="'. $participant->openid . '" AND hb_record.openid="'. $friendsid . '"');
			if ($row === NULL) {
				$success = FALSE;
				$error = '查询用户金钱出错';
			}
			else {
				$Points = $row->poolamount;
				$picUrl = $row->picUrl;
				$nickname =$row->name;
				$amount=$row->amount;
			}
		}
		return array('status' => $success ? 'success' : 'error',
				'poolamount' => $Points,
				'picUrl' => $picUrl,
				'amount' => $amount,
		 		'nickname' => $nickname
		);

	}


	public function get_FWC_Points() {
		$success=true;
		$participant = Session_Util::my_session_get('participant');

		if ($participant === NULL) {
			$success = FALSE;
			$error = '用户未授权';
		} else {
			$participant = json_decode($participant);

			$row = $this->db
			->get_row('SELECT * FROM hb_user WHERE uid="'. $participant->openid . '" ');
			if ($row === NULL) {
				$success = FALSE;
				$error = '查询用户出错';
			}
			else {
				$Points = $row->poolamount;
				$picUrl = $row->picUrl;
				$nickname =$row->name;
				$gzDownload =$row->gzDownload;
				$ShareNum= $row->ShareNum;
				$joinNum= $row->joinNum;
				$BDNum= $row->BDNum;
				$uzfbcoed= $row->uzfbcoed;
				$uzfbname= $row->uzfbname;

			}
		}
		return array('status' => $success ? 'success' : 'error',
				'poolamount' => $Points,
				'picUrl' => $picUrl,
				'gzDownload' => $gzDownload,
				'ShareNum' => $ShareNum,
				'joinNum' => $joinNum,
				'BDNum' => $BDNum,
				'uzfbcoed' => $uzfbcoed,
				'uzfbname' => $uzfbname,
		 		'nickname' => $nickname
		);

	}


	public function get_MyPoints() {
		//查询用户积分
		$success=true;
		$participant = Session_Util::my_session_get('participant');
		$Points=0;
		$my="01";
		$nickname='';
		$row=NULL;
		if ($participant === NULL) {
			$success = FALSE;
			$error = '用户未授权';
		} else {
			$participant = json_decode($participant);
			$my="02";
			$row = $this->db
			->get_row('SELECT * FROM hb_user WHERE uid="'. $participant->openid . '" ');
			$Points = $row->poolamount;
			$picUrl = $row->picUrl;
			$nickname =$row->name;
			$gzDownload =$row->gzDownload;
			$amount=$row->amount;

			$arr=array( 'status' => $success ? 'success' : 'error',
				'poolamount' => $Points,
				'nickname' => $nickname,
				'picUrl'   => $picUrl,
				'gzDownload'   => $gzDownload,
				'ClickNum' => $row->ClickNum,
				'ratio' => $row->ratio,
				'gzUsers' => $row->gzUsers,
				'gzSecurities' => $row->gzSecurities,
				'gzEmploy' => $row->gzEmploy,
				'uzfbcoed' => $row->uzfbcoed,
				'ShareNum' => $row->ShareNum,
				'my' => $my );
		}
		return $arr;
	}

	/**
	 *
	 * 授权登录后记录相关信息
	 */
	public function insert_participant_login() {

		$success = TRUE;
		$error = '';
		$joinNum=1;
		$refnum=0;
		$refnumsql='';
		$sqlShare='';
		$this->db->query('BEGIN');
		$participant = Session_Util::my_session_get('participant');
		if ($participant === NULL) {
			$success = FALSE;
			$error = '用户未授权';
		} else {
			$participant = json_decode($participant);
			$row = $this->db
			->get_row('SELECT id,referCode,joinNum,ratio,uptime FROM hb_user WHERE uid="'. $participant->openid . '"');
			if ($row === NULL) {
				//t_participant
				//插入新用户
				$FriendsId=$this->db->escape($participant->friendid);
				if($FriendsId!="")
				{
					$this->insert_lottery_imagesid($FriendsId);
				}

				$insert_result = $this->db
				->query( 'INSERT INTO hb_user(uid,name,picUrl,referCode,token,utype,joinNum,poolamount,ClickNum,ShareNum,BDNum,ratio,friendid,addtime) VALUE("'
				. $participant->openid . '","'
				. $this->db->escape($participant->nickname) . '","'
				. $participant->picUrl . '","'
				. $participant->referCode . '","'
				. $participant->token . '",0,'.$joinNum.',0,0,0,0,0, "'
				. $this->db->escape($participant->friendid) . '","'
				. date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']).'"'.')');
				if ($insert_result === FALSE) {
					$success = FALSE;
					$error = '记录用户信息出错';
					$this->Inset_loginfo("记录用户信息出错","记录用户信息出错");
				}
			} else {
				$id=$row->id;
				$referCode = $row->referCode;
				$uptime = $row->uptime;
				$ratio= $row->ratio;
				if(floatval($ratio) <0.5)
				{
					if($referCode!=""){
						//*****************邀请码不为空，取用户新增活动次数**********
						$refnum=$this->Get_referNum($referCode);
						$refnum=floatval($refnum);
						$refnumsql=',gzEmploy="01",ratio= ratio+'.$refnum ;
					}
				}
				if($uptime!==date('Y-m-d',$_SERVER['REQUEST_TIME'])){
					$sqlShare=",BDNum=0";
				}
				$update_result = $this->db
				->query('UPDATE hb_user SET  name="'. $this->db->escape($participant->nickname)
				. '",picUrl="'. $participant->picUrl
				. '"'. $refnumsql.' ,uptime="'. date('Y-m-d',$_SERVER['REQUEST_TIME']). '"  '.$sqlShare.'  WHERE id=' . intval($id));
				if ($update_result === FALSE) {
					$success = FALSE;
					$error = '同步用户信息出错';
					$this->Inset_loginfo("同步用户信息出错", "同步用户信息出错" );
				}
			}
		}
		if ($success) {

			$this->db->query('COMMIT');

		} else {
			$this->db->query('ROLLBACK');
		}

		return array('status' => $success ? 'success' : 'error',
				'message' => $success ? '记录登录用户信息成功' : $error);
	}

	/**
	 *
	 * 取用户新增活动次数 int
	 */
	public function Get_referNum($code) {

		$count = 0;
		$logined =false;
		$api = new API();

		$UserActivity =$api->UserActivities($code);
		$info=json_decode($UserActivity,true);

		if(!empty($info['id']))
		{

			//print_r($info);
			$id = $info['id'];
			$displayname = $info['displayName'];
			//$picurl = $info['picUrl'];
			$code = $info['code'];
			$loginedtoday = $info['loginedToday'];
			if($loginedtoday!='1')
			{
				$loginedtoday ='0';
			}
			$tradecount =intval( $info['tradeCount']);
			$joincompetitioncount = intval($info['joinCompetitionCount']);
			$herocount =intval( $info['heroCount']);
			$followercount =intval( $info['followerCount']);
			$sharecount =intval( $info['shareCount']);
			if($loginedtoday == '1') {
				$islogin='01';
			}
			else {
				$islogin='02';
			}
			$query = 'SELECT * FROM hb_useractivity where id="'.$id.'"';
			$insert = 'INSERT INTO hb_useractivity(id,displayName,code,loginedToday,tradeCount,joinCompetitionCount,heroCount,followerCount,shareCount,islogin,uptime)
			VALUE("'.$id.'","'.$displayname.'","'.$code.'",'.$loginedtoday.','.$tradecount.','.$joincompetitioncount.','.$herocount.','.$followercount.','.$sharecount.',"'. $islogin .'","'. date('Y-m-d',$_SERVER['REQUEST_TIME']).'")';
			$row = $this->db->get_row($query);
			if($row === NULL)
			{
				//插入
				$inert_result = $this->db->query($insert);
				if ($inert_result === FALSE) {
					$count= 0;
				}
				else {
					if($loginedtoday == '1') {
						$count=0.1;
						$logined=true;
					}
				}
			}
			else{
				//print_r($row);
				//计算
				$loginedtoday1 = $row->loginedToday;

				$islogin=	$row->islogin;
				$istrade=	$row->istrade;
				$isjoincompetition=	$row->isjoincompetition;
				$isshare=	$row->isshare;

				$tradecount1 =intval( $row->tradeCount);
					
				$joincompetitioncount1 =intval( $row->joinCompetitionCount);
					
				$sharecount1 =intval( $row->shareCount);
					
				$uptime= $row->uptime;
					
				if( $loginedtoday == '1')
				{
					if($islogin!="01")
					{
						$count=$count+0.1;
						$islogin="01";
						$login=' ,islogin = "01" ';
					}
				}
				if( $tradecount1 < $tradecount)
				{
					if($istrade!="01")
					{
						$count=$count+0.1;
						$istrade="01";
						$trade=' ,istrade = "01" ';
					}
				}

				if( $joincompetitioncount1 < $joincompetitioncount) {
					if($istrade!="01")
					{
						$count=$count+0.1;
						$isjoincompetition="01";
						$joincompetition=' ,isjoincompetition = "01" ';
					}
				}
				//				//分享
				//				if( $sharecount1 < $sharecount){
				//					if($isshare!="01")
				//					{
				//						$count=$count+0.2;
				//						$isshare="01";
				//						$share=' ,isshare = "01" ';
				//					}
				//				}
				if($count>=0)
				{

					$update =' UPDATE hb_useractivity SET displayName="'.$displayname.'",loginedToday='.$loginedtoday.',
								tradeCount='.$tradecount.',joinCompetitionCount='.$joincompetitioncount.',heroCount='.$herocount.',
								followerCount='.$followercount.',shareCount='.$sharecount .$login.$trade.$joincompetition.$share.' where id='.$id ;
					$update_result = $this->db->query($update);
					if ($update_result === FALSE) {
						$this->Inset_loginfo("更新历史信息出错", $this->db->escape($update) );
						$count= 0;
					}
				}
				}

			}

			return $count;
		}


		public function get_yjusers($users) {
			$success = true;
			$api = new API();
			$participant = Session_Util::my_session_get('participant');
			if ($participant !== NULL) {
				$participant = json_decode($participant);
				$api->Batchfollow($users);
				$update_result = $this->db->query('UPDATE hb_user SET ratio=ratio+0.1, gzUsers="01"  WHERE uid="' . $participant->openid .'"');
				if ($update_result === FALSE) {
					$success = FALSE;
					$error = '一键关注股神信息出错';
				}
			}
			else {
				$success = false;
				$error = '未授权！';
			}
			return array('status' => $success ? 'success' : 'error',
				'message' =>  $error);
		}

		public function get_yjsecurities($securities) {
			$success = true;
			$api = new API();
			$participant = Session_Util::my_session_get('participant');
			if ($participant !== NULL) {
				$participant = json_decode($participant);
				$api->BatchCreatePositions($securities);
				$update_result = $this->db->query('UPDATE hb_user SET ratio=ratio+0.1, gzSecurities="01"  WHERE uid="' . $participant->openid .'"');
				if ($update_result === FALSE) {
					$success = FALSE;
					$error = '一键关注股票信息出错';
				}
			}
			else {
				$success = false;
				$error = '未授权！';
			}
			return array('status' => $success ? 'success' : 'error',
				'message' =>  $error);
		}


		public function get_BatchCreatePositions($securityIds) {
			$success = true;
			$api = new API();
			$participant = Session_Util::my_session_get('participant');
			if ($participant !== NULL) {
				$participant = json_decode($participant);
				$api->BatchCreatePositions($securityIds);

			}
			else {
				$success = false;
				$error = '未授权！';
			}
			return array('status' => $success ? 'success' : 'error',
				'message' =>  $error);
		}



		public function binduzfbcoed($uzfbcoed,$Textname) {
			$success = true;

			$participant = Session_Util::my_session_get('participant');
			if ($participant !== NULL) {
				$participant = json_decode($participant);
				$update_result = $this->db->query('UPDATE hb_user SET  uzfbcoed="'.$this->db->escape($uzfbcoed).'",uzfbname="'.$this->db->escape($Textname).'",adduzftime="'. date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']). '"  WHERE uid="' . $participant->openid .'"');
				if ($update_result === FALSE) {
					$success = FALSE;
					$error = '绑定支付宝出错';
				}
			}
			else {
				$success = false;
				$error = '未授权！';
			}
			return array('status' => $success ? 'success' : 'error',
				'message' =>  $error);
		}

		public function insert_download() {
			$success = TRUE;
			$error = '记录下载信息成功';
			$participant = Session_Util::my_session_get('participant');
			if ($participant === NULL) {
				$success = FALSE;
				$error = '用户未授权';
			} else {
				$participant = json_decode($participant);
				$openid= $participant->openid;

				$row = $this->db->get_row('SELECT uid,gzDownload FROM hb_user WHERE uid="'. $openid  . '" ');

				if ($row !== NULL) {
					if($row->gzDownload !="01")
					{
						$this->db->query('BEGIN');
						$insert_result = $this->db
						->query('update  hb_user set gzDownload="01",joinNum=joinNum+1 where uid="'. $openid  . '" ');
						if ($insert_result === FALSE) {
							$success = FALSE;
							$error = '记录下载信息出错';
						}
						if ($success) {
							$this->db->query('COMMIT');
						} else {
							$this->db->query('ROLLBACK');
						}
					}
					else {
						$error = '已下载!';
					}
				}
				else {
					$success = FALSE;
					$error = '查询出错!';
				}
			}
			return array('status' => $success ? '1' : '0',
				'message' =>  $error);

		}


		public function update_ShareNum() {
			$success = TRUE;
			$error = '记录首页提示信息成功';
			$participant = Session_Util::my_session_get('participant');
			if ($participant === NULL) {
				$success = FALSE;
				$error = '用户未授权';
			} else {
				$participant = json_decode($participant);
				$openid= $participant->openid;
				$insert_result = $this->db
				->query('update  hb_user set ShareNum=ShareNum+1,BDNum=1 where uid="'. $openid  . '" ');
				if ($insert_result === FALSE) {
					$success = FALSE;
					$error = '首页提示信息出错';
				}
			}
			return array('status' => $success ? '1' : '0',
				'message' =>  $error);

		}



		/**
		 *
		 * //是否有增加机会
		 */
		public function Get_IsAward($openid,$FriendsId) {
			$success = FALSE;
			$row = $this->db
			->get_row('SELECT * FROM hb_record WHERE openid="'
			. $FriendsId. '" and FriendsId ="'.  $openid . '"');
			if ($row === NULL) {
				$success=true;
			}
			return $success;
		}

		/**
		 *
		 * //是否有增加机会
		 */
		public function Get_ClickNum($FriendsId) {
			$success = FALSE;
			$row = $this->db
			->get_row('SELECT ClickNum FROM hb_user WHERE uid="'. $FriendsId  . '" ');
			if ($row === NULL) {
				$success=true;
			}
			return $success;
		}

		/**
		 *
		 * 插入邀请
		 */
		public  function insert_lottery_imagesid($FriendsId) {

			$error = '';
			$success = TRUE;
			$error = '记录下载信息成功';
			$participant = Session_Util::my_session_get('participant');
			if ($participant === NULL) {
				$success = FALSE;
				$error = '用户未授权';
			} else {
				$participant = json_decode($participant);
				$openid= $participant->openid;
					
				$this->db->query('BEGIN');
				$insert_result = $this->db
				->query('INSERT INTO hb_record(openid,FriendsId,ClickTime) VALUE("'
				.  $FriendsId. '","'
				.  $openid . '","'
				. date('Y-m-d H:i:s',
				$_SERVER['REQUEST_TIME'])
				. '")');
				if ($insert_result === FALSE) {
					$success = FALSE;
					$error = '记录抽奖信息出错';
				} else {
					if($FriendsId!==$openid)
					{
						$row = $this->db->get_row('SELECT ClickNum FROM hb_user WHERE uid="'. $FriendsId  . '" ');
						if(intval($row->ClickNum) <8)
						{
							// 参与数+1
							$update_result = $this->db
							->query( 'UPDATE hb_user SET joinNum=joinNum+1,ClickNum=ClickNum+1 WHERE uid="' . $FriendsId .'"' );
							if ($update_result=== FALSE) {
								$success = FALSE;
								$error = '更新可拆数信息出错';
							}
						}
					}
				}
				if ($success) {
					$this->db->query('COMMIT');
				} else {
					$this->db->query('ROLLBACK');
				}
			}
			return $success;
		}

		/**
		 *
		 * //获取推荐人
		 */
		public function Get_friendidcount() {

			$tags__result=null;
			$participant = Session_Util::my_session_get('participant');
			if ($participant !== NULL) {
				$participant = json_decode($participant);
					
				$tags__result= $this->db->get_results( 'SELECT uid,name,addtime,friendid FROM hb_user WHERE uid<> friendid and friendid="'. $participant->openid  . '" ');
			}

			return $tags__result;
		}

		/**
		 *
		 * 插入榜单
		 */
		public  function insert_BDstockPick() {

			$error = '';
			$success = TRUE;
				$this->db->query('BEGIN');
				$api = new API();
				$BDstockPick= json_decode($api->BDstockPick(), true);
				
				$row = $this->db->get_row('SELECT count(*) al FROM stockpick WHERE rankedDate="'. $BDstockPick[0]["rankedDate"]  . '" ');
				if(intval($row->al)==0)
				{
					foreach($BDstockPick as $k=>$val){
						
						if(intval($val["rank"])<4 )
						{
							$insert_result=	$this->db
							->query('INSERT INTO stockpick(uid,pickedDate,maxStockName,maxRoi,rank,userName,rankedDate) VALUE("'
							.  $val["userId"] . '","'
							.  $val["pickedDate"] . '","'
							.  $val["maxStockName"] . '","'
							.  $val["maxRoi"]   . '","'
							.  $val["rank"] . '","'
							.  $val["userName"] . '","'
							.  $val["rankedDate"] .'" )');
							
							if ($insert_result === FALSE) {
								$success = FALSE;
							}
						}
					}
				}
			if ($success) {
				
				$this->db->query('COMMIT');
			} else {
				$this->db->query('ROLLBACK');
			}
			return $success;
		}
		
		public function Get_stockPick_User() {

			$tags__result=null;
			$participant = Session_Util::my_session_get('participant');
			if ($participant !== NULL) {
				$participant = json_decode($participant);
				$tags__result= $this->db->get_results( 'SELECT  tjuser.uid,tjuser.name,tjuser.friendid ,stockpick.rank,stockpick.pickedDate from (SELECT uid,name,addtime,friendid FROM hb_user WHERE uid<> friendid and friendid="'. $participant->openid  . '") tjuser,stockpick where  tjuser.uid  =stockpick.uid ');
			
			}

			return $tags__result;
		}
	}
