<?php 
ini_set('max_execution_time', 6000); 
require_once '../lib/simple_html_dom.php' ;
require_once '../fx/libyaakhbart_functions.php';
	//number of pages to scrap
	$nbr_pages 				= 	2;
	//Urls 
	$url 					= 	"https://www.libyaakhbar.com/libya-news";
	//selectors
	$container_sel 			=	"div.vce-loop-wrap";
	$title_sel 				=	'article.vce-post > h2.entry-title > a';
	$time_sel 				=	'div.date > span.updated';
	$content_sel			=	'div.entry-content > p';

//$content , $container_selector , $title_selector , $time_selector ,$content_sel
$html = new simple_html_dom();
$d  = new DateTime();
$folder_name = "../libyaakhbar " . $d->format('Y-m-d H-i-s');
mkdir($folder_name);
//for(	$i=0	;	$i < $nbr_pages;	$i++){
	$page_url = $url ;//.'?ls-art0='. $i *13;
	$html->load_file($page_url);
	$data=[];
	$first_articles 		= getFirstArticles($html,$content_sel);
	$articles 			= getArticles($html, $container_sel);
	foreach ($first_articles as $key => $article) {
		array_push($data, $article );
	}
	foreach ($articles as $key => $article) {
		 array_push($data, $article );
	}
	$i=1;
	createXML($data ,$folder_name ,'page'.$i);
//}
 echo "the end";
 echo "<a href='../index.php'>Back to menu </a>";
 ?>