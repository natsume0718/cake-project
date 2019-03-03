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
				$this->Flash->error(__('存在しないユーザーです'));
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
		//アクセスユーザーチェック
		if($this->Auth->user('id') !== $id)
		{
			$this->Flash->error(__('不正なアクセスです'));
			return $this->redirect(array('controller'=>'posts', 'action'=>'index'));
		}

		//フォームからの送信を処理
		if($this->request->is('post'))
		{
			$do_update = true;
			//画像とメッセージの更新結果
			$message_res = null;
			$image_res = null;
			//データの更新のためセット
			$this->User->id = $id;
			//送信されてきたデータをセット
			$request_data = $this->request->data['User'];
			$this->User->set($request_data);

			//画像有無
			if(!empty($request_data['image']['name']))
			{
				//imageバリデーションを適用
				$img_valid_res = $this->User->validates(array('fieldList'=>array('image')));
				//messageを更新して良いか
				$do_update = $img_valid_res;
				//バリデーション結果判定
				if($img_valid_res)
				{
					//ファイルの形式取得
					$type = pathinfo($request_data['image']['name'],PATHINFO_EXTENSION);
					//ファイルの内容からハッシュ生成
					$hashed_filename = hash_file('sha256', $request_data['image']['tmp_name']);
					//一時ディレクトリからの移動先のフルパス
					$fullpath = WWW_ROOT . 'img' . DS . 'user' . DS . $hashed_filename . '.' . $type;
					//相対パス付き画像の名前
					$img_name = 'user' . DS . $hashed_filename . '.' . $type;
					//移動
					$move_res = move_uploaded_file($request_data['image']['tmp_name'], $fullpath);
					if($move_res)
					{
						//更新
						$image_res = $this->User->saveField('image', $img_name, false);
					}
				}
			}
			//画像にバリデーションエラーがない時更新
			if($do_update)
			{
				//コメント更新
				$message_res = $this->User->saveField('message', $request_data['message'], true);
				//どちらかが編集できた
				if($message_res || $image_res)
				{
					$this->Flash->success(__('編集しました'));
					return $this->redirect(['action'=>'edit',$id]);
				}
				else
				{
					$this->Flash->error(__('更新失敗しました'));
				}
			}
			else
			{
				$this->Flash->error(__('更新失敗しました'));
			}
		}
		else
		{
			//ユーザー情報を取得
			$find_res = $this->User->findById($id);
			$user_info = $find_res['User'];
			//ユーザー情報をビューにセット
			if(isset($user_info))
			{
				//ユーザー情報セット
				$this->set('user_info', $user_info);
			}
		}

		//プレースホルダーにセット
		$this->request->data['User']['message'] = $user_info['message'];
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
