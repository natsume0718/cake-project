<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel
{
	public $validate = array(
		'username'=>array(
			'require'=>array(
				'rule'=>'notBlank',
				'required'=>true,
				'message'=>'入力してください'
			),
			'uni'=>array(
				'rule'=>'isUnique',
				'message'=>'既に同一メールアドレスが登録されています'
			)
		),
		'password'=>array(
			'require'=>array(
				'rule'=>'notBlank',
				'required'=>true,
				'message'=>'入力してください'
			),
			'strType'=>array(
				'rule'=>'alphaNumeric',
				'message'=>'英数字で入力してください'
			)
		),
		'email'=>array(
			'require'=>array(
				'rule'=>'notBlank',
				'required'=>true,
				'message'=>'入力してください'
			),
			'email'=>array(
				'rule'=>array('email',true),
				'message'=>'有効なメールアドレスの形式で入力してください'
			),
			'uni'=>array(
				'rule'=>'isUnique',
				'message'=>'既に同一メールアドレスが登録されています'
			)
		),
		'image'=>array(
			//拡張子チェック
			'extension'=>array(
				'rule'=>array( 'extension', array(
					'jpg', 'jpeg', 'png')
				),
				'message'=>'無効なファイルの拡張子です'
			),
			//MIMEでチェック
			'mimetype'=>array(
				'rule'=>array( 'mimeType', array(
					'image/jpeg', 'image/png', 'image/gif')
				),
				'message'=>'無効なファイ拡張子です'
			),
			'size'=>array(
				'rule'=>array('fileSize', '<=', '1MB'),
				'message'=>'ファイルサイズは1MB以下にしてください'
			)
		),
		'message'=>array(
			'length'=>array(
				'rule'=>array('lengthBetween', 0, 255),
				'message'=>'255文字以下で入力してください'
			)
		)
	);

	//保存前にパスワードハッシュする
	public function beforeSave($options =array())
	{
		if(isset($this->data[$this->alias]['password']))
		{
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		return true;
	}
}

