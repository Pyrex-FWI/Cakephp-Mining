<div class="doublons form">
<?php echo $this->Form->create('Doublon');?>
	<fieldset>
		<legend><?php echo __('Edit Doublon'); ?></legend>
	<?php
		echo $this->Form->input('md5');
		echo $this->Form->input('nb_songs');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Doublon.md5')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Doublon.md5'))); ?></li>
		<li><?php echo $this->Html->link(__('List Doublons'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Songs'), array('controller' => 'songs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add')); ?> </li>
	</ul>
</div>
