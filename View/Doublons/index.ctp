<div class="doublons index">
	<h2><?php echo __('Doublons');?></h2>
	<div class="paging center">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('onclick'=>"load_page('#content',this.href);return false;"), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','onclick'=>"load_page('#content',this.href);return false;"));
		echo $this->Paginator->next(__('next') . ' >', array('onclick'=>"load_page('#content',this.href);return false;"), null, array('class' => 'next disabled'));
	?>
	</div>	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('md5',null,array('onclick'=>"load_page('#content',this.href);return false;"));?></th>
			<th><?php echo $this->Paginator->sort('nb_songs');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($doublons as $doublon): 
	$titles = Set::classicExtract($doublon,"Song.{n}.title");
	$titles = (implode(', ', $titles));	
	?>
	<tr>
		<td><?php echo h($titles); ?>&nbsp;</td>
		<td><?php echo h($doublon['Doublon']['nb_songs']); ?>&nbsp;</td>
		<td class="actions">
		<?php
			$songs_id = Set::classicExtract($doublon,"Song.{n}.id");
		?>
			<?php echo $this->Html->link(__('Play songs'), array_merge(array('plugin'=>'player','controller'=>'players','action' => 'player_side','player_params'=>"autoplay=1"),$songs_id), array('onclick'=>"load_page('#player_side',this.href);return false;")); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $doublon['Doublon']['md5'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $doublon['Doublon']['md5'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $doublon['Doublon']['md5']), null, __('Are you sure you want to delete # %s?', $doublon['Doublon']['md5'])); ?>
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
		<li><?php echo $this->Html->link(__('New Doublon'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Songs'), array('controller' => 'songs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add')); ?> </li>
	</ul>
</div>

