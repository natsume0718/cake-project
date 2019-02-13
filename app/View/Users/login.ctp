<h1>ログイン</h1>
<div class="users form">
	<?php
	echo $this->Flash->render('auth');
	echo $this->Form->create('User');
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->end('ログイン');
	?>
</div>

