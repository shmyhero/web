<?php
//echo paging(125, "page");
function paging(
	$pages,
	$pagevar="page",
	$page_name,
	$ppv=8,
	
	$first ="<a href='{url}' class='p-l-all'></a>",
	$firsts ="<a class='p-l-all'></a>",
	$prev ="<a href='{url}' class='p-l-one'></a>",
	$prevs ="<a class='p-l-one'></a>",
	$num ="<a href='{url}'>{page}</a>",
	$nums ="<a class='current'>{page}</a>",
	//$sep =" <font class='page'>|</font> ",
	$more ="<a href='{url}'>[…]</a>",
	$next ="<a href='{url}' class='p-r-one'></a>",
	$nexts ="<a class='p-r-one'></a>",
	$last ="<a href='{url}' class='p-r-all'></a>",
	$lasts ="<a class='p-r-all'></a>"){

/*
<a href="#" class="p-l-all"></a>
<a href="#" class="p-l-one"></a>
<a href="#" class="current">1</a>
<a href="#">2</a><a href="#">3</a>
<a href="#">4</a><a href="#">5</a>
<a href="#">6</a>
<a href="#" class="p-r-one"></a>
<a href="#" class="p-r-all"></a>
*/

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

		$page=(is_numeric($_GET[$pagevar])) ? $_GET[$pagevar] : 1;
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