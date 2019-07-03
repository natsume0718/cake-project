<h1>パスワード再設定</h1>
<?php
echo $this->Form->create('User');
echo $this->Form->input('User.password',array('label'=>'新規パスワード'));
echo $this->Form->end('再設定');
?>
