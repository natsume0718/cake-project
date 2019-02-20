<p>パスワード再発行</p>
<?php
echo $this->Form->create('Reset');
echo $this->Form->input('email', array('label'=>'メールアドレス', 'maxlength'=>false));
echo $this->Form->end('再発行');
?>
