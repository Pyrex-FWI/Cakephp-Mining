<div class="doublons view">
<h2><?php  echo __('Doublon');?></h2>
	<dl>
		<dt><?php echo __('Md5'); ?></dt>
		<dd>
			<?php echo h($doublon['Doublon']['md5']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nb Songs'); ?></dt>
		<dd>
			<?php echo h($doublon['Doublon']['nb_songs']); ?>
			&nbsp;
		</dd>
	</dl>
	<div class="player">
	<?php
	
	$SongIds = Set::classicExtract($doublon,"Song.{n}.id");
	$urlPlayer = Router::url("/player/dewplayer-playlist.swf");
	$xMlPlaylist = Router::url(array_merge(array(/*"plugin"=>"player",*/'controller'=>'songs','action'=>'xmlPlaylist'),$SongIds));
	?>
		<object type="application/x-shockwave-flash" data="<?php echo $urlPlayer; ?>" width="240" height="200" id="dewplayer" name="dewplayer">
		<param name="wmode" value="transparent" />
		<param name="movie" value="<?php echo $urlPlayer; ?>" />
		<param name="flashvars" value="showtime=true&autoreplay=true&xml=<?php echo $xMlPlaylist;?>" />
		</object>
	
	</div>	
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Doublon'), array('action' => 'edit', $doublon['Doublon']['md5'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Doublon'), array('action' => 'delete', $doublon['Doublon']['md5']), null, __('Are you sure you want to delete # %s?', $doublon['Doublon']['md5'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Doublons'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doublon'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Songs'), array('controller' => 'songs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="related">
	<h3><?php echo __('Related Songs');?></h3>
	<?php if (!empty($doublon['Song'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Filename'); ?></th>
		<th><?php echo __('Path'); ?></th>
		<th><?php echo __('Size'); ?></th>
		<th><?php echo __('Filepath'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Feat'); ?></th>
		<th><?php echo __('Md5'); ?></th>
		<th><?php echo __('Md5 Filepath'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($doublon['Song'] as $song): ?>
		<tr>
			<td><?php echo $song['id'];?></td>
			<!--<td><?php echo $song['filename'];?></td>
			<td><?php echo $song['path'];?></td>
			<td><?php echo $song['size'];?></td>-->
			<td><?php echo $song['filepath'];?></td>
			<!-- <td><?php echo $song['title'];?></td>
			<td><?php echo $song['feat'];?></td>
			<td><?php echo $song['md5'];?></td>
			<td><?php echo $song['md5_filepath'];?></td>-->
			<td class="actions">
				<?php //echo $this->element('play_btn',array(),array('plugin'=>'Player')); ?>
				<?php echo $this->Player->addLink($song['id']); ?>
				<?php echo $this->Html->link(__('View'), array('controller' => 'songs', 'action' => 'view', $song['id'])); ?>
				<?php //echo $this->Html->link(__('Edit'), array('controller' => 'songs', 'action' => 'edit', $song['id'])); ?>
				<?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'songs', 'action' => 'delete', $song['id']), null, __('Are you sure you want to delete # %s?', $song['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
<div class="speakkerSmall"></div>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<script type="text/javascript">
/*$(document).ready(function() {	
	$('.speakkerSmall').speakker({
		file: 'http://localhost:81/pyrex_mining/player/players/play/2969',
		title: 'one single MP3',
		theme: 'dark'
		//poster: 'cover.jpg'
	});
});
$(document).ready(function(){
    var description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id tortor nisi. Aenean sodales diam ac lacus elementum scelerisque. Suspendisse a dui vitae lacus faucibus venenatis vel id nisl. Proin orci ante, ultricies nec interdum at, iaculis venenatis nulla. ';
    var myPlaylist = [

                      {
                          mp3:'http://localhost:81/pyrex_mining/player/players/play/8000',
                          //oga:'mix/1.ogg',
                          title:'Sample',
                          artist:'Sample',
                          rating:4,
                          buy:'#',
                          price:'0.99',
                          duration:'0:30'
                          //cover:'mix/1.png'
                      }
                  ];
    $('.speakkerSmall').ttwMusicPlayer(myPlaylist, {
        autoPlay:false, 
        description:description,
        jPlayer:{
            swfPath:'../plugin/jquery-jplayer' //You need to override the default swf path any time the directory structure changes
        }
    });
});*/
</script>
