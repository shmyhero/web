<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');
$api = new API();

$timelineid=Security_Util::my_get('id');
//echo $timelineid;
$timeline=json_decode($api->timeline_byId($timelineid),true);
$timelineitem=json_decode($api->timelineitem($timelineid),true);
//print_r($timelineitem) ;	


function TO_date($strALL)
{
//	$arr= explode('T',$strALL);
//	$str=$arr[0];
//	return $arr[0].' '. $arr[1];
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
	  <div class="row">
		  <div class="col-md-12 toolbar">
				<span class="btn-group">
				  <button class="btn btn-light-grey replyBtn">
					<i class="fa fa-reply"></i>
				  </button>
				</span>
				<span class="btn-group">
					<button class="btn btn-light-grey deleteBtn">
						<i class="fa fa-trash-o"></i>
					</button>
				</span> 
		  </div>
	  </div>
	  <div class="divide-20"></div>
      <div class="emailTitle emailViewHeader" >
         <h1> <?php echo $timeline["user"]["displayName"] ;   ?> :<?php echo $timeline["header"]; ?></h1> 
      </div>
	  <hr>
      <div class="emailViewContent">
         
			<div class="form-group">
				<label class="col-sm-1 control-label">时间:</label>
				<label class="col-sm-11 control-label"><?php echo TO_date($timeline["createdAtUtc"]) ;   ?></label>
			</div>
		
      </div>
	  <hr>
      <div class="emailView">
        <p><?php echo $timeline["text"] ;   ?></p>
      </div>
      <hr>
      <div class="emailView">
      <?php	if( $timeline["picUrl"]!="" )
		{ ?>
						<p>
							<img id="img1"  height="200" width="400" src="<?php echo $timeline["picUrl"] ;  ?>" />	
						</p>
		<?php	} ?>
       
      </div>
      <hr>
  <div class="box-body font-14">
    <?php
	foreach($timelineitem["data"] as $k=>$val){  ?>
										 
											  <ul style=" list-style: none;">
													<li>
														 <span class="btn-grey">回复<i class="fa fa-arrow-right text-primary"> </i> <input  type="hidden"  value="<?php echo $val["user"]["id"] ;   ?>" /></span>   &nbsp;&nbsp;&nbsp;&nbsp;  <small><?php echo $val["user"]["displayName"]  ;   ?> </small> <span class="btn-yellow">封号<i class="fa fa-ban text-primary"> </i> <input  type="hidden"  value="<?php echo $val["id"] ;   ?>" /></span>
													</li>
													<li>
														<small><?php echo TO_date($val["createdAtUtc"]) ;   ?> </small>
													</li>
													<li><?php echo parseText($val["text"]) ;   ?>
													</li>
													
											  </ul>
											
        <?php
		}
		?>
      </div>									
 	 <hr>
	 <div class="emailField address template" id="ToHF">
            <label class="control-label">To:</label>
            <div class="fields fieldsTo">
               <input class="form-control col-md-12" id="Toinput" name="to" type="text">
            </div>
         </div>		
     <hr>						
     <div class="emailField">
            <div class="divide-20"></div>
            <div id="alerts"></div>
            <textarea rows="3" cols="30" id="editor" class="form-control"></textarea>
         </div>
         <input type="hidden" id="timelineid" value="<?php echo $timeline["id"];   ?>" />
         <input type="hidden" id="userid"  />
         <input type="hidden" id="username"  />
    <div class="emailComposeButtons">           
			<button class="btn btn-hf"><i class="fa fa-check-square-o"></i> 回复</button>
         </div>
   </body>
</html>