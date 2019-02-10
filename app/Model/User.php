<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel
{
	public $vaidate = array(
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
				'mesasge'=>'有効なメールアドレスの形式で入力してください'
			),
			'uni'=>array(
				'rule'=>'isUnique',
				'message'=>'同一メールアドレスが存在しています'
			)
		)
	);

	public function beforeSave($options =array())
	{
		if(isset($this->data[$this->alias]['password']))
		{
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		return true;
}

