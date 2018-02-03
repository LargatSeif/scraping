<?php 



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

function getArticles($content , sel ){
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




 ?>










 ?>