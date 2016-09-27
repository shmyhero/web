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
	elseif ($type===2)
	{
				 $array= array("TH-Language-Code:zh-CN",
            	 "Content-Type:multipart/form-data; boundary=-------------------------acebdf13572468",
            	 "Connection:Keep-Alive",
            	 "Accept-Encoding:gzip",
            	 "Host:cn1.api.tradehero.mobi",
				 "TH-Client-Type: 4",
				 "Authorization:".$participant->token);
	}
	return $array;
}


function getbanner()
{

	return Http::request("http://cfd-webapi.chinacloudapp.cn/api/banner2",null,'GET',false,null);
}

function getbannerbyid($id)
{
	return Http::request("http://cfd-webapi.chinacloudapp.cn/api/getbannerbyid?id=".$id,null,'GET',false,null);
}

function getheadline()
{
	return Http::request("http://cfd-webapi.chinacloudapp.cn/api/headline/group",null,'GET',false,null);
}

function getheadlinebyid($id)
{
  return Http::request("http://cfd-webapi.chinacloudapp.cn/api/headline/".$id,null,'GET',false,null);
}

}
