<?php
class API  {
	
function headersarray($type)
{
	if($type===1)
	{        
		$participant = Session_Util::my_session_get('participant');
		$participant = json_decode($participant);
		$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	}  
	elseif ($type===0)
	{
				$array=	array("TH-Language-Code:zh-CN",
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				// "User-Agent: Fiddler",
				 "TH-Api-Key:TradeheroTempKey01");
	}
	return $array;
}

function signupAndLogin($token,$source,$channelId) {

	$array=$this->headersarray(0);
	$params = '{"token":"'.$token.'","source":'.$source.',"channelId":'.$channelId.'}';
	
	$signupAndLogin = Http::request("https://cn1.api.tradehero.mobi/api/signupAndLoginNew",$params,"POST",true,$array);
	return $signupAndLogin;
}

//2
function UserActivities($code)
{
	$array=$this->headersarray(0);
	return Http::request("https://cn1.api.tradehero.mobi/api/social/userActivities?code=".$code,null,'GET',false,$array);
}

//3
function recommend()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/recommend",null,'GET',false,$array);
}

//4  批量关注股神
function Batchfollow($GUS)
{
	$array=$this->headersarray(1);
	$params='{"userIds":['.$GUS.']}';
	return Http::request("https://cn1.api.tradehero.mobi/api/users/batchfollow/free",$params,"POST",true,$array);
}

//5批量关注股票
function BatchCreate($GUP)
{
	$array=$this->headersarray(1);
	$params='{"securityIds":['.$GUP.']}';
	return Http::request("https://cn1.api.tradehero.mobi/api/BatchCreateWatchlistPositions",$params,"POST",true,$array);
}

//6批量购买股票
function BatchCreatePositions($securityIds)
{
	$array=$this->headersarray(1);
	$params='{"securityIds":['.$securityIds.']}';
	return Http::request("https://cn1.api.tradehero.mobi/api/BatchCreatePositions",$params,"POST",true,$array);
}

//laba抽奖
function reward($userId)
{
	$array=$this->headersarray(0);
	$params='{"userId":'.$userId.',"reason":"LaBa prize","amount":1000}';
	return Http::request("https://cn1.api.tradehero.mobi/api/social/reward",$params,"POST",true,$array);
}

//选择 一支股票
function stockpick($securityId)
{
	$array=$this->headersarray(1);
	$params='{"securityId":'.$securityId.'}';
	return Http::request("https://cn1.api.tradehero.mobi/api/stockpick",$params,"POST",true,$array);
}

//历史选股
function StockpickHistory($perPage)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/stockpick?page=1&perPage=".$perPage,null,'GET',false,$array);
}

//查询股
function SecuritiesSearch($txtSearch)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/securities/search?q=".$txtSearch,null,'GET',false,$array);
}


//榜单
function BDstockPick()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/stockPick",null,'GET',false,$array);
}

//三日榜单
function ThreeDaysStockPick()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/stockPick?includeThreeDays=true",null,'GET',false,$array);
}


//个人榜单
function MYstockPick()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/stockPick?rankedOnly=true&page=1&perPage=5",null,'GET',false,$array);
}

function Securitiesrecommend()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/securities/recommend",null,'GET',false,$array);
}

function SearchHC($txtSearch)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/securities/searchcn?q=".$txtSearch."&page=1&perPage=10",null,'GET',false,$array);
}

function sendCode($phoneNumber)
{
	$array=$this->headersarray(0);
	return Http::request("https://cn1.api.tradehero.mobi/api/sendCode?phoneNumber=".$phoneNumber,null,"POST",true,$array);
}


/**
 * 帖子管理后台
 **/

//获取帖子（讨论大厅）
function timeline_original()
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=original&maxCount=20",null,'GET',false,$array);
}

//下一页（讨论大厅）
function next_original($maxId)
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=original&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}

//学堂数据接口
function timeline_guide()
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=guide&maxCount=20",null,'GET',false,$array);
}

//下一页学堂
function next_guide($maxId)
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=guide&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}

//精华区数据接口
function timeline_essential()
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=essential&maxCount=20",null,'GET',false,$array);
}

//下一页精华区
function next_essential($maxId)
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=essential&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}

//悬赏区数据接口
function timeline_question()
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=question&maxCount=20",null,'GET',false,$array);
}

//下一页悬赏区
function next_question($maxId)
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=question&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}

//公告数据接口
function timelinen_otice()
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=notice&maxCount=20",null,'GET',false,$array);
}

//下一页公告
function next_otice($maxId)
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=notice&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}

/**
 * 
管理员删贴  {"isDeleted":true}
管理员设置公告 {"isNotice":true}
管理员设置新手学堂 {"isGuide":true}
管理员加精 {"isEssential":true}

管理员置顶 {"stickType":15}
=2 学堂区置顶
=4 精华区置顶
=8 悬赏帖区置顶 
=15 四个区都置顶
 * */

/**
 * 0删贴
 * 1设置公告
 * 2新手学堂
 * 3加精
 * 4置顶
 **/
function operation($timelineid,$type,$stickType,$bool='true')
{
	$params=null;
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	switch ($type) {
			case 0:
				$params='{"isDeleted":true}';
				break;
			case 1:
				$params='{"isNotice":true}';
				break;
			case 2:
				$params='{"isGuide":true}';
				break;
			case 3:
				$params= '{"isEssential":true}';
				break;
			case 4:
				switch ($stickType) {
						case 0:
						$params= '{"stickType":15}';
						break;
						case 1:
						$params= '{"stickType":2}';
						break;
						case 2:
						$params= '{"stickType":4}';
						break;
						case 3:
						$params= '{"stickType":8}';
						break;
				}
				break;		
	} 
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline/".$timelineid."/operation",$params,"POST",true,$array);
	
}

function operationfalse($timelineid,$type,$stickType,$bool='true')
{
	$params=null;
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	switch ($type) {
			case 1:
				$params='{"isNotice":false}';
				break;
//			case 2:
//				$params='{"isGuide":false}';
//				break;
			case 3:
				$params= '{"isEssential":false}';
				break;
			case 4:
				$params= '{"stickType":0}';	
				break;		
	}
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline/".$timelineid."/operation",$params,"POST",true,$array);
	
}
// 发帖

function timeline($text,$header)
{
	//	$text = mb_ereg_replace('^(　| )+', '', $text); 
	//	$text =  mb_ereg_replace('(　| )+$', '', $text); 
	//	$text =  mb_ereg_replace('　　', "\n　　", $text); 
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	$params='{"text":"'.$text.'", "header":"'.$header.'"}';
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline",$params,"POST",true,$array);
}

function xstimeline($text,$header)
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	$params='{"text":"'.$text.'", "header":"'.$header.'", "prizeAmount":1000 }';
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline",$params,"POST",true,$array);
}

//回复
//回复帖子的某条评论 <@@七彩流浪人,704495430@>+text
function discussions($text,$inReplyToId)
{
	$array=$this->headersarray(1);
	$params=' {"text":"'.$text.'","inReplyToId":'.$inReplyToId.',"inReplyToType":"timelineitem"}';
	return Http::request("https://cn1.api.tradehero.mobi/api/discussions",$params,"POST",true,$array);
}

//回复股票讨论
//回复股票讨论 的某条评论 <@@七彩流浪人,704495430@>+text
function DiscussionsSecurity($text,$inReplyToId)
{
	$array=$this->headersarray(1);
	$params=' {"text":"'.$text.'","inReplyToId":'.$inReplyToId.',"inReplyToType":"security"}';
	return Http::request("https://cn1.api.tradehero.mobi/api/discussions",$params,"POST",true,$array);
}


//单个帖子
function timeline_byId($timeLineId)
{
	$array=$this->headersarray(0);
	return Http::request("https://cn1.api.tradehero.mobi/api/timeline/".$timeLineId,null,'GET',false,$array);
}


//帖子回复 
function timelineitem($timeLineId)
{
	$array=$this->headersarray(0);
	return Http::request("https://cn1.api.tradehero.mobi/api/discussions/timelineitem/".$timeLineId."?page=1&perPage=10",null,'GET',false,$array);					  
}

//用户个人帖子
function timelinen_commentOnly()
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?maxCount=10&type=commentOnly",null,'GET',false,$array);
}


//举报用户发帖 
function fenghao($timelineid)
{
	$array=$this->headersarray(1);
	$params='{"discussionId":'. $timelineid .',"discussionType":2, "reportType": 5}';
	return Http::request("https://cn1.api.tradehero.mobi/api/report",$params,"POST",true,$array);
}

//举报用户回帖  
function report($commentid)
{
	$array=$this->headersarray(1);
	$params='{"discussionId":'. $commentid .',"discussionType":1, "reportType": 5}';
	echo $params;
	return Http::request("https://cn1.api.tradehero.mobi/api/report",$params,"POST",true,$array);
}

function search_users($usersname)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/search?q=".$usersname."&page=1&perPage=1",null,'GET',false,$array);
}

//热门持有
function trendingHold()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/securities/trendingHold?exchange=SHA",null,'GET',false,$array);
}

//涨幅榜单
function trendingRisePercent()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/securities/trendingRisePercent?exchange=SHA",null,'GET',false,$array);
}

//中国概念
function trendingMarketCap()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/securities/trendingMarketCap?exchange=ChinaConcept",null,'GET',false,$array);
}

//个股信息

function SecurityInfo($exchange,$securityId)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/cn/v2/quotes/".$exchange."/".$securityId."/detail",null,'GET',false,$array);
}



//个股讨论
function SecurityDiscussions($exchange,$securityId)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/cn/v2/securities/".$exchange."/". $securityId ."/discussions?page=1&perPage=10",null,'GET',false,$array);
}



//login
function login($email,$password)
{
	$array=	array('TH-Client-Version: 2.4.2.5705',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:Basic ".base64_encode($email.":".$password));
			 
	$params='{"useOnlyHeroCount":"true","clientVersion":"2.4.2","clientType":5}';
	return Http::request("https://cn1.api.tradehero.mobi/api/login",$params,"POST",true,$array);
}


function stockDiscussions()
{
	
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?maxCount=20&type=stock",null,'GET',false,$array);
}


function next_stockDiscussions($maxId)
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array=	array('TH-Language-Code:zh-CN',
            	 "Content-Type:application/json;charset=UTF-8",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline?type=stock&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}


function stockrecommend($param)
{
	$participant = Session_Util::my_session_get('participant');
	$participant = json_decode($participant);
	$array= array("TH-Language-Code:zh-CN",
            	 "Content-Type:multipart/form-data; boundary=-------------------------acebdf13572468",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "TH-Client-Type: 4",
				 "Authorization:".$participant->token);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/". $participant->openid ."/timeline",$param,'POST',true,$array);
}

}
