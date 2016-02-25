<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$api = new API();
$search=Security_Util::my_get('search');
$report=Security_Util::my_get('report');
if($search!=''){
	$StockpickHistory=json_decode($api->search_users($search),true);
}
$count=count($StockpickHistory);

function TO_date($strALL)
{
	$arr= explode('T',$strALL);
	$str=$arr[0];
	return $arr[0].' '. $arr[1];
}

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>


<table class="table table-hover">
	<thead>
		<tr>
			<th colspan="6"><!--  <input type="checkbox"> -->
			 <a class="btn btn-light-grey" ><i class="fa fa-refresh fa-lg"></i></a>
			<span class="btn-group">
			<button class="btn btn-light-grey isDeleted"><i class="fa fa-ban "> 封号</i></button>
			</span></th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($count>0){
	foreach($StockpickHistory as $k=>$val){  ?>
		<tr class="new">
			<td class="width-10"><input type="checkbox" name="box" value="<?php echo $val["userId"] ;   ?>"></td>
			
			<td class="viewEmail  hidden-xs"><?php echo $val["userthDisplayName"] ;   ?></td>
			<td class="viewEmail "><img height="100px" width="100px" alt="" src="<?php echo $val["userPicture"] ;   ?>" /></td>
		</tr>
		<?php
		}}?>
	</tbody>
<!--	<thead>-->
<!--		<tr>-->
<!--			<th colspan="4"></th>-->
<!--			<th class="emailPager" colspan="3"><a class="btn btn-sm btn-light-grey"><i class="fa fa-angle-right">下一页</i></a>-->
<!--			<input type="hidden" id="maxId" value="<?php echo $maxId-1 ;   ?>" />-->
<!--			<input type="hidden" id="type" value="<?php echo $type ;   ?>" /></th>-->
<!--		</tr>-->
<!--	</thead>-->
</table>
</body>
</html>
