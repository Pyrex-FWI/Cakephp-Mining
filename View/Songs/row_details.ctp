<?php 
//debug($song);
//debug($same);
$domId = "row_details_".time();
$accordion_domId = "accordion_details_".time();
?>
<div id="<? echo $accordion_domId; ?>">
	<h3><a href="#">Auto Mix suggestions</a></h3>
	<div>
		<!-- <p> -->
		<div id="<?php echo $domId;?>">
			<ul>
			<?php foreach(array_keys($same) as $grp):?>
				<li><a href="#<?php echo strtolower($grp)?>"><?php echo $grp. " (" .count($same[$grp]).")"?></a></li>
			<?php endforeach; ?>
			</ul>
			<?php foreach(array_keys($same) as $grp):?>
			<div id="<?php echo strtolower($grp)?>">
				<table class="table table-bordered table-striped table-condensed" cellpadding="0" cellspacing="0">
					<?php foreach($same[$grp] as $dataSet): ?>
	
					<tr>
					<td><?php echo $this->SongDetails->extendRowLinks($dataSet); ?></td>
					<td><?php echo $dataSet['Interprete']['name']?></td>
					
					<?php foreach($dataSet['Song'] as $kitem => $songData): ?>
					<?php if($kitem == 'id') continue;?>
					<td><?php  echo $songData ?></td>
					
					<?php endforeach; ?>
					<td><?php echo $dataSet[0]['percent_scale']?></td>
					<td><?php echo $dataSet['Genre']['name']?></td>
					 <td> <?php echo $this->Html->link('play', array('plugin'=>'player','controller'=>'players','action' => 'play', $dataSet['Song']['id']),  array("type"=>"audio/mpeg",'class'=>'sm2_button ','escape'=>false)); ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<?php endforeach; ?>
		</div>	
		<!-- </p> -->
	</div>
	<h3><a href="#"><?php echo $song['Interprete']['name']. " - ".$song['Song']['title'];?> Details</a></h3>
	<div>

		<!-- <p> -->
		<dl class="dl-horizontal">
		<?php foreach($song['Song'] as $item => $itemVal):?>
	        <dt><?php echo __d('Song','Song.'.$item); ?></dt>
	        <dd><?php  echo $itemVal; ?>&nbsp;</dd>
		<?php endforeach;?>
		</dl>
		<!-- </p> -->
	</div>

	
</div>


<script type="text/javascript">
soundManager.setup({
	useFlashBlock: false, // optional - if used, required flashblock.css
	//useHTML5Audio: false,
	url: '<?php echo (Router::url("/"))?>/swf/' // required: path to directory containing SM2 SWF files
});
/*
$(function() {
	$( "#<?php echo $domId;?>" ).tabs();
	$( "#<?php echo $accordion_domId;?>" ).accordion({
		autoHeight: false
		});
});
*/

</script>		

		