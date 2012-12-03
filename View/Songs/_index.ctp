<?php echo $this->Session->flash(); ?>
<div class="songs index">
	<h2><?php echo __('Songs');?></h2>
	<div class="paging center">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('onclick'=>"load_page('#content',this.href);return false;"), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','onclick'=>"load_page('#content',this.href);return false;"));
		echo $this->Paginator->next(__('next') . ' >', array('onclick'=>"load_page('#content',this.href);return false;"), null, array('class' => 'next disabled'));
	?>
	</div>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th colspan="2"><?php echo $this->Paginator->sort('filename',null,array('onclick'=>"load_page('#content',this.href);return false;"));?></th>
			<th><?php echo $this->Paginator->sort('title',null,array('onclick'=>"load_page('#content',this.href);return false;"));?></th>
			<th><?php echo $this->Paginator->sort('Genre.name','Genre',array('onclick'=>"load_page('#content',this.href);return false;"));?></th>
			<th><?php echo $this->Paginator->sort('play_count',null,array('onclick'=>"load_page('#content',this.href);return false;"));?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($songs as $song): ?>
	<tr>
		<td><?php echo $this->Html->link(__('>'), array('action' => 'view', $song['Song']['id']), array('onclick'=>"load_page('#content',this.href);return false;")); ?>&nbsp;</td>
		<td><?php echo h($song['Song']['filename']); ?>&nbsp;</td>
		<td><?php echo h($song['Song']['title']); ?>&nbsp;</td>
		<td><?php echo h($song['Genre']['name']); ?>&nbsp;</td>
		<td><?php echo h($song['Song']['play_count']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Play'), array('plugin'=>'player','controller'=>'players','action' => 'player_side', $song['Song']['id'],'player_params'=>'autoplay=1'),array('onclick'=>"load_page('#player_side',this.href); return false;")); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $song['Song']['id']), array('onclick'=>"load_page('#content',this.href);return false;")); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $song['Song']['id']), array('onclick'=>"load_page('#content',this.href);return false;")); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $song['Song']['id']), array('onclick'=>"load_page('#content',this.href);return false;"), __('Are you sure you want to delete # %s?', $song['Song']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging center">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('onclick'=>"load_page('#content',this.href);return false;"), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','onclick'=>"load_page('#content',this.href);return false;"));
		echo $this->Paginator->next(__('next') . ' >', array('onclick'=>"load_page('#content',this.href);return false;"), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Song'), array('action' => 'add'), array('onclick'=>"load_page('#content',this.href);return false;")); ?></li>
		<li><?php echo $this->Html->link(__('List Artists'), array('controller' => 'artists', 'action' => 'index'), array('onclick'=>"load_page('#content',this.href);return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('New Artist'), array('controller' => 'artists', 'action' => 'add'), array('onclick'=>"load_page('#content',this.href);return false;")); ?> </li>
	</ul>
</div>
