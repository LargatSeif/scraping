<?php
function removeErrors($str){	
	$not_allowed = ['&nbsp;','&rdquo;','&ldquo;'];
	$toSave = str_replace( $not_allowed ,' ', $str);
	return $toSave;
}

function getFirstArticles($content ,$content_sel){
	$article_content 	= '';
	$articles = [];
	foreach($content->find('header.entry-header') as $article )
	{
		$article_title 		= $article->find('h2.entry-title > a',0)->plaintext;	
		$article_time		= $content->find('div.date > span.updated',0)->plaintext;
		$article_id			= $content->find('h2.entry-title > a ',0)->href;
		$article_url		= $article_id;	
		$article_page 		= file_get_html($article_url);		
		foreach ($article_page->find($content_sel) as $p) {					
			$article_content= $article_content . $p->plaintext;
		}
		$article = [
			'title' 	=> 	$article_title ,
			'content' 	=> 	removeErrors($article_content) ,
			'url' 		=> 	$article_url ,
			'date'		=>	$article_time
		];
		array_push($articles ,$article);
	}
	return $articles;
}

function getArticles($content , $container_selector ){
	$title_selector				=	'article > header > h2.entry-title > a';
	$content_sel				=	'div.entry-content > p';
	$time_selector				=	'div.date > span.updated ';
	$articles =[];	
	foreach($content->find($container_selector) as $key => $title_list)
	{
		foreach($title_list->find($title_selector) as $key => $title)
		{
			$article['title'] = $title->plaintext;
			$sub_url = $title->href;			
			$article['url']= $sub_url;
			$content = file_get_html($sub_url);
			$data='';			
			foreach ($content->find($content_sel) as $text) 
			{
				$data = $data.$text->plaintext;
			}	
			$article['content'] = removeErrors($data);
			$article['date'] = $content->find($time_selector,0)->plaintext ;
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
	
	
	
}*/

/*
function getPath($folder_name ,$file_name)
{
	return $file_path;
}*/