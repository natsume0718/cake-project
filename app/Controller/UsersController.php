<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
	public $helpers = array('Html', 'Form', 'Flash', 'Session');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout');
		$this->set('authuser', $this->Auth->user());
	}

	//新規登録
	public function add()
	{
		if($this->request->is('post'))
		{
			$user_info = $this->request->data;
			$this->User->create();
			$save_res = $this->User->save($user_info);
			if($save_res)
			{
				$this->Flash->success(__('登録しました'));
				return $this->redirect(array('controller'=>'posts', 'action'=>'index'));
			}
			$this->Flash->error(__('登録に失敗しました'));
		}
	}

	public function view($id = null)
	{
		if($id)
		{
			$find_res = $this->User->findById($id);
			$user_info = $find_res['User'];
			if($user_info)
			{
				//ユーザー情報セット
				$this->set('user_info', $user_info);
			}
			else
			{
				$this->Flash->warning(__('存在しないユーザーです'));
				return $this->redirect(array('controller'=>'posts', 'action'=>'index'));
			}
		}
		else
		{
			throw new NotFoundException;
		}
	}

	public function edit($id = null)
	{
		if($this->request->is('post'))
		{
			//送信されてきたデータをセット
			$request_data = $this->request->data['User'];
			$this->User->set($request_data);
			//imageバリデーションを適用
			$img_valid_res = $this->User->validates(array('fieldList'=>array('image')));
			//バリデーション結果判定
			if($img_valid_res)
			{
				//ファイルの形式取得
				$type = pathinfo($request_data['image']['name'],PATHINFO_EXTENSION);
				//ファイルの内容からハッシュ生成
				$hashed_filename = hash_file('sha256', $request_data['image']['tmp_name']);
				//一時ディレクトリからの移動先のフルパス
				$fullpath = WWW_ROOT . 'img' . DS . 'user' . DS . $hashed_filename . '.' . $type;
				$move_res = move_uploaded_file($request_data['image']['tmp_name'], $fullpath);
				if($move_res)
				{
					debug($fullpath);

				}
			}
		}
	}

	public function login()
	{
		//リクエスト判定
		if($this->request->is('post'))
		{
			//ログイン
			if($this->Auth->login())
			{
				$this->Flash->success(__('ログインしました'));
				$this->redirect($this->Auth->redirect());
			}
			else
			{
				$this->Flash->error(__('ログインに失敗しました'));
			}
		}
	}

	public function logout()
	{
		$this->Flash->success(__('ログアウトしました'));
		$this->redirect($this->Auth->logout());
	}
}
