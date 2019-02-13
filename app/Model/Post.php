<?php
class Post extends AppModel
{
	//アソシエーションでUser情報と紐づける
	public $belongsTo = array(
		'User'=>array(
			'className'=>'User',
			'foreignKey'=>'user_id',
			'fields'=>array('User.id', 'User.username')
		)
	);
	public $validate = array(
		'title'=>array(
			'rule'=>'notBlank'
		),
		'body'=>array(
			'rule'=>'notBlank'
		)
	);
}
