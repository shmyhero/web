
<?php  
 
		//设置编码为UTF-8  
		header('Content-Type:text/html;charset= UTF-8');       

		$data = json_decode(file_get_contents("rss_ticket.json"));

		if ($data->expire_time < time()) {
			//RSS源地址列表数组  
			$rssfeed = array("http://xueqiu.com/hots/topic/rss");  
  
		    $buff = "";  
		    $rss_str="";  
		    //打开rss地址，并读取，读取失败则中止  
		    $fp = fopen($rssfeed[0],"r") or die("can not open $rssfeed");   
		    while ( !feof($fp) ) {  
		        $buff .= fgets($fp,4096);  
		    }  
		    //关闭文件打开  
		    fclose($fp);
		    $fp = fopen("rss1.xml", "w");	 
			fwrite($fp, $buff);
			fclose($fp);
		    
		    $data->expire_time = time() + 7200;
			
			$fp1 = fopen("rss_ticket.json", "w");
				 
			fwrite($fp1, json_encode($data));
			fclose($fp1);
		}
		
//			$doc = new DOMDocument;
//			$doc->load();
//			$articles = $doc->getElementsByTagName("item");
//			$id=0;
//			foreach ($articles as $article)
//			{
//				//$id++;
//				$$article_array = array();
//				$title = $article->getElementsByTagName("title")->item(0)->nodeValue;
//				$link = $article->getElementsByTagName("link")->item(0)->nodeValue;
//				$description = $article->getElementsByTagName("description")->item(0)->nodeValue;
//				//$pubDate = $article->getElementsByTagName("dc:date")->item(0)->nodeValue;
//				 $array = array('title'=>$title, 'link'=>$link,'description'=>$description);
//				 
//				//,'pubDate'=>$pubDate
//			}
//			echo urldecode(json_encode($article_array));
			


$xml_array=simplexml_load_file('rss1.xml'); 
echo urldecode(json_encode($xml_array));

			  	
?> 
