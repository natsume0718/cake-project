<h1>ユーザー情報</h1>
<p><?php echo $this->Html->link('トップに戻る', array('controller'=>'posts', 'action'=>'index')); ?></p>

<?php
if(isset($user_info)): ?>
<p><?php echo $this->Html->image($user_info['image']); ?></p>
<p>ユーザー名:<?php echo h($user_info['username']); ?></p>
<p>一言:<?php echo h($user_info['message']); ?></p>
	<?php
	if($authuser['id'] === $user_info['id']): ?>
	<p><?php echo $this->Html->link('編集',array('action'=>'edit', $authuser['id'])); ?></p>
	<?php endif; ?>
</p>
<?php endif; ?>

