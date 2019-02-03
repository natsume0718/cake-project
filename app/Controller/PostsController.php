<?php

class PostsController extends AppController
{
	//使用ヘルパー
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Flash');
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

	public function add()
	{
		//post送信があった場合
		if($this->request->is('post'))
		{
			//モデルの状態リセット
			$this->Post->create();
			//データ挿入
			if($this->Post->save($this->request->data))
			{
				$this->Flash->success(__('投稿に成功しました'));
				return $this->redirect(array('controller'=>'Posts','action'=>'index'));
			}
			$this->Flash->error(__('投稿に失敗しました'));
		}
	}

}

?>
