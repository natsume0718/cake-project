<h1>ユーザー情報</h1>
<?php
var_dump($user_info);
?>
<p><?php echo $this->Html->link('トップに戻る', array('controller'=>'posts', 'action'=>'index')); ?></p>
<?php var_dump($user); ?>

<?php
if(isset($user_info)): ?>
<p>画像</p>
<p><?php echo $user_info['username']; ?></p>
<p><?php echo $user_info['comment']; ?></p>

<?php endif; ?>

