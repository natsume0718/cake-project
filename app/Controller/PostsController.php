<?php

class PostsController extends AppController
{
	//使用ヘルパー
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Flash');

	public function index()
	{
		$this->set('title_for_layout', '投稿一覧');
		//投稿を全件取得して変数にセット
		$this->set('posts', $this->Post->find('all'));
		//ログイン情報取得して渡す
		$user['id'] = $this->Auth->user('id');
		$this->set('user', $user);
	}

	public function view($id = null)
	{
		if(!$id)
		{
			throw new NotFoundException(__('投稿が見つかりません'));
		}

		$post = $this->Post->findById($id);
		if(!$post)
		{
			throw new NotFoundException(__('投稿が見つかりません'));
		}
		$this->set('title_for_layout', $post['Post']['title']);
		$this->set('post', $post);
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
			throw new MethodNotAllowedException();
		}
		if($id)
		{
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

}

?>
