<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$api = new API();
$type=Security_Util::my_get('type');
$maxId=Security_Util::my_get('maxId');
switch ($type) {
	case 0:
		if($maxId!=''){
			$StockpickHistory=json_decode($api->next_original($maxId),true);
		}else {
			$StockpickHistory=json_decode($api->timeline_original(),true);
		}
		break;
	case 1:
		if($maxId!=''){
			$StockpickHistory=json_decode($api->next_guide($maxId),true);
		}else {
			$StockpickHistory=json_decode($api->timeline_guide(),true);
		}
		break;
	case 2:
		if($maxId!=''){
			$StockpickHistory=json_decode($api->next_essential($maxId),true);
		}else {
			$StockpickHistory=json_decode($api->timeline_essential(),true);	
		}
		break;
	case 3:
		if($maxId!=''){
			$StockpickHistory=json_decode($api->next_question($maxId),true);
		}else {
			$StockpickHistory=json_decode($api->timeline_question(),true);	
		}
		break;
	case 4:
		if($maxId!=''){
			$StockpickHistory=json_decode($api->next_otice($maxId),true);
		}else {
			$StockpickHistory=json_decode($api->timelinen_otice(),true);	
		}
		break;
}
	$count=count($StockpickHistory);
	if($count>0)
	{
		$result   = array();   
		foreach((array)$StockpickHistory["users"] as $key=>$row){ 
		     $result[$row["id"]] = $row["displayName"]; 
		        }
	}
 

function TO_date($strALL)
{
	return date("Y-m-d H:i:s",strtotime("+8hours",strtotime($strALL)));
}

function testkong($a){
	if($a===''||$a===null||$a===""){
		return false;
	}else{
		return true;
	}
}

function parseText($text){
    if (preg_match ("/\\[.*\\]/", $text, $a)) 
	{
		$a = $a[0];
	}
	if (preg_match ("/\\(.*\\)/", $text, $link)) 
    {
      	$link = $link[0];
    }
    if (preg_match ("/\\*.*\\*/", $text, $des)) 
    {
      	$des = $des[0];
    }else
    {
    	  $des =  $text;
    }
    $ahref="";
    if($link != null){
      	 if(strpos($link, 'tradehero')){
    	   $ahref= "<a href='". $link . "'>" . $a . "</a>"; 
      	 }
      }
      $html = $ahref.$des;
      return $html;
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>

<table class="table table-hover" >
	<thead>
		<tr>
			<th colspan="6"><!--  <input type="checkbox"> -->
			<a class="btn btn-light-grey isrefresh" ><i class="fa fa-refresh fa-lg"></i></a>
			<span class="btn-group">
		
			<button class="btn btn-light-grey isDeleted"><i class="fa fa-trash-o"> 删帖</i></button>
			<button class="btn btn-light-grey isEssential"><i class="fa fa-pencil"> 加精</i></button>
			<button class="btn btn-light-grey stickType"><i class="fa fa-volume-off"> 置顶</i></button>
			<button class="btn btn-light-grey isNotice"><i class="fa fa-clock-o"> 公告</i></button>
			<button class="btn btn-light-grey NOEssential"><i class="fa fa-clock-o"> 取消加精</i></button>
			<button class="btn btn-light-grey NOstick"><i class="fa fa-clock-o"> 取消置顶</i></button>
			<button class="btn btn-light-grey isfenghao"><i class="fa fa-ban "> 封号</i></button>
			</span></th>
		</tr>
	</thead>
	<tbody>
	
	<?php
	$i=0;
	if($count>0){
	foreach($StockpickHistory["enhancedItems"] as $k=>$val){  ?>
		<tr class="new" >
			<td class="width-10"> <input type="checkbox" name="box" value=" <?php  echo $val["id"].'|'.$val["userId"] ?>">  </td> 
			<td class="width-10"><i class="fa fa-star <?php echo $val["isEssential"]==1? "starred":"" ;   ?>"> <i class="fa fa-star <?php echo $val["stickType"]!= 0 ? "starred":"" ;   ?>"></i></i></td>
			<td class="viewEmail  hidden-xs"><?php echo $val["header"] ;   ?></td>
			<td class="viewEmail "><?php echo parseText($val["text"]) ;   ?></td>
			<td class="viewEmail "><?php echo $result[$val["userId"]] ; //["displayName"]  ?></td>
			<td class="viewEmail  text-right"><?php echo TO_date($val["createdAtUtc"]) ;   ?></td>
		</tr>
		<?php
		if($i==19)
		{
			$maxId=$val["id"];
		}
		$i++;}}
		?>
	</tbody>
	<thead>
		<tr>
			<th colspan="4"></th>
			<th class="emailPager" colspan="3"><a class="btn btn-sm btn-light-grey"><i class="fa fa-angle-right">下一页</i></a>
			<input type="hidden" id="maxId" value="<?php echo $maxId-1 ;   ?>" />
			<input type="hidden" id="type" value="<?php echo $type ;   ?>" /></th>
		</tr>
	</thead>
</table>
</body>
</html>
