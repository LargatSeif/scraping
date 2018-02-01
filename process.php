<?php

ini_set('max_execution_time', 600); 
// example of how to use basic selector to retrieve HTML contents
include('lib/simple_html_dom.php');
 
//echo "<table border='1'><thead><th>id</th><th>title</th><th>content</th><th>time</th></thead><tbody>";

  $nbrPages = 1;
$obj = new SimpleXMLElement('<xml/>');

for ($i=1; $i <$nbrPages+1 ; $i++) { 
	//$url = "https://www.echoroukonline.com/ara/francais/index.".$i.".html";
	$url = "https://www.echoroukonline.com/ara/watani/index.1.html";

	$html = file_get_html($url); 

	
		$firstTitle = $html->find('h3.article-title',0)->plaintext . '<br>';
		$firstTime = $html->find('div.meta-b > span',0)->plaintext;

		$firstContent = $html->find('h3.article-title > a',0)->getAttribute('href');
		$sub_url = 'https://www.echoroukonline.com/ara/'.$firstContent;
		$content = file_get_html($sub_url); 




 		$data='';
		$data = $data. $firstTitle.'<br>';
		$articleContent = '';
		foreach ($content->find('section.article-contents > p') as $p) { 	$articleContent+= $p->plaintext;	}		
		//$data = $data. '<br>';	
		//$data = $data. $firstTime;
		//$data = $data. '<hr>';	


 	$article = $obj->addChild('article');
    $article->addChild('title', "$firstTitle");
    $article->addChild('time', "$firstTime");
    $article->addChild('content', "$articleContent");
    $article->addChild('url', "$sub_url");

	Header('Content-type: text/xml');
	print($xml->asXML());
	die;







	
	foreach($html->find('ul.__archives > li') as $key => $li)
	{
		foreach($li->find('a') as $key => $a)
			{
				$data = $data. $a->plaintext.'<br>';
			}

			foreach($li->find('a') as $key => $a)
			{
				$sub_url = 'https://www.echoroukonline.com/ara/'.$a->href;
				$content = file_get_html($sub_url); 

				foreach ($content->find('section.article-contents > p') as $p) {
				 	$data = $data. $p->plaintext;
				}			

				$data = $data. '<br>';
			}


			foreach($li->find('time') as $key => $time)
			{
				$data = $data. $time->plaintext;
			}
		if($key < 11){$data = $data. '<hr>';}
	}

	$content = $data;
	echo $content;/*
	//$tosavetxt = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);
	$tosavetxt = html_entity_decode($content);
	$fp = fopen($_SERVER['DOCUMENT_ROOT']."/scraping/test2/page1.txt","wb");
	fwrite($fp,$tosavetxt);
	fclose($fp);*/
}



 
?>
 

 