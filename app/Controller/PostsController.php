<?php

class PostsController extends AppController
{
	//使用ヘルパー
	public $helpers = array('Html', 'Form');

	public function index()
	{
		//投稿を全件取得して変数にセット
		$this->set('posts', $this->Post->find('all'));
	}
