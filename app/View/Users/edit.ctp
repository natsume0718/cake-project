<h1>マイページ</h1>
<p><?php echo $this->Html->link('トップに戻る', array('controller'=>'posts', 'action'=>'index')); ?></p>
<p><?php
echo $this->Html->image($user_info['image']); ?></p>
<p>ユーザー名: <?php echo h($user_info['username']); ?></p>
<p>mail: <?php echo h($user_info['email']); ?></p>
<p>一言：<?php echo h($user_info['message']); ?></p>
<?php
echo $this->Form->create('User', array('type'=>'post', 'enctype'=>'multipart/form-data'));
echo $this->Form->input('image', array('type'=>'file', 'label'=>'画像', 'required'=>false));
echo $this->Form->input('message', array('required'=>false));
echo $this->Form->end('編集');
?>
