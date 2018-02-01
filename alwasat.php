<?php 
ini_set('max_execution_time', 600); 
include('lib/simple_html_dom.php');

function getFirstData($content){		  
	$article_content 	= '';
	$article_title 		= $content->find('div.mainInBlock > a > div.title',0)->plaintext;
	$article_time		= $content->find('div.mainInBlock > time',0)->datetime;
	$article_id			= $content->find('div.mainInBlock > a ',0)->href;
	$article_url		= 'https://alwasat.ly'.$article_id;
	$article_page 		= file_get_html($article_url); 

	foreach ($article_page->find('div.art-content > p[style=direction: rtl;]') as $p) { 	
		$article_content= $article_content . $p->plaintext;
	}	 

	$article = [
		'title' 	=> 	$article_title ,
		'content' 	=> 	$article_content ,
		'url' 		=> 	$article_url ,
		'date'		=>	$article_time
	];
	return $article;
}

function getSecondaryArticles($content){
	$articles =[];
	
	foreach($content->find('ul.h_list > li') as $key => $title_list)
	{
		foreach($title_list->find('a > div.title') as $key => $title)
			{				
				$article['title'] = utf8_decode($title->plaintext);
			}

			foreach($title_list->find('a') as $key => $a)
			{
				$sub_url = 'https://alwasat.ly'.$a->href;
				$article['url']= $sub_url;

				$content = file_get_html($sub_url); 
				$data='';
				foreach ($content->find("div.art-content > p[style=direction: rtl;]") as $text) {
				 	$data = $data.$text->plaintext;
				}			
				$article['content'] = $data;

				foreach($content->find('div.art-info > time') as $key => $time)
				{
				 	$article['date'] = $time->datetime ;
				}
			
			}


			
		array_push($articles, $article);
	}
	return $articles;
}

function getArticles($content){
	$articles =[];
	
	foreach($content->find('div#maincol > div.section-item') as $key => $title_list)
	{
		 
		foreach($title_list->find('div.title > a') as $key => $title)
			{
				
			$article['title'] = $title->plaintext;
			}

			foreach($title_list->find('div.title > a') as $key => $a)
			{
				$sub_url = 'https://alwasat.ly'.$a->href;
				$article['url']= $sub_url;
				$content = file_get_html($sub_url); 
				$data='';

				foreach ($content->find("div.art-content > p[style=direction: rtl;]") as $text) {
				 	$data = $data.$text->plaintext;
				}			
				$article['content'] = $data;

				foreach($content->find('div.art-info > time') as $key => $time)
				{
				 	$article['date'] = $time->datetime ;
				}
			
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
	$article->addChild('date', $data['date']);
	$article->addChild('url', html_entity_decode($data['url'])); 	
	return $xml;
}
	
function xmlToFile($xml ,$file_name){
	Header('Content-type:text/xml');	
	$dom = new DOMDocument('1.0','ISO-8859-1');
	$dom->preserveWhiteSpace = FALSE;
	$dom->loadXML($xml->asXML());	
	$d  = new DateTime();
	$folder_name = "alwasat in " . $d->format('Y-m-d H-i');
	mkdir($folder_name);
	$dom->save("$folder_name/$file_name.xml");
}

$nbr_pages=3;

for ($i=0; $i < $nbr_pages; $i++) { 
	 
	$url = "https://alwasat.ly/ar/news/libya/?ls-art0=".$i*13;
	 
	 

	$content = file_get_html($url);
	 
	$data =[];
	 
	array_push($data, getFirstData($content));  

	foreach (getSecondaryArticles($content) as $key => $article) {
		 array_push($data, $article );
	}
	
	foreach (getArticles($content) as $key => $article) {
		 array_push($data, $article );
	}
		
	//var_dump($data );die;
 	
 	 
	foreach ($data as $key => $article) {

		$xml_object = toXML($article)  ;

		xmlToFile($xml_object, 'article'.$key);		 
	} 
	
}

echo "the end !";
 


