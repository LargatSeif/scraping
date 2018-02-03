<?php 
ini_set('max_execution_time', 600); 
include('lib/simple_html_dom.php');

function getFirstData($content){		  
	$article_content = '';
	$article_title 	= $content->find('h3.article-title',0)->plaintext;
	$article_time	= $content->find('div.meta-b > span',0)->plaintext;
	$article_id		= $content->find('h3.article-title > a',0)->getAttribute('href');
	$article_url	= 'https://www.echoroukonline.com/ara/'.$article_id;
	$article_page = file_get_html($article_url); 
	foreach ($article_page->find('section.article-contents > p') as $p) { 	
		$article_content= $article_content . $p->plaintext;
	}	 
	$article = [
		'title' => $article_title ,
		'content' => $article_content ,
		'url' => $article_url ,
		'date'=>$article_time
	];
	return $article;
}

function getArticles($content){
	$articles =[];
	
	foreach($content->find('ul.__archives > li') as $key => $title_list)
	{
		 
		foreach($title_list->find('a') as $key => $title)
			{
				
			$article['title'] = $title->innertext;
			}

			foreach($title_list->find('a') as $key => $a)
			{
				$sub_url = 'https://www.echoroukonline.com/ara/'.$a->href;
			$article['url']= $sub_url;
				$content = file_get_html($sub_url); 
				$data='';
				foreach ($content->find('section.article-contents > p') as $text) {
				 	$data = $data.$text->plaintext;
				}			
			$article['content'] = $data;
			}


			foreach($title_list->find('time') as $key => $time)
			{
				 $article['date'] = $time->plaintext;
			}
		array_push($articles, $article);
	}
	return $articles;
}

function toXML($data){
	$xml = new SimpleXMLElement('<xml/>');	 
	$article = $xml->addChild('article');
	$article->addChild('title',$data['title']);
	$article->addChild('content', html_entity_decode($data['content']));	    
	$article->addChild('date', html_entity_decode($data['date']));
	$article->addChild('url', html_entity_decode($data['url'])); 	
	return $xml;
}
	
function xmlToFile($xml ,$file_name){
	Header('Content-type:text/xml');	
	$dom = new DOMDocument();
	$dom->preserveWhiteSpace = FALSE;
	$dom->loadXML($xml->asXML());	
	$d  = new DateTime();
	$folder_name = "chourouk in " .$d->format('Y-m-d H-i');
	mkdir($folder_name);
	$dom->save("$folder_name/$file_name.xml");
}

$nbr_pages=1;

for ($i=1; $i < $nbr_pages + 1; $i++) { 

	$url = "https://www.echoroukonline.com/ara/watani/index.$i.html";	

	$content = file_get_html($url);

	$data =[];
	array_push($data, getFirstData($content));
	foreach (getArticles($content) as $key => $article) {
		 array_push($data, $article );
	}
		
	
	//	var_dump($data[10]);die;
	foreach ($data as $key => $article) {

		$xml_object = toXML($article)  ;

		xmlToFile($xml_object, 'article'.$key);		 
	}
	
}

echo "the end !";
 


