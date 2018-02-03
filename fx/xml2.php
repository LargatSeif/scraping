<?php 
 
 
$xml = new SimpleXMLElement('<xml/>');

for ($i = 1; $i <= 8; ++$i) {
    $track = $xml->addChild('track');
    $track->addChild('path', "song$i.mp3");
    $track->addChild('title', "Track $i - Track Title");
}

Header('Content-type: text/xml');




print($xml->asXML());

$dom = new DOMDocument;
$dom->preserveWhiteSpace = FALSE;
$dom->loadXML($xml->asXML);

$dom->save('test.xml');
/*
		$url = "https://www.echoroukonline.com/ara/watani/index.1.html";

		$html = file_get_html($url); 

	
		$firstTitle = $html->find('h3.article-title',0)->plaintext . '<br>';
		$firstTime = $html->find('div.meta-b > span',0)->plaintext;

		$firstContent = $html->find('h3.article-title > a',0)->getAttribute('href');
		$sub_url = 'https://www.echoroukonline.com/ara/'.$firstContent;
		$content = file_get_html($sub_url); 



		$articleContent = '';

		foreach ($content->find('section.article-contents > p') as $p) { 	$articleContent+= $p->plaintext;	}		
		

		$obj = new SimpleXMLElement('<xml/>');

	 	$article = $obj->addChild('article');
	    $article->addChild('title', $firstTitle);
	    $article->addChild('time', $firstTime);
	    $article->addChild('content', $articleContent);
	    $article->addChild('url', $sub_url);

		Header('Content-type: text/xml');
		print($xml->asXML());
*/