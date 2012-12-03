<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Scaffolds
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php 
$scaffoldFields = $this->ColGrid->getColGrid();
//debug($scaffoldFields);


?>
<?php echo$this->assign('top_title', $pluralHumanName);?>

<div class="<?php echo $pluralVar;?> index">

<table class="table table-bordered table-striped table-condensed" cellpadding="0" cellspacing="0">
<tr>
<th>&nbsp;</th>
<?php foreach ($scaffoldFields as $_fieldModel):?>
<?php 
$_field = substr($_fieldModel, strrpos($_fieldModel, '.')+1);
$_model = substr($_fieldModel, 0, strrpos($_fieldModel, '.'));
$id_use[$_model.'_'.$_field] = isset($id_use[$_model.'_'.$_field]) ?  $id_use[$_model.'_'.$_field]+1 : 1;
?>
	<th id="<?php echo $_model.'_'.$_field.$id_use[$_model.'_'.$_field];?>">
		<?php echo $this->Paginator->sort($_field);?>
	</th>
<?php endforeach;?>
	<th><?php echo __d('cake', 'Actions');?></th>
</tr>
<?php
$i = 0;
foreach (${$pluralVar} as ${$singularVar}):
$rowId = $this->uuid('row',array('action'=>'index'));
	echo "<tr id=\"r_".${$singularVar}[$modelClass][$primaryKey]."\">";
	echo "<td>".$this->SongDetails->extendRowLinks(${$singularVar})."</td>";
		foreach ($scaffoldFields as $_fieldModel) {
			$_field = substr($_fieldModel, strrpos($_fieldModel, '.')+1);
			$_model = substr($_fieldModel, 0, strrpos($_fieldModel, '.'));

			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $_alias => $_details) {
					if ($_field === $_details['foreignKey']) {
						$isKey = true;
						echo "<td>" . $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . "</td>";
						break;
					}
				}
			}
			if ($isKey !== true ) {
				echo "<td>" . h($this->Text->truncate(${$singularVar}[$_model][$_field],20,array('exact'=>true))) . "</td>";
			}
		}

		echo '<td class="actions">';
		if($modelClass == "Song")
			echo $this->Html->link('play', array('plugin'=>'player','controller'=>'players','action' => 'play', ${$singularVar}[$modelClass][$primaryKey]),  array("type"=>"audio/mpeg",'class'=>'sm2_button ','escape'=>false))."&nbsp;";
		echo $this->Html->link('<i class="icon-eye-open"></i>', array('action' => 'view', ${$singularVar}[$modelClass][$primaryKey]),  array('class'=>' btn btn-mini','escape'=>false))."&nbsp;";
		echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]),array('class'=>' btn btn-mini ','escape'=>false))."&nbsp;";
		echo $this->Form->postLink(
			'<i class="icon-remove"></i>',
			array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]),
			array('class'=>' btn btn-mini btn-warning','escape'=>false),
			__d('cake', 'Are you sure you want to delete').' #' . ${$singularVar}[$modelClass][$primaryKey]
		);
		echo '</td>';
	echo '</tr>';

endforeach;

?>
</table>
<?php echo $this->ColGrid->printColGridChooseTable($FieldsCol);		?>
	<p><?php
	echo $this->Paginator->counter(array(
		'format' => __d('cake', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?></p>

	<div class="pagination">
	<ul>
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('tag'=>'li'), null, array('class' => 'prev disabled','tag'=>'li'));
		echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass'=>'active'));
		echo $this->Paginator->next(__('next') . ' >', array('tag'=>'li'), null, array('class' => 'next disabled'));
	?>
	</ul>
	</div>	
</div>




<?php 

$this->start('actionMenu');
?>	
		<li><?php echo $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('action' => 'add'),array('class'=>'actionMenu')); ?></li>
<?php
//debug(/$associations);
		$done = array();
		$plugin = '';
		foreach ($associations as $_type => $_data) {
			foreach ($_data as $_alias => $_details) {

				if(strrpos($_details['controller'], '.')){
					$_details['controller'] = substr($_details['controller'], strrpos($_details['controller'], '.')+1);
				}
				if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
					echo "<li>" . $this->Html->link(__d('cake', 'List %s', Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index'),array('class'=>'actionMenu')) . "</li>";
					echo "<li>" . $this->Html->link(__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add'),array('class'=>'actionMenu')) . "</li>";
					$done[] = $_details['controller'];
				}
			}
		}
		//echo $this->ColGrid->printColGridChoose($FieldsCol);		
		
?>

<?php $this->end(); ?>
	