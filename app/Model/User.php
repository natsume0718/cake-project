<?php

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
