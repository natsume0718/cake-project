<?php

class PostsController extends AppController
{
	//使用ヘルパー
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Flash');

	public function index()
	{
		$this->set('title_for_layout', '投稿一覧');
		//投稿を削除済み以外全件取得して変数にセット
		$param = array('conditions'=>array('Post.is_deleted'=>FALSE), 'order'=>array('Post.id'));
		$this->set('posts', $this->Post->find('all', $param));
		//ログイン情報取得して渡す
		$this->set('user', $this->Auth->user());
	}

	public function add()
	{
		$this->set('title_for_layout', '新規投稿');
		//post送信があった場合
		if($this->request->is('post'))
		{
			//モデルの状態リセット
			$this->Post->create();
			//投稿者IDを追加
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
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
			$this->Flash->error(__('不正なアクセス'));
			return $this->redirect(array('action'=>'index'));
		}
		if($id)
		{
			//投稿確認
			$post = $this->Post->findById($id);
			if($post['Post']['user_id'] !== $this->Auth->user('id'))
			{
				$this->Flash->error(__('不正なアクセスです'));
			}
			else
			{
				//論理削除なのでid指定
				$this->Post->id = $id;
				//投稿論理削除
				if($this->Post->saveField('is_deleted', TRUE))
				{

					$this->Flash->success(__('投稿を削除しました'));
				}
				else
				{
					$this->Flash->error(__('投稿の削除失敗'));
				}
			}
		}
		return $this->redirect(array('action'=>'index'));
	}

	public function edit($id = null)
	{
		if($id)
		{
			//投稿確認
			$post = $this->Post->findById($id);
			//投稿がない場合、投稿者ではない場合エラー
			if(!$post)
			{
				throw new NotFoundException();
			}
			else if($post['Post']['user_id'] !== $this->Auth->user('id'))
			{
				$this->Flash->error(__('不正なアクセスです'));
				return $this->redirect(array('action'=>'index'));
			}

			$this->set('title_for_layout', '編集：' . $post['Post']['title']);

			//フォームからのリクエストチェック
			if($this->request->is(array('post', 'put')))
			{
				//編集なのでIDは変えない
				$this->Post->id = $id;
				$update_res = $this->Post->save($this->request->data);
				if($update_res)
				{
					$this->Flash->success(__('投稿の更新に成功しました'));
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

}

?>
