<?php
include(dirname(__FILE__) . '/inc/my_session.php');
include(dirname(__FILE__) . '/inc/model_require.php');
include(dirname(__FILE__) . '/inc/require_file.php');
header('Content-type: text/html; charset=utf-8');


$header =Security_Util::my_post('header');
$editor =Security_Util::my_post('editor');
$isStock =Security_Util::my_post('isStock');
	$item=$_FILES['file1'];

	$_formdata = array(
    'header' => $header,
    'text' => $editor
	);
	$API = new API();
	$boundary = '-------------------------acebdf13572468'; 
     $data = '--'.$boundary."\r\n";
     $formdata = ''; 
  
    
      $formdatah .= "content-disposition: form-data; name=\"".'header'."\"\r\n\r\n"; 
      $formdatah .= $header."\r\n";  
      $formdatah .= '--'.$boundary."\r\n";
     
  	  $formdatat .= "content-disposition: form-data; name=\"".'text'."\"\r\n\r\n"; 
      $formdatat .= $editor."\r\n";  
      $formdatat .= '--'.$boundary."\r\n";
      
      $formdatais .= "content-disposition: form-data; name=\"".'isStock'."\"\r\n\r\n"; 
      $formdatais .= 'true'."\r\n";  
      if($isStock=="true")
    	{ 
      	$formdatais .= '--'.$boundary."\r\n";
   	 	}
      else{
      	$formdatais .= '--'.$boundary."--\r\n";
    	}
    // file data
    if($isStock=="true")
    { 
    	$filedata = ''; 
        $filedata .= "content-disposition: form-data; name=\"".$item['filename']."\"; filename=\"".$item['name']."\"\r\n"; 
        $filedata .= "content-type: ".$item['type']."\r\n\r\n"; 
        $filedata .= file_get_contents($item['tmp_name'])."\r\n"; 
        $filedata .= '--'.$boundary."--\r\n";
    }
        

    $data .= $formdatah.$formdatat.$formdatais.$filedata."\r\n\r\n";
    $out .= $data;
	echo $API->stockrecommend($out);

		
          	
          	
	function ensure_writable_dir($dir) {
	     if(!file_exists($dir)) {
	         mkdir($dir, 0766, true);
	         chmod($dir, 0766);
	         chmod($dir, 0777);
	     }
	     else if(!is_writable($dir)) {
	        chmod($dir, 0766);
	         chmod($dir, 0777);
	         if(!is_writable($dir)) {
	             throw new FileSystemException("目录 $dir 不可写");
	         }
	     }
	      //扩展名
             $extension = '';
              if(strcmp($item['type'], 'image/jpeg') == 0) {
                 $extension = '.jpg';
             }
             else if(strcmp($item['type'], 'image/png') == 0) {
                 $extension = '.png';
             }
             else if(strcmp($item['type'], 'image/gif') == 0) {
                $extension = '.gif';
              }
             else {
                //如果type不是以上三者，我们就从图片原名称里面去截取判断去取得(处于严谨性)    
                $substr = strrchr($item['name'], '.');
                 if(FALSE == $substr) {
                  $files[$index]['error'] = 8002;
                 }
 
                  //取得元名字的扩展名后，再通过扩展名去给type赋上对应的值
                  if(strcasecmp($substr, '.jpg') == 0 || strcasecmp($substr, '.jpeg') == 0 || strcasecmp($substr, '.jfif') == 0 || strcasecmp($substr, '.jpe') == 0 ) {
                     $files[$index]['type'] = 'image/jpeg';
                 }
                  else if(strcasecmp($substr, '.png') == 0) {
                      $files[$index]['type'] = 'image/png';
                  }
                 else if(strcasecmp($substr, '.gif') == 0) {
                      $files[$index]['type'] = 'image/gif';
                  }
                 else {
                     $files[$index]['error'] = 8003;
                     continue;
                 }
                 $extension = $substr;
             }
 			
             //对临时文件名加密，用于后面生成复杂的新文件名
             $md5 = md5_file($item['tmp_name']);
             //取得图片的大小
             $imageInfo = getimagesize($item['tmp_name']);
             $rawImageWidth = $imageInfo[0];
             $rawImageHeight = $imageInfo[1];

             $path = BASE_URL.'upfolder/';
            
             //文件名
             $name = $md5.$extension;

             $files[$index]['path'] = $path . $name;        //存图片路径
             $files[$index]['success'] = true;            //图片上传成功标志
             $files[$index]['width'] = $rawImageWidth;    //图片宽度
             $files[$index]['height'] = $rawImageHeight;    //图片高度
             $files[$index]['id'] = $Id; 
             //			$files = array();
//			 $success = 0;
//			 $index=0;
//   			  $item=$_FILES['file1'];
//              $files[$index]['srcName'] = $item['name'];    //上传图片的原名字
//              $files[$index]['error'] = $item['error'];    //和该文件上传相关的错误代码
//              $files[$index]['size'] = $item['size'];        //已上传文件的大小，单位为字节
//              $files[$index]['type'] = $item['type'];        //文件的 MIME 类型，需要浏览器提供该信息的支持，例如"image/gif"
//
//              
//  
//          	echo json_encode($files);
	 }
	 
	 
?>
