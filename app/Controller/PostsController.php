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

	public function view($id = null)
	{
		if(!$id)
		{
			throw new NotFoundException(__('投稿が見つかりません'));
		}

		$post = $this->Post->findById($id);
		if(!$id)
		{
			throw new NotFoundException(__('投稿が見つかりません'));
		}
		$this->set('post', $post);
	}
}
