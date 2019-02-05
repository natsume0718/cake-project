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
			$save_res = $this->Post->save($this->request->data);
			if($save_res)
			{
				$this->Flash->success(__('投稿に成功しました'));
				return $this->redirect(array('controller'=>'Posts','action'=>'index'));
			}
			$this->Flash->error(__('投稿に失敗しました'));
		}
	}

	public function delete($id)
	{
		//getアクセスは弾く
		if($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}

		//投稿削除
		$delete_res = $this->Post->delete($id);
		if($delete_res)
		{
			$this->Flash->success(__('投稿を削除しました'));
		}
		else
		{
			$this->Flash->error(__('投稿の削除失敗'));
		}

		return $this->redirect(array('action'=>'index'));
	}

	public function edit($id = null)
	{
		//投稿確認
		$post = $this->Post->findById($id);
		if(!$post)
		{
			throw new NotFoundException();
		}

		//フォームからのリクエストチェック
		if($this->request->is(array('post', 'put')))
		{
			//idで投稿取得
			$this->Post->id = $id;
			$update_res = $this->Post->save($this->request->data);
			if($update_res)
			{
				$this->Flash->success(__('投稿の交信に成功しました'));
				return $this->redirect(array('action'=>'index'));
			}
		}

		//フォーム内に投稿情報セット
		if(empty($this->request->data))
		{
			$this->request->data = $post;
		}
	}

}

?>
