<div class="artists view">
<h2><?php  echo __('Artist');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($artist['Artist']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($artist['Artist']['name']); ?>
			&nbsp;
		</dd>
	</dl>
	<br/>
<div class="related">
	<h3><?php echo __('Related Songs');?></h3>
	<?php if (!empty($artist['Song'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th colspan="2"><?php echo __('Title'); ?></th>
		<th><?php echo __('Play Count'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($artist['Song'] as $song): ?>
		<tr>
			<td><?php echo $this->Html->link(__('>'), array('controller' => 'songs', 'action' => 'view', $song['id']),array('onclick'=>"load_page('#content',this.href);return false;")); ?></td>
			<td><?php echo $song['title'];?></td>
			<td><?php echo $song['play_count'];?></td>
			<td class="actions">
			<?php echo $this->Html->link(__('Play'), array('plugin'=>'player','controller'=>'players','action' => 'player_side', $song['id'],'player_params'=>'autoplay=1'),array('onclick'=>"load_page('#player_side',this.href); return false;")); ?>
				<?php echo $this->Html->link(__('View'), array('controller' => 'songs', 'action' => 'view', $song['id']),array('onclick'=>"load_page('#content',this.href);return false;")); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'songs', 'action' => 'edit', $song['id']),array('onclick'=>"load_page('#content',this.href); return false;")); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'songs', 'action' => 'delete', $song['id']), array('onclick'=>"load_page('#content',this.href); return false;"), __('Are you sure you want to delete # %s?', $song['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add'),array('onclick'=>"load_page('#content',this.href); return false;"));?> </li>
		</ul>
	</div>
</div>
	
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Artist'), array('action' => 'edit', $artist['Artist']['id']),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Artist'), array('action' => 'delete', $artist['Artist']['id']), null, __('Are you sure you want to delete # %s?', $artist['Artist']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Artists'), array('action' => 'index'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('New Artist'), array('action' => 'add'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('List Songs'), array('controller' => 'songs', 'action' => 'index'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
	</ul>
</div>
