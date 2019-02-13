<h1>新規登録</h1>
<div class="users form">
	<?php
	echo $this->Form->create('User');
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->input('email');
	echo $this->Form->end('新規登録');
	?>
</div>
<?php echo $this->Html->link('投稿一覧に戻る', array('controller'=>'posts', 'action'=>'index')); ?>
