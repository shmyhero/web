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
			$StockpickHistory=json_decode($api->next_stockDiscussions($maxId),true);
		}else {
			$StockpickHistory=json_decode($api->stockDiscussions(),true);
		}
		break;
	case 1:
		if($maxId!=''){
			$StockpickHistory=json_decode($api->stockDiscussions(),true);
		}else {
			$StockpickHistory=json_decode($api->stockDiscussions(),true);
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
//print_r($StockpickHistory);
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

	<?php
	$i=0;
	if($count>0){
	foreach($StockpickHistory["enhancedItems"] as $k=>$val){  ?>
		<div class="alert alert-block alert-info fade in viewEmail">
						<a class="close " ><?php echo TO_date($val["createdAtUtc"]) ;   ?></a>
						
						<h4><i class="fa fa-check-square-o"><input type="hidden" name="box" value="<?php  echo $val["id"].'|'.$val["userId"] ?>">  <?php echo $result[$val["userId"]] ; //["displayName"]  ?>：   </i> <?php echo $val["header"] ;   ?></h4>
						<p><?php echo $val["text"] ;   ?></p>
						<?php
		if( $val["picUrl"]!="" )
		{ ?>
						<p>
							<img id="img1"  height="200" width="400" src="<?php echo $val["picUrl"] ;  ?>" />	
						</p>
		<?php	} ?>
		</div>
		<?php
		if($i==19)
		{
			$maxId=$val["id"];
		}
		$i++;}}
		?>
		<table class="table table-hover" >
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
