<?php
//设置编码为UTF-8  
header('Content-Type:text/html;charset= UTF-8');   

  $doc = new DOMDocument('1.0', 'UTF-8');
  $doc->load('rss.xml');

  $articles = $doc->getElementsByTagName("item");
  $id=0;
  
  foreach ($articles as $article)
	{
		$id++;
		$title = $article->getElementsByTagName("title")->item(0)->nodeValue;
		$link = $article->getElementsByTagName("link")->item(0)->nodeValue;
		$description = $article->getElementsByTagName("description")->item(0)->nodeValue;
		$pubDate = $article->getElementsByTagName("dc:date")->item(0)->nodeValue;
		$article_array[$id] = array('title'=>$title, 'link'=>$link, 'description'=>$description, 'pubDate'=>$pubDate );
	}
	
  echo urldecode(json_encode($article_array));

//输出结果
//echo "<pre>";
//var_dump($article_array);
//echo "</pre>";