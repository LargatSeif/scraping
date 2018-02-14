<?php 
ini_set('max_execution_time', 6000);
require_once 'lib/simple_html_dom.php' ;
require_once 'fx/eanlibya_functions.php';
//number of pages to scrap
$nbr_pages 				= 	2;
//Urls 
$url 					= 	"http://www.eanlibya.com/local-news";
//selectors
$container_sel 			=	"div.grid-container";
$title_sel 				=	'div.grid-archive > h2 > a';
$time_sel				=	'ul.info-meta > li.ndate ';
$content_sel			=	'div.entry > p';
//$content , $container_selector , $title_selector , $time_selector ,$content_sel
$html = new simple_html_dom();
$d  = new DateTime();
$folder_name = "eanlibya " . $d->format('Y-m-d H-i-s');
mkdir($folder_name);
for (	$i=1	;	$i <= $nbr_pages;	$i++){
	$page_url = $url."/page/". $i ;	
	$html->load_file($page_url);	
	$data=[];	
	if($i==1){
		$first_article 	= getFirstArticle($html,$content_sel);
		array_push($data,$first_article);
	}
	$articles 		= getArticles($html, $title_sel ,$container_sel , $content_sel, $time_sel);
	foreach ($articles as $key => $article) {
		array_push($data, $article );
	}
	createXML($data ,$folder_name ,'page'.$i);
}
echo "the end";
echo "<a href='index.php' >Back to menu </a>";
?>
