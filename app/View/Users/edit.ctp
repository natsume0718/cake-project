<h1>マイページ</h1>
<p>画像</p>
<p>name</p>
<p>address</p>
<p>一言：</p>
<?php
echo $this->Form->create('User', array('type'=>'post', 'enctype'=>'multipart/form-data'));
echo $this->Form->input('image', array('type'=>'file', 'label'=>'画像', 'required'=>false));
echo $this->Form->input('message', array('required'=>false));
echo $this->Form->end('編集');
?>
