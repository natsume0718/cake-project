<h1>投稿記事</h1>
<table>
<?php
//ループで記事出力
foreach($posts as $post): ?>
<tr><td><?php echo $post['Post']['id']; ?></td></tr>
<tr><td><?php $this->Html->link($post['Post']['title'], array('controller'=>'posts', 'action'=>'view', $post['Post']['id'])); ?></td></tr>
<tr><td><?php echo $post['Post']['created']; ?></td></tr>
<?php endforeach; ?>
</table>

