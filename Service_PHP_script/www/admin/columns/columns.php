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
		'article_title' => '���������',
		'article_text' => '�����',
		'article_cat'  => '���������',
		'article_release' => '������',
		'article_date_add' => '���� ����������',
	),

	'authors' => array(
		'author_id' => 'ID',
		'author_name' => '���',
		'author_description' => '��������',
	),
	
	'categories' => array(
		'category_id'    => 'ID',
		'category_title' => '�������� ��������� (�������)',

	),

	'dictionary' => array(
		'dic_id' => 'ID',
		'dic_word' => '�����',
		'dic_description' => '��������',
		'dic_release' => '� �������',
	),
	

	'news' => array(
		'news_id' => 'ID',
		'news_title' => '���������',
		'news_text' => '�����',
		'news_date' => '����',
	),
	
	'releases' => array(
		'release_id'     => 'ID',
		'release_number' => '����� �������',
		'release_date'   => '���� �������',
	),

	'users' => array(
		'user_id' => 'ID',
		'user_login' => 'Login',
		'user_password' => '������������� ������',
		'user_realname' => '�������� ���',
		'user_email' => 'e-mail',
		'user_paid_till' => '������� ��',
		
	),

);

?>