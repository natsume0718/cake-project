<h1>ユーザー情報</h1>
<p><?php echo $this->Html->link('トップに戻る', array('controller'=>'posts', 'action'=>'index')); ?></p>
<p>画像</p>
<p>
<?php
if(!empty($user_info['image'])):
echo $this->Html->image($user_info['image']);
else: ?>
画像は未設定です
<?php endif; ?>
</p>
<p>ユーザー名:<?php echo h($user_info['username']); ?></p>
<p>一言:<?php echo h($user_info['message']); ?></p>
	<?php
	if($authuser['id'] === $user_info['id']): ?>
	<p><?php echo $this->Html->link('編集',array('action'=>'edit', $authuser['id'])); ?></p>
	<?php endif; ?>
</p>

