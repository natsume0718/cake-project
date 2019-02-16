<h1>ユーザー情報</h1>
<?php
var_dump($user_info);
?>
<p><?php echo $this->Html->link('トップに戻る', array('controller'=>'posts', 'action'=>'index')); ?></p>
<?php var_dump($authuser); ?>

<?php
if(isset($user_info)): ?>
<p>画像</p>
<p><?php echo $user_info['username']; ?></p>
<p>一言:
	<?php
	if(isset($user_info['comment'])):
		echo $user_info['comment'];
	else: ?>
設定されていません
	<?php endif ?>
	<?php
	if($authuser['id'] === $user_info['id']): ?>
	<p><?php echo $this->Form->postLink('編集',array('action'=>'edit', $authuser['id'])); ?></p>
	<?php endif; ?>
</p>
<?php endif; ?>

