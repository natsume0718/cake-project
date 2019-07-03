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
			if(!empty($email_find_res))
			{
				//ランダムなバイト文字列生成し、16進数に変換するに変換する
				$key = bin2hex(openssl_random_pseudo_bytes(20));
				$this->Reset->create();
				//ランダムなキーと現在から30分後を有効期限として登録
				$data = array('resetkey'=>$key, 'user_id'=>$email_find_res['User']['id'], 'timelimit'=>date('Y-m-d H:i:s', strtotime('+30 minute')));
				if($this->Reset->save($data))
				{
					$email = new CakeEmail('default');
					$email->transport('Mail');
					$email->from('example@gmail.com', '掲示板管理者');
					$email->to($email_find_res['User']['email']);
					$email->subject('パスワード再発行のお知らせ');
					//再発行url
					$url = Router::url('/Resets/reset', true) . '?key=' . $key;
					$body = '再発行URL :' . $url;
					$email->send($body);
				}
			}
			$this->Flash->success(__('再発行のメールを送信しました'));
			$this->redirect($this->request->referer());

		}

	}

	public function reset()
	{
		$key = $this->request->query('key');
		if($key)
		{
			//現在時刻<有効期限のものを取得
			$find_res = $this->Reset->find('first', array(
				'conditions'=>array(
					'Reset.resetkey'=>$key,
					'Reset.timelimit >'=>date('Y-m-d H:i:s')
				),
			));
			if($find_res)
			{
				if($this->request->is('post'))
				{
					/*
					 * 保存するデータ
					 * keyが再度使えないように変更
					 */
					$data = array(
						'Reset'=>array(
							'id'=>$find_res['Reset']['id'],
							'resetkey'=>null,
							'timelimit'=>null
						),
						'User'=>array(
							'id'=>$find_res['Reset']['user_id'],
							'password'=>$this->request->data['User']['password']
						)
					);
					//保存するモデルのレコードを指定して保存
					$save_res = $this->Reset->saveAssociated($data, array('validate'=>'true', 'fieldList'=>array(
						'Reset'=>array('resetkey', 'timelimit'),
						'User'=>array('password')
					)));
					if($save_res)
					{
						$this->Flash->success(__('再設定しました'));
						return $this->redirect(array('controller'=>'Users', 'action'=>'login'));
					}
					else
					{
						$this->Flash->error(__('再設定失敗しました'));
						return $this->redirect($this->request->referer());
					}
				}
			}
			else
			{
				$this->Flash->error(__('失敗しました。有効期限が切れている可能性があります'));
				return $this->redirect(array('controller'=>'Users', 'action'=>'login'));

			}
		}
	}

}
