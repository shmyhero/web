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
				 "Authorization:".$participant->token) ;
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


//上证k线
function Search1A0001()
{
	$array=$this->headersarray(0);
	return Http::request("https://cn1.api.tradehero.mobi/api/cn/v2/quotes/SHA/1A0001/klines/day",null,'GET',false,$array);
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
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=original&maxCount=20",null,'GET',false,$array);
}

//下一页（讨论大厅）
function next_original($maxId)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=original&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}

//学堂数据接口
function timeline_guide()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=guide&maxCount=20",null,'GET',false,$array);
}

//下一页学堂
function next_guide($maxId)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=guide&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}

//精华区数据接口
function timeline_essential()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=essential&maxCount=20",null,'GET',false,$array);
}

//下一页精华区
function next_essential($maxId)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=essential&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}

//悬赏区数据接口
function timeline_question()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=question&maxCount=20",null,'GET',false,$array);
}

//下一页悬赏区
function next_question($maxId)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=question&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
}

//公告数据接口
function timelinen_otice()
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=notice&maxCount=20",null,'GET',false,$array);
}

//下一页公告
function next_otice($maxId)
{
	$array=$this->headersarray(1);
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline?type=notice&maxCount=20&maxId=".$maxId,null,'GET',false,$array);
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
function operation($timelineid,$type,$stickType=15,$bool='true')
{
	$params=null;
	$array=$this->headersarray(1);
	switch ($type) {
			case 0:
				$params='{"isDeleted":'.$bool.'}';
				break;
			case 1:
				$params='{"isNotice":'.$bool.'}';
				break;
			case 2:
				$params='{"isGuide":'.$bool.'}';
				break;
			case 3:
				$params= '{"isEssential":'.$bool.'}';
				break;
			case 4:
				if($stickType==15)
				{
					$params= '{"stickType":15}';
				}else{
				$params= '{"stickType":'.$stickType.'}';
				}
				break;		
	}
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline/".$timelineid."/operation",$params,"POST",true,$array);
}
// 发帖

function timeline($text,$header)
{
	$array=$this->headersarray(1);
	$params='{"text":'.$text.', "header":'.$header.'}';
	return Http::request("https://cn1.api.tradehero.mobi/api/users/552948/timeline",$params,"POST",true,$array);
}


//用户黑名单 
function report()
{
	$array=$this->headersarray(1);
	$params='{"discussionId":701602857,"discussionType":2, "reportType": 5}';
	return Http::request("https://cn1.api.tradehero.mobi/api/report",$params,"POST",true,$array);
}


}
