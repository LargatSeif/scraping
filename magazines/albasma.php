<?php 
ini_set('max_execution_time', 6000); 
require_once '../lib/simple_html_dom.php' ;
require_once '../fx/albasma_functions.php';
	//number of pages to scrap
	$nbr_pages 				= 	2;
	//Urls 
	$url 					= 	"http://albasma.ly/?cat=64";

	//selectors
	$container_sel 			=	"div.post-listing";
	$title_sel 				=	'article.item-list > h2.post-box-title > a';
	$time_sel				=	'div.post-inner > span.updated ';
	$content_sel1			=	'article.post-listing > div.post-inner > div.entry > article.art-item > div.art-content > p';
	$content_sel2			=	'article.post-listing > div.post-inner > div.entry > div.line > p';
	$content_sel3			=	'article.post-listing > div.post-inner > div.entry > p';

//$content , $container_selector , $title_selector , $time_selector ,$content_sel
$html = new simple_html_dom();
$d  = new DateTime();
$folder_name = "../albasma " . $d->format('Y-m-d H-i-s');
mkdir($folder_name);
for(	$i=1	;	$i <= $nbr_pages;	$i++){
	$page_url = $url.'&paged='. $i ;
	$html->load_file($page_url);
	$data=[];
	$articles = getArticles($html, $title_sel ,$container_sel , $content_sel1, $content_sel2,$content_sel3, $time_sel);
	
	foreach ($articles as $key => $article) {
		 array_push($data, $article );
	}
	createXML($data ,$folder_name ,'page'.$i);
}
 echo "the end";
 echo "<a href='../index.php'>Back to menu </a>";
 ?>