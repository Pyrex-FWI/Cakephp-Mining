<div class="songs form">
<?php echo $this->Form->create('Song');?>
	<fieldset>
		<legend><?php echo __('Add Song'); ?></legend>
	<?php
		echo $this->Form->input('filename');
		echo $this->Form->input('path');
		echo $this->Form->input('size');
		echo $this->Form->input('filepath');
		echo $this->Form->input('title');
		echo $this->Form->input('feat');
		echo $this->Form->input('md5');
		echo $this->Form->input('md5_filepath');
		echo $this->Form->input('play_count');
		echo $this->Form->input('Artist');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Songs'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Artists'), array('controller' => 'artists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Artist'), array('controller' => 'artists', 'action' => 'add')); ?> </li>
	</ul>
</div>
