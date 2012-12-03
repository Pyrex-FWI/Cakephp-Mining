<div class="songs view">
<h2><?php  echo __('Song');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($song['Song']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Filename'); ?></dt>
		<dd>
			<?php echo h($song['Song']['filename']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Path'); ?></dt>
		<dd>
			<?php echo h($song['Song']['path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Size'); ?></dt>
		<dd>
			<?php echo h($song['Song']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Filepath'); ?></dt>
		<dd>
			<?php echo h($song['Song']['filepath']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($song['Song']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Feat'); ?></dt>
		<dd>
			<?php echo h($song['Song']['feat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Md5'); ?></dt>
		<dd>
			<?php echo h($song['Song']['md5']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Md5 Filepath'); ?></dt>
		<dd>
			<?php echo h($song['Song']['md5_filepath']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Play Count'); ?></dt>
		<dd>
			<?php echo h($song['Song']['play_count']); ?>
			&nbsp;
		</dd>
		<dt>Player</dt>
		<dd><?php echo $this->Html->link(__('Play'), array('plugin'=>'player','controller'=>'players','action' => 'player_side', $song['Song']['id'],'player_params'=>'autoplay=1'),array('onclick'=>"load_page('#player_side',this.href); return false;")); ?></dd>
	</dl>
	<br/>
<div class="related">
	<h3><?php echo __('Related Artists');?></h3>
	<?php if (!empty($song['Artist'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($song['Artist'] as $artist): ?>
		<tr>
			<td><?php echo $artist['id'];?></td>
			<td><?php echo $artist['name'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'artists', 'action' => 'view', $artist['id']),array('onclick'=>"load_page('#content',this.href);return false;")); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'artists', 'action' => 'edit', $artist['id']),array('onclick'=>"load_page('#content',this.href); return false;")); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'artists', 'action' => 'delete', $artist['id']), array('onclick'=>"load_page('#content',this.href); return false;"), __('Are you sure you want to delete # %s?', $artist['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Artist'), array('controller' => 'artists', 'action' => 'add'),array('onclick'=>"load_page('#content',this.href); return false;"));?> </li>
		</ul>
	</div>
</div>
	
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Song'), array('action' => 'edit', $song['Song']['id']),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Song'), array('action' => 'delete', $song['Song']['id']), null, __('Are you sure you want to delete # %s?', $song['Song']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Songs'), array('action' => 'index'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('New Song'), array('action' => 'add'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('List Artists'), array('controller' => 'artists', 'action' => 'index'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('New Artist'), array('controller' => 'artists', 'action' => 'add'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
	</ul>
</div>
