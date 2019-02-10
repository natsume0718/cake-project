<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout');
	}

	public function add()
	{
		if($this->request->is('post'))
		{
			$user_info = array(
				'username'=>$this->request->data['username'],
				'password'=>$this->request->data['pass'],
				'email'=>$this->request->data['email']
			);
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

	public function login()
	{
		//リクエスト判定
		if($this->request->is('post'))
		{
			//ログイン
			if($this->Auth->login())
			{
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
		$this->redirect($this->Auth->logout());
	}
}
