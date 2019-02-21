<?php
$form = array(
	'articles' => array(
		'article_id' => 'int',
		'article_title' => 'text',
		'article_text' => 'textarea_reach',
		'article_cat'  => 'dropdown',
		'article_release' => 'dropdown',
		'article_date_add' => 'datetime',
	),

	'authors' => array(
		'author_id' => 'int',
		'author_name' => 'text',
		'author_description' => 'text',
	),
	
	'categories' => array(
		'category_id'    => 'int',
		'category_title' => 'text',

	),

	'dictionary' => array(
		'dic_id' => 'int',
		'dic_word' => 'text',
		'dic_description' => 'text',
		'dic_release' => 'dropdown',
	),
	

	'news' => array(
		'news_id' => 'int',
		'news_title' => 'text',
		'news_text' => 'textarea_reach',
		'news_date' => 'datetime',
	),
	
	'releases' => array(
		'release_id'     => 'int',
		'release_number' => 'int',
		'release_date'   => 'date',
	),

	'users' => array(
		'user_id' => 'int',
		'user_login' => 'text',
		'user_password' => 'text',
		'user_realname' => 'text',
		'user_email' => 'text',
		'user_paid_till' => 'date',
	),
	
);


$form_defaults = array(
	'authors' => array(),
	'categories' => array(),
	'dictionary' => array(),

	'articles' => array(
		'article_date_add' => date('Y-m-d\TH:i'),
	),


	'news' => array(
		'news_date' => date('Y-m-d\TH:i'),
	),
	
	'releases' => array(
		'release_date'   => date('Y-m-d'),
	),

	'users' => array(
		'user_paid_till' => date('Y-m-d'),
	),
	
);


$form_elements = array(
	'articles' => array(
	
		// Категория статьи
		'article_cat' => array(
			'source_table' => 'categories',
			'key'          => 'category_id',
			'value'        => 'category_title'
		),
		
		// Выпуск, в котором опубликована новость
		'article_release' => array(
			'source_table' => 'releases',
			'key'          => 'release_id',
			'value'        => 'release_number'
		),

	),
	'dictionary' => array(
		'dic_release' => array(
			'source_table' => 'releases',
			'key'          => 'release_id',
			'value'        => 'release_number'
		),
	),
);
?>
