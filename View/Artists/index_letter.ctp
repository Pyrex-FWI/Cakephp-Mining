<?php echo $this->Session->flash(); ?>
<div class="artists index">
	<h2><?php echo __('Artistes');?></h2>
	<div>
	Total artistes: <?php echo $total_artists;?><br/>
	Total '<?php echo strtoupper($curLetter);?>' artistes: <?php echo count($artists); ?><br/>
	
	</div>
	<div class="paging center">
	<?php
	foreach ($alpha as $value) {
		echo $this->Html->link(strtoupper($value),array('action'=>'indexLetter',$value),array('onclick'=>'load_page("#content",this.href);return false;'));
	}
	?>
	</div>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th colspan="2"><?php echo 'Nom';?></th>
			<th><?php echo 'Songs';?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($artists as $artist): ?>
	<tr>
		<td><?php echo $this->Html->link(__('>'), array('action' => 'view', $artist['Artist']['id']), array('onclick'=>"load_page('#content',this.href);return false;")); ?></td>	
		<td><?php echo h($artist['Artist']['name']); ?>&nbsp;</td>
		<td><?php echo count($artist['Song']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Play songs'), array('plugin'=>'player','controller'=>'players','action' => 'playByArtistId', $artist['Artist']['id']), array('onclick'=>"load_page('#player_side',this.href);return false;")); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $artist['Artist']['id']), array('onclick'=>"load_page('#content',this.href);return false;")); ?>

			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $artist['Artist']['id']), array('onclick'=>"load_page('#content',this.href);return false;")); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $artist['Artist']['id']), array('onclick'=>"load_page('#content',this.href);return false;"), __('Are you sure you want to delete # %s?', $artist['Artist']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Artist'), array('action' => 'add'), array('onclick'=>"load_page('#content',this.href);return false;")); ?></li>
		<li><?php echo $this->Html->link(__('List Songs'), array('controller' => 'songs', 'action' => 'index'), array('onclick'=>"load_page('#content',this.href);return false;")); ?> </li>
		<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add'), array('onclick'=>"load_page('#content',this.href);return false;")); ?> </li>
	</ul>
</div>
