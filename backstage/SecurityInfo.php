<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$api = new API();
$Securityid=Security_Util::my_get('Securityid');
$exchange=Security_Util::my_get('exchange');
$id=Security_Util::my_get('id');
$SecurityInfo=json_decode($api->SecurityInfo($exchange,$Securityid),true);

$Discussions=json_decode($api->SecurityDiscussions($exchange,$Securityid),true);

$count=count($Discussions);

function TO_date($strALL)
{
	return date("Y-m-d H:i:s",strtotime("+8hours",strtotime($strALL)));
}

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>

    <div class="row">

							<div class="col-md-6">
							
								<!-- BOX -->
								<div class="box border inverse">
									<div class="box-body">
										<form class="form-horizontal" role="form">
												  <div class="form-group">
													<label class="col-sm-3 control-label">开盘价</label>
													<div class="col-sm-9">
													  <label class="col-sm-3 control-label"><?php echo $SecurityInfo["open"] ;   ?></label>
													</div>
												  </div>
												  <div class="form-group">
													<label class="col-sm-3 control-label">最新价</label>
													<div class="col-sm-9">
														<label class="col-sm-3 control-label"><?php echo $SecurityInfo["last"];   ?></label>
													</div>
												  </div>
												 <div class="form-group">
													<label class="col-sm-3 control-label">涨跌幅</label>
													<div class="col-sm-9">
														<label class="col-sm-3 control-label"><?php echo round( ($SecurityInfo["last"]-$SecurityInfo["prec"]) / $SecurityInfo["prec"] *100,2) ;   ?>%</label>
													</div>
												  </div>
												 </form>
										<?php
											if($count>0){
											foreach($Discussions["comments"] as $k=>$val){  ?>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h3 class="panel-title"><span class="btn-grey">回复<i class="fa fa-arrow-right text-primary"> </i> <input  type="hidden"  value="<?php echo $val["user"]["id"] ;   ?>" /></span>   &nbsp;&nbsp;&nbsp;&nbsp;  <small><?php echo $val["userName"] ;?></small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo TO_date($val["createdAtUtc"]) ;   ?></h3>
													</div>
													<div class="panel-body">
														<ul style=" list-style: none;">
															<li><?php echo $val["text"] ;   ?></li>
														</ul>
													</div>
												</div>
												<?php
												}}?>	
								
									</div>
								<!-- /BOX -->
							</div>
						</div>
						
						    <div class="col-md-4">
								
							 <div class="emailField address template" id="ToHF">
						            <label class="control-label">To:</label>
						            <div class="fields fieldsTo">
						               <input class="form-control col-md-12" id="Toinput" name="to" type="text" >
<!--						               placeholder="Disabled input here..." disabled-->
						            </div>
						         </div>		
						     <hr>						
						     <div class="emailField">
						            <div class="divide-20"></div>
						            <div id="alerts"></div>
						            <textarea rows="3" cols="30" id="editor" class="form-control">
									</textarea>
						         </div>
						         <input type="hidden" id="securityid" value="<?php echo $Securityid;   ?>" />
						          <input type="hidden" id="id" value="<?php echo $id;   ?>" />
						          <input type="hidden" id="exchange" value="<?php echo $exchange;   ?>" />
						          
						         <input type="hidden" id="userid"  />
						         <input type="hidden" id="username"  />
						    <div class="emailComposeButtons">           
									<button class="btn btn-hf"><i class="fa fa-check-square-o"></i> 回复</button>
						         </div>
							
									</div>
									</div>
</body>
</html>
