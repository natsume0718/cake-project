<h1>投稿記事</h1>
<p><?php echo $this->Html->link('新規投稿',array('controller'=>'posts', 'action'=>'add')); ?></p>
<table>
	<?php
	//ループで記事出力
	foreach($posts as $post): ?>
	<tr><td><?php echo $post['Post']['id']; ?></td></tr>
	<tr><td><?php echo $this->Html->link($post['Post']['title'], array('controller'=>'posts', 'action'=>'view', $post['Post']['id'])); ?></td></tr>
	<tr><td><?php echo $post['Post']['created']; ?></td></tr>
	<?php endforeach; ?>
</table>

