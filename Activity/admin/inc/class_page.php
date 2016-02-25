<?php
//echo paging(125, "page");
function paging(
	$pages,
	$pagevar="page",
	$ppv=10, 
	$first ="<a href='{url}' class='page'>首页</a> ",
	$firsts ="<font class='page'>首页</font> ",
	$prev ="<a href='{url}' class='page'>上一页</a>  ",
	$prevs ="<font class='page'>上一页</font> ",
	$num ="<a href='{url}' class='page'>{page}</a>",
	$nums ="<font class='page' id='on'><b>{page}</b></font>",
	//$sep =" <font class='page'>|</font> ",
	$more ="<font class='page'><a href='{url}'>[…]</a></font>",
	$next ="  <a href='{url}' class='page'>下一页</a>",
	$nexts =" <font class='page'>下一页</font>",
	$last =" <a href='{url}' class='page'>尾页</a>",
	$lasts =" <font class='page'>尾页</font>"){
		// get URI parameters   
		$getvars=$_SERVER['PHP_SELF']."?";
		foreach ($_GET as $key => $val){
			if ($key!=$pagevar){
				if (isset($val) && $val!=""){
					$getvars.="$key=$val&";
				}else{
					$getvars.="$key&";
				}
			}
		}
		$page=(is_numeric(@$_GET[$pagevar])) ? @$_GET[$pagevar] : 1;
		$page=($page>$pages) ? $pages : $page;
		$prevpage=($page>1) ? $page-1 : 1;
		$nextpage=($page < $pages) ? $page+1 : $pages;
		$paging="";
	
		if ($pages>1){
			// first
			$paging.=($page>1) ? str_replace("{url}", "$getvars$pagevar=1", $first) : $firsts;
			// prev
			$paging.=($page>1) ? str_replace("{url}", "$getvars$pagevar=$prevpage", $prev) : $prevs;
			// pages  
			$ppvrange=ceil($page/$ppv);
			$start=($ppvrange-1)*$ppv;
			$end=($ppvrange-1)*$ppv+$ppv;
			$end=($end>$pages) ? $pages : $end;
			$paging.=($start>1) ? str_replace("{url}", "$getvars$pagevar=".($start-1), $more).$sep : "";
			for ($i=1; $i<=$pages; $i++){
				if ($i>$start && $i<= $end){
					$paging.=($page==$i) ? str_replace("{page}", $i, $nums).(($i<$end) ? $sep : "") : str_replace(array("{url}", "{page}"), array("$getvars$pagevar=$i", $i), $num).(($i<$end) ? $sep : "");
				}
			}
			$paging.=($end<$pages) ? $sep.str_replace("{url}", "$getvars$pagevar=".($end+1), $more) : "" ;
			// next
			$paging.=($page<$pages) ? str_replace("{url}", "$getvars$pagevar=$nextpage", $next) : $nexts;
			// last
			$paging.=($page<$pages) ? str_replace("{url}", "$getvars$pagevar=$pages", $last) : $lasts;
		}
		return $paging;
	}
?>