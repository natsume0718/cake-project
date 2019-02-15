<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
	public $helpers = array('Html', 'Form', 'Flash', 'Session');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout');
		$this->set('user', $this->Auth->user());
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

	public function edit()
	{

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
