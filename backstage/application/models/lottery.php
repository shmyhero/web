<?php
class lottery extends Dao_Impl{

	private $return = 0;
	private $tip = '';
	private $url = '';
	private $bondAL = 0;
	private $bondMoney = 0;
	public function __construct() {
		parent::__construct();
	}

	//查询兑奖( 5T ST c处理方式) CNY_ strtr('',0,2)

	//插入兑奖记录 ticketrecord

	//更新积分 cny_points

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
		$base_result = array_map(array(__CLASS__, '_urlencode_val'),
		$base_result);
		return $base_result;
	}




	/**
	 *
	 * 查询 是否加
	 */
	private  function Get_IsAward($Type,$amount) {

		$success = 0;
		$Type=intval($Type);
		$amount=intval($amount);
		if($amount> GJ_amount)
		{
			if($Type==1)
			{
				$row = $this->db->get_row('SELECT count(*) Sl FROM hb_user WHERE poolamount>'.DJ_amount );
				if(intval($row->Sl)<hongbao)
				{
					$success =  7;
					return $success;
				}
				else {
					$success =  8;
					return $success;
				}
			}
			else {
				$success =  0;
				return $success;
			}
		}
		elseif ($amount<=D1JD_amount)
		{
			$success =  1;
			return $success;
		}
		elseif ($amount>D1JD_amount&&$amount<=D2JD_amount)
		{
			$success =  2;
			return $success;
		}
		elseif ($amount>D2JD_amount&&$amount<=D3JD_amount)
		{
			$success =  3;
			return $success;
		}
		elseif ($amount>D3JD_amount&&$amount<=D4JD_amount)
		{
			$success =  4;
			return $success;
		}
		elseif ($amount>D4JD_amount&&$amount<=D5JD_amount)
		{
			$success =  5;
			return $success;
		}
		elseif ($amount>D5JD_amount&&$amount<=D6JD_amount)
		{
			$success =  6;
			return $success;
		}
		elseif ($amount>D6JD_amount&&$amount<=D7JD_amount)
		{
			$success =  7;
			return $success;
		}
		elseif ($amount>D7JD_amount&&$amount<=GJ_amount)
		{
			$success =  8;
			return $success;
		}
	}

	/**
	 *
	 * //是否有抽奖机会
	 */
	public function Get_images_IsAward($openid,$FriendsId) {
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
	 * 是否有抽奖次数
	 */
	public function Get_joinNum_IsAward($openid) {
		$success = FALSE;
		$row = $this->db
		->get_row('SELECT joinNum FROM hb_user WHERE uid="'. $openid. '" ');
		if ($row !== NULL) {
			$success= intval($row->joinNum)>0;
		}
		return $success;
	}



	/**
	 *
	 * // 自己领红包
	 */
	public function luckDrawByMe()
	{
		$error='';
		$success = FALSE;
		$amount=0;
		$participant = Session_Util::my_session_get('participant');
		if ($participant === NULL) {
			$success = FALSE;
			$error = '用户未授权';
		} else {
			$participant = json_decode($participant);
			//是否有抽奖机会
			if($this->Get_images_IsAward($participant->openid,$participant->openid)){
				$IsAward=TRUE;
				$amount= rand(50,80);
				$lucktype="01";
				if($this->insert_lottery_imagesid($participant->openid,$participant->openid,$participant->nickname,$participant->picUrl,$lucktype,$amount))
				{
					$success=TRUE;
				}
			}
			else {
				$success=false;
			}
		}
		return array('status' => $success ?  'success' : 'error',
				'AwardID' => $lucktype ,
				'amount' => $amount ,
				'openid' => $participant->openid ,
				'message' => $success ? '发红包了' : $error);
	}

	/**
	 *
	 * // 朋友领红包  高几率
	 */
	public function luckDrawByF($FriendsId)
	{
		$error='';
		$success = FALSE;
		$amount=0;
		$participant = Session_Util::my_session_get('participant');
		if ($participant === NULL) {
			$success = FALSE;
			$error = '用户未授权';
		} else {
			$participant = json_decode($participant);
			//是否有抽奖机会
			if($this->Get_images_IsAward($participant->openid,$FriendsId)){
				$row = $this->db
				->get_row('SELECT utype,poolamount FROM hb_user  WHERE uid="'. $FriendsId  . '"'); //  此处剁手 $friendsid
				$Type = $row->utype;
				$amount = $row->poolamount;
				$IsAward= $this->Get_IsAward($Type,$amount);
				switch ($IsAward) {
					case 0:
						$amount=1;
						break;
					case 1:
						$rewardArray= array(45,50,4,1);
						$luckDraw=$this->luckDrawBYone($rewardArray);
						switch ($luckDraw) {
							case 0:
								$amount=rand(50,80);
								break;
							case 1:
								$amount=rand(30,50);
								break;
							case 2:
								$amount=rand(6,29);
								break;
							case 3:
								$amount=rand(1,5);
								break;
						}
						break;
					case 2:
						$rewardArray= array(20,20,50,10);
						$luckDraw=$this->luckDrawBYone($rewardArray);
						switch ($luckDraw) {
							case 0:
								$amount=rand(50,80);
								break;
							case 1:
								$amount=rand(30,50);
								break;
							case 2:
								$amount=rand(6,29);
								break;
							case 3:
								$amount=rand(1,5);
								break;
						}
						break;
					case 3:
						$rewardArray= array(10,20,58,12);
						$luckDraw=$this->luckDrawBYone($rewardArray);
						switch ($luckDraw) {
							case 0:
								$amount=rand(50,80);
								break;
							case 1:
								$amount=rand(30,50);
								break;
							case 2:
								$amount=rand(6,29);
								break;
							case 3:
								$amount=rand(1,5);
								break;
						}
						break;
					case 4:
						$rewardArray= array(5,5,50,40);
						$luckDraw=$this->luckDrawBYone($rewardArray);
						switch ($luckDraw) {
							case 0:
								$amount=rand(50,80);
								break;
							case 1:
								$amount=rand(30,50);
								break;
							case 2:
								$amount=rand(6,29);
								break;
							case 3:
								$amount=rand(1,5);
								break;
						}
						break;
					case 5:
						$rewardArray= array(2,3,34,61);
						$luckDraw=$this->luckDrawBYone($rewardArray);
						switch ($luckDraw) {
							case 0:
								$amount=rand(50,80);
								break;
							case 1:
								$amount=rand(30,50);
								break;
							case 2:
								$amount=rand(6,29);
								break;
							case 3:
								$amount=rand(1,5);
								break;
						}
						break;
					case 6:
						$rewardArray= array(1,1,23,75);
						$luckDraw=$this->luckDrawBYone($rewardArray);
						switch ($luckDraw) {
							case 0:
								$amount=rand(50,80);
								break;
							case 1:
								$amount=rand(30,50);
								break;
							case 2:
								$amount=rand(6,29);
								break;
							case 3:
								$amount=rand(1,5);
								break;
						}
						break;

					case 7:
						$rewardArray= array(1,14,85);
						$luckDraw=$this->luckDrawBYone($rewardArray);
						switch ($luckDraw) {
							case 0:
								$amount=rand(30,50);
								break;
							case 1:
								$amount=rand(6,29);
								break;
							case 2:
								$amount=rand(1,5);
								break;
						}
						break;
					case 8:
						$amount=rand(1,3);
						break;
				}
				$lucktype="02";
				if($this->insert_lottery_imagesid($FriendsId,$participant->openid,$participant->nickname,$participant->picUrl,$lucktype,$amount))
				{
					$success=TRUE;
					$error="插入出错";
				}
			}
			else {
				$success=false;
			}
		}
		return array('status' => $success ?  'success' : 'error',
				'AwardID' => $lucktype ,
				'amount' => $amount ,
				'openid' => $participant->openid ,
				'message' => $success ? '发红包了' : $error);
	}

	public function randomFloat($min = 0, $max = 1) {
		$zhi= $min + mt_rand() / mt_getrandmax() * ($max - $min);
		return  floatval(round($zhi, 1));
	}

	/**
	 * 简单的抽奖概率函数
	 * @param array $rewardArray 概率,如：$rewardArray = array(10, 20, 20, 30, 10, 10)，对应各奖品的概率
	 * @return int    概率数组的下标
	 */
	public function luckDrawBYone($rewardArray)
	{
		$return=0;
		//$rewardArray = array(20,20,60);
		$sum = array_sum($rewardArray);
		//获取随机数
		$rewardNum = mt_rand(0, $sum - 1);
		$totalnum = count($rewardArray);
		for($i = 0; $i < $totalnum; $i++)
		{
			if($i == 0)
			{
				if($rewardArray[$i] > $rewardNum && $rewardNum >= 0)
				{
					$return= $i;
				}
			}
			else
			{
				$max = $min = 0;
				for($j = 0; $j <= $i; $j++)
				{
					$max = $max + $rewardArray[$j];
				}
				for($k = 0; $k < $i; $k++)
				{
					$min = $min + $rewardArray[$k];
				}
				if($max > $rewardNum && $rewardNum >= $min)
				{
					$return= $i;
				}
			}
		}
		return  $return;
	}

	/**
	 *
	 * 插入中奖信息
	 */
	private function insert_lottery_imagesid($FriendsId,$openid,$Friendname,$Friendurl,$lucktype,$amount) {
		$success = TRUE;
		$error = '';
		$this->db->query('BEGIN');
		$insert_result = $this->db
		->query('INSERT INTO hb_record(openid,FriendsId,Friendname,Friendurl,Type,amount,ClickTime) VALUE("'
		.  $FriendsId. '","'
		.  $openid . '","'
		.  $Friendname . '","'
		.  $Friendurl . '","'
		.  $lucktype . '",'
		.  $amount . ',"'
		. date('Y-m-d H:i:s',
		$_SERVER['REQUEST_TIME'])
		. '")');
		if ($insert_result === FALSE) {
			$success = FALSE;
			$error = '记录抽奖信息出错';
		} else {
			$Clicksql="";
			if($FriendsId!==$openid)
			{
				$Clicksql="ClickNum=ClickNum+1,";
				// 参与数-1
				$update_result = $this->db
				->query( 'UPDATE hb_user SET joinNum=joinNum-1  WHERE uid="' . $openid .'"' );
				if ($update_result=== FALSE) {
					$success = FALSE;
					$error = '更新可拆数信息出错';
				}
			}
			$update_result = $this->db
			->query( 'UPDATE hb_user SET '.$Clicksql.' poolamount=poolamount+ ' . $amount .' WHERE uid="' . $FriendsId .'"' );
			if ($update_result=== FALSE) {
				$success = FALSE;
				$error = '更新积分信息出错';
			}

		}
		if ($success) {
			$this->db->query('COMMIT');
		} else {
			$this->db->query('ROLLBACK');
		}
		return $success;
	}

	/**
	 *
	 * 用户分享+1信息
	 */
	public function insert_shareBYFriendsId($FriendsId) {

		$success = TRUE;
		$error = '';

		$participant = Session_Util::my_session_get('participant');
		if ($participant === NULL) {
			$success = FALSE;
			$error = '用户未授权';
		} else {
			$participant = json_decode($participant);
			$openid=$participant->openid;

			$update_result = $this->db
			->query( 'UPDATE hb_user SET ShareNum=ShareNum+1  WHERE openid="' . $FriendsId .'"' );
			if ($update_result=== FALSE) {
				$success = FALSE;
				$error = '更新分享数信息出错';
			}
		}
		return array('status' => $success ? '1' : '0',
				'message' => $success ? '记录分享信息成功' : $error);
	}



}