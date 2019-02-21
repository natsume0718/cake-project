<h1>マイページ</h1>
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
<p>ユーザー名: <?php echo h($user_info['username']); ?></p>
<p>mail: <?php echo h($user_info['email']); ?></p>
<p>一言：<?php echo h($user_info['message']); ?></p>
<?php
echo $this->Form->create('User', array('type'=>'post', 'enctype'=>'multipart/form-data'));
echo $this->Form->input('image', array('type'=>'file', 'label'=>'画像', 'required'=>false));
echo $this->Form->input('message', array('required'=>false));
echo $this->Form->end('編集');
?>
