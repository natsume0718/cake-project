<h1>投稿記事</h1>
<?php
var_dump($user);
//ログイン状態で処理わけ
if(!isset($user)): ?>
<p><?php echo $this->Html->link('ログイン', array('controller'=>'users', 'action'=>'login')); ?></p>
<?php else: ?>
<p><?php echo $this->Html->link('ログアウト', array('controller'=>'users', 'action'=>'logout')); ?></p>
<?php endif; ?>
<p><?php echo $this->Html->link('新規投稿',array('controller'=>'posts', 'action'=>'add')); ?></p>
<table>
	<?php
	//ループで記事出力
	foreach($posts as $post): ?>
	<tr><td><?php echo $post['Post']['id']; ?></td><td><?php echo $this->Html->link($post['Post']['title'], array('controller'=>'posts', 'action'=>'view', $post['Post']['id'])); ?></td><td><?php echo $post['Post']['created']; ?></td></tr>
		<?php if($user['id'] === $post['Post']['user_id']): ?>
	<tr>
		<td>
			<?php
			echo $this->Form->postLink(
			'削除',
			array('action' => 'delete', $post['Post']['id']),
			array('confirm' => 'Are you sure?')
			);
			?>
		</td>
		<td>
			<?php
			echo $this->Html->link('編集', array('action'=>'edit', $post['Post']['id']));
			?>
		</td>
	</tr>
		<?php endif; ?>
	<?php endforeach; ?>
</table>

