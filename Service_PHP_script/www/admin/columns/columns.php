<?php

$_keys = array(
	'articles'   => 'article_id',
	'authors'    => 'author_id',
	'categories' => 'category_id',
	'dictionary' => 'dic_id',
	'news'       => 'news_id',
	'releases'   => 'release_id',
	'users'      => 'user_id',
);

$_columns = array(
	'articles' => array(
		'article_id' => 'ID',
		'article_title' => 'Заголовок',
		'article_text' => 'Текст',
		'article_cat'  => 'Категория',
		'article_release' => 'Выпуск',
		'article_date_add' => 'Дата добавления',
	),

	'authors' => array(
		'author_id' => 'ID',
		'author_name' => 'Имя',
		'author_description' => 'Описание',
	),
	
	'categories' => array(
		'category_id'    => 'ID',
		'category_title' => 'Название категории (рубрики)',

	),

	'dictionary' => array(
		'dic_id' => 'ID',
		'dic_word' => 'Слово',
		'dic_description' => 'Описание',
		'dic_release' => 'В выпуске',
	),
	

	'news' => array(
		'news_id' => 'ID',
		'news_title' => 'Заголовок',
		'news_text' => 'Текст',
		'news_date' => 'Дата',
	),
	
	'releases' => array(
		'release_id'     => 'ID',
		'release_number' => 'Номер выпуска',
		'release_date'   => 'Дата выпуска',
	),

	'users' => array(
		'user_id' => 'ID',
		'user_login' => 'Login',
		'user_password' => 'Зашифрованный пароль',
		'user_realname' => 'Реальное имя',
		'user_email' => 'e-mail',
		'user_paid_till' => 'Оплачен до',
		
	),

);

?>