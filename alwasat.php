<?php 
ini_set('max_execution_time', 600); 
require_once 'lib/simple_html_dom.php' ;
require_once 'fx/alwasat_functions.php';
	//number of pages to scrap
	$nbr_pages 				= 	2;
	//Urls 
	$url 					= 	"https://alwasat.ly/ar/news/libya/";
	$content_url 			=	'https://alwasat.ly';
	//selectors
	$container_sel 			=	"div#maincol > div.section-item";
	$title_sel 				=	'div.title > a';
	$content_sel			=	'div.art-content > p[style=direction: rtl;]';
	$time_sel 				=	'div.art-info > time';
//$content , $container_selector , $title_selector , $time_selector ,$content_sel
$html = new simple_html_dom();
$d  = new DateTime();
$folder_name = "alwasat " . $d->format('Y-m-d H-i-s');
mkdir($folder_name);
for(	$i=0	;	$i < $nbr_pages;	$i++){
	$page_url = $url.'?ls-art0='. $i *13;
	$html->load_file($page_url );	
	$data=[];
	$first_article 		= getFirstArticle($html,$content_url,$content_sel);
	$secondary_articles = getSecondaryArticles($html);
	$articles 			= getArticles($html,$container_sel,$title_sel,$time_sel,$content_url,$content_sel);
	array_push($data,$first_article);
	foreach ($secondary_articles as $key => $article) {
		array_push($data, $article );
	}
	foreach ($articles as $key => $article) {
		 array_push($data, $article );
	}	
	createXML($data ,$folder_name ,'page'.$i);
}

 echo "the end";
 ?>
