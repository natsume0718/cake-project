<h1>投稿記事</h1>
<?php
//ログイン状態で処理わけ
if(!isset($user)): ?>
<p><?php echo $this->Html->link('ログイン', array('controller'=>'users', 'action'=>'login')); ?></p>
<p><?php echo $this->Html->link('新規登録', array('controller'=>'users', 'action'=>'add')); ?></p>
<?php else: ?>
<p><?php echo $this->Html->link('ログアウト', array('controller'=>'users', 'action'=>'logout')); ?></p>
<?php endif; ?>
<p><?php echo $this->Html->link('新規投稿',array('controller'=>'posts', 'action'=>'add')); ?></p>
<?php if(isset($user)): ?>
<p>こんにちは: <?php echo $this->Html->link($user['username'], array('controller'=>'users', 'action'=>'view', $user['id'])); ?> さん</p>
<?php endif; ?>
<table>
	<?php
	//ループで記事出力
	foreach($posts as $post): ?>
	<tr>
		<td>
			投稿ID:<?php echo $post['Post']['id']; ?>
		</td>
		<td>
			投稿者:
			<?php echo $this->Html->link($post['User']['username'],array('controller'=>'users', 'action'=>'view', $post['User']['id'])); ?>
		</td>
		<td>
			投稿日:
			<?php echo $post['Post']['created']; ?>
		</td>
	</tr>
		<td>
			タイトル:
			<?php echo $post['Post']['title']; ?>
		</td>
		<td colspan="2">
			本文:
			<?php echo $post['Post']['body']; ?>
		</td>
	</tr>
	<?php
	//投稿者とログイン者が同じなら削除編集表示
   	if($user['id'] === $post['Post']['user_id']): ?>
	<tr>
		<td>
			<?php
			echo $this->Form->postLink( '削除',
			array('action' => 'delete', $post['Post']['id']),
			array('confirm' => 'Are you sure?')
			);
			?>
		</td>
		<td colspan="2">
			<?php
			echo $this->Html->link('編集', array('action'=>'edit', $post['Post']['id']));
			?>
		</td>
	</tr>
	<?php endif; ?>
	<?php endforeach; ?>
</table>

