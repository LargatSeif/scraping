<?php 

ini_set('max_execution_time', 600); 
require_once 'lib/simple_html_dom.php' ;
require_once 'functions.php';

if(isset($_POST)){
	extract($_POST);
	$nbr_pages 				= 	$nbr;

	$url 					= 	$url;
	//selectors
	$container_sel 			=	$container;//"div#maincol > div.section-item";

	$title_sel 				=	$title;//'div.title > a';

	$content_sel			=	$content;//'div.art-content > p[style=direction: rtl;]';

	$time_sel 				=	$time ;//'div.art-info > time';
}
else{
	$nbr_pages 				= 	2;

	$url 					= 	"https://alwasat.ly/ar/news/libya/";
	//selectors
	$container_sel 			=	"div#maincol > div.section-item";

	$title_sel 				=	'div.title > a';

	$content_sel			=	'div.art-content > p[style=direction: rtl;]';

	$time_sel 				=	'div.art-info > time';
}



//$content , $container_selector , $title_selector , $time_selector ,$content_sel

$html = new simple_html_dom();

$d  = new DateTime();
$folder_name = "alwasat " . $d->format('Y-m-d H-i-s');
mkdir($folder_name);

for(	$i=0	;	$i < $nbr_pages;	$i++){

	$page_url = $url .'?ls-art0='. $i *13;
	$html->load_file($url);

	$data = getArticles($html, $container_sel,$title_sel,$time_sel, $content_sel);
	
	createXML($data ,$folder_name ,'page'.$i);
}

 
 echo "the end";

 


















 ?>