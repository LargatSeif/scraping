<?php 

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
				$article['title'] = utf8_encode($title->plaintext);
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

function getArticles($content , $container_selector , $title_selector , $time_selector ,$content_sel){
	$articles =[];
	
	foreach($content->find($container_selector) as $key => $title_list)
	{
		 
		foreach($title_list->find($title_selector) as $key => $title)
			{
				
			$article['title'] = $title->plaintext;
			}

			foreach($title_list->find($title_selector) as $key => $a)
			{
				$sub_url = 'https://alwasat.ly'.$a->href;
				$article['url']= $sub_url;
				$content = file_get_html($sub_url); 
				$data='';

				foreach ($content->find($content_sel) as $text) {
				 	$data = $data.$text->plaintext;
				}			
				$article['content'] = $data;

				foreach($content->find($time_selector) as $key => $time)
				{
				 	$article['date'] = $time->datetime ;
				}
			
			}


			
		array_push($articles, $article);
	}
	return $articles;
}

function getPath($folder_name ,$file_name){

	
	return $file_path;
}

function createXML($data ,$folder_name,$file_name){

	$file_path	= 	$folder_name.'/'.$file_name.'.xml';

	$dom     	= 	new DOMDocument('1.0', 'utf-8'); 

	$root      	= 	$dom->createElement('articles'); 
	
	foreach ($data as $key => $article) {

		$art = $dom->createElement('article');
		$art->setAttribute('id', $key);

		
		$title     		= $dom->createElement('title', $article['title']); 
		$art->appendChild($title); 


		$content     	= $dom->createElement('content', $article['content']); 
		$art->appendChild($content); 


		$url     		= $dom->createElement('url', $article['url']); 
		$art->appendChild($url); 


		$date     		= $dom->createElement('date', $article['date']); 
		$art->appendChild($date); 


		$root->appendChild($art);
	}

	$dom->appendChild($root); 

	
   	$dom->save( $file_path );
}


 