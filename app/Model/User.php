<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel
{
	public $validate = array(
		'username'=>array(
			'require'=>array(
				'rule'=>'notBlank',
				'required'=>true,
				'message'=>'入力してください'
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

