<?php 
ini_set('max_execution_time', 6000);
require_once '../lib/simple_html_dom.php' ;
require_once '../fx/lana-news_functions.php';
//number of pages to scrap
$nbr_pages 				= 	10;
//Urls 
$url 					= 	"git";
//selectors
$container_sel 			=	"ul.news_titles";

$title_sel 				=	'li > a';

$time_sel				=	'publish_date';

$content_sel			=	'p.article_text';

//$content , $container_selector , $title_selector , $time_selector ,$content_sel
$html = new simple_html_dom();
$d  = new DateTime();
$folder_name = "../lana-news " . $d->format('Y-m-d H-i-s');
mkdir($folder_name);

for (	$i=1	;	$i <= $nbr_pages;	$i++){
	
	$page_url = $url."/". $i ;	
	$html->load_file($page_url);	
	 
	$data=[];

	$articles 		= getArticles($html, $title_sel ,$container_sel , $content_sel, $time_sel);

	foreach ($articles as $key => $article) {
		array_push($data, $article );
	}
	createXML($data ,$folder_name ,'page'.$i);

}

echo "the end";
echo "<a href='../index.php' >Back to menu </a>";
?>
