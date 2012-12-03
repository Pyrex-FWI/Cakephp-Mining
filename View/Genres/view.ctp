<div class="genres view">
<h2><?php  echo __('Genre');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($genre['Genre']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($genre['Genre']['name']); ?>
			&nbsp;
		</dd>
	</dl>
	<br/>
<div class="related">
	<h3><?php echo __('Related Songs');?></h3>
	<?php if (!empty($genre['Song'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Filename'); ?></th>
		<th><?php echo __('Genre Id'); ?></th>
		<th><?php echo __('Year'); ?></th>
		<th><?php echo __('Bpm'); ?></th>
		<th><?php echo __('Play Count'); ?></th>
		<th><?php echo __('Group'); ?></th>
		<th><?php echo __('Key'); ?></th>
		<th><?php echo __('Comments'); ?></th>
		<th><?php echo __('Path'); ?></th>
		<th><?php echo __('Size'); ?></th>
		<th><?php echo __('Filepath'); ?></th>
		<th><?php echo __('Feat'); ?></th>
		<th><?php echo __('Md5'); ?></th>
		<th><?php echo __('Md5 Filepath'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($genre['Song'] as $song): ?>
		<tr>
			<td><?php echo $song['id'];?></td>
			<td><?php echo $song['title'];?></td>
			<td><?php echo $song['filename'];?></td>
			<td><?php echo $song['genre_id'];?></td>
			<td><?php echo $song['year'];?></td>
			<td><?php echo $song['bpm'];?></td>
			<td><?php echo $song['play_count'];?></td>
			<td><?php echo $song['group'];?></td>
			<td><?php echo $song['key'];?></td>
			<td><?php echo $song['comments'];?></td>
			<td><?php echo $song['path'];?></td>
			<td><?php echo $song['size'];?></td>
			<td><?php echo $song['filepath'];?></td>
			<td><?php echo $song['feat'];?></td>
			<td><?php echo $song['md5'];?></td>
			<td><?php echo $song['md5_filepath'];?></td>
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
		<li><?php echo $this->Html->link(__('Edit Genre'), array('action' => 'edit', $genre['Genre']['id']),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Genre'), array('action' => 'delete', $genre['Genre']['id']), null, __('Are you sure you want to delete # %s?', $genre['Genre']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Genres'), array('action' => 'index'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('New Genre'), array('action' => 'add'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('List Songs'), array('controller' => 'songs', 'action' => 'index'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add'),array('onclick'=>"load_page('#content',this.href); return false;")); ?> </li>
	</ul>
</div>
