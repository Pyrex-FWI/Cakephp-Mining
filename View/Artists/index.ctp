<?php echo $this->Session->flash(); ?>
<div class="artists index">
	<h2><?php echo __('Artists');?></h2>
	<div class="paging center">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('onclick'=>"load_page('#content',this.href);return false;"), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','onclick'=>"load_page('#content',this.href);return false;"));
		echo $this->Paginator->next(__('next') . ' >', array('onclick'=>"load_page('#content',this.href);return false;"), null, array('class' => 'next disabled'));
	?>
	</div>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id',null,array('onclick'=>"load_page('#content',this.href);return false;"));?></th>
			<th><?php echo $this->Paginator->sort('name',null,array('onclick'=>"load_page('#content',this.href);return false;"));?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($artists as $artist): ?>
	<tr>
		<td><?php echo h($artist['Artist']['id']); ?>&nbsp;</td>
		<td><?php echo h($artist['Artist']['name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $artist['Artist']['id']), array('onclick'=>"load_page('#content',this.href);return false;")); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $artist['Artist']['id']), array('onclick'=>"load_page('#content',this.href);return false;")); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $artist['Artist']['id']), array('onclick'=>"load_page('#content',this.href);return false;"), __('Are you sure you want to delete # %s?', $artist['Artist']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Artist'), array('action' => 'add'), array('onclick'=>"load_page('#content',this.href);return false;")); ?></li>
		<li><?php echo $this->Html->link(__('List Songs'), array('controller' => 'songs', 'action' => 'index'), array('onclick'=>"load_page('#content',this.href);return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add'), array('onclick'=>"load_page('#content',this.href);return false;")); ?> </li>
	</ul>
</div>
