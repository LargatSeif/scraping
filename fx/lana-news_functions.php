<?php 

function removeErrors($str){	
	$not_allowed = ['&nbsp;','&rdquo;','&ldquo;','&#8211;',';8221#',';8220#','<br />'];
	$toSave = str_replace( $not_allowed ,' ', $str);
	return $toSave;
}

/*
function getFirstArticle($content ,$content_sel){		  
	$article_content 	= '';
	
	$article_title 		= $content->find('article fulltext > h2.first-post > a ',0);
	$article_time		= $content->find('ul.info-meta > li.ndate',0)->plaintext;
	$article_url		= $article_title->href;
	$article_page 		= file_get_html($article_url); 

	foreach ($article_page->find($content_sel) as $p) { 	
		$article_content= $article_content . $p->plaintext;
	}	 

	$article = [
		'title' 	=> 	$article_title->plaintext ,
		'content' 	=> 	removeErrors($article_content) ,
		'url' 		=> 	$article_url ,
		'date'		=>	$article_time
	];
	return $article;
}
*/

/*
function getSecondaryArticles($content){
	$articles =[];
	
	foreach($content->find('ul.h_list > li') as $key => $title_list)
	{
		foreach($title_list->find('a > div.title') as $key => $title)
			{				
				$article['title'] = $title->plaintext;
			}

			foreach($title_list->find('a') as $key => $a)
			{
				$sub_url = $a->href;
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
*/
function getMyDate($publish_date){
	$d = $publish_date->find('pub_day',0)->plaintext ;	 
	$m = $publish_date->find('pub_month',0)->plaintext ;
	$y = $publish_date->find('pub_year',0)->plaintext ;
	$t = $publish_date->find('pub_time',0)->plaintext ;	 
	return $d.'/'.$m.'/'.$y.' '.$t;
}

function getArticles($content ,$title_selector , $container_selector, $content_selector,$time_selector){
	$articles =[];	
	foreach($content->find($container_selector) as $key => $title_list)
	{
		 
		foreach($title_list->find('a') as $key => $title)
		{			
			$article['title'] = $title->plaintext;			
			$sub_url = "http://www.lana-news.ly".$title->href;
			$article['url']= $sub_url;			
			$content = file_get_html($sub_url);
			$data='';
			foreach ($content->find($content_selector) as $text) 
			{
				$data = $data.$text->plaintext;
			}				
			$article['content'] = removeErrors($data);
			$article['date'] = getMyDate($content->find($time_selector,0)) ;			
			
			array_push($articles, $article);
		}	
			
	} 
	
	return $articles;
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


 