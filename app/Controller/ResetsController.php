<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ResetsController extends AppController
{
	public $helpers = array('Html', 'Form', 'Flash');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('send', 'reset');
	}

	public function send()
	{
		if($this->request->is('post'))
		{
			//ユーザーモデルからメールアドレスで検索
			$this->loadModel('User');
			$email_find_res = $this->User->findByEmail($this->request->data['Reset']['email']);
			debug($email_find_res);
			if(!empty($email_find_res))
			{
				//ランダムなバイト文字列生成し、16新巣に変換するに変換する
				$key = bin2hex(openssl_random_pseudo_bytes(20));
				$email = new CakeEmail('default');
				$email->from(


			}


		}

	}

}
