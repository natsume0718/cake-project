<h1>マイページ</h1>
<p><?php
debug($user_info);
echo $this->Html->image($user_info['image']); ?></p>
<p><?php echo h($user_info['username']); ?></p>
<p>address<?php echo h($user_info['email']); ?></p>
<p>一言：<?php echo h($user_info['message']); ?></p>
<?php
echo $this->Form->create('User', array('type'=>'post', 'enctype'=>'multipart/form-data'));
echo $this->Form->input('image', array('type'=>'file', 'label'=>'画像', 'required'=>false));
echo $this->Form->input('message', array('required'=>false));
echo $this->Form->end('編集');
?>
